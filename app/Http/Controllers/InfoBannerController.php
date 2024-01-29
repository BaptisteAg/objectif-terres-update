<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InfoBannerController extends Controller
{
    public function close(Request $request)
    {
        session()->put('info-banner-closed', $request->input('closed'));
        return response()->json(['success' => true]);
    }
}