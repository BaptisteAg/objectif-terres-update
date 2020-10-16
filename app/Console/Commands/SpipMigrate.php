<?php

namespace App\Console\Commands;

use App\Exports\Spip\AdsExport;
use App\Exports\Spip\UsersExport;
use App\Models\Ad;
use App\Models\Spip\Auteur;
use App\Models\User;
use App\Services\Ads\AdService;
use App\Services\Spip\SpipService;
use App\Services\Users\UserService;
use Illuminate\Console\Command;
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
     * @var UserService
     */
    private $userService;
    /**
     * @var AdService
     */
    protected $adService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(SpipService $spipService, UserService $userService, AdService $adService)
    {
        parent::__construct();

        $this->spipService = $spipService;
        $this->userService = $userService;
        $this->adService = $adService;

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

        /** @var Auteur[] $auteur */
        foreach($spipAdsByUser as $auteur) {

            if($auteur->articles_count === 0) {
                echo("User without ads, skipping : ".$auteur->email."\n");
                continue;
            }

            $user = User::where('email', $auteur->email)->first();

            if($user) {
                echo("User retrieved : ".$auteur->email."\n");

                $user->ads->each(function (Ad $ad) {
                    $ad->forceDelete();
                });
                //$user->forceDelete();
            }
            else {
                if(!$auteur->bio) {
                    echo("Generating password for user : ".$auteur->email."\n");
                    $auteur->bio = Str::random(8);
                    $auteur->save();
                }

                $user = $this->userService->create(
                    $this->spipService->getLocalUserMapping($auteur)
                );

                print_r("User created : ".$auteur->email."\n");
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

                print_r("Created ad n°".$stats["adCount"]." : ".json_encode([
                    "spip_id" => $article->id_article,
                    "id" => $ad->id,
                    "title" => $ad->title,
                    "url" => $article->url ? $article->url->url : ''
                ])."\n");

                $importedAds[] = [
                    "title" => $ad->title,
                    "ad_type" => $this->adService->getAdType($ad),
                    "is_published" => $ad->is_draft ? "0" : "1",
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
                if(!$ad->documents_count) {
                    $stats["adsWithoutDocument"]++;
                }
            }

            $importedUsers[] = [
                "first_name" => $user->first_name,
                "last_name" => $user->name,
                "email" => $user->email,
                "password" => utf8_encode($auteur->bio),
                "ads_count" => $userAdCount,
                "last_ad_is_published" => !$lastUserAd || $lastUserAd->is_draft ? '0' : '1',
                "last_ad_title" => $lastUserAd ? $lastUserAd->title : '',
                "last_ad_date" => $lastUserAd ? $lastUserAd->created_at : '',
            ];
        }

        array_splice($importedUsers, 0, 0, [array_keys($importedUsers[0])]);
        array_splice($importedAds, 0, 0, [array_keys($importedAds[0])]);

        \Excel::store(new UsersExport($importedUsers), 'spip_users.xlsx');
        \Excel::store(new AdsExport($importedAds), 'spip_ads.xlsx');

        $stats["land_seek"] = collect($importedAds)->filter(function ($ad) {
            return $ad["ad_type"] === "land_seek";
        })->count();
        $stats["land_offer"] = collect($importedAds)->filter(function ($ad) {
            return $ad["ad_type"] === "land_offer";
        })->count();
        $stats["job_seek"] = collect($importedAds)->filter(function ($ad) {
            return $ad["ad_type"] === "job_seek";
        })->count();
        $stats["job_offer"] = collect($importedAds)->filter(function ($ad) {
            return $ad["ad_type"] === "job_offer";
        })->count();

        $stats["users_without_ad"] = collect($importedUsers)->filter(function ($user) {
            return $user["ads_count"] === 0;
        })->count();
        $stats["users_with_more_than_1_ad"] = collect($importedUsers)->filter(function ($user) {
            return $user["ads_count"] > 1;
        })->count();

        print_r($stats);
        echo "\n";
    }
}
