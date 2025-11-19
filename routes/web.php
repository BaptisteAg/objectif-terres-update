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

use Illuminate\Http\Request;
use App\Http\Controllers\SalesforceOAuthController;

Route::get('/', 'HomePage\HomePageController@show')->name('home');
Route::get('/premiere-visite', 'HomePage\HomePageController@show')->name('site-tour');

Route::prefix('annonces')->name('ads.')->namespace('Ads')->group(function () {
    Route::middleware(['auth'])->get('creer', 'AdsController@create')->name('create');
    Route::middleware('auth')->post('sauvegarder', 'AdsController@saveDraft')->name('save-draft');
    Route::middleware('auth')->post('creer', 'AdsController@save')->name('save');
    Route::middleware('auth')->get('preview/{id}', 'AdsController@preview')->name('preview');
    Route::middleware('auth')->get('modifier/{id}', 'AdsController@edit')->name('edit');
    Route::middleware('auth')->get('request-publishing/{id}', 'AdsController@requestPublishing')->name('request-publishing');
    Route::middleware('auth')->get('mes-annonces', 'AdsController@list')->name('list');
    Route::get('{id}', 'AdsController@show')->name('show');

    Route::middleware('auth')->post('survey/{ad}/{action}', 'AdsController@survey')->name('survey');
    Route::middleware('auth')->get('supprimer/{ad}', 'AdsController@delete')->name('delete');
    Route::middleware('auth')->get('archiver/{ad}', 'AdsController@archive')->name('archive');
    Route::middleware('auth')->get('republier/{ad}', 'AdsController@republish')->name('republish');
    Route::middleware('auth')->post('survey/{ad}/{action}', 'AdsController@survey')->name('survey');
    Route::middleware('auth')->get('etendre-expiration/{id}', 'AdsController@extendPublish')->name('extend');
});


Route::prefix('accompagnement')->name('support-request.')->namespace('Ads')->group(function () {
    Route::middleware([])->get('demarrer', 'SupportRequestsController@start')->name('start');
    Route::middleware([])->post('demarrer', 'SupportRequestsController@processStart')->name('process-start');
    Route::middleware(['auth'])->get('creer', 'SupportRequestsController@create')->name('create');
    Route::middleware(['auth'])->get('creer/copier-annonce/{ad}', 'SupportRequestsController@createFromAd')
        ->name('create-from-ad');
    Route::middleware(['auth'])->post('creer', 'SupportRequestsController@submitRequest')->name('store');
    Route::middleware(['auth'])->post('sauvegarder', 'SupportRequestsController@save')->name('save');

    Route::middleware(['auth'])->get('suivi', 'SupportRequestsController@show')->name('show');
    Route::middleware(['auth'])->post('suivi/sauvegarder-indicateurs', 'SupportRequestsController@updateProjectDataKeysValues')
        ->name('show.update-project-data-keys-values');
    Route::middleware('auth')->get('modifier', 'SupportRequestsController@edit')->name('edit');
});

Route::namespace('Cms')->group(function () {
    Route::get('faq', 'CmsController@faq')->name('faq');
    Route::get('qui-sommes-nous', 'CmsController@quiSommesNous')->name('qui-sommes-nous');
    Route::get('mouvement-terre-de-liens', 'CmsController@mouvementTerreDeLiens')->name('mouvement-terre-de-liens');
    Route::get('minstaller-comme-paysan', 'CmsController@minstallerCommePaysan')->name('minstaller-comme-paysan');
    Route::get('trouver-une-terre-ou-des-financements', 'CmsController@trouverUneTerreOuDesFinancements')->name('trouver-une-terre-ou-des-financements');
    Route::get('transmettre-ma-ferme', 'CmsController@cederMaFerme')->name('transmettre-ma-ferme');
    Route::get('trouver-un-emploi', 'CmsController@trouverUnEmploi')->name('trouver-un-emploi');
    Route::get('mentions-legales', 'CmsController@mentionsLegales')->name('mentions-legales');
    Route::get('confier-mes-terres', 'CmsController@confierMesTerres')->name('confier-mes-terres');
    Route::get('ressources-utiles', 'CmsController@ressourcesUtiles')->name('ressources-utiles');
    Route::get('contactez-nous', 'CmsController@contactezNous')->name('contactez-nous');
    Route::get('proprietaire-de-foncier', 'CmsController@proprietaireDeFoncier')->name('proprietaire-de-foncier');
    Route::get('conditions-utilisation', 'CmsController@conditionsUtilisation')->name('conditions-utilisation');
    Route::get('charte', 'CmsController@charte')->name('charte');
    Route::get('plan-du-site', 'CmsController@plan')->name('plan-du-site');
});

Route::prefix('documents')->name('documents.')->namespace('Documents')->group(function () {
    Route::middleware('auth')->post('upload', 'DocumentsController@upload')->name('upload');
    Route::get('{type}/{user_id}/{filename}', 'DocumentsController@show')->name('show');
});

