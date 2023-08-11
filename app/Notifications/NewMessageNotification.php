<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class NewMessageNotification extends Notification implements ShouldQueue
{
	use Queueable;

	protected $data;

	/**
	 * Create a new notification instance.
	 *
	 * @param array $data
	 */
	public function __construct(array $data)
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
		$mailMessage = new MailMessage();

		$mailMessage
			->subject('Nouveau message de la part de ' . $this->data['sender_first_name'] . ' ' . $this->data['sender_name'])
			->greeting('Bonjour, ' . $notifiable->fisrt_name)
            ->line('Vous avez reçu un nouveau message de ' . $this->data['sender_first_name'] . ' ' . $this->data['sender_name'].".")
			->action('Consulter votre messagerie', url('/mon-espace/messagerie'))
			->line('A bientôt sur Objectif Terres !')
			->salutation('L\'équipe d\'Objectif Terres')
            ->replyTo("objectif-terres@terredeliens.org");

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
			//
		];
	}
}
