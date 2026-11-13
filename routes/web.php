<?php

use App\Http\Controllers\Administrators;
use App\Http\Controllers\Ads;
use App\Http\Controllers\Advisors;
use App\Http\Controllers\AttributionAds;
use App\Http\Controllers\Auth;
use App\Http\Controllers\Cms;
use App\Http\Controllers\Documents;
use App\Http\Controllers\FavoriteAds;
use App\Http\Controllers\Histories;
use App\Http\Controllers\HomePage;
use App\Http\Controllers\InfoBannerController;
use App\Http\Controllers\Locationables;
use App\Http\Controllers\Moderators;
use App\Http\Controllers\Newsletter;
use App\Http\Controllers\Notifications;
use App\Http\Controllers\Researches;
use App\Http\Controllers\ResponseTemplates;
use App\Http\Controllers\RssController;
use App\Http\Controllers\Supervisors;
use App\Http\Controllers\Threads;
use App\Http\Controllers\Users;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomePage\HomePageController::class, 'show'])->name('home');
Route::get('/premiere-visite', [HomePage\HomePageController::class, 'show'])->name('site-tour');

Route::prefix('annonces')->name('ads.')->group(function () {
    Route::middleware(['auth'])->get('creer', [Ads\AdsController::class, 'create'])->name('create');
    Route::middleware('auth')->post('sauvegarder', [Ads\AdsController::class, 'saveDraft'])->name('save-draft');
    Route::middleware('auth')->post('creer', [Ads\AdsController::class, 'save'])->name('save');
    Route::middleware('auth')->get('preview/{id}', [Ads\AdsController::class, 'preview'])->name('preview');
    Route::middleware('auth')->get('modifier/{id}', [Ads\AdsController::class, 'edit'])->name('edit');
    Route::middleware('auth')->get('request-publishing/{id}', [Ads\AdsController::class, 'requestPublishing'])->name('request-publishing');
    Route::middleware('auth')->get('mes-annonces', [Ads\AdsController::class, 'list'])->name('list');
    Route::get('{id}', [Ads\AdsController::class, 'show'])->name('show');

    Route::middleware('auth')->post('survey/{ad}/{action}', [Ads\AdsController::class, 'survey'])->name('survey');
    Route::middleware('auth')->get('supprimer/{ad}', [Ads\AdsController::class, 'delete'])->name('delete');
    Route::middleware('auth')->get('archiver/{ad}', [Ads\AdsController::class, 'archive'])->name('archive');
    Route::middleware('auth')->get('republier/{ad}', [Ads\AdsController::class, 'republish'])->name('republish');
    Route::middleware('auth')->post('survey/{ad}/{action}', [Ads\AdsController::class, 'survey'])->name('survey');
    Route::middleware('auth')->get('etendre-expiration/{id}', [Ads\AdsController::class, 'extendPublish'])->name('extend');
});

Route::prefix('accompagnement')->name('support-request.')->group(function () {
    Route::middleware([])->get('demarrer', [Ads\SupportRequestsController::class, 'start'])->name('start');
    Route::middleware([])->post('demarrer', [Ads\SupportRequestsController::class, 'processStart'])->name('process-start');
    Route::middleware(['auth'])->get('creer', [Ads\SupportRequestsController::class, 'create'])->name('create');
    Route::middleware(['auth'])->get('creer/copier-annonce/{ad}', [Ads\SupportRequestsController::class, 'createFromAd'])
        ->name('create-from-ad');
    Route::middleware(['auth'])->post('creer', [Ads\SupportRequestsController::class, 'submitRequest'])->name('store');
    Route::middleware(['auth'])->post('sauvegarder', [Ads\SupportRequestsController::class, 'save'])->name('save');

    Route::middleware(['auth'])->get('suivi', [Ads\SupportRequestsController::class, 'show'])->name('show');
    Route::middleware(['auth'])->post('suivi/sauvegarder-indicateurs', [Ads\SupportRequestsController::class, 'updateProjectDataKeysValues'])
        ->name('show.update-project-data-keys-values');
    Route::middleware('auth')->get('modifier', [Ads\SupportRequestsController::class, 'edit'])->name('edit');
});

