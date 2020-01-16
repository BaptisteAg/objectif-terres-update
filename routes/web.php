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

Route::get('/', function () {
    return view('pages.homepage');
});

Route::get('new', 'Ads\AdsController@create');
Route::post('new', 'Ads\AdsController@store');

Route::get('/authenticate', 'SalesForceAuthController@register');

//Route::get('/researches', function() {
//    return view('pages.researches');
//});

Route::post('/recherches', 'Researches\ResearchesController@index');

Route::prefix('json')->group(function () {
   Route::get('locationables', 'Json\LocationableController@locationables');
});

