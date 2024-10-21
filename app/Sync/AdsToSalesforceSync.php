<?php

namespace App\Sync;

use App\Models\Ad;
use App\Models\AdStatus;
use App\Models\Country;
use App\Models\InstallationType;
use App\Models\OfferGenre;
use App\Presenters\AdPresenter;
use App\Repositories\Ads\AdRepository;
use App\Repositories\SalesForce\SalesForceRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class AdsToSalesforceSync
{
    public function __construct(private SalesForceRepository $repository)
    {
    }

    public function sync()
    {
        $this->repository->authenticate();

        $ads = Ad::with([
            'userPp',
            'userPp.zipCode',
            'attributionAd',
            ...AdRepository::getSubAdEagerLoading(),
            ...AdRepository::getLocationEagerLoading()
        ])->where('updated_at', '>=', now()->subDay())->get();

        $departmentCodes = $this->collectUniqueCodes($ads, 'mainDepartment', 'departments');
        $regionCodes = $this->collectUniqueCodes($ads, 'regions');
        $cityCodes = $this->collectUniqueCodes($ads, 'cities', 'insee_code');

        $departmentsByCode = $this->fetchTerritoriesByCodesInChunks($departmentCodes);
        $regionsByCode = $this->fetchTerritoriesByCodesInChunks($regionCodes);
        $citiesByCode = $this->fetchTerritoriesByCodesInChunks($cityCodes, 'Code_adm__c');

        foreach ($ads as $ad) {
            $subAd = $ad->{$ad->type};
            $presenter = app(AdPresenter::class)->setWrappedObject($ad);

            $values = array_filter([
                "RecordType" => ["Name" => "Annonce"],
                "Type_d_annonce__c" => $this->getAdType($ad->type),
                "Name" => Str::limit($ad->title, 80, ''),
                "Contact__c" => $ad->userPp->id,
                "Territoire_Principal__c" => $ad->main_department ? $departmentsByCode[$ad->mainDepartment->code]["Id"] : null,
                "Territoire_concerne__c" => $this->getTerritoire($ad->main_department?->territory?->name),
                "Surface_ha__c" => $presenter->surface ?? null,
                "Production_agricole_prinicipale__c" => $this->getMainProductionGenre($subAd->productionGenres),
                "Autres_productions_agricoles__c" => $this->getSecondaryProductionGenres($subAd->productionGenresSecondary),
                "Experience_professionnelle_recherchee__c" => $this->getJobOfferTypes($subAd->jobOfferTypes),
                "Transmission_d_activit_agricole__c" => $subAd->is_activity_transmission ? 'Oui' : 'Non',
                "Agriculture_biologique__c" => $this->getBioStatus($subAd->is_bio),
                "Certification_des_terres__c" => $this->getBioCertifications($subAd->bioCertifications),
                "Acces_eau__c" => $this->getWaterAccess($subAd->water_access),
                "Presence_d_habitations__c" => $subAd->has_houses,
                "Presence_de_batiments_agricoles__c" => $subAd->has_buildings,
                "Modalite_d_installation__c" => $this->getInstallationType($subAd->installationType),
                "Type_de_transmission__c" => $this->getMainOfferGenre($subAd->offerGenres),
                "Prix__c" => $subAd->price ?? null,
                "Fermage_annuel__c" => $subAd->rent_price ?? null,
                "Statut__c" => $this->getAdStatus($ad->attributionAd->ad_status_id),
                "Date_de_creation_OT__c" => $this->formatDate($ad->created_at),
                "Date_de_modification_OT__c" => $this->formatDate($ad->updated_at),
                "Date_de_suppression_OT__c" => $this->formatDate($ad->deleted_at),
                "Date_de_publication_OT__c" => $this->formatDate($ad->attributionAd->published_on),
                "Descr__c" => $ad->about_project_content,
                "Informations_compl_mentaires_demandeur__c" => $ad->about_content,
                "Description__c" => $subAd->sau_description ?: $subAd->land_description ?: '',
                "Altitude_m__c" => $subAd->altitude ?? null,
                "Aboutie_grace_a_OT__c" => $ad->survey_thanks_to_platform,
                "Commentaires_suite_cloture__c" => $ad->survey_remarks,
                "ID_Laravel__c" => $ad->id
            ]);

            $this->repository->upsert('Dossier_de_demande_d_accompagnement__c', 'ID_Laravel__c', $values);

            $this->syncTerritories($ad, $departmentsByCode, $regionsByCode, $citiesByCode);
        }
    }

    private function collectUniqueCodes($ads, $relation, $field = 'code')
    {
        return $ads->pluck($relation)->flatten()->pluck($field)->unique()->toArray();
    }

    private function fetchTerritoriesByCodesInChunks(array $codes, string $codeField = 'Code_adm__c', int $chunkSize = 100)
    {
        $chunks = collect($codes)->chunk($chunkSize);
        $results = collect();

        foreach ($chunks as $chunk) {
            $queryResult = collect($this->repository->findWhere('Territoire__c', [
                $codeField => $chunk->toArray()
            ], ["Id", $codeField]));

            $results = $results->merge($queryResult);
        }

        return $results->keyBy($codeField);
    }

    private function getAdType($type)
    {
        return match ($type) {
            'landOfferAd' => 'Offre Terre',
            'landSeekAd' => 'Recherche Terre',
            'jobOfferAd' => 'Offre Expérience',
            'jobSeekAd' => 'Recherche Expérience',
            'associateOfferAd' => 'Associé sur ferme',
            'associateSeekAd' => 'Associé pour installation',
        };
    }

    private function getTerritoire($name)
    {
        return match(trim($name)) {
            "Bourgogne / Franche-Comté" => "Bourgogne-Franche-Comté",
            "Languedoc-Roussillon" => "Languedoc",
            "Champagne-Ardenne" => "Champagne",
            "Corsica" => "Corse",
            null => null,
            default => trim($name),
        };
    }

    private function getMainProductionGenre($productionGenres)
    {
        return $productionGenres->map($this->productionGenreMapper())->filter()->first();
    }

    private function getSecondaryProductionGenres($productionGenres)
    {
        return $productionGenres?->map($this->productionGenreMapper())->unique()->filter()->join(';');
    }

    private function productionGenreMapper()
    {
        return static function ($productionGenre) {
            return match ($productionGenre->name) {
                "Maraîchage" => "Maraichage",
                "Autres petites cultures (PPAM, petits fruits)" => "Petits Fruits",
                "Céréales et légumineuses" => "Grandes cultures",
                "Paysan boulanger / paysan brasseur", "Autres (chevaux, ...)", "Autres productions végétales" => "Autres productions",
                "Elevage", "Gros ruminants - Bovins (lait ou viande)" => "Bovins",
                "Petits ruminants - caprins ou ovins (lait ou viande)" => "Ovins / Caprins",
                "Volailles (oeuf ou chair)" => "Volailles",
                "Porcin" => "Porcins",
                "Petits animaux (lapins, escargots, poissons)" => "Petits animaux",
                "Aucune" => null,
                default => $productionGenre->name,
            };
        };
    }

    private function getJobOfferTypes($jobOfferTypes)
    {
        return $jobOfferTypes?->map(function ($jobOfferType) {
            return match ($jobOfferType->name) {
                "Espace-test" => "Espace Test",
                default => $jobOfferType->name,
            };
        })->unique()->join(';');
    }

    private function getBioStatus($isBio)
    {
        return match ($isBio) {
            0 => 'non',
            1 => 'oui',
            default => 'je ne sais pas encore',
        };
    }

    private function getBioCertifications($bioCertifications)
    {
        return $bioCertifications?->pluck('name')
            ->filter(fn($c) => $c !== "Aucune")
            ->join(';');
    }

    private function getWaterAccess($waterAccess)
    {
        return match ($waterAccess) {
            -1 => 'Je ne sais pas',
            0 => 'Non',
            1 => 'Oui',
            default => null,
        };
    }

    private function getInstallationType($installationType)
    {
        return $installationType ? match ($installationType->name) {
            "Seul·e" => "Seul",
            default => $installationType->name,
        } : null;
    }

    private function getMainOfferGenre($offerGenres)
    {
        if ($offerGenres?->contains(fn($genre) => $genre->name === "Je ne sais pas")) {
            return "Je ne sais pas";
        }

        $saleAndRent = $offerGenres?->pluck('name')->intersect(["Vente", "Location"])->count() === 2;
        if ($saleAndRent) {
            return "A la vente et en location";
        }

        return $offerGenres?->map(function ($offerGenre) {
            return match ($offerGenre->name) {
                "Vente" => "A la vente",
                "Location" => "En location",
                "Test Agricole" => "Pour du test agricole",
                "Leg ou donation envisagée" => "Legs ou donation à Terre de liens",
                default => null,
            };
        })->first(fn($value) => $value !== null);
    }

    private function getAdStatus($statusId)
    {
        return match ($statusId) {
            AdStatus::APPROVE_ID => 'Validé',
            AdStatus::PENDING_ID => 'En attente',
            AdStatus::REFUSE_ID => 'Refusé',
            AdStatus::PENDING_MODERATION_STATUS_ID => 'À modérer',
            AdStatus::ARCHIVED_ID => 'Archivé',
            default => null,
        };
    }

    private function formatDate($date)
    {
        return $date ? $date->setTimezone('UTC')->format('Y-m-d\TH:i:s.v\Z') : null;
    }

    private function syncTerritories($ad, $departmentsByCode, $regionsByCode, $citiesByCode)
    {
        $existingTerritories = $this->repository->findWhere('Territoire_du_dossier__c', [
            'Dossier_Objectif_Terres__c' => $ad->id
        ]);

        foreach ($existingTerritories as $territory) {
            $this->repository->delete('Territoire_du_dossier__c', $territory["Id"]);
        }

        if($ad->departments?->count()) {
            $ad->departments->pluck('code')->map(fn($code) =>
            $this->attachLocation('Département', $ad->id, $departmentsByCode[$code]["Id"])
            );
        }
        if($ad->regions?->count()) {
            $ad->regions->pluck('code')->map(fn($code) =>
            $this->attachLocation('Région', $ad->id, $regionsByCode[$code]["Id"])
            );
        }
        if($ad->cities?->count()) {
            $cities = $ad->cities->pluck('insee_code')->map(fn($code) => $citiesByCode[$code]["Id"] ?? null)->filter();
            if($cities->count()) {
                $cities->map(fn($cityId) => $this->attachLocation('Commune', $ad->id, $cityId));
            }
        }
    }

    private function attachLocation($type, $adId, $locationId)
    {
        return $this->repository->create('Territoire_du_dossier__c', [
            'Dossier_Objectif_Terres__c' => $adId,
            'Territoire__c' => $locationId,
            'Name' => $type
        ]);
    }
}
