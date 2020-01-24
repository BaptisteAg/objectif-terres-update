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
		$research = $this->researchService->find($id);
		$research['subject'] = 'Création d\'une alerte pour une recherche de projet | Objectif Terres';
		$research['message'] = 'Une alerte a bien été créée pour une recherche';
		Notification::route('mail', "test@mailtrap.io")
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
			$research['subject'] = 'De nouvelles annonces sont disponibles pour votre recherche | Objectif Terres';
			$research['message'] = 'Consulter les dernières annonces publiées !';
			Notification::route('mail', "test@mailtrap.io")
				->notify(new ResearchNotification($research));

		}
	}

}