//Route::get('/register', 'Salesforces\SalesForceAuthController@register');

Route::prefix('recherche')->name('researches.')->namespace('Researches')->group(function () {
    Route::get('/', 'ResearchesController@index')->name('index');

//	Route::middleware('auth')->group(function () {
//		Route::post('sauvegarde', 'ResearchesController@store')->name('store');
//		Route::get('liste', 'ResearchesController@show')->name('show');
//		Route::post('supprimer', 'ResearchesController@destroy')->name('destroy');
//		Route::get('supprimer-alerte/{id}', 'ResearchesController@deleteAlert')->name('deleteAlert');
//		Route::get('notification', 'ResearchesController@notificationCreateAlert')->name('notification');
//	});

});
Route::prefix('mon-espace/recherches')->middleware('auth')->name('researches.')->namespace('Researches')->group(function () {
    Route::post('sauvegarde', 'ResearchesController@store')->name('store');
    Route::get('liste', 'ResearchesController@show')->name('show');
    Route::get('supprimer/{research}', 'ResearchesController@destroy')->name('destroy');
    Route::get('supprimer-alerte/{research}', 'ResearchesController@deleteAlert')->name('deleteAlert');
    Route::get('notification', 'ResearchesController@notificationCreateAlert')->name('notification');
});

Route::prefix('rss')->name('rss.')->group(function () {
    Route::get('news', 'RssController@news')->name('news');
});

Route::middleware('auth')->name('user.')->namespace('Users')->group(function () {
    Route::prefix('mon-espace')->group(function () {
        Route::get('/', 'UsersController@index')->name('index');
        Route::get('modification-compte/{user}', 'UsersController@edit')->name('edit');
        Route::post('mon-compte', 'UsersController@update')->name('update');
    });
    Route::prefix('utilisateurs')->group(function () {
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
    Route::get('{id}', 'MessagesController@show')->name('show');
    Route::post('envoi', 'MessagesController@create')->name('send');
    Route::post('upload', 'MessagesController@uploadDocuments')->name('upload');
    Route::get('delete/{id}', 'MessagesController@delete')->name('delete-message');
//	Route::get('{type}/{filename}', 'MessagesController@show')->name('show');

});

Route::prefix('locations')->namespace('Locationables')->group(function () {
    Route::get('/', 'LocationableController@locations');
    Route::get('countries', 'LocationableController@countries');
    Route::get('cities', 'LocationableController@cities');
    Route::get('departments', 'LocationableController@departments');
    Route::get('cities-and-regions', 'LocationableController@citiesAndRegions');
    Route::get('cities-and-departments', 'LocationableController@citiesAndDepartments');
    Route::get('departments-and-regions', 'LocationableController@departmentsAndRegions');
    Route::prefix('polygon')->group(function () {
        Route::post('regions', 'LocationableController@regionsPolygon');
        Route::get('departments', 'LocationableController@departmentsPolygon');
        Route::get('france', 'LocationableController@france');
        Route::post('ad-locations', 'LocationableController@adLocations');
    });
});

Route::middleware('moderator')->prefix('gestion-des-annonces')->name('moderator.')->group(function () {
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

Route::middleware('moderator')->get('historique/{id}', 'Histories\HistoriesController@show')->name('history.show');

Route::middleware('admin')->prefix('administration')->name('administrator.')->namespace('Administrators')->group(function () {
    Route::get('liste-utilisateurs-par-territoires', 'AdministratorController@showUsersByTerritories')->name('usersByTerritories');
});

Route::prefix('mon-tableau-de-bord')->name('supervisor.')->namespace('Supervisors')->group(function () {
    Route::middleware('supervisor')->get('/', 'SupervisorsController@index')->name('index');
    Route::middleware('supervisor')->get('recherche', 'SupervisorsController@show')->name('show');
    Route::middleware('supervisor')->get('aide-et-ressources', 'SupervisorsController@help')->name('help');
    Route::post('attribution', 'SupervisorsController@attribute')->name('attribute');
    Route::get('supprimer-attribution/{adId}/{slot}', 'SupervisorsController@deleteAttribution')->name('delete_attribution');
    Route::middleware('supervisor')->get('export', 'SupervisorsController@export')->name('export');
    Route::middleware('supervisor')->get('rapports-et-indicateurs', 'SupervisorsController@report')->name('report');
    Route::middleware('supervisor')->get('administration-indicateurs', 'SupervisorsController@projectKeysDataEdit')->name('projectDataKeysEdit');
    Route::middleware('supervisor')->post('creation-indicateur', 'SupervisorsController@projectDataKeysCreate')->name('projectDataKeysCreate');
    Route::middleware('supervisor')->post('suppression-indicateur', 'SupervisorsController@projectDataKeyDelete')->name('projectDataKeyDelete');
});

Route::middleware('advisor')->prefix('gestion-des-accompagnements')->name('advisor.')->namespace('Advisors')->group(function () {
    Route::get('/', 'AdvisorsController@index')->name('index');
    Route::get('aide-et-ressources', 'AdvisorsController@help')->name('help');
    Route::get('recherche', 'AdvisorsController@show')->name('show');
    Route::get('creation-compte-pp', 'AdvisorsController@createNewUserPp')->name('createNewPp');
    Route::post('creation-compte-pp', 'AdvisorsController@registerNewUserPp')->name('registerNewPp');
    Route::get('export', 'AdvisorsController@export')->name('export');
    Route::get('espace-suivi/{id}', 'AdvisorsController@showSupport')->name('showSupport');
    Route::post('mise-a-jour-statut', 'AdvisorsController@updateSupport')->name('updateSupport');
    Route::post('creation-note', 'AdvisorsController@createNote')->name('createNote');
    Route::post('edition-note', 'AdvisorsController@editNote')->name('editNote');
    Route::post('suppression-note', 'AdvisorsController@deleteNote')->name('deleteNote');
    Route::post('modification-valeurs-indicateurs', 'AdvisorsController@updateProjectDataKeysValues')->name('updateProjectDataKeysValues');
    Route::post('ajout-document', 'AdvisorsController@uploadDocuments')->name('uploadDocuments');
    Route::post('bloquer-utlisateur', 'AdvisorsController@blockUser')->name('blockUser');
});

Route::middleware('supervisor')->prefix('gestion-reponse-types')->name('responseTemplates.')->namespace('ResponseTemplates')->group(function () {
    Route::get('/', 'ResponseTemplatesController@index')->name('index');
    Route::post('/creer', 'ResponseTemplatesController@create')->name('create');
    Route::post('/editer', 'ResponseTemplatesController@edit')->name('edit');
    Route::post('/supprimer', 'ResponseTemplatesController@delete')->name('delete');
});

Route::middleware('auth')->prefix('notification')->name('notification.')->namespace('Notifications')->group(function () {
    Route::get('index', 'NotificationsController@index')->name('index');
    Route::patch('{notification}', 'NotificationsController@update')->name('update');
});

// Authentication
Route::get('connexion', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('connexion', 'Auth\LoginController@login')->name('login');
Route::post('connexion/checkpoint', 'Auth\LoginController@checkpoint')->name('checkpoint');
Route::get('connexion/sso', 'Auth\SalesforceLoginController@salesforceLogin')->name('login.sso');
//Route::post('login', 'Auth\SalesforceLoginController@login')->name('login');
Route::get('deconnexion/sso', 'Auth\SalesforceLoginController@salesforceLogout')->name('logout.sso');
Route::get('deconnexion', 'Auth\LoginController@logout')->name('logout');
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

// Registration
Route::get('inscription', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('inscription', 'Auth\RegisterController@register');

// Password Reset
Route::prefix('motdepasse')->name('password.')->group(function () {
    Route::get('reinitialiser', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('request');
    Route::post('email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('email');
    Route::get('reinitialiser/{token}', 'Auth\ResetPasswordController@showResetForm')->name('reset');
    Route::post('reinitialiser', 'Auth\ResetPasswordController@reset')->name('update');
});

Route::post('newsletter', 'Newsletter\NewsletterController@create');

Route::post('/info-banner/close', 'InfoBannerController@close')->name('info-banner.close');


// Routes pour l'authentification Salesforce OAuth
Route::prefix('salesforce/oauth')->name('salesforce.oauth.')->group(function () {
    // Route pour initier la redirection vers Salesforce
    Route::get('connect', [SalesforceOAuthController::class, 'redirectToSalesforce'])->name('connect');

    // Route de callback que Salesforce appellera
    // L'URI de cette route DOIT correspondre exactement à la 'callbackURI'
    // configurée dans votre Application Connectée Salesforce et dans forrest.php / .env
    Route::get('callback', [SalesforceOAuthController::class, 'handleSalesforceCallback'])->name('callback');

    // Route optionnelle pour tester la connexion
    //Route::get('test', [SalesforceOAuthController::class, 'testSalesforceConnection'])->name('test');

    // Route optionnelle pour révoquer le token (déconnexion)
    //Route::get('revoke', [SalesforceOAuthController::class, 'revokeSalesforceToken'])->name('revoke');
});

/*Route::get('test-alerts', function() {

    $errors = new \Illuminate\Support\ViewErrorBag();

    $bag = $errors->getBags()['default'] ?? new \Illuminate\Support\MessageBag();
    $bag->add('test', 'Test error');
    $bag->add('test2', 'Test error');

    session()->flash('success', 'Test success');
    session()->flash('errors', $errors->put('default', $bag));
    session()->flash('warning', 'Test warning');
    session()->flash('info', 'Test info');

    return view("auth.login");
});

Route::prefix('old_annonces')->name('ads.')->namespace('Ads')->group(function () {
    Route::get('{id}', 'AdsController@oldshow')->name('oldshow');
});*/

//Route::get('test', function () {
//    return view('baptiste.test');
//})->name('baptiste');
