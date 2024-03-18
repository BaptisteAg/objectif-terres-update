<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

class OverdueModerationNotification extends Notification implements ShouldQueue
{
	use Queueable;

	protected $data;
	protected $attributions;

	/**
	 * Create a new notification instance.
	 *
	 * @param array $data
	 * @param Collection $attributions
	 */
	public function __construct(array $data, Collection $attributions)
	{
		$this->data = $data;
		$this->attributions = $attributions;
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

		$url = url('/gestion-des-annonces/recherche?ad_statuses[0]=4');
		$mail =  (new MailMessage)
			->from(config('mail.from.address'), "Objectif Terres")
			->subject($this->data['subject'] ?? 'Des annonces sont en attente de modération')
			->greeting('Bonjour, ' . $notifiable->first_name)
			->line("Depuis 7 jours, une ou plusieurs annonces sont en attente d’être modérées.")
			->line("Merci de consulter votre espace modérateur.")
			->action('Mon espace Modérateur', $url)
            ->line(new HtmlString('Lien vers la charte Objectif Terres : <a href="'.url('/charte').'">'.url('/charte').'</a>'))
            ->line("Merci pour votre aide dans la gestion de la plateforme")
            ->salutation('A bientôt sur Objectif Terres !')
            //->cc("objectif-terres@terredeliens.org")
            ->replyTo("objectif-terres@terredeliens.org");

        $mail->viewData['disable_donation_button'] = true;

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
			'number_of_ads_to_moderate' => $this->attributions->count(),
			'attribution_ids' => $this->attributions->pluck('id')->toArray(),
		];
	}
}
