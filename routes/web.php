<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Omniphx\Forrest\Providers\Laravel\Facades\Forrest;

Route::get('/', function () {
    return view('pages.homepage');
});


Route::get('new', 'Ads\AdsController@create');
Route::post('new', 'Ads\AdsController@store');
Route::post('new-land-seek-ad', 'Ads\AdsController@storeLandSeekAd');

Route::get('/authenticate', 'SalesForceAuthController@register');

Route::get('/researches', function() {
    return view('pages.researches');
});
