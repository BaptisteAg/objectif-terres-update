<?php namespace App\Services\Salesforce;

use App\Models\City;
use App\Models\Country;
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
    	'00ew0000001V7RJ' => 0,
		// Moderator
        '00e1r000001td1k' => 1,
		// Super Admin
		'00e20000001FEdPAAW' => 4
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
            "LanguageLocaleKey" => "fr",
            "ContactId" => $contact["id"]
        ]);
        $this->repository->updateUserPassword($user["id"], $data["password"]);

        return $user;
    }

    /**
     * Right after a successful login, this method receives the retrieved
     * Saml2 User from Salesforce; it then retrieve or create a corresponding
     * local user.
     *
     * @param \Aacotroneo\Saml2\Saml2User $samlUser
     * @return User
     * @throws \Throwable
     */
    public function getUserFromSaml(\Aacotroneo\Saml2\Saml2User $samlUser) : User
    {
        $this->apiAuthenticationRefresh();

        $email = $samlUser->getAttribute('email')[0];
        $sfId = $samlUser->getAttribute('userId')[0];

        /** @var User $user */
        $user = $this->userRepository->findByEmail($email);

        // Reverse user creation : if no user has been found, then we'll create it on the fly
        // to allow every salesforce-only user to pass the registration form
        if(!$user) {
            $salesforceUser = $this->repository->find('User', $sfId, ['FirstName', 'LastName', 'ProfileId']);

			$user = $this->userRepository->create([
				'first_name' => $salesforceUser["FirstName"],
				'name' => $salesforceUser["LastName"],
				'email' => $email,
				'role' => $this->getRoleFromProfileId($salesforceUser["ProfileId"])
			]);
        }

        if($user->sf_id != $sfId) {
            $user->sf_id = $sfId;
            $user->save();
        }

        return $user;
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

    protected function getRoleFromProfileId($profileId)
    {
        return $this->profileToRoleMapping[$profileId] ?? 0;
    }
}