Route::get('faq', [Cms\CmsController::class, 'faq'])->name('faq');
Route::get('qui-sommes-nous', [Cms\CmsController::class, 'quiSommesNous'])->name('qui-sommes-nous');
Route::get('mouvement-terre-de-liens', [Cms\CmsController::class, 'mouvementTerreDeLiens'])->name('mouvement-terre-de-liens');
Route::get('minstaller-comme-paysan', [Cms\CmsController::class, 'minstallerCommePaysan'])->name('minstaller-comme-paysan');
Route::get('trouver-une-terre-ou-des-financements', [Cms\CmsController::class, 'trouverUneTerreOuDesFinancements'])->name('trouver-une-terre-ou-des-financements');
Route::get('transmettre-ma-ferme', [Cms\CmsController::class, 'cederMaFerme'])->name('transmettre-ma-ferme');
Route::get('trouver-un-emploi', [Cms\CmsController::class, 'trouverUnEmploi'])->name('trouver-un-emploi');
Route::get('mentions-legales', [Cms\CmsController::class, 'mentionsLegales'])->name('mentions-legales');
Route::get('confier-mes-terres', [Cms\CmsController::class, 'confierMesTerres'])->name('confier-mes-terres');
Route::get('ressources-utiles', [Cms\CmsController::class, 'ressourcesUtiles'])->name('ressources-utiles');
Route::get('contactez-nous', [Cms\CmsController::class, 'contactezNous'])->name('contactez-nous');
Route::get('proprietaire-de-foncier', [Cms\CmsController::class, 'proprietaireDeFoncier'])->name('proprietaire-de-foncier');
Route::get('conditions-utilisation', [Cms\CmsController::class, 'conditionsUtilisation'])->name('conditions-utilisation');
Route::get('charte', [Cms\CmsController::class, 'charte'])->name('charte');
Route::get('plan-du-site', [Cms\CmsController::class, 'plan'])->name('plan-du-site');

Route::prefix('documents')->name('documents.')->group(function () {
    Route::middleware('auth')->post('upload', [Documents\DocumentsController::class, 'upload'])->name('upload');
    Route::get('{type}/{user_id}/{filename}', [Documents\DocumentsController::class, 'show'])->name('show');
});

// Route::get('/register', 'Salesforces\SalesForceAuthController@register');

Route::prefix('recherche')->name('researches.')->group(function () {
    Route::get('/', [Researches\ResearchesController::class, 'index'])->name('index');

    //	Route::middleware('auth')->group(function () {
    //		Route::post('sauvegarde', 'ResearchesController@store')->name('store');
    //		Route::get('liste', 'ResearchesController@show')->name('show');
    //		Route::post('supprimer', 'ResearchesController@destroy')->name('destroy');
    //		Route::get('supprimer-alerte/{id}', 'ResearchesController@deleteAlert')->name('deleteAlert');
    //		Route::get('notification', 'ResearchesController@notificationCreateAlert')->name('notification');
    //	});

});
Route::prefix('mon-espace/recherches')->middleware('auth')->name('researches.')->group(function () {
    Route::post('sauvegarde', [Researches\ResearchesController::class, 'store'])->name('store');
    Route::get('liste', [Researches\ResearchesController::class, 'show'])->name('show');
    Route::get('supprimer/{research}', [Researches\ResearchesController::class, 'destroy'])->name('destroy');
    Route::get('supprimer-alerte/{research}', [Researches\ResearchesController::class, 'deleteAlert'])->name('deleteAlert');
    Route::get('notification', [Researches\ResearchesController::class, 'notificationCreateAlert'])->name('notification');
});

Route::prefix('rss')->name('rss.')->group(function () {
    Route::get('news', [RssController::class, 'news'])->name('news');
});

Route::middleware('auth')->name('user.')->group(function () {
    Route::prefix('mon-espace')->group(function () {
        Route::get('/', [Users\UsersController::class, 'index'])->name('index');
        Route::get('modification-compte/{user}', [Users\UsersController::class, 'edit'])->name('edit');
        Route::post('mon-compte', [Users\UsersController::class, 'update'])->name('update');
    });
    Route::prefix('utilisateurs')->group(function () {
        Route::get('{user}', [Users\UsersController::class, 'show'])->name('show');
    });
});

Route::prefix('mon-espace/annonces-favorites')->middleware('auth')->name('favoriteAds.')->group(function () {
    Route::get('sauvegarde', [FavoriteAds\FavoriteAdsController::class, 'create'])->name('create');
    Route::get('liste', [FavoriteAds\FavoriteAdsController::class, 'show'])->name('show');
    Route::get('supprimer/{favoriteAd}', [FavoriteAds\FavoriteAdsController::class, 'destroy'])->name('destroy');
});

