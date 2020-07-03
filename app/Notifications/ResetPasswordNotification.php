<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification implements ShouldQueue
{
	use Queueable;

	/**
	 * The password reset token
	 * @var string
	 */
	public $token;

	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct($token)
	{
		$this->token = $token;
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
		return (new MailMessage)
			->subject('Réinitialisation de votre mot de passe ')
			->greeting('Bonjour,')
			->line('Vous venez de recevoir ce mail car vous souhaitez réinitialiser votre mot de passe pour accéder à votre compte Objectif Terres. ')
			->action('Générer un nouveau mot de passe',  url(config('app.url').route('password.reset', $this->token, false)))
			->line('Ce lien va expirer dans 60 minutes. Si vous ne générer pas un nouveau mot de passe, l\'ancien mot de passe restera actif.')
			->salutation('Cordialement, L\'équipe d\'Objectif Terres');
	}


}
