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

        dd(Forrest::query('Select Id, Name, Description from Profile where Id=\'00ew0000001V72nAAC\''));

        /*$response = Forrest::sobjects('User',[
            'method' => 'post',
            'body'   => [
                'FirstName' => 'Dunder',
                "Username" => "dunder.mifflin@test.com",
                "LastName" => "Mifflin",
                "Email" => "dunder.mifflin@test.com",
                "Alias" => "dmifflin",
                "TimeZoneSidKey" => "Europe/Paris",
                "LocaleSidKey" => "fr_FR",
                "EmailEncodingKey" => "UTF-8",
                "ProfileId" => "00ew0000001V72nAAC",
                "LanguageLocaleKey" => "fr"
            ]
        ]);*/

        dd($response);

//        return Redirect::to('/');
    }
}
