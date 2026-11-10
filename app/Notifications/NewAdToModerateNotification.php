<?php

namespace App\Notifications;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class NewAdToModerateNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $ad;

    /** @var User|Authenticatable */
    protected $userPP;

    /**
     * Create a new notification instance.
     *
     * @param  User  $userPP
     */
    public function __construct(Ad $ad, Authenticatable $userPP)
    {
        $this->ad = $ad;
        $this->userPP = $userPP;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url('/annonces/'.$this->ad->id);
        $isNewAd = $this->ad->attributionAd->created_at == $this->ad->attributionAd->updated_at;

        $mailMessage = new MailMessage;
        if ($isNewAd) {
            $mailMessage->subject('Modérez l\'annonce n°['.$this->ad->id.']');
        } else {
            $mailMessage->subject('Modérez l\'annonce n°['.$this->ad->id.'] MODIFIÉE par son auteur');
        }

        $mailMessage->greeting('Bonjour, '.$notifiable->first_name);

        if ($isNewAd) {
            $mailMessage->line('Une annonce doit être modérée. ');
        } else {
            $mailMessage->line('Cette annonce a été modifiée par son auteur·e et doit être modérée à nouveau.');

        }
        $mailMessage->line('Titre : "'.$this->ad->title.'"')
            ->line('Auteur·e :"'.$this->userPP->name.'"')
            ->action('Modérer l\'annonce', $url)
            ->line(new HtmlString('Pour accéder à l\'annonce vous pouvez copier-coller l\'adresse ci-dessous dans votre moteur de recherche : <a href="'.$url.'">'.$url.'</a>'))
            ->line(new HtmlString('Lien vers la charte Objectif Terres : <a href="'.url('/charte').'">'.url('/charte').'</a>'))
            ->line('Merci pour votre aide dans la gestion de la plateforme.')
            ->line('Cordialement')
            ->salutation('L’équipe support d’Objectif Terres')
            // ->cc("objectif-terres@terredeliens.org")
            ->replyTo('objectif-terres@terredeliens.org');

        $mailMessage->viewData['disable_donation_button'] = true;

        return $mailMessage;
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
            'ad_id' => $this->ad->id,
            'user_pp_id' => $this->userPP->id,
            'user_pp_first_name' => $this->userPP->first_name,
            'user_pp_name' => $this->userPP->name,
        ];
    }
}
