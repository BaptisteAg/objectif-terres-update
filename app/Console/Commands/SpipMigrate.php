<?php

namespace App\Console\Commands;

use App\Exports\Spip\AdsExport;
use App\Exports\Spip\UsersExport;
use App\Models\Ad;
use App\Models\Spip\Auteur;
use App\Models\User;
use App\Services\Ads\AdService;
use App\Services\Auth\RegisterService;
use App\Services\Salesforce\SalesforceService;
use App\Services\Spip\SpipService;
use App\Services\Users\UserService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class SpipMigrate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spip:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports terredeliens.org users and ads';
    /**
     * @var SpipService
     */
    protected $spipService;
    /**
     * @var RegisterService
     */
    private $registerService;
    /**
     * @var AdService
     */
    protected $adService;
    /**
     * @var SalesforceService
     */
    private $salesforceService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(SpipService $spipService, RegisterService $registerService, AdService $adService, SalesforceService $salesforceService)
    {
        parent::__construct();

        $this->spipService = $spipService;
        $this->registerService = $registerService;
        $this->adService = $adService;
        $this->salesforceService = $salesforceService;

    }

    /**
     * Execute the console command.
     *
     * @throws \Throwable
     * @throws \Throwable
     */
    public function handle()
    {
        $stats = [
            "adCount" => 0,
            "adsWithoutLocation" => 0,
            "adsWithoutUrl" => 0,
            "adsWithoutAdType" => 0,
            "adsWithoutDocument" => 0,
        ];

        // Checking ads with more than 1 attached user, which should not be imported
        //$articles = $this->spipService->getAllAdsWithUsers();
        //dd($articles->filter(function ($a) {return $a->auteurs->count() > 1;})->map(function ($a) {return $a->auteurs->pluck("email");}));

        $spipAdsByUser = $this->spipService->getAllUsersWithAds();

        $userCount = $spipAdsByUser->count();
        $adCount = $spipAdsByUser->pluck('articles')->flatten()->count();

        echo("Found $userCount users and $adCount ads.\n");

        $importedUsers = [];
        $importedAds = [];

        $stats["generated_passwords"] = 0;
        $stats["salesforce_users"] = 0;

        /** @var Auteur[] $auteur */
        foreach($spipAdsByUser as $auteur) {

            if($auteur->articles_count === 0) {
                echo("User without ads, skipping : ".$auteur->email."\n");
                continue;
            }
            if(empty($auteur->email)) {
                echo("User without email, skipping : ".$auteur->cpnom. " " . $auteur->cnom."\n");
                continue;
            }

            $user = User::where('email', $auteur->email)->first();

            $isSalesforceUser = $this->salesforceService->userNameExists($auteur->email, 'User');

            if($isSalesforceUser) {
                $stats["salesforce_users"]++;
            }

            if($user) {
                echo("User retrieved : ".$auteur->email."\n");

                if(config('app.env') === "local") {
                    $user->ads->each(function (Ad $ad) {
                        $ad->forceDelete();
                    });
                }
            }
            else {
                if($auteur->bio) {
                    if(strpos($auteur->bio, "TRAITE ") !== false) {
                        $auteur->bio = str_replace("TRAITE ", "", $auteur->bio);
                    }

                    $auteur->bio = html_entity_decode($auteur->bio);
                    $auteur->save();
                }
                elseif(!$auteur->bio && !$isSalesforceUser) {
                    echo("Generating password for user : ".$auteur->email."\n");
                    $auteur->bio = Str::random(8);
                    $auteur->save();
                    $stats["generated_passwords"]++;
                }

                $user = $this->registerService->create(
                    $this->spipService->getLocalUserMapping($auteur)
                );

                print_r("User imported : ".$auteur->email."\n");
            }

            //dd($auteur->email, $auteur->bio, $auteur->id_auteur);
            //dd($this->spipService->getLocalUserMapping($auteur));

            $lastUserAd = null;
            $userAdCount = 0;

            foreach($auteur->articles as $article) {
                $localAdMapping = $this->spipService->getLocalAdMapping($article, $user->id);

                if(empty($localAdMapping["locationable"]["regions"]) || empty($localAdMapping["locationable"]["regions"][0])) {
                    print_r("Ad without location (".$article->id_article."), skipping\n");
                    $stats["adsWithoutLocation"]++;
                    continue;
                }
                if(empty($article->url)) {
                    print_r("Ad without url (".$article->id_article."), skipping\n");
                    $stats["adsWithoutUrl"]++;
                    continue;
                }
                if(!$this->spipService->hasAdType($article)) {
                    print_r("Ad without ad type (".$article->id_article."), skipping\n");
                    $stats["adsWithoutAdType"]++;
                    continue;
                }

                $ad = $this->adService->importAd(
                    $localAdMapping,
                    $user->id
                );

                print_r("Imported ad n°".$stats["adCount"]." : ".json_encode([
                    "spip_id" => $article->id_article,
                    "id" => $ad->id,
                    "title" => $ad->title,
                    "url" => $article->url ? $article->url->url : ''
                ])."\n");

                $importedAds[] = [
                    "title" => $ad->title,
                    "ad_type" => $this->adService->getAdType($ad),
                    "is_published" => $ad->is_draft ? "0" : "1",
                    "pp_display_name" => $ad->userPp->first_name ?
                        ($ad->userPp->first_name.' '.$ad->userPp->name) :
                        $ad->userPp->email,
                    "moderator" => $ad->is_draft ? "" : $ad->attributionAd->userModerator->email,
                    "date" => $ad->created_at,
                    "about_content" => $ad->about_content,
                    "about_project_content" => $ad->about_project_content,
                    "documents" => $ad->documents_count,
                    "spip_id" => $article->id_article,
                    "id" => $ad->id,
                    "spip_url" => "https://terredeliens.org/".$article->url->url,
                    "url" => "https://www.objectif-terres.org/annonces/".$ad->id,
                ];
                $lastUserAd = $ad;
                $stats["adCount"]++;
                $userAdCount++;
                if(!$ad->documents()->count()) {
                    $stats["adsWithoutDocument"]++;
                }
            }

            $importedUsers[] = [
                "first_name" => $user->first_name,
                "last_name" => $user->name,
                "email" => $user->email,
                "is_salesforce" => $isSalesforceUser,
                "password" => $auteur->bio,
                "ads_count" => $userAdCount,
                "last_ad_is_published" => !$lastUserAd || $lastUserAd->is_draft ? '0' : '1',
                "last_ad_title" => $lastUserAd ? $lastUserAd->title : '',
                "last_ad_date" => $lastUserAd ? $lastUserAd->created_at : '',
            ];
        }

        Cache::flush();

        array_splice($importedUsers, 0, 0, [array_keys($importedUsers[0])]);
        array_splice($importedAds, 0, 0, [array_keys($importedAds[0])]);

        \Excel::store(new UsersExport($importedUsers), 'spip_users.xlsx');
        \Excel::store(new AdsExport($importedAds), 'spip_ads.xlsx');

        $ads = collect($importedAds)->splice(0,1);
        $users = collect($importedUsers)->splice(0,1);

        /*$stats["land_seek"] = $ads->filter(function (Ad $ad) {
            return !empty($ad->landSeekAd);
    })->count();
        $stats["land_offer"] = $ads->filter(function (Ad $ad) {
            return !empty($ad->landOfferAd);
        })->count();
        $stats["job_seek"] = $ads->filter(function (Ad $ad) {
            return !empty($ad->jobSeekAd);
        })->count();
        $stats["job_offer"] = $ads->filter(function (Ad $ad) {
            return !empty($ad->jobOfferAd);
        })->count();

        $stats["users_without_ad"] = $users->filter(function (User $user) {
            return $user->ads_count === 0;*
        })->count();
        $stats["users_with_1_ad"] = $users->filter(function (User $user) {
            return $user->ads_count === 1;
        })->count();
        $stats["users_with_more_than_1_ad"] = $users->filter(function (User $user) {
            return $user->ads_count > 1;
        })->count();*/

        print_r($stats);
        echo "\n";
    }
}