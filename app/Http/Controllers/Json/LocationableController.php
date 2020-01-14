<?php

namespace App\Http\Controllers\Json;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class LocationableController extends Controller
{
    public function cities(Request $request)
    {
        if(!$request->has('q')) {
            return response()->json(['error' => 'La requête est vide.']);
        }

        return response()->json(array_slice(array_merge(
            City::where('name', 'LIKE', ''.$request->get('q').'%')->get()->toArray(),
            City::where('name', 'LIKE', '%'.$request->get('q').'%')->get()->toArray(),
        ),0, 20));
    }

    public function regions(Request $request)
    {

    }

    public function departments(Request $request)
    {

    }
}
