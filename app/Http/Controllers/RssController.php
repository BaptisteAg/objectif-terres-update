<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RssController extends Controller
{
    public function news()
    {
        request()->header('Content-Type : application/xml');

        return response()->file_get_contents("https://terredeliens.org/spip.php?page=backend&id_rubrique=7");
    }
}
