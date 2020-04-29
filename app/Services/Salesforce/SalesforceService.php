<?php namespace App\Services\Salesforce;

use App\Models\City;
use App\Models\Country;
use App\Models\Department;
use App\Models\User;
use App\Repositories\SalesForce\SalesForceRepository;
use App\Repositories\Users\UserRepository;
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
    protected $userRepository;
    /**
     * @var TokenRepository|null
     */
    protected $tokenRepository;

    protected $profileToRoleMapping = [
        // Customer community - membre
        '00ew0000001V7RJAA0' => 0,
		// Moderator ( Chatter External User )
        '00e1r000001td1kAAA' => 1,
		// Super Admin
		'00e20000001FEdPAAW' => 4,
		// .. TODO: complete
	];

    public function __construct(SalesForceRepository $repository, UserRepository $userRepository)
    {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
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
        $this->apiAuthenticationRefresh();

        $city = City::findOrFail($data["city_id"]);

        /*
         * array:3 [
              "id" => "0011q00000XA0LIAA1"
              "success" => true
              "errors" => []
            ]
         */
        /*$account = $this->repository->create('Account', [
            "Name" => $data["first_name"] . " " . $data["name"],
            "Description" => "Compte Objectif Terre",
        ]);*/

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
            "LastName" => $data["name"],
            'FirstName' => $data["first_name"],
            "Phone" => $data["phone"],
            "MailingStreet" => $data["street"],
            "MailingPostalCode" => $city->zip_code,
            "MailingCity" => $city->name,
            "MailingCountry" => Country::findOrFail($data["country_id"])->name_fr_fr,
        ]);
        /**
         * array:3 [
         * "id" => "0051q000003fRgJAAU"
         * "success" => true
         * "errors" => []
         * ]
         */

        /*$user = $this->repository->create('User', [
            'Email' => $data["email"],
            'Username' => $data["email"],
            "Alias" => substr($data["first_name"],0,1) . substr($data["name"],1,7),
            'FirstName' => $data["first_name"],
            "LastName" => $data["name"],
            "Phone" => $data["phone"],
            "Street" =>$data["address"],
            "PostalCode" => $city->zip_code,
            "City" => $city->name,
            "Country" => Country::findOrFail($data["country_id"])->name_fr_fr,
            "TimeZoneSidKey" => "Europe/Paris",
            "LocaleSidKey" => "fr_FR",
            "EmailEncodingKey" => "UTF-8",
            // Chatter Free
            //"ProfileId" => "00e20000001clYf",
            // Chatter External
            //"ProfileId" => "00e20000001Ue7l",
            // Customer community - membre
            "ProfileId" => "00ew0000001V7RJ",
            // "PP Objectif Terres"
            //"ProfileId" => "00e1q000000M3vz",
            "LanguageLocaleKey" => "fr",
            "ContactId" => $contact["id"]
        ]);
        $this->repository->updateUserPassword($user["id"], $data["password"]);*/

        return $contact;
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
        $this->apiAuthenticationRefresh();

        $email = $samlUser->getAttribute('email')[0];
        $sfId = $samlUser->getAttribute('userId')[0];

        /** @var User $localUser */
        $user = $this->repository->find('User', $sfId, ['FirstName', 'LastName', 'ProfileId']);
        $localUser = $this->userRepository->findByEmail($email);

        // Reverse user creation : if no user has been found, then we'll create it on the fly
        // to allow every salesforce-only user to pass the registration form
        if(!$localUser) {
			$localUser = $this->userRepository->create([
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
        if($localUser->role !== $this->getRoleFromUser($user)) {
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
    public function emailExists(string $email) : bool
    {
        $this->apiAuthenticationRefresh();

        return !!$this->repository->findWhere('Contact', [
            'Email' => $email
        ]);
    }

    protected function apiAuthenticationRefresh()
    {
        /** @var TokenRepository $forrestToken */
        $forrestToken = app('forrest_token');

        if(!$forrestToken->has()) {
            $this->repository->authenticate();
        }
    }

    protected function getRoleFromUser($user)
    {
        return $this->profileToRoleMapping[$user["ProfileId"]] ?? 0;
    }
}