<?php namespace App\Sync;

use App\Models\Ad;
use App\Models\AdStatus;
use App\Models\AssociateOfferAd;
use App\Models\AssociateSeekAd;
use App\Models\BioCertification;
use App\Models\Country;
use App\Models\InstallationType;
use App\Models\JobOfferAd;
use App\Models\JobSeekAd;
use App\Models\LandOfferAd;
use App\Models\LandSeekAd;
use App\Models\OfferGenre;
use App\Models\User;
use App\Presenters\AdPresenter;
use App\Repositories\Ads\AdRepository;
use App\Repositories\SalesForce\SalesForceRepository;
use Carbon\Carbon;
use Illuminate\Console\OutputStyle;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Omniphx\Forrest\Exceptions\SalesforceException;

class AdsToSalesforceSync
{

    public function __construct(private SalesForceRepository $repository)
    {
    }

    public function run(Collection|array $ads, OutputStyle $output)
    {
        $this->repository->authenticate();

        $ads = $ads->load([
            'userPp',
            'userPp.zipCode',
            'attributionAd',
            ...AdRepository::getSubAdEagerLoading(),
            ...AdRepository::getLocationEagerLoading()
        ]);

        //$ads = $ads->filter(function ($ad) use(&$passed) {
        //    //if($ad->userPp->id === 14104) {
        //    if($ad->id === 7466) {
        //        return true;
        //    }
        //    return false;
        //});

        \DB::enableQueryLog();

        $users = $ads->pluck('userPp')->unique('email')->values();

        //$existingContactsById = $this->fetchExistingContactsInChunks($users->pluck('OT_user_id__c')->toArray());
        $existingContactsByEmail = $this->fetchExistingContactsInChunks($users->pluck('email')->toArray());

        $output->text("Upserting " . count($users) . " users");

        $progressBar = $output->createProgressBar(count($users));
        $progressBar->setFormat('custom');

        $upsertedContacts = $users
            ->map(function (User $user, $i) use ($users, $progressBar, $output, /*$existingContactsById,*/ $existingContactsByEmail) {
                $lastError = null;
                $tries = 0;
                do {
                    try {
                        $tries++;
                        $phone = Str::limit(
                            preg_replace("/[ .-]/i",'', preg_replace('/(^\+?33 ?0?)/', '0', $user->phone)),
                            10, ''
                        );
                        // Make sure it starts with 0 or +33, otherwise add 0
                        if (!preg_match('/^(0|\+33)/', $phone)) {
                            $phone = '0' . $phone;
                        }
                        // If it's still not a valid phone number, set it to null
                        if (($lastError === "INVALID_PHONE") || $this->isInvalidPhoneNumber($phone)) {
                            $phone = null;
                        }

                        $values = array_filter([
                            "Email" => $user->email,
                            "OT_user_id__c" => $user->id,
                            "Phone" => $phone,
                            "MailingStreet" => $user->street,
                            "MailingPostalCode" => $user->zipCode?->zip_code,
                            "MailingCity" => $user->zipCode?->name,
                            "MailingCountry" => $user->country_id ? Country::find($user->country_id)?->name_fr_fr : 'France',
                            "LeadSource" => "Petites annonces",
                            "role__c" => 'Annonceur Objectif Terres',
                            "Profil_Objectif_Terres__c" => $user->profile ? \App\Models\User::$profiles[$user->profile] : null,
                            "Recevoir_les_infos_de_TDL__c" => empty($user->accept_communication) ? 0 : 1,
                        ]);

                        $progressBar->advance();
                        $progressBar->display();

                        //$existingContact = $existingContactsById[$user->id] ?? null;
                        //if ($existingContact) {
                        //    $progressBar->setMessage("Updating Contact " . ($i + 1) . " / " . count($users) . " ( $user->email ) " . json_encode($values). "\n");
//
                        //    // Fixing OT Phone Data Quality because stuck for update
                        //    if($existingContact["MobilePhone"] && $this->isInvalidPhoneNumber($existingContact["MobilePhone"])) {
                        //        // try to fix it. Data should be kept intact as much as possible
                        //        // Only if the phone number is still invalid should we replace it with the new one
                        //        $values["MobilePhone"] = $this->fixPhoneNumber($existingContact["MobilePhone"]);
//
                        //    }
                        //    return $this->repository->update('Contact/Id', $existingContact["Id"], $values);
                        //}

                        $existingContact = $existingContactsByEmail[$user->email] ?? null;
                        if ($existingContact) {
                            $progressBar->setMessage("Updating Contact " . ($i + 1) . " / " . count($users) . " ( $user->email ) " . json_encode($values). "\n");

                            // Fixing OT Phone Data Quality because stuck for update
                            if($existingContact["MobilePhone"] && $this->isInvalidPhoneNumber($existingContact["MobilePhone"])) {
                                // try to fix it. Data should be kept intact as much as possible
                                // Only if the phone number is still invalid should we replace it with the new one
                                $values["MobilePhone"] = $this->fixPhoneNumber($existingContact["MobilePhone"]);

                            }
                            return $this->repository->update('Contact/Id', $existingContact["Id"], $values);
                        }

                        $progressBar->setMessage("Creating Contact " . ($i + 1) . " / " . count($users) . " ( $user->email ) " . json_encode($values). "\n");

                        return $this->repository->create('Contact', array_merge($values,[
                            "AccountId" => config('salesforce.contact_account_id'),
                            "LastName" => $user->name ?: 'Vide',
                            'FirstName' => $user->first_name ?: 'Vide',
                        ]));
                    }
                    catch (\Exception $e) {
                        if($e instanceof SalesforceException) {
                            $json = json_decode($e->getMessage(), true);
                            $errorCode = $json["errorCode"] ?? " ";

                            if($errorCode === "UNABLE_TO_LOCK_ROW") {
                                $output->error("UNABLE_TO_LOCK_ROW error, retrying...");
                                continue;
                            }
                            if($errorCode === "FIELD_CUSTOM_VALIDATION_EXCEPTION" && $json["fields"][0] === "Phone") {
                                $lastError = "INVALID_PHONE";
                                continue;
                            }
                            if(isset($json[0]["duplicateResult"])) {
                                $id = $json[0]["duplicateResult"]["matchResults"][0]["matchRecords"][0]["record"]["Id"];
                                return $this->repository->find('Contact', $id, ["Id", 'OT_user_id__c']);
                            }
                            $lastError = $errorCode;
                        }
                    }
                } while($tries < 3);
                eval(\Psy\sh());
                return null;
            })->filter();


        \DB::getQueryLog();
        $progressBar->finish();

        // Do $contactsById again but chunking by 100 to avoid SOQL error
        $contactsById = $upsertedContacts->chunk(100)->map(function ($chunk) {
            return collect($this->repository->findWhere('Contact', [
                'Id' => $chunk->pluck('id')->toArray()
            ], ["Id", 'OT_user_id__c']))->keyBy('OT_user_id__c');
        })->flatten(1)->keyBy('OT_user_id__c');

        // Collect unique codes for departments, regions, and cities
        $departmentCodes = $ads->pluck('mainDepartment')->pluck('code')->unique()
            ->concat($ads->pluck('departments')->flatten()->pluck('code')->unique())->toArray();
        $regionCodes = $ads->pluck('regions')->flatten()->pluck('code')->unique()->toArray();
        $cityCodes = $ads->pluck('cities')->flatten()->pluck('insee_code')->unique()->toArray();

        // Fetch territories by codes in chunks
        $departmentsByCode = $this->fetchTerritoriesByCodesInChunks($departmentCodes);
        $regionsByCode = $this->fetchTerritoriesByCodesInChunks($regionCodes);
        $citiesByCode = $this->fetchTerritoriesByCodesInChunks($cityCodes);

        $productionGenreMapper = function ($productionGenre) {
            return match ($productionGenre->name) {
                "Maraîchage" => "Maraichage",
                "Autres petites cultures (PPAM, petits fruits)" => "Petits Fruits",
                "Céréales et légumineuses" => "Grandes cultures",
                "Paysan boulanger / paysan brasseur" => "Autres productions",
                "Autres productions végétales" => "Autres productions",
                "Elevage" => "Bovins",
                "Gros ruminants - Bovins (lait ou viande)" => "Bovins",
                "Petits ruminants - caprins ou ovins (lait ou viande)" => "Ovins / Caprins",
                "Volailles (oeuf ou chair)" => "Volailles",
                "Porcin" => "Porcins",
                "Petits animaux (lapins, escargots, poissons)" => "Petits animaux",
                "Autres (chevaux, ...)" => "Autres productions",
                "Aucune" => null,
                default => $productionGenre->name,
            };
        };

        $installationTypeMapper = function (InstallationType $type) {
            return match ($type->name) {
                "Seul·e" => "Seul",
                default => $type->name,
            };
        };

        $jobOfferTypeMapper = function ($jobOfferType) {
            return match ($jobOfferType->name) {
                "Espace-test" => "Espace Test",
                default => $jobOfferType->name,
            };
        };

        $progressBar = $output->createProgressBar(count($ads));
        $progressBar->setFormat('custom');

        $existingAds = $this->fetchExistingAdsInChunks($ads->pluck('id')->toArray());

        $output->text("Upserting " . count($ads) . " ads");

        /** @var Ad $ad */
        foreach ($ads as $ad) {
            $this->repository->authenticate();
            /** @var LandSeekAd|LandOfferAd|JobSeekAd|JobOfferAd|AssociateOfferAd|AssociateSeekAd $subAd */
            $subAd = $ad->{$ad->type};
            /** @var AdPresenter $presenter */
            $presenter = app(AdPresenter::class)->setWrappedObject($ad);

            try {
                $values = array_filter([
                    "RecordType" => ["Name" => "Annonce"],
                    "Type_d_annonce__c" => match ($ad->type) {
                        'landOfferAd' => 'Offre Terre',
                        'landSeekAd' => 'Recherche Terre',
                        'jobOfferAd' => 'Offre Expérience',
                        'jobSeekAd' => 'Recherche Expérience',
                        'associateOfferAd' => 'Associé sur ferme',
                        'associateSeekAd' => 'Associé pour installation',
                    },
                    "Name" => \Str::limit($ad->title,  80, ''),
                    "Contact__c" => $contactsById[$ad->userPp->id]["Id"] ?? null,
                    "Territoire_Principal__c" => $ad->main_department ? $departmentsByCode[$ad->mainDepartment->code]["Id"] : null,
                    "Territoire_concerne__c" => $ad->main_department->territory->name ?? null,
                    "Surface_ha__c" => $presenter->surface ?? null,
                    "Production_agricole_prinicipale__c" => $subAd?->productionGenres->map($productionGenreMapper)->filter()[0] ?? null,
                    "Autres_productions_agricoles__c" => $subAd->productionGenresSecondary?->map($productionGenreMapper)?->unique()?->filter()?->join(';') ?? null,
                    "Experience_professionnelle_recherchee__c" => $subAd->jobOfferTypes?->map($jobOfferTypeMapper)?->unique()?->join(';') ?? null,
                    "Transmission_d_activit_agricole__c" => $subAd->is_activity_transmission ? 'Oui' : 'Non',
                    "Agriculture_biologique__c" => /*$subAd->bioCertifications?->count() ? 'oui' :*/ match ($subAd->is_bio) {
                        -1 => 'je ne sais pas encore',
                        0 => 'non',
                        1 => 'oui',
                        default => 'je ne sais pas encore',
                    },
                    "Certification_des_terres__c" => $subAd->bioCertifications?->pluck('name')
                        ->filter(fn($c) => $c !== "Aucune")
                        ->join(';'),
                    "Acces_eau__c" => match ($subAd->water_access) {
                        -1 => 'Je ne sais pas',
                        0 => 'Non',
                        1 => 'Oui',
                        default => null,
                    },
                    "Presence_d_habitations__c" => $subAd->has_houses,
                    "Presence_de_batiments_agricoles__c" => $subAd->has_buildings,
                    "Modalite_d_installation__c" => $subAd->installationType ? $installationTypeMapper($subAd->installationType) : null,
                    "Type_de_transmission__c" => $this->getMainOfferGenre($subAd->offerGenres),
                    "Prix__c" => $subAd->price ?? null,
                    "Fermage_annuel__c" => $subAd->rent_price ?? null,
                    "Statut__c" => match ($ad->attributionAd->ad_status_id) {
                        AdStatus::APPROVE_ID => 'Validé',
                        AdStatus::PENDING_ID => 'En attente',
                        AdStatus::REFUSE_ID => 'Refusé',
                        AdStatus::PENDING_MODERATION_STATUS_ID => 'À modérer',
                        AdStatus::ARCHIVED_ID => 'Archivé',
                        default => null,
                    },
                    "Date_de_creation_OT__c" => $ad->created_at->setTimezone('UTC')->format('Y-m-d\TH:i:s.v\Z'),
                    "Date_de_modification_OT__c" => $ad->updated_at->setTimezone('UTC')->format('Y-m-d\TH:i:s.v\Z'),
                    "Date_de_suppression_OT__c" => $ad->deleted_at?->setTimezone('UTC')->format('Y-m-d\TH:i:s.v\Z'),
                    "Date_de_publication_OT__c" => Carbon::make($ad->attributionAd->published_on)?->setTimezone('UTC')->format('Y-m-d\TH:i:s.v\Z'),
                    "Descr__c" => $ad->about_project_content,
                    "Informations_compl_mentaires_demandeur__c" => $ad->about_content,
                    "Description__c" => $subAd->sau_description ?: $subAd->land_description ?: '',
                    "Altitude_m__c" => $subAd->altitude ?? null,
                    // TODO Baptiste : mapping des champs suivants
                    //"Aboutie_grace_a_OT__c" => $ad->closed_because_ot ? 'Oui' : 'Non',
                    //"Commentaires_suite_cloture__c" => $ad->closed_comment,
                ], fn($value) => $value !== null);

                $progressBar->advance();
                $progressBar->display();

                $existingAd = $existingAds[$ad->id] ?? null;

                if($existingAd) {
                    $progressBar->setMessage("Updating Ad " . " ( $ad->id )" . json_encode($values) . "\n");
                    $response = $this->repository->update('Dossier_de_demande_d_accompagnement__c/ID_Laravel__c', $ad->id, $values);
                } else {
                    $progressBar->setMessage("Creating Ad " . " ( $ad->id )" . json_encode($values) . "\n");
                    $response = $this->repository->create('Dossier_de_demande_d_accompagnement__c', array_merge($values, [
                        "ID_Laravel__c" => $ad->id
                    ]));
                }

                if ($response["success"]) {
                    $id = $response["id"];

                    $existingTerritories = $this->repository->findWhere('Territoire_du_dossier__c', [
                        'Dossier_Objectif_Terres__c' => $id
                    ]);

                    foreach ($existingTerritories as $territory) {
                        $this->repository->delete('Territoire_du_dossier__c', $territory["Id"]);
                    }

                    if($ad->departments?->count()) {
                        $ad->departments->pluck('code')->map(fn($code) =>
                            $this->attachTerritory('Département', $id, $departmentsByCode[$code]["Id"])
                        );
                    }
                    if($ad->regions?->count()) {
                        $ad->regions->pluck('code')->map(fn($code) =>
                            $this->attachTerritory('Région', $id, $regionsByCode[$code]["Id"])
                        );
                    }
                    if($ad->cities?->count()) {
                        $cities = $ad->cities->pluck('insee_code')->map(fn($code) => $citiesByCode[$code]["Id"] ?? null)->filter();
                        if($cities->count()) {
                            $cities->map(fn($cityId) => $this->attachTerritory('Commune', $id, $cityId));
                        }
                    }
                }
            } catch (\Exception $e) {
                eval(\Psy\sh());
            }
        }
        $progressBar->finish();
    }

