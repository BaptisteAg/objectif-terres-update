<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Omniphx\Forrest\Providers\Laravel\Facades\Forrest;

class SalesForceAuthController extends Controller
{
    public function register()
    {
        Forrest::authenticate();
        return Redirect::to('/');
    }
}
