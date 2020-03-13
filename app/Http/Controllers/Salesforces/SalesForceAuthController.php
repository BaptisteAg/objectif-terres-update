<?php

namespace App\Http\Controllers\Salesforces;

use App\Http\Controllers\Controller;
use Omniphx\Forrest\Client;
use Omniphx\Forrest\Providers\Laravel\Facades\Forrest;

/**
 * Class SalesForceAuthController
 * @package App\Http\Controllers
 */
class SalesForceAuthController extends Controller
{
    /**
     *
     */
    public function register()
    {
        Forrest::authenticate();
        //Forrest::authenticateUser('https://test.salesforce.com',"dunder.miffli3@test.com", "test123"..env('SF_TOKEN'));
        dd(Forrest::identity());

        //dd(Forrest::query('Select Id, Name, Description from Profile where Id=\'00ew0000001V72nAAC\''));

        /*
         * array:3 [▼
              "id" => "0011q00000XA0LIAA1"
              "success" => true
              "errors" => []
            ]
         */
        /*$response = Forrest::sobjects('Account',[
            'method' => 'post',
            'body'   => [
                "Name" => "Dunder Mifflin",
                "Description" => "Test",
            ]
        ]);*/


        /**
         * array:3 [▼
            "id" => "0031q00000RVzsRAAT"
            "success" => true
            "errors" => []
            ]
         */
        /*$response = Forrest::sobjects('Contact',[
            'method' => 'post',
            'body'   => [
                "AccountId" => "0011q00000XA0LIAA1",
                "Email" => "dunder.miffli3n@test.com",
                "LastName" => "Mifflin",
            ]
        ]);
        dd($response);*/


        /**
         * array:3 [▼
            "id" => "0051q000003fRgJAAU"
            "success" => true
            "errors" => []
            ]
         */
        /*$response = Forrest::sobjects('User',[
            'method' => 'post',
            'body'   => [
                'Email' => 'dunder.miffli3n@test.com',
                'Username' => 'dunder.miffli3@test.com',
                "Alias" => "dmifflin",
                'FirstName' => 'Dunder',
                "LastName" => "Mifflin",
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
                "ContactId" => "0031q00000RVzsRAAT"
            ]
        ]);
        dd($response);*/

        dd(Forrest::sobjects('User/0051q000003fRgJAAU/password', [
            'method' => 'post',
            'body' => [
                "NewPassword" => "test123"
            ]
        ]));

//        return Redirect::to('/');
    }
}
