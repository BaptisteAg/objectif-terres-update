<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class SupportRequestTerritoryNotification extends Notification
{
	use Queueable;
	protected $data;

	/**
	 * Create a new notification instance.
	 *
	 * @return void
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
	public function toMail(User $notifiable)
	{
		return (new MailMessage)
			->subject($this->data['subject'])
			->greeting('Bonjour ' . $notifiable->first_name . ',')
			//->cc("objectif-terres@terredeliens.org")
			->replyTo("objectif-terres@terredeliens.org")
			->line("Merci de nous avoir fait part de votre projet '" . $this->data['ad_title'] . "'")
			->line("Un membre de Terre de Liens " . $this->data['supportRequest_name'] . " prendra contact avec vous prochainement")
			->line("Voici les modalités d’accompagnement de notre association :")
			->line(new HtmlString($this->data['supportRequest_content']))
			->line("Vous pouvez mettre à jour projet sur Objectif Terres")
			->action($this->data["action"][0] ?? null, $this->data["action"][1] ?? null)
			->salutation('A bientôt sur Objectif Terres !');

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
