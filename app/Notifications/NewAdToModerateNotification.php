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
	/** @var User|Authenticatable  */
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
		$url = url('/annonces/'.$this->ad->id);
		return (new MailMessage)
			->from(env('MAIL_FROM_ADDRESS'), "Administration | Objectif Terres")
			->subject('MODEREZ l\'annonce n°['.$this->ad->id.']')
			->greeting('Bonjour, '.$this->ad->attributionAd->userModerator->first_name.' '. $this->ad->attributionAd->userModerator->name)
			->line('L\'annonce "'.$this->ad->title .'" de '. $this->userPP->first_name.' '.$this->userPP->name.' attend d’être modérée par vos soins.')
			->action('Modérer l\'annonce', $url)
			->line('A bientôt,')
			->salutation('L\'équipe d\'Objectif Terres');
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
