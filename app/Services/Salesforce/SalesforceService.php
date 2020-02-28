<?php namespace App\Services\Salesforce;

use App\Repositories\SalesForce\SalesForceRepository;
use Omniphx\Forrest\Exceptions\MissingTokenException;
use Omniphx\Forrest\Providers\Laravel\Facades\Forrest;

class SalesforceService
{
    /**
     * @var SalesForceRepository
     */
    protected $repository;

    public function __construct(SalesForceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findObject($object, $id)
    {
        $this->apiAuthenticate();

        return $this->repository->find($object, $id);
    }

    public function registerPP($data)
    {
        $this->apiAuthenticate();

        /*
         * array:3 [▼
              "id" => "0011q00000XA0LIAA1"
              "success" => true
              "errors" => []
            ]
         */
        $account = $this->repository->create('Account', [
            "Name" => $data["firstname"] . " " . $data["name"],
            "Description" => "Compte Objectif Terre",
        ]);

        /**
         * array:3 [▼
         * "id" => "0031q00000RVzsRAAT"
         * "success" => true
         * "errors" => []
         * ]
         */
        $contact = $this->repository->create('Contact', [
            "AccountId" => $account["id"],
            "Email" => $data["email"],
            "LastName" => $data["name"],
        ]);
        /**
         * array:3 [▼
         * "id" => "0051q000003fRgJAAU"
         * "success" => true
         * "errors" => []
         * ]
         */

        $user = $this->repository->create('User', [
            'Email' => $data["email"],
            'Username' => $data["email"],
            "Alias" => $data["firstname"] . " " . $data["name"],
            'FirstName' => $data["firstname"],
            "LastName" => $data["name"],
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
     * Salesforce authentication by SAML SSO.
     * User is redirected to salesforce login page
     * before coming back to the website
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login()
    {
        return redirect()->route('saml2_login', 'salesforce');
    }

    private function apiAuthenticate()
    {
        try {
            Forrest::identity();
        } catch (MissingTokenException $exception) {
            Forrest::authenticate();
        }
    }

}
