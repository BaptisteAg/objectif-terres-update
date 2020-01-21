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

Route::get('/', 'HomePage\HomePageController@show');

Route::prefix('annonces')->name('ads.')->namespace('Ads')->group(function () {
    Route::get('creer', 'AdsController@create')->name('create');
    Route::post('creer', 'AdsController@store')->name('store');
    Route::get('{id}', 'AdsController@show')->name('show');
});

Route::get('/authenticate', 'SalesForceAuthController@register');

Route::post('/recherches', 'Researches\ResearchesController@index');

Route::prefix('json')->group(function () {
    Route::get('locationables', 'Json\LocationableController@locationables');
    Route::get('cities', 'Json\LocationableController@cities');
    Route::prefix('polygon')->group(function () {
        Route::post('regions', 'Json\LocationableController@regionsPolygon');
    });
});


