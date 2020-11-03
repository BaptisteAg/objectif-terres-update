<?php

namespace App\Notifications;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewAdToModerateNotification extends Notification implements ShouldQueue
{
	use Queueable;

	protected $ad;
	/** @var User|Authenticatable */
	protected $userPP;

	/**
	 * Create a new notification instance.
	 *
	 * @param Ad $ad
	 * @param User $userPP
	 */
	public function __construct(Ad $ad, Authenticatable $userPP)
	{
		$this->ad = $ad;
		$this->userPP = $userPP;
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @param mixed $notifiable
	 * @return array
	 */
	public function via($notifiable)
	{
		return ['database', 'mail'];
	}

	/**
	 * Get the mail representation of the notification.
	 *
	 * @param mixed $notifiable
	 * @return \Illuminate\Notifications\Messages\MailMessage
	 */
	public function toMail($notifiable)
	{
		$url = url('/annonces/' . $this->ad->id);
		$isNewAd = $this->ad->updated_at->eq($this->ad->created_at);
		
		$mailMessage = new MailMessage();
		if ($isNewAd) {
			$mailMessage->subject('MODEREZ l\'annonce n°[' . $this->ad->id . ']');
		} else {
			$mailMessage->subject('MODEREZ l\'annonce n°[' . $this->ad->id . '] MODIFIÉE par son auteur');
		}

		$mailMessage->greeting('Bonjour, ' . $notifiable->first_name);

		if ($isNewAd) {
			$mailMessage->line('Cette annonce attend d\'être modérée. ');
		} else {
			$mailMessage->line('Cette annonce a été modifiée par son auteur·e et doit être modérée à nouveau.');

		}
		$mailMessage->line('Titre : "' . $this->ad->title . '"')
			->line('Auteur·e :"' . $this->userPP->name . '"')
			->action('Modérer l\'annonce', $url)
			->salutation('A bientôt sur Objectif Terres !')
            ->cc("objectifterres@terredeliens.org");

		return $mailMessage;
	}

	/**
	 * Get the array representation of the notification.
	 *
	 * @param mixed $notifiable
	 * @return array
	 */
	public function toArray($notifiable)
	{
		return [
			'ad_id' => $this->ad->id,
			'user_pp_id' => $this->userPP->id,
			'user_pp_first_name' => $this->userPP->first_name,
			'user_pp_name' => $this->userPP->name,
		];
	}
}
