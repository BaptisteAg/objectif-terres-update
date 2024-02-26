<?php

namespace App\Notifications;

use App\Models\Ad;
use App\Models\AttributionAd;

class UnpublishedAdNotification extends AdNotification
{

    public function __construct(AttributionAd $attributionAd, string $since)
    {
        $formUrl = Ad::SALESFORCE_FORM_BY_AD_TYPE[$attributionAd->ad->type] ?? '';

        parent::__construct([
            'subject' => "Votre annonce N°".$attributionAd->ad->id." n'est plus en ligne",
            'url' => '/annonces/' . $attributionAd->ad->id,
            'action' => ["Répondre au questionnaire", $formUrl],
            'message' => 'Votre annonce était en ligne depuis '.$since.' et vient d\'être archivée.
            Vous pouvez la retrouver et la modifier sur votre compte Objectif Terres via <a href="' . route('ads.show', $attributionAd->ad->id) . '">ce lien</a>. Et vous pourrez, si besoin, de nouveau la mettre en ligne.
            
            Nous avons besoin de savoir combien de personnes trouvent leur ferme, ou vendent leur ferme grâce à Objectif Terres, c’est pourquoi nous vous proposons de répondre à quelques questions.\n Merci pour votre coopération !',
            'salutation' => "Bonne chance dans vos projets !\nL’équipe Terre de Liens"
        ]);
    }
}