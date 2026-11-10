<?php

namespace App\Notifications;

use App\Models\AttributionAd;

class AcceptedAdNotification extends BasicNotification
{
    public function __construct(AttributionAd $attributionAd)
    {
        parent::__construct([
            'subject' => 'Votre annonce n°'.$attributionAd->ad->id.' a été validée',
            'message' => "Votre annonce a été publiée sur Objectif Terres. Elle sera en ligne durant 6 mois.
                Vous pouvez la retrouver et la modifier sur votre compte Objectif Terres via <a href='".route('ads.show', $attributionAd->ad->id)."'>ce lien</a>
                Si besoin vous pouvez la modifier ou la supprimer.\n",
            'action' => ['Gérer mes annonces', route('ads.list')],
            'salutation' => 'Bonne chance dans vos projets !']);
    }
}
