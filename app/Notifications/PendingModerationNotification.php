<?php

namespace App\Notifications;

use App\Models\Ad;

class PendingModerationNotification extends BasicNotification
{
    public function __construct(Ad $ad)
    {
        parent::__construct([
            'subject' => 'Votre annonce N°'.$ad->id.' est en cours de modération',
            'message' => "Votre annonce '".$ad->title."' va être prochainement modérée par un membre de l’équipe, qui rassemble ".
                "des bénévoles et salarié·es.\nNous faisons notre possible pour vous répondre le plus rapidement.\n
                Vous pouvez gérer vos annonces depuis votre espace personnel Objectif Terres :\n",
            'action' => ['Gérer mes annonces', route('ads.list')],
            'salutation' => "Bonne chance dans vos projets,\nL’équipe Terre de Liens.",
        ]);
    }
}
