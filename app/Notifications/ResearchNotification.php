<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResearchNotification extends Notification
{
	use Queueable;

	/**
	 * Create a new notification instance.
	 * @param object
	 * @return void
	 */
	public function __construct(object $data)
	{
		$this->data = $data;
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @param mixed $notifiable
	 * @return array
	 */
	public function via($notifiable)
	{
		return ['mail'];
	}

	/**
	 * Get the mail representation of the notification.
	 *
	 * @param mixed $notifiable
	 * @return \Illuminate\Notifications\Messages\MailMessage
	 */
	public function toMail($notifiable)
	{
		$subject = $this->data->subject;
		$message = $this->data->message;
		$url = url('/recherches/recherche/' . $this->data->url);

		return (new MailMessage)
			->subject($subject)
			->line($message)
			->greeting('Bonjour,')
			->action('Consulter les résultats de votre recherche', $url)
			->line('Merci d\'utiliser les services du site d\'Objectif Terres !');


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
			//
		];
	}
}
