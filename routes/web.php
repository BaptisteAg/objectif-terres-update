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

    Route::middleware('auth')->get('creer', 'AdsController@create')->name('create');
    Route::middleware('auth')->post('creer', 'AdsController@store')->name('store');
    Route::middleware('auth')->get('liste-mes-annonces', 'AdsController@list')->name('list');
    Route::get('{id}', 'AdsController@show')->name('show');


});

Route::prefix('documents')->name('documents.')->namespace('Documents')->group(function () {

    Route::middleware('auth')->post('upload', 'DocumentsController@upload')->name('upload');
    Route::get('{type}/{filename}', 'DocumentsController@show')->name('show');

});

Route::get('/register', 'Salesforces\SalesForceAuthController@register');

Route::prefix('recherches')->name('researches.')->namespace('Researches')->group(function () {

    Route::get('recherche', 'ResearchesController@index')->name('index');

    Route::middleware('auth')->group(function () {
        Route::post('sauvegarde', 'ResearchesController@store')->name('store');
        Route::get('liste', 'ResearchesController@show')->name('show');
        Route::post('supprimer', 'ResearchesController@destroy')->name('destroy');
        Route::get('supprimer-alerte/{id}', 'ResearchesController@deleteAlert')->name('deleteAlert');
        Route::get('notification', 'ResearchesController@notificationCreateAlert')->name('notification');
    });

});
Route::prefix('mon-espace/recherches')->middleware('auth')->name('researches.')->namespace('Researches')->group(function () {
	Route::post('sauvegarde', 'ResearchesController@store')->name('store');
	Route::get('liste', 'ResearchesController@show')->name('show');
	Route::post('supprimer', 'ResearchesController@destroy')->name('destroy');
	Route::get('supprimer-alerte/{id}', 'ResearchesController@deleteAlert')->name('deleteAlert');
	Route::get('notification', 'ResearchesController@notificationCreateAlert')->name('notification');
});

Route::middleware('auth')->prefix('threads')->name('threads.')->namespace('Threads')->group(function () {
	Route::post('creer', 'ThreadsController@create')->name('create');
});

Route::middleware('auth')->prefix('mon-espace')->name('userAccount.')->namespace('HomePage')->group(function () {
	Route::get('/', 'HomePageLoggedController@index')->name('showAccount');
});

Route::prefix('mon-espace/annonces-favorites')->middleware('auth')->name('favoriteAds.')->namespace('FavoriteAds')->group(function () {
	Route::get('sauvegarde', 'FavoriteAdsController@create')->name('create');
	Route::get('liste', 'FavoriteAdsController@show')->name('show');
	Route::post('supprimer', 'FavoriteAdsController@destroy')->name('destroy');

});

Route::prefix('mon-espace/messagerie')->middleware('auth')->name('messagerie.')->namespace('Threads')->group(function () {
	Route::get('/', 'ThreadsController@index')->name('index');
	Route::get('{thread}', 'MessagesController@show')->name('show');
});


Route::prefix('json')->group(function () {
	Route::get('locationables', 'Json\LocationableController@locationables');
	Route::get('cities', 'Json\LocationableController@cities');
	Route::prefix('polygon')->group(function () {
		Route::post('regions', 'Json\LocationableController@regionsPolygon');
	});
});

// Authentication Routes...
Route::get('connexion', 'Auth\LoginController@showLoginForm')->name('signIn');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::post('deconnexion', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('inscription', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('inscription', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::prefix('motdepasse')->name('password.')->group(function () {
    Route::get('reinitialiser', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('request');
    Route::post('email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('email');
    Route::get('reinitialiser/{token}', 'Auth\ResetPasswordController@showResetForm')->name('reset');
    Route::post('reinitialiser', 'Auth\ResetPasswordController@reset')->name('update');
});
