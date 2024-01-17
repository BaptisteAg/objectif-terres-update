<?php namespace App\Services\Salesforce;

use App\Models\Ad;
use App\Models\AdStatus;
use App\Models\AssociateOfferAd;
use App\Models\AssociateSeekAd;
use App\Models\City;
use App\Models\Country;
use App\Models\Department;
use App\Models\InstallationType;
use App\Models\JobOfferAd;
use App\Models\JobSeekAd;
use App\Models\LandOfferAd;
use App\Models\LandSeekAd;
use App\Models\OfferGenre;
use App\Models\User;
use App\Repositories\Ads\AdRepository;
use App\Repositories\SalesForce\SalesForceRepository;
use App\Repositories\Users\UserRepository;
use Carbon\Carbon;
use Illuminate\Console\OutputStyle;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Omniphx\Forrest\Repositories\TokenRepository;

class SalesforceService
{
    /**
     * @var SalesForceRepository
     */
    protected $repository;
    /**
     * @var UserRepository
     */
    protected $localUserRepository;
    /**
     * @var TokenRepository|null
     */
    protected $tokenRepository;

    public function __construct(SalesForceRepository $repository, UserRepository $userRepository)
    {
        $this->repository = $repository;
        $this->localUserRepository = $userRepository;
    }

    /**
     * Registers a basic user ( role : Porteur de projet )
     * in Salesforce.
     *
     * @param $data
     * @return mixed
     */
    public function registerPP($data)
    {
        $this->repository->authenticate();

        $city = City::findOrFail($data["city_id"] ?? $data["zip_code_id"]);

        if (empty($data["country_id"])) {
            // France
            $data["country_id"] = 75;
        }

        $sfPayload = [
            // Account global donné par Youssouf
            "AccountId" => "0011r00002XFjaeAAD",
            "Email" => $data["email"],
            "LastName" => $data["name"],
            'FirstName' => $data["first_name"],
            "Phone" => $data["phone"],
            "MailingStreet" => $data["street"],
            "MailingPostalCode" => $city->zip_code,
            "MailingCity" => $city->name,
            "MailingCountry" => Country::findOrFail($data["country_id"])->name_fr_fr,
            "LeadSource" => "Petites annonces",
            "OT_Password__c" => Hash::make($data["password"]),
            "role__c" => 'Annonceur Objectif Terre',
            "Recevoir_les_infos_de_TDL__c" => empty($data["accept_communication"]) ? 0 : 1
        ];

        $contactsFound = $this->repository->findWhere('Contact', ["Email" => $data["email"]]);

        if (count($contactsFound)) {
            $contactId = $contactsFound[0]["Id"];
            $contact = $this->repository->upsert('Contact', $contactId, $sfPayload);
        } else {
            /**
             * example response :
             * array:3 [
             * "id" => "0031q00000RVzsRAAT"
             * "success" => true
             * "errors" => []
             * ]
             */
            $contact = $this->repository->create('Contact', $sfPayload);
        }

        return $contact;
    }

    public function updateContact($contactId, $data)
    {
        $this->repository->authenticate();

        $this->repository->upsert('Contact', $contactId, $data);
    }

    /**
     * Used for testing only, it allows the remote creation of a user for roles > 0
     * @param $data
     */
    public function createPortalUser($data)
    {
        $this->repository->authenticate();

        /**
         * array:3 [
         * "id" => "0031q00000RVzsRAAT"
         * "success" => true
         * "errors" => []
         * ]
         */
        $contact = $this->repository->create('Contact', [
            // Account global donné par Youssouf
            "AccountId" => "0012000000o2X3TAAU",
            "Email" => $data["email"],
            "LastName" => $data["lastName"],
            'FirstName' => $data["firstName"],
            //"Phone" => $data["phone"],
            //"MailingStreet" => $data["street"],
            //"MailingPostalCode" => $city->zip_code,
            //"MailingCity" => $city->name,
            //"MailingCountry" => Country::findOrFail($data["country_id"])->name_fr_fr,
            //"OT_Password__c" => Hash::make($data["password"])
        ]);

        /**
         * array:3 [
         * "id" => "0051q000003fRgJAAU"
         * "success" => true
         * "errors" => []
         * ]
         */
        $user = $this->repository->create('User', [
            'Email' => $data["email"],
            'Username' => $data["email"],
            "Alias" => substr($data["firstName"], 0, 1) . substr($data["lastName"], 1, 7),
            'FirstName' => $data["firstName"],
            "LastName" => $data["lastName"],
            //"Phone" => $data["phone"],
            //"Street" =>$data["address"],
            //"PostalCode" => $city->zip_code,
            //"City" => $city->name,
            //"Country" => Country::findOrFail($data["country_id"])->name_fr_fr,
            "TimeZoneSidKey" => "Europe/Paris",
            "LocaleSidKey" => "fr_FR",
            "EmailEncodingKey" => "UTF-8",
            // Customer community - membre
            "ProfileId" => "00ew0000001V7RJ",
            "LanguageLocaleKey" => "fr",
            "ContactId" => $contact["id"],
            "Role_Objectif_Terre__c" => $data["role"] . "-" . implode('_', $data["departments"])
        ]);
        $this->repository->updateUserPassword($user["id"], $data["password"]);
    }

