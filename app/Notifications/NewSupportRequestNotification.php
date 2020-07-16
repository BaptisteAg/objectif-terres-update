<?php

namespace App\Notifications;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewSupportRequestNotification extends Notification implements ShouldQueue
{
	use Queueable;

	protected $ad;

	/**
	 * Create a new notification instance.
	 *
	 * @param Ad $ad
	 */
	public function __construct(Ad $ad)
	{
		$this->ad = $ad;
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
			->subject('Nouvelle demande d\'accompagnement !')
			->greeting('Bonjour,')
			->line('Vous avez reçu une nouvelle demande d\'accompagnment pour un projet posté par '. $this->ad->userPp->first_name.' '.$this->ad->userPp->name.' .')
			->action('Consulter le projet', $url)
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
		return [
			'ad_id' => $this->ad->id,
			'user_pp_id' => $this->ad->userPp->id,
			'user_pp_first_name' => $this->ad->userPp->first_name,
			'user_pp_name' => $this->ad->userPp->name,
			'is_project' =>true
		];
	}
}
