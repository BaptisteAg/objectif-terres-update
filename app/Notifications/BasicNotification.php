<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class
BasicNotification extends Notification implements ShouldQueue
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
	public function toMail(User $notifiable)
	{
		$message = (new MailMessage)
			->subject($this->data['subject'])
			->greeting('Bonjour ' . $notifiable->name . ',')
            ->cc("objectifterres@terredeliens.org")
            ->replyTo("objectifterres@terredeliens.org");

		foreach (explode("\n", strip_tags($this->data["message"])) as $line) {
			$message->line($line);
		}

		$message->action($this->data["action"][0] ?? null, $this->data["action"][1] ?? null)
			->line($this->data["additional_message"] ?? null)
			->salutation($this->data['salutation'] ?? 'A bientôt sur Objectif Terres !');

		return $message;
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
