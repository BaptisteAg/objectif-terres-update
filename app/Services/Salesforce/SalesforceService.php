<?php namespace App\Services\Salesforce;

use App\Models\Ad;
use App\Models\AdStatus;
use App\Models\AttributionAd;
use App\Models\City;
use App\Models\Country;
use App\Models\Department;
use App\Models\User;
use App\Repositories\Ads\AdRepository;
use App\Repositories\SalesForce\SalesForceRepository;
use App\Repositories\Users\UserRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
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

        if(empty($data["country_id"])) {
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

        if(count($contactsFound)) {
            $contactId = $contactsFound[0]["Id"];
            $contact = $this->repository->upsert('Contact', $contactId, $sfPayload);
        }
        else {
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
            "Alias" => substr($data["firstName"],0,1) . substr($data["lastName"],1,7),
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
            "Role_Objectif_Terre__c" => $data["role"]."-".implode('_', $data["departments"])
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
    public function getSyncedLocalUserFromSaml(\Aacotroneo\Saml2\Saml2User $samlUser) : User
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
    public function syncLocalUser(string $email, string $sfId) : User {
        $this->repository->authenticate();

        /** @var User $localUser */
        $user = $this->repository->find('User', $sfId, ['FirstName', 'LastName', 'ProfileId', 'Role_Objectif_Terre__c']);
        if(!$user) {
            throw new \Exception("Nous n'avons pas pu vous identifier. Veuillez contacter un administrateur.");
        }
        $localUser = $this->localUserRepository->findByEmail($email);

        // Reverse user creation : if no user has been found, then we'll create it on the fly
        // to allow every salesforce-only user to pass the registration form
        if(!$localUser) {
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
        if($localUser->role !== $role) {
            $localUser->role = $role;
        }

        $localUser->save();

        if($role === 4) {
            $newDepartmentIds = Department::all()->pluck('id');
            $localUser->departments()->sync($newDepartmentIds);
        }
        else if($role > 0) {
            if(!isset($roleAndDepartments[1])) {
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
    public function usernameExists(string $email, string $object) : bool
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
    public function upsertAds(Collection|array $ads, callable $log = null): void
    {
        $this->repository->authenticate();
        $log = $log ?? function() {};

        $ads->load([
            'userPp',
            'userPp.zipCode',
            'attributionAd',
            ...AdRepository::getSubAdEagerLoading(),
            ...AdRepository::getLocationEagerLoading()
        ]);

        $users = $ads->pluck('userPp')->unique('email');

        $log("Upserting ".count($users)." users");

        $contactsByEmail = $users->map(function(User $user, $i) use($log, $users) {
            $log("Creating Contact " . ($i+1) . " / ".count($users)." ( $user->email )");

             return $this->repository->upsert('Contact/Email', $user->email, [
                "AccountId" => "0011r00002XFjaeAAD",
                "LastName" => $user->name,
                'FirstName' => $user->first_name,
                "Phone" => $user->phone,
                "MailingStreet" => $user->street,
                "MailingPostalCode" => $user->zipCode->zip_code,
                "MailingCity" => $user->zipCode->name,
                "MailingCountry" => $user->country_id ? Country::findOrFail($user->country_id)->name_fr_fr : 'France',
                "LeadSource" => "Petites annonces",
                "role__c" => 'Annonceur Objectif Terres',
                "Recevoir_les_infos_de_TDL__c" => empty($user->accept_communication) ? 0 : 1
            ]);
        });

        $departmentsByCode = collect($this->repository->findWhere('Territoire_Principal__c', [
            'Code__c' => $ads->pluck('department')->pluck('code')->unique()->toArray()
        ], ['Id', 'Code__c']))->keyBy('Code__c');

        $log("Upserting ".count($ads)." ads");

        foreach($ads as $i => $ad) {
            $log("Upserting Ad " . ($i+1) . " / ".count($ads)." ( $ad->id )");

            $this->repository->upsert('Dossier_de_demande_d_accompagnement__c/ID_Laravel', $ad->id, [
                "Type_d_annonce__c" => match($ad->type) {
                    'landOfferAd' => 'Recherche Terre',
                    'landSeekAd' => 'Offre Terre',
                    'jobOfferAd' => 'Recherche Expérience',
                    'jobSeekAd' => 'Offre Expérience',
                    'associateOfferAd' => 'Associé pour installation',
                    'associateSeekAd' => 'Associé sur ferme',
                },
                "Name" => $ad->title,
                "Contact__c" => $contactsByEmail[$ad->user->email]["Id"],
                "Territoire_Principal__c" => $departmentsByCode[$ad->department->code]["Id"],
                "Surface_ha__c" => $ad->{$ad->type}->surface ?? null,
                "Production_agricole_prinicipale__c" => $ad->{$ad->type}->productionGenres[0]->name ?? null,
                "Autres_productions_agricoles__c" => $ad->{$ad->type}->productionGenresSecondary->pluck('name')->join(', ') ?? null,
                "Experience_professionnelle_recherchee__c" => $ad->{$ad->type}->jobOfferTypes->pluck('name')->join(', ') ?? null,
                "Transmission_d_activit_agricole__c" => $ad->{$ad->type}->is_activity_transmission ? 'Oui' : 'Non',
                "Certification_des_terres__c" => $ad->{$ad->type}->bioCertifications->pluck('name')->join(', ') ?? null,
                "Acces_eau__c" => match($ad->{$ad->type}->has_water_access) {
                    -1 => 'Je ne sais pas',
                    0 => 'Non',
                    1 => 'Oui',
                },
                "Presence_d_habitations__c" => $ad->{$ad->type}->has_houses ? 'Oui' : 'Non',
                "Presence_de_batiments_agricoles__c" => $ad->{$ad->type}->has_buildings ? 'Oui' : 'Non',
                "Modalite_d_installation__c" => $ad->{$ad->type}->installationType->name ?? null,
                "Type_de_transmission__c" => $ad->{$ad->type}->offerGenres->pluck('name')->join(', ') ?? null,
                "Prix__c" => $ad->{$ad->type}->price ?? null,
                "Fermage_annuel__c" => $ad->{$ad->type}->rent_price ?? null,
                "Statut__c" => match($ad->attributionAd->ad_status_id) {
                    AdStatus::APPROVE_ID => 'Validée',
                    AdStatus::PENDING_ID => 'En attente',
                    AdStatus::REFUSE_ID => 'Refusée',
                    AdStatus::PENDING_MODERATION_STATUS_ID => 'À modérer',
                    AdStatus::ARCHIVED_ID => 'Archivée',
                },
            ]);
        }
    }
}
