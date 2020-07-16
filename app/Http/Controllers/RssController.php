<?php

namespace App\Http\Controllers;

class RssController extends Controller
{
    public function news()
    {
        return response(file_get_contents("https://terredeliens.org/spip.php?page=backend&id_rubrique=7"))
                ->header('Content-Type', 'application/xml');
    }
}