    /**
     * Right after a successful login, this method receives the retrieved
     * Saml2 User from Salesforce; it then retrieve or create a corresponding
     * local user and updates its properties if a sync is needed
     *
     * @param \Aacotroneo\Saml2\Saml2User $samlUser
     * @return User
     * @throws \Throwable
     */
    public function getSyncedLocalUserFromSaml(\Aacotroneo\Saml2\Saml2User $samlUser): User
    {
        $email = $samlUser->getAttribute('email')[0];
        $sfId = $samlUser->getAttribute('userId')[0];

        return $this->syncLocalUser($email, $sfId);
    }

    /**
     * @param string $email
     * @param string $sfId
     * @return User
     * @throws \Throwable
     */
    public function syncLocalUser(string $email, string $sfId): User
    {
        $this->repository->authenticate();

        /** @var User $localUser */
        $user = $this->repository->find('User', $sfId, ['FirstName', 'LastName', 'ProfileId', 'Role_Objectif_Terre__c']);
        if (!$user) {
            throw new \Exception("Nous n'avons pas pu vous identifier. Veuillez contacter un administrateur.");
        }
        $localUser = $this->localUserRepository->findByEmail($email);

        // Reverse user creation : if no user has been found, then we'll create it on the fly
        // to allow every salesforce-only user to pass the registration form
        if (!$localUser) {
            $localUser = $this->localUserRepository->create([
                'first_name' => $user["FirstName"],
                'name' => $user["LastName"],
                'email' => $email
            ]);
        }

        $localUser->deleted_at = null;

        // Sync Firstname / Name
        $localUser->first_name = $user["FirstName"];
        $localUser->name = $user["LastName"];

        // Sync SF ID
        $localUser->sf_id = $sfId;
        $localUser->is_sf_user = true;

        $roleAndDepartments = explode('-', $user["Role_Objectif_Terre__c"]);
        $role = (int)$roleAndDepartments[0] ?: 0;

        // Sync role
        if ($localUser->role !== $role) {
            $localUser->role = $role;
        }

        $localUser->save();

        if ($role === 4) {
            $newDepartmentIds = Department::all()->pluck('id');
            $localUser->departments()->sync($newDepartmentIds);
        } else if ($role > 0) {
            if (!isset($roleAndDepartments[1])) {
                throw new \Exception("Nous n'avons pas pu lire votre territoire renseigné dans Salesforce. Veuillez contacter un administrateur.");
            }

            $departments = explode('_', $roleAndDepartments[1]);
            // Sync user territory only for roles > 0
            $newDepartmentIds = Department::whereIn('code', $departments)->pluck('id');
            $localUser->departments()->sync($newDepartmentIds);
        }

        return $localUser;
    }

    /**
     * @param string $email
     * @return bool
     */
    public function usernameExists(string $email, string $object): bool
    {
        $this->repository->authenticate();

        return !!$this->repository->findWhere($object, [
            'Username' => $email
        ]);
    }

