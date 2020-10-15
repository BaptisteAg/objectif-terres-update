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
        // Checking ads with more than 1 attached user, which should not be imported
        //$articles = $this->spipService->getAllAdsWithUsers();
        //dd($articles->filter(function ($a) {return $a->auteurs->count() > 1;})->map(function ($a) {return $a->auteurs->pluck("email");}));

        $spipAdsByUser = $this->spipService->getAllUsersWithAds();

        $userCount = $spipAdsByUser->count();
        $adCount = $spipAdsByUser->pluck('articles')->flatten()->count();

        print_r("Found $userCount users and $adCount ads.\n");

        $importedUsers = [];
        $importedAds = [];

        /** @var Auteur[] $auteur */
        foreach($spipAdsByUser as $auteur) {

            $user = User::where('email', $auteur->email)->first();

            if($user) {
                $user->ads->each(function (Ad $ad) {
                    $ad->forceDelete();
                });
                //$user->forceDelete();
            }
            else {
                if(!$auteur->bio) {
                    $auteur->bio = Str::random(8);
                    $auteur->save();
                }

                $user = $this->userService->create(
                    $this->spipService->getLocalUserMapping($auteur)
                );
            }

            //dd($auteur->email, $auteur->bio, $auteur->id_auteur);
            //dd($this->spipService->getLocalUserMapping($auteur));

            $importedUsers[] = [
                "first_name" => $user->first_name,
                "name" => $user->name,
                "email" => $user->email,
                "password" => utf8_encode($auteur->bio),
            ];

            foreach($auteur->articles as $article) {
                $localAdMapping = $this->spipService->getLocalAdMapping($article, $user->id);

                if(empty($localAdMapping["locationable"]["regions"]) || empty($localAdMapping["locationable"]["regions"][0])) {
                    continue;
                }

                $ad = $this->adService->importAd(
                    $localAdMapping,
                    $user->id
                );

                $importedAds[] = $ad->only(["title", "about_content", "about_project_content"]);
            }
        }

        \Excel::store(new UsersExport($importedUsers), 'spip_users.xlsx');
        \Excel::store(new AdsExport($importedAds), 'spip_ads.xlsx');
    }
}
