<?php

namespace App\Http\Controllers\Researches;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResearchesController extends Controller
{
    public function index(Request $request)
    {
        dd($request->input('research_location'));
    }
}