Route::prefix('mon-espace/messagerie')->middleware('auth')->name('threads.')->group(function () {
    Route::get('actualisation', [Threads\ThreadsController::class, 'refreshUnreadMessages'])->name('refreshUnreadMessages');
    Route::get('/', [Threads\ThreadsController::class, 'index'])->name('index');
    Route::post('creer', [Threads\ThreadsController::class, 'create'])->middleware('throttle.messages:1,1')->name('create');
    Route::get('{id}', [Threads\MessagesController::class, 'show'])->name('show');
    Route::post('envoi', [Threads\MessagesController::class, 'create'])->middleware('throttle.messages:1,1')->name('send');
    Route::post('upload', [Threads\MessagesController::class, 'uploadDocuments'])->name('upload');
    Route::get('delete/{id}', [Threads\MessagesController::class, 'delete'])->name('delete-message');
    //	Route::get('{type}/{filename}', 'MessagesController@show')->name('show');

});

Route::prefix('locations')->group(function () {
    Route::get('/', [Locationables\LocationableController::class, 'locations']);
    Route::get('countries', [Locationables\LocationableController::class, 'countries']);
    Route::get('cities', [Locationables\LocationableController::class, 'cities']);
    Route::get('departments', [Locationables\LocationableController::class, 'departments']);
    Route::get('cities-and-regions', [Locationables\LocationableController::class, 'citiesAndRegions']);
    Route::get('cities-and-departments', [Locationables\LocationableController::class, 'citiesAndDepartments']);
    Route::get('departments-and-regions', [Locationables\LocationableController::class, 'departmentsAndRegions']);
    Route::prefix('polygon')->group(function () {
        Route::post('regions', [Locationables\LocationableController::class, 'regionsPolygon']);
        Route::get('departments', [Locationables\LocationableController::class, 'departmentsPolygon']);
        Route::get('france', [Locationables\LocationableController::class, 'france']);
        Route::post('ad-locations', [Locationables\LocationableController::class, 'adLocations']);
    });
});

Route::middleware('moderator')->prefix('gestion-des-annonces')->name('moderator.')->group(function () {
    Route::get('/', [Moderators\ModeratorController::class, 'index'])->name('index');
    Route::get('recherche', [Moderators\ModeratorController::class, 'show'])->name('show');
    Route::get('aide-et-ressources', [Moderators\ModeratorController::class, 'help'])->name('help');
    Route::post('validation', [AttributionAds\AttributionAdsController::class, 'acceptAd'])->name('acceptAd');
    Route::post('modification', [AttributionAds\AttributionAdsController::class, 'modifyAd'])->name('modifyAd');
    Route::post('refus', [AttributionAds\AttributionAdsController::class, 'rejectAd'])->name('rejectAd');
});

Route::middleware('moderator')->get('historique/{id}', [Histories\HistoriesController::class, 'show'])->name('history.show');

Route::middleware('admin')->prefix('administration')->name('administrator.')->group(function () {
    Route::get('liste-utilisateurs-par-territoires', [Administrators\AdministratorController::class, 'showUsersByTerritories'])->name('usersByTerritories');
});

Route::prefix('mon-tableau-de-bord')->name('supervisor.')->group(function () {
    Route::middleware('supervisor')->get('/', [Supervisors\SupervisorsController::class, 'index'])->name('index');
    Route::middleware('supervisor')->get('recherche', [Supervisors\SupervisorsController::class, 'show'])->name('show');
    Route::middleware('supervisor')->get('aide-et-ressources', [Supervisors\SupervisorsController::class, 'help'])->name('help');
    Route::post('attribution', [Supervisors\SupervisorsController::class, 'attribute'])->name('attribute');
    Route::get('supprimer-attribution/{adId}/{slot}', [Supervisors\SupervisorsController::class, 'deleteAttribution'])->name('delete_attribution');
    Route::middleware('supervisor')->get('export', [Supervisors\SupervisorsController::class, 'export'])->name('export');
    Route::middleware('supervisor')->get('rapports-et-indicateurs', [Supervisors\SupervisorsController::class, 'report'])->name('report');
    Route::middleware('supervisor')->get('administration-indicateurs', [Supervisors\SupervisorsController::class, 'projectKeysDataEdit'])->name('projectDataKeysEdit');
    Route::middleware('supervisor')->post('creation-indicateur', [Supervisors\SupervisorsController::class, 'projectDataKeysCreate'])->name('projectDataKeysCreate');
    Route::middleware('supervisor')->post('suppression-indicateur', [Supervisors\SupervisorsController::class, 'projectDataKeyDelete'])->name('projectDataKeyDelete');
});

