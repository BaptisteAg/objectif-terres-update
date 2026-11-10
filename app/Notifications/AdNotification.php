<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class AdNotification extends Notification implements ShouldQueue
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
    public function toMail(User $notifiable)
    {

        $mailMessage = new MailMessage;

        $mailMessage
            ->subject($this->data['subject'])
            ->greeting('Bonjour '.$notifiable->first_name.',')
            ->line(new HtmlString(nl2br($this->data['message'])))
            // ->cc("objectif-terres@terredeliens.org")
            ->replyTo('objectif-terres@terredeliens.org');

        if (isset($this->data['url'])) {
            $mailMessage->action('Consulter votre annonce', url($this->data['url']));
        }
        if (isset($this->data['action'])) {
            $mailMessage->action($this->data['action'][0] ?? null, $this->data['action'][1] ?? null);
        }
        if (isset($this->data['additional_message'])) {
            $mailMessage->line($this->data['additional_message'] ?? null);
        }
        if (isset($this->data['additional_action'])) {
            $mailMessage->action($this->data['additional_action'][0] ?? null, $this->data['additional_action'][1] ?? null);
        }

        return $mailMessage
            ->line('En vous remerciant pour votre confiance,')
            ->salutation('L’équipe Terre de Liens.');
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
