<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;

class OverdueModerationNotification extends Notification implements ShouldQueue
{
	use Queueable;

	protected $data;
	protected $attributions;

	/**
	 * Create a new notification instance.
	 *
	 * @param string $data
	 * @param object $attributions
	 */
	public function __construct(string $data, Collection $attributions)
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
		return [
			'number_of_ads_to_moderate' => $this->attributions->count(),
			'attribution_ids' => $this->attributions->pluck('id')->toArray(),
		];
	}
}
