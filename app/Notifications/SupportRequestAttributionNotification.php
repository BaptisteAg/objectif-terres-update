<?php

namespace App\Notifications;


use App\Models\Ad;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SupportRequestAttributionNotification extends Notification implements ShouldQueue
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
		$url = url('/annonces/' . $this->ad->id);
		$mail = (new MailMessage)
			->from(config('mail.from.address'), "Administration")
			->subject('Nouvelle attribution d\'une demande d\'accompagnement !')
			->greeting('Bonjour,');

		if($this->ad->attributionAd->userSupervisor) {
		    $mail->line(
                'Votre responsable territorial ' .
                $this->ad->attributionAd->userSupervisor->first_name . ' ' .
                $this->ad->attributionAd->userSupervisor->name .
                ' vous a attribué une nouvelle demande d\'accomapgnement.'
            );
        }

		$mail
			->line('La demande d\'accompagnement a été soumise par ' . $this->ad->userPp->first_name . ' ' . $this->ad->userPP->name . ' .')
			->action('Consulter la demande d\'accompagnement', $url)
			->line('A bientôt sur Objectif Terres !')
			->salutation('Cordialement, L\'équipe d\'Objectif Terres');

		return $mail;
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
		];
	}

}
