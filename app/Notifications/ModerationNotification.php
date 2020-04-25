<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ModerationNotification extends Notification implements ShouldQueue
{
	use Queueable;

	protected $data;
	protected $adsToModerateByModerator;

	/**
	 * Create a new notification instance.
	 *
	 * @param string $data
	 * @param object $adsToModerateByModerator
	 */
	public function __construct(string $data, object $adsToModerateByModerator)
	{
		$this->data = $data;
		$this->adsToModerateByModerator = $adsToModerateByModerator;
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @param mixed $notifiable
	 * @return array
	 */
	public function via($notifiable)
	{
		return ['mail', 'database'];
	}

	/**
	 * Get the mail representation of the notification.
	 *
	 * @param mixed $notifiable
	 * @return \Illuminate\Notifications\Messages\MailMessage
	 */
	public function toMail($notifiable)
	{
		$message = $this->data;
		$url = url('/mon-espace-moderateur/recherches?ad_statuses[0]=4&order=asc&sort=date');
		return (new MailMessage)
			->from(env('MAIL_FROM_ADDRESS'), "Administration | Objectif Terres")
			->subject('Des annonces sont en attente de modération !')
			->greeting('Bonjour,')
			->line($message)
			->action('Accéder à mon espace modérateur', $url)
			->line('A bientôt sur Objectif Terres !')
			->salutation('Cordialement, L\'équipe d\'Objectif Terres');
	}

	/**
	 * Get the array representation of the notification.
	 *
	 * @param mixed $notifiable
	 * @return array
	 */
	public function toArray($notifiable)
	{
		$listOfAdsId = '';
		foreach ($this->adsToModerateByModerator as $attributionAd){
			$listOfAdsId = $listOfAdsId.$attributionAd->id.' ';
		}
		return [
			'number_of_ads_to_moderate' => $this->adsToModerateByModerator->count(),
			'ads_id' => $listOfAdsId,
		];
	}
}
