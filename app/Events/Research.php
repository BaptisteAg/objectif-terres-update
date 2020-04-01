<?php

namespace App\Events;

use App\Notifications\ResearchNotification;
use App\Services\Researches\ResearchService;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class Research
{
	private $researchService;
    use Dispatchable, InteractsWithSockets, SerializesModels;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ResearchService $researchService)
    {
    	$this->researchService = $researchService;
    }

    /**
     * Send an email when creating a new alert on research
     *
     * @param int
     */
    public function createAlert(int $id)
    {
    	//Set the has_alert column to TRUE
		$research = $this->researchService->find($id);
		$research->update(['has_alert' => 1]);
		$research['greeting'] = "Bonjour,";
		$research['subject'] = 'Création d\'une alerte pour une recherche de projet | Objectif Terres';
		$research['message'] = 'Une alerte a bien été créée pour une recherche';
		Notification::route('mail', auth()->user()->email)
			->notify(new ResearchNotification($research));
    }

	/**
	 * Send an email to every user who have new ads in their research
	 *
	 */
    public function sendAlert(){
		$ads = $this->researchService->findNewRelatedAds();
		foreach ( $ads as $idResearch =>$ad){
			$research = $this->researchService->find($idResearch);
			$research['greeting'] = "Bonjour,";
			$research['subject'] = 'De nouvelles annonces correspondantes à votre recherche ont été publiées | Objectif Terres';
			$research['message'] = 'De nouvelles annonces concernant votre recherche ont été publiées, consulter les dernières annonces correspondantes à votre recherche !';
			Notification::route('mail', $research->user->email)
				->notify(new ResearchNotification($research));
		}
	}

}
