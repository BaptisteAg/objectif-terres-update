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
<<<<<<< HEAD
//Route::get('new', function () {
//	return view('pages.ads.new');
//});
Route::get('new', 'Ads\AdsController@create');
Route::post('new', 'Ads\AdsController@store');
=======

Route::get('/authenticate', 'SalesForceAuthController@register');

Route::get('/researches', function() {
    return view('pages.researches');
});
>>>>>>> 29e7685ac9febc4d15091a22ba0cd8e80a50c77a
