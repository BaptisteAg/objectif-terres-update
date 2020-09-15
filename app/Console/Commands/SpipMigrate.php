<?php

namespace App\Console\Commands;

use App\Models\Spip\Auteur;
use App\Models\User;
use App\Services\Spip\SpipService;
use App\Services\Users\UserService;
use Illuminate\Console\Command;

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
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(SpipService $spipService, UserService $userService)
    {
        parent::__construct();

        $this->spipService = $spipService;
        $this->userService = $userService;

    }

    /**
     * Execute the console command.
     *
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

        $spipAdsByUser->each(function (Auteur $auteur) {
            User::where('email', $auteur->email)->delete();
            //dd($auteur->email, $auteur->bio, $auteur->id_auteur);

            //dd($this->spipService->getLocalUserMapping($auteur));

            $this->userService->create(
                $this->spipService->getLocalUserMapping($auteur)
            );
        });


    }
}
