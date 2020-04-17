<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewMessageNotification extends Notification
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
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
			->from(env('MAIL_FROM_ADDRESS'), "Objectif Terres")
			->subject('Vous avez reçu un nouveau message ! | Objectif terres')
			->greeting('Bonjour,')
			->line( 'Vous avez reçu un nouveau message de '.$this->data['sender_first_name'].' '. $this->data['sender_name']. ' : ')
			->line( "''". $this->data['message_content']."''")
			->action( 'Consulter votre messagerie', url('/mon-espace/messagerie'))
			->line('A bientôt sur Objectif Terres !')
			->salutation('Cordialement, L\'équipe d\'Objectif Terres');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
