<?php

namespace App\Jobs;

use App\Models\Ad;
use App\Notifications\BasicNotification;
use App\Services\Ads\AdService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyPublishDateExtendBeforeExpiration implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $adService;

	/**
	 * Create a new job instance.
	 *
	 * @param AdService $adService
	 */
    public function __construct(AdService $adService)
    {
        $this->adService = $adService;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if(config("app.is_scheduler_live_mode")) {
            $date = Carbon::now()->subMonths(6)->subDays(6);
            $extraMsg = '';
        }
        else {
            $date = Carbon::now()->subMonths(6)->subHours(2);
            $extraMsg = " \n(MODE TEST : NOTIFICATION 2 HEURES AVANT, EXPIRATION LE ".$date. ")";
        }

       $soonToExpireAds = $this->adService->findAdsPublishedSince($date);

        logger("Suggesting soon to expire (".$date.") ads owner to extend the date... ".$soonToExpireAds->count()." found.");

        foreach($soonToExpireAds as $ad) {
            try {
                $ad->userPp->notify(new BasicNotification([
                    'subject' => "Votre annonce va bientôt expirer",
                    'message' => "Nous espérons que ce service a répondu à votre besoin.\n

                    Sans action de votre part d'ici 7 jours, cette annonce ne sera plus visible sur notre site.\n

                    Pour reconduire votre annonce sans modification pour une durée de 6 mois, cliquez sur le bouton ci-dessous.\n

                    Vous pouvez également modifier votre annonce.\n\n

                    Si vous souhaitez supprimer votre annonce, merci de prendre une minute
                    <a href='https://framaforms.org/questionnaire-objectif-terres-en-direction-des-annonceurs-qui-suppriment-leur-annonce-1641204728'>pour remplir ce formulaire</a> pour nous aider à améliorer notre plateforme.\n\n

                    En vous remerciant pour votre confiance." . $extraMsg,
                    'action' => ["Etendre l'annonce", route('ads.extend', ["id" => $ad->id])]
                ]));
                if(env('MAIL_HOST', false) === 'smtp.mailtrap.io'){
                    sleep(1);
                }
            }
            catch (\Exception $e) {

            }
        }
    }
}