Route::middleware('advisor')->prefix('gestion-des-accompagnements')->name('advisor.')->group(function () {
    Route::get('/', [Advisors\AdvisorsController::class, 'index'])->name('index');
    Route::get('aide-et-ressources', [Advisors\AdvisorsController::class, 'help'])->name('help');
    Route::get('recherche', [Advisors\AdvisorsController::class, 'show'])->name('show');
    Route::get('creation-compte-pp', [Advisors\AdvisorsController::class, 'createNewUserPp'])->name('createNewPp');
    Route::post('creation-compte-pp', [Advisors\AdvisorsController::class, 'registerNewUserPp'])->name('registerNewPp');
    Route::get('export', [Advisors\AdvisorsController::class, 'export'])->name('export');
    Route::get('espace-suivi/{id}', [Advisors\AdvisorsController::class, 'showSupport'])->name('showSupport');
    Route::post('mise-a-jour-statut', [Advisors\AdvisorsController::class, 'updateSupport'])->name('updateSupport');
    Route::post('creation-note', [Advisors\AdvisorsController::class, 'createNote'])->name('createNote');
    Route::post('edition-note', [Advisors\AdvisorsController::class, 'editNote'])->name('editNote');
    Route::post('suppression-note', [Advisors\AdvisorsController::class, 'deleteNote'])->name('deleteNote');
    Route::post('modification-valeurs-indicateurs', [Advisors\AdvisorsController::class, 'updateProjectDataKeysValues'])->name('updateProjectDataKeysValues');
    Route::post('ajout-document', [Advisors\AdvisorsController::class, 'uploadDocuments'])->name('uploadDocuments');
    Route::post('bloquer-utlisateur', [Advisors\AdvisorsController::class, 'blockUser'])->name('blockUser');
});

Route::middleware('supervisor')->prefix('gestion-reponse-types')->name('responseTemplates.')->group(function () {
    Route::get('/', [ResponseTemplates\ResponseTemplatesController::class, 'index'])->name('index');
    Route::post('/creer', [ResponseTemplates\ResponseTemplatesController::class, 'create'])->name('create');
    Route::post('/editer', [ResponseTemplates\ResponseTemplatesController::class, 'edit'])->name('edit');
    Route::post('/supprimer', [ResponseTemplates\ResponseTemplatesController::class, 'delete'])->name('delete');
});

Route::middleware('auth')->prefix('notification')->name('notification.')->group(function () {
    Route::get('index', [Notifications\NotificationsController::class, 'index'])->name('index');
    Route::patch('{notification}', [Notifications\NotificationsController::class, 'update'])->name('update');
});

// Authentication
Route::get('connexion', [Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('connexion', [Auth\LoginController::class, 'login']);
Route::post('connexion/checkpoint', [Auth\LoginController::class, 'checkpoint'])->name('checkpoint');
Route::get('connexion/sso', [Auth\SalesforceLoginController::class, 'salesforceLogin'])->name('login.sso');
// Route::post('login', 'Auth\SalesforceLoginController@login')->name('login');
Route::get('deconnexion/sso', [Auth\SalesforceLoginController::class, 'salesforceLogout'])->name('logout.sso');
Route::get('deconnexion', [Auth\LoginController::class, 'logout'])->name('logout');
Route::get('email/verify', [Auth\VerificationController::class, 'show'])->name('verification.notice');
Route::get('email/verify/{id}/{hash}', [Auth\VerificationController::class, 'verify'])->name('verification.verify');
Route::post('email/resend', [Auth\VerificationController::class, 'resend'])->name('verification.resend');

// Registration
Route::get('inscription', [Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('inscription', [Auth\RegisterController::class, 'register']);

// Password Reset
Route::prefix('motdepasse')->name('password.')->group(function () {
    Route::get('reinitialiser', [Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('request');
    Route::post('email', [Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('email');
    Route::get('reinitialiser/{token}', [Auth\ResetPasswordController::class, 'showResetForm'])->name('reset');
    Route::post('reinitialiser', [Auth\ResetPasswordController::class, 'reset'])->name('update');
});

Route::post('newsletter', [Newsletter\NewsletterController::class, 'create']);

Route::post('/info-banner/close', [InfoBannerController::class, 'close'])->name('info-banner.close');

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

Route::prefix('old_annonces')->name('ads.')->group(function () {
    Route::get('{id}', 'AdsController@oldshow')->name('oldshow');
});*/

// Route::get('test', function () {
//    return view('baptiste.test');
// })->name('baptiste');
