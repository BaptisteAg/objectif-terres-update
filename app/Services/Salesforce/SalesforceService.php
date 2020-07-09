<?php namespace App\Services\Salesforce;

use App\Models\City;
use App\Models\Country;
use App\Models\Department;
use App\Models\User;
use App\Repositories\SalesForce\SalesForceRepository;
use App\Repositories\Users\UserRepository;
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

        $city = City::findOrFail($data["city_id"]);


        /**
         * example response :
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
            "LastName" => $data["name"],
            'FirstName' => $data["first_name"],
            "Phone" => $data["phone"],
            "MailingStreet" => $data["street"],
            "MailingPostalCode" => $city->zip_code,
            "MailingCity" => $city->name,
            "MailingCountry" => Country::findOrFail($data["country_id"])->name_fr_fr,
            "LeadSource" => "Petites annonces",
            "OT_Password__c" => Hash::make($data["password"])
        ]);

        return $contact;
    }

    public function updateContact($contactId, $data)
    {
        $this->repository->authenticate();

        $this->repository->update('Contact', $contactId, $data);
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
		$this->repository->authenticate();

        $email = $samlUser->getAttribute('email')[0];
        $sfId = $samlUser->getAttribute('userId')[0];

        /** @var User $localUser */
        $user = $this->repository->find('User', $sfId, ['FirstName', 'LastName', 'ProfileId', 'Role_Objectif_Terre__c']);
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

        // Sync SF ID
        $localUser->sf_id = $sfId;
        $localUser->is_sf_user = true;

        $roleAndDepartments = explode('-', $user["Role_Objectif_Terre__c"]);
        $role = $roleAndDepartments[0] ?: 0;

        // Sync role
        if((string)$localUser->role !== $role) {
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
    public function emailExists(string $email, string $object) : bool
    {
		$this->repository->authenticate();

        return !!$this->repository->findWhere($object, [
            'Email' => $email
        ]);
    }
}