    /**
     * @param Collection|array|Ad[] $ads
     * @param callable|null $log
     * @return void
     */
    public function upsertAds(Collection|array $ads, OutputStyle $output): void
    {
        $this->repository->authenticate();

        $ads->load([
            'userPp',
            'userPp.zipCode',
            'attributionAd',
            ...AdRepository::getSubAdEagerLoading(),
            ...AdRepository::getLocationEagerLoading()
        ]);

        \DB::enableQueryLog();

        $users = $ads->pluck('userPp')->unique('email')->values();

        $output->text("Upserting " . count($users) . " users");

        $progressBar = $output->createProgressBar(count($users));
        $progressBar->setFormat('custom');

        $upsertedContacts = $users
            ->map(function (User $user, $i) use ($users, $progressBar) {
                try {
                    $phone = Str::limit(
                        preg_replace("/[ .-]/i",'', preg_replace('/(^\+?33 ?0?)/', '0', $user->phone)),
                        10, ''
                    );
                    // Make sure it starts with 0 or +33, otherwise add 0
                    if (!preg_match('/^(0|\+33)/', $phone)) {
                        $phone = '0' . $phone;
                    }
                    // If it's still not a valid phone number, set it to null
                    if (!preg_match('/^0[1-9]([-. ]?[0-9]{2}){4}$/', $phone)) {
                        $phone = null;
                    }

                    $values = [
                        "Email" => $user->email,
                        "OT_user_id__c" => $user->id,
                        "AccountId" => "001MU000001pZ0zYAE",
                        "LastName" => $user->name ?: 'Vide',
                        'FirstName' => $user->first_name ?: 'Vide',
                        "Phone" => $phone,
                        "MailingStreet" => $user->street,
                        "MailingPostalCode" => $user->zipCode?->zip_code,
                        "MailingCity" => $user->zipCode?->name,
                        "MailingCountry" => $user->country_id ? Country::find($user->country_id)?->name_fr_fr : 'France',
                        "LeadSource" => "Petites annonces",
                        "role__c" => 'Annonceur Objectif Terres',
                        "Recevoir_les_infos_de_TDL__c" => empty($user->accept_communication) ? 0 : 1
                    ];

                    $progressBar->setMessage("Creating Contact " . ($i + 1) . " / " . count($users) . " ( $user->email ) " . json_encode($values));
                    $progressBar->advance();
                    $progressBar->display();

                    $existingContacts = $this->repository->findWhere('Contact', ["Email" => $user->email]);

                    if (count($existingContacts)) {
                        return $this->repository->upsert('Contact/Id', $existingContacts[0]["Id"], $values);
                    }

                    return $this->repository->create('Contact', $values);
                }
                catch (\Exception $e) {
                    eval(\Psy\sh());
                }
            });


        \DB::getQueryLog();
        $progressBar->finish();

        // Do $contactsById again but chunking by 100 to avoid SOQL error
        $contactsById = $upsertedContacts->chunk(100)->map(function ($chunk) {
            return collect($this->repository->findWhere('Contact', [
                'Id' => $chunk->pluck('id')->toArray()
            ], ["Id", 'OT_user_id__c']))->keyBy('OT_user_id__c');
        })->flatten(1)->keyBy('OT_user_id__c');

        $departmentsByCode = collect($this->repository->findWhere('Territoire__c', [
            'Code_adm__c' => $ads->pluck('mainDepartment')
                ->pluck('code')
                ->unique()
                ->concat(
                    $ads->pluck('departments')
                        ->flatten()
                        ->pluck('code')
                        ->unique()
                )
                ->toArray()
        ], ["Id", 'Code_adm__c']))->keyBy('Code_adm__c');

        $regionsByCode = collect($this->repository->findWhere('Territoire__c', [
            'Code_adm__c' => $ads
                ->pluck('regions')
                ->flatten()
                ->pluck('code')
                ->unique()
                ->toArray()
        ], ["Id", 'Code_adm__c']))->keyBy('Code_adm__c');

        $citiesByCode = collect($this->repository->findWhere('Territoire__c', [
            'Code_adm__c' => $ads
                ->pluck('cities')
                ->flatten()
                ->pluck('insee_code')
                ->unique()
                ->toArray()
        ], ["Id", 'Code_adm__c']))->keyBy('Code_adm__c');

        $productionGenreMapper = function ($productionGenre) {
            return match ($productionGenre->name) {
                "Maraîchage" => "Maraichage",
                "Autres petites cultures (PPAM, petits fruits)" => "Autres productions",
                "Arboriculture" => "Arboriculture",
                "Céréales et légumineuses" => "Grandes cultures",
                "Viticulture" => "Viticulture",
                "Paysan boulanger / paysan brasseur" => "Autres productions",
                "Autres productions végétales" => "Autres productions",
                "Apiculture" => "Apiculture",
                "Elevage" => "Autres productions",
                "Gros ruminants - Bovins (lait ou viande)" => "Bovin viande",
                "Petits ruminants - caprins ou ovins (lait ou viande)" => "Ovins viande",
                "Volailles (oeuf ou chair)" => "Volailles de chair",
                "Porcin" => "Porcins",
                "Petits animaux (lapins, escargots, poissons)" => "Autres productions",
                "Autres (chevaux, ...)" => "Autres productions",
                default => null,
            };
        };

        $offerGenreMapper = function (OfferGenre $offerGenre) {
            return match ($offerGenre->name) {
                "Vente" => "À la vente",
                "Location" => "En location",
                "Test Agricole" => "Pour du test agricole",
                "Leg ou donation envisagée" => "Leg ou donation à Terre de liens",
                default => null,
            };
        };

        $installationTypeMapper = function (InstallationType $type) {
            return match ($type->name) {
                "Seul·e" => "Seul",
                default => $type->name,
            };
        };

        $progressBar = $output->createProgressBar(count($ads));
        $progressBar->setFormat('custom');

        $output->text("Upserting " . count($ads) . " ads");

        foreach ($ads as $ad) {
            $this->repository->authenticate();
            /** @var LandSeekAd|LandOfferAd|JobSeekAd|JobOfferAd|AssociateOfferAd|AssociateSeekAd $subAd */
            $subAd = $ad->{$ad->type};

            try {
                $values = array_filter([
                    "RecordType" => ["Name" => "Annonce"],
                    "Type_d_annonce__c" => match ($ad->type) {
                        'landOfferAd' => 'Recherche Terre',
                        'landSeekAd' => 'Offre Terre',
                        'jobOfferAd' => 'Recherche Expérience',
                        'jobSeekAd' => 'Offre Expérience',
                        'associateOfferAd' => 'Associé pour installation',
                        'associateSeekAd' => 'Associé sur ferme',
                    },
                    "Name" => \Str::limit($ad->title,  80, ''),
                    "Contact__c" => $contactsById[$ad->userPp->id]["Id"],
                    "Territoire_Principal__c" => $departmentsByCode[$ad->mainDepartment->code]["Id"],
                    "Surface_ha__c" => $subAd->surface ?? null,
                    "Production_agricole_prinicipale__c" => $subAd?->productionGenres->map($productionGenreMapper)[0] ?? null,
                    "Autres_productions_agricoles__c" => $subAd->productionGenresSecondary?->map($productionGenreMapper)?->unique()?->join(';') ?? null,
                    "Experience_professionnelle_recherchee__c" => $subAd->jobOfferTypes?->pluck('name')[0] ?? null,
                    "Transmission_d_activit_agricole__c" => $subAd->is_activity_transmission ? 'Oui' : 'Non',
                    "Agriculture_biologique__c" => match ($subAd->is_bio) {
                        -1 => 'je ne sais (pas encore)',
                        0 => 'non',
                        1 => 'oui',
                        default => null,
                    },
                    "Certification_des_terres__c" => $subAd->is_bio ? $subAd->bioCertifications?->pluck('name')->join(';') ?? null : null,
                    "Acces_eau__c" => match ($subAd->water_access) {
                        -1 => 'Je ne sais pas',
                        0 => 'Non',
                        1 => 'Oui',
                        default => null,
                    },
                    "Presence_d_habitations__c" => $subAd->has_houses,
                    "Presence_de_batiments_agricoles__c" => $subAd->has_buildings,
                    "Modalite_d_installation__c" => $subAd->installationType ? $installationTypeMapper($subAd->installationType) : null,
                    "Type_de_transmission__c" => $subAd->offerGenres?->map($offerGenreMapper)[0] ?? null,
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
                    "Date_de_creation_OT__c" => $ad->created_at->format('Y-m-d'),
                    "Date_de_modification_OT__c" => $ad->updated_at->format('Y-m-d'),
                    "Date_de_suppression_OT__c" => $ad->deleted_at?->format('Y-m-d'),
                    "Date_de_publication_OT__c" => Carbon::make($ad->attributionAd->published_on)?->format('Y-m-d'),
                ], fn($value) => $value !== null);

                $progressBar->setMessage("Upserting Ad " . " ( $ad->id )" . json_encode($values));
                $progressBar->advance();
                $progressBar->display();

                $response = $this->repository->upsert('Dossier_de_demande_d_accompagnement__c/ID_Laravel__c', $ad->id, $values);

                if ($response["success"]) {
                    $id = $response["id"];
                    //$this->repository->deleteWhere('Territoire_du_dossier__c', [
                    //    'Dossier_Objectif_Terres__c' => $id
                    //]);
                    if($ad->departments?->count()) {
                        $this->repository->create('Territoire_du_dossier__c', [
                            'Dossier_Objectif_Terres__c' => $id,
                            'Territoire__c' => $ad->departments->pluck('code')->map(fn($code) => $departmentsByCode[$code]["Id"])->join(';'),
                            'Name' => 'Départment'
                        ]);
                    }
                    if($ad->regions?->count()) {
                        $this->repository->create('Territoire_du_dossier__c', [
                            'Dossier_Objectif_Terres__c' => $id,
                            'Territoire__c' => $ad->regions->pluck('code')->map(fn($code) => $regionsByCode[$code]["Id"])->join(';'),
                            'Name' => 'Région'
                        ]);
                    }
                    if($ad->cities?->count()) {
                        $cities = $ad->cities->pluck('insee_code')->map(fn($code) => $citiesByCode[$code]["Id"] ?? null)->filter();
                        if($cities->count()) {
                            $this->repository->create('Territoire_du_dossier__c', [
                                'Dossier_Objectif_Terres__c' => $id,
                                'Territoire__c' => $cities->join(';'),
                                'Name' => 'Commune'
                            ]);
                        }
                    }
                }
            } catch (\Exception $e) {
                eval(\Psy\sh());
            }
        }
        $progressBar->finish();
    }
}
