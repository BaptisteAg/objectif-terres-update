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

    protected $profileToRoleMapping = [
        // Customer community - membre
        '00ew0000001V7RJAA0' => 0,
		// Moderator ( Chatter External User )
        '00e1r000001td1kAAA' => 1,
        // Responsable territorial - Supervisor ( Customer community - Resp. Territorial )
        '00e1q000000M41YAAS' => 3,
		// Super Admin
		'00e20000001FEdPAAW' => 4,
		// .. TODO: remove completely
	];

    public function __construct(SalesForceRepository $repository, UserRepository $userRepository)
    {
        $this->repository = $repository;
        $this->localUserRepository = $userRepository;

        /** @var TokenRepository $forrestToken */
        $forrestToken = app('forrest_token');

        if(!$forrestToken->has()) {
            $this->repository->authenticate();
        }
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
            "OT_Password__c" => Hash::make($data["password"])
        ]);

        return $contact;
    }

    /**
     * Used for testing only, it allows the remote creation of a user for roles > 0
     * @param $data
     */
    public function createPortalUser($data)
    {
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
        if($localUser->sf_id != $sfId) {
            $localUser->sf_id = $sfId;
        }

        // Sync role
        if((string)$localUser->role !== $this->getRoleFromUser($user)) {
            $localUser->role = $this->getRoleFromUser($user);
        }

        // Sync territory
        $newDepartmentIds = Department::all()->pluck('id')->toArray();
        $localUser->departments()->sync($newDepartmentIds);

        $localUser->save();

        return $localUser;
    }

    /**
     * @param string $email
     * @return bool
     */
    public function emailExists(string $email, string $object) : bool
    {
        return !!$this->repository->findWhere($object, [
            'Email' => $email
        ]);
    }

    protected function getRoleFromUser($user)
    {
        if(!empty($user["Role_Objectif_Terre__c"])) {
            return explode('-', $user["Role_Objectif_Terre__c"])[0];
        }

        return $this->profileToRoleMapping[$user["ProfileId"]] ?? 0;
    }
}