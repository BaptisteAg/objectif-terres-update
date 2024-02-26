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

        $aboutAd = isset($this->data['ad_name']) ? ' à propos de l\'annonce ' . $this->data['ad_name'] : '';

		$mailMessage
			->subject('Vous avez un nouveau message de ' . $this->data['sender_first_name'] . ' ' . $this->data['sender_name'] . $aboutAd)
			->greeting('Bonjour, ' . $notifiable->fisrt_name)
            ->line('Vous avez reçu un nouveau message de ' . $this->data['sender_first_name'] . ' ' . $this->data['sender_name'].".")
			->action('Consulter votre messagerie', url('/mon-espace/messagerie'))
			->line('Bonne chance dans vos projets !')
			->salutation('L\'équipe Terre de Liens')
            ->line(new HtmlString('Pour accéder à votre messagerie vous pouvez copier-coller l\'adresse ci-dessous dans votre moteur de recherche : <a href="'.url('/mon-espace/messagerie').'">'.url('/mon-espace/messagerie').'</a>'))
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
