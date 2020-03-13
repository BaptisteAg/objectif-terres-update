<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CmsController extends Controller
{
    public function quiSommesNous()
    {
        return view('pages/cms/qui-sommes-nous');
    }
    public function minstallerCommePaysan()
    {
        return view('pages/cms/minstaller-comme-paysan');
    }
    public function louerVendreMesTerres()
    {
        return view('pages/cms/louer-vendre-mes-terres');
    }
    public function cederMaFerme()
    {
        return view('pages/cms/ceder-ma-ferme');
    }
    public function cederMesTerres()
    {
        return view('pages/cms/ceder-mes-terres');
    }
    public function trouverUnEmploi()
    {
        return view('pages/cms/trouver-un-emploi');
    }
}
