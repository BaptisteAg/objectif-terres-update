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

Route::get('/', 'HomePage\HomePageController@show')->name('home');

Route::prefix('annonces')->name('ads.')->namespace('Ads')->group(function () {
	Route::middleware(['auth'])->get('creer', 'AdsController@create')->name('create');
	Route::middleware(['auth', 'ad_limit'])->post('creer', 'AdsController@requestPublishing')->name('store');
	Route::middleware('auth')->post('sauvegarder', 'AdsController@save')->name('save');
	Route::middleware('auth')->get('liste-mes-annonces', 'AdsController@list')->name('list');
	Route::get('{id}', 'AdsController@show')->name('show');
	Route::middleware('auth')->get('supprimer/{ad}', 'AdsController@delete')->name('delete');
});

Route::name('cms.')->namespace('Cms')->group(function () {
	Route::get('faq', 'CmsController@faq');
	Route::get('qui-sommes-nous', 'CmsController@quiSommesNous');
	Route::get('minstaller-comme-paysan', 'CmsController@minstallerCommePaysan');
	Route::get('louer-vendre-mes-terres', 'CmsController@louerVendreMesTerres');
	Route::get('ceder-ma-ferme', 'CmsController@cederMaFerme');
	//Route::get('ceder-mes-terres', 'CmsController@cederMesTerres');
	Route::get('trouver-un-emploi', 'CmsController@trouverUnEmploi');
	Route::get('mentions-legales', 'CmsController@mentionsLegales');
	Route::get('confier-mes-terres', 'CmsController@confierMesTerres');
	Route::get('ressources-utiles', 'CmsController@ressourcesUtiles');
	Route::get('contactez-nous', 'CmsController@contactezNous');
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
	Route::get('supprimer/{research}', 'ResearchesController@destroy')->name('destroy');
	Route::get('supprimer-alerte/{research}', 'ResearchesController@deleteAlert')->name('deleteAlert');
	Route::get('notification', 'ResearchesController@notificationCreateAlert')->name('notification');
});


Route::middleware('auth')->name('user.')->namespace('Users')->group(function () {
	Route::prefix('mon-espace')->group(function (){
		Route::get('/', 'UsersController@index')->name('index');
		Route::get('mon-compte/{user}','UsersController@edit')->name('edit');
		Route::post('mon-compte','UsersController@update')->name('update');
	});
	Route::prefix('porteur-de-projet')->group(function (){
		Route::get('{user}', 'UsersController@show')->name('show');
	});
});

Route::prefix('mon-espace/annonces-favorites')->middleware('auth')->name('favoriteAds.')->namespace('FavoriteAds')->group(function () {
	Route::get('sauvegarde', 'FavoriteAdsController@create')->name('create');
	Route::get('liste', 'FavoriteAdsController@show')->name('show');
	Route::get('supprimer/{favoriteAd}', 'FavoriteAdsController@destroy')->name('destroy');
});

Route::prefix('mon-espace/messagerie')->middleware('auth')->name('threads.')->namespace('Threads')->group(function () {
	Route::get('actualisation', 'ThreadsController@refreshUnreadMessages')->name('refreshUnreadMessages');
	Route::get('/', 'ThreadsController@index')->name('index');
	Route::post('creer', 'ThreadsController@create')->name('create');
	Route::get('{thread}', 'MessagesController@show')->name('show');
	Route::post('envoi', 'MessagesController@create')->name('send');
});

Route::prefix('locations')->namespace('Locationables')->group(function () {
	Route::get('/', 'LocationableController@locations');
	Route::get('cities', 'LocationableController@cities');
	Route::get('cities-and-departments', 'LocationableController@citiesAndDepartments');
	Route::get('departments-and-regions', 'LocationableController@departmentsAndRegions');
	Route::prefix('polygon')->group(function () {
		Route::post('regions', 'LocationableController@regionsPolygon');
	});
});

Route::middleware('moderator')->prefix('mon-espace-moderateur')->name('moderator.')->group(function () {
	Route::namespace('Moderators')->group(function () {
		Route::get('/', 'ModeratorController@index')->name('index');
		Route::get('recherche', 'ModeratorController@show')->name('show');
		Route::get('aide-et-ressources', 'ModeratorController@help')->name('help');
	});
	Route::namespace('AttributionAds')->group(function () {
		Route::post('validation', 'AttributionAdsController@acceptAd')->name('acceptAd');
		Route::post('modification', 'AttributionAdsController@modifyAd')->name('modifyAd');
		Route::post('refus', 'AttributionAdsController@rejectAd')->name('rejectAd');
	});

});

Route::middleware('supervisor')->prefix('mon-espace-responsable-territorial')->name('supervisor.')->namespace('Supervisors')->group(function () {
	Route::get('/', 'SupervisorsController@index')->name('index');
	Route::get('recherche', 'SupervisorsController@show')->name('show');
	Route::get('aide-et-ressources', 'SupervisorsController@help')->name('help');
	Route::post('attribution', 'SupervisorsController@attribute')->name('attribute');
	Route::get('export', 'SupervisorsController@export')->name('export');
	Route::get('rapports-et-indicateurs', 'SupervisorsController@report')->name('report');
});

Route::middleware('advisor')->prefix('mon-espace-primo-accueillant')->name('advisor.')->namespace('Advisors')->group(function () {
	Route::get('/', 'AdvisorsController@index')->name('index');
	Route::get('aide-et-ressources', 'AdvisorsController@help')->name('help');
});

Route::middleware('auth')->prefix('notification')->name('notification.')->namespace('Notifications')->group(function () {
	Route::get('index', 'NotificationsController@index')->name('index');
	Route::patch('{notification}', 'NotificationsController@update')->name('update');
});

// Authentication Routes for authentification
Route::get('connexion', 'Auth\LoginController@salesforceLogin')->name('login');
//Route::post('login', 'Auth\LoginController@login')->name('login');
Route::post('deconnexion', 'Auth\LoginController@salesforceLogout')->name('logout');

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