    /**
     * Fetches territories by codes in chunks to avoid SOQL query max length.
     *
     * @param array $codes The list of territory codes to fetch.
     * @param string $codeField The field name in Salesforce that corresponds to the territory code.
     * @param int $chunkSize The size of each chunk to fetch at a time.
     * @return \Illuminate\Support\Collection
     */
    private function fetchTerritoriesByCodesInChunks(array $codes, string $codeField = 'Code_adm__c', int $chunkSize = 100): \Illuminate\Support\Collection {
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

    private function fetchExistingAdsInChunks(array $ids, int $chunkSize = 100): \Illuminate\Support\Collection {
        $chunks = collect($ids)->chunk($chunkSize);
        $results = collect();

        foreach ($chunks as $chunk) {
            $queryResult = collect($this->repository->findWhere('Dossier_de_demande_d_accompagnement__c', [
                'ID_Laravel__c' => $chunk->toArray()
            ], ["Id", 'ID_Laravel__c']));

            $results = $results->merge($queryResult);
        }

        return $results->keyBy('ID_Laravel__c');
    }

    private function attachTerritory(string $name, mixed $adId, $territoryId)
    {
        return $this->repository->create('Territoire_du_dossier__c', [
            'Dossier_Objectif_Terres__c' => $adId,
            'Territoire__c' => $territoryId,
            'Name' => $name
        ]);
    }

    private function getMainOfferGenre(Collection|null $offerGenres)
    {
        // Check if "Je ne sais pas" is one of the genres
        $unknown = $offerGenres?->contains(function (OfferGenre $offerGenre) {
            return $offerGenre->name === "Je ne sais pas";
        });

        if ($unknown) {
            return "Je ne sais pas";
        }

        // Check for both "Vente" and "Location"
        $saleAndRent = $offerGenres?->pluck('name')->intersect(["Vente", "Location"])->count() === 2;
        if ($saleAndRent) {
            return "A la vente et en location";
        }

        // Map each genre to its Salesforce equivalent
        return $offerGenres?->map(function (OfferGenre $offerGenre) {
            return match ($offerGenre->name) {
                "Vente" => "A la vente",
                "Location" => "En location",
                "Test Agricole" => "Pour du test agricole",
                "Leg ou donation envisagée" => "Legs ou donation à Terre de liens",
                default => null,
            };
        })->first(fn($value) => $value !== null);
    }

    private function fetchExistingContactsInChunks(array $toArray)
    {
        $chunks = collect($toArray)->chunk(100);
        $results = collect();

        foreach ($chunks as $chunk) {
            $queryResult = collect($this->repository->findWhere('Contact', [
                'Email' => $chunk->toArray()
            ], ["Id", 'Email', 'Phone', 'MobilePhone', 'OT_user_id__c']));

            $results = $results->merge($queryResult);
        }

        return $results->keyBy('Email');
    }

    private function isInvalidPhoneNumber($phone): bool
    {
        // Array of valid patterns
        $validPatterns = [
            '/^\(\d{3}\) \d{3}-\d{4}$/',    // (999) 999-9999
            '/^\+?\d{10,13}$/',             // +9999999999 (10 à 13 chiffres)
            '/^\d{3}-\d{3}-\d{4}$/'         // 999-999-9999
        ];

        foreach ($validPatterns as $pattern) {
            if (preg_match($pattern, $phone)) {
                return false; // The number is valid
            }
        }

        return true; // The number is invalid
    }

    /**
     * Try fixing incorrect strings containing a mobile phone
     * Remove any extra string and format the phone number
     * Example :
     * - 06 12 34 56 78 => 0612345678
     * - something 06 12 34 56 78 => 0612345678
     * - +33 6 12 34 56 78 (something) => +33612345678
     *
     * @param string $phoneNumber
     * @return string|null
     */
    private function fixPhoneNumber(string $phoneNumber) {
        // Remove any non-digit characters except for '+'
        $cleanedNumber = preg_replace('/[^\d+]/', '', $phoneNumber);

        // Check if the cleaned number is valid using the helper
        if ($this->isInvalidPhoneNumber($cleanedNumber)) {
            return null; // Return null if the number is still invalid
        }

        return $cleanedNumber;
    }
}