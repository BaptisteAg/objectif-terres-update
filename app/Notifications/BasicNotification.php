<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class BasicNotification extends Notification implements ShouldQueue
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
			->greeting('Bonjour ' . $notifiable->first_name . ',')
            //->cc("objectif-terres@terredeliens.org")
            ->replyTo("objectif-terres@terredeliens.org");

        $message->line(new HtmlString(nl2br($this->data["message"])));

        if (isset($this->data['action'])) {
            $message->action($this->data["action"][0] ?? null, $this->data["action"][1] ?? null);
        }
        if (isset($this->data['additional_message'])) {
            $message->line($this->data["additional_message"] ?? null);
        }
        if (isset($this->data['additional_action'])) {
            $message->viewData["additional_action"] = [$this->data["additional_action"][0] ?? null, $this->data["additional_action"][1] ?? null];
        }

        $message->salutation(isset($this->data['salutation']) ? nl2br($this->data['salutation']) : 'A bientôt sur Objectif Terres !');

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
