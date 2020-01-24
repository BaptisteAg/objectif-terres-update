<?php

namespace App\Http\Controllers\Salesforces;

use App\Http\Controllers\Controller;
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

//        return Redirect::to('/');
    }
}
