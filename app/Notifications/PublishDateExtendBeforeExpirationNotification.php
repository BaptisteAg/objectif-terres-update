<?php

namespace App\Notifications;

use App\Models\Ad;

class PublishDateExtendBeforeExpirationNotification extends BasicNotification
{
    public function __construct(mixed $ad)
    {
        $formUrl = Ad::SALESFORCE_FORM_BY_AD_TYPE[$ad->type] ?? '';
        $extraMsg = '';
        if (! config('app.is_scheduler_live_mode')) {
            $extraMsg = " \n(MODE TEST : NOTIFICATION 30 MINUTES APRES, EXPIRATION DANS 30 MINUTES DE PLUS)";
        }
        parent::__construct([
            'subject' => 'Votre annonce N°'.$ad->title.' va bientôt  expirer',
            'message' => 'Votre annonce est en ligne depuis le '.$ad->attributionAd->created_at->format('d/m/Y').".
                    Sans action de votre part, elle sera archivée dans 7 jours.\n
                    Lien de votre annonce : ".route('ads.show', ['id' => $ad->id])."\n
                    ID de l'annonce : ".$ad->id.".\n\n²
                    Si vous souhaitez prolonger sa publication, cliquez sur le bouton ci-dessous.
                    Vous pouvez également la modifier si besoin.".$extraMsg,
            'action' => ['Prolonger votre annonce', route('ads.extend', ['id' => $ad->id])],
            'additional_message' => "Vous pouvez dès à présent archiver ou supprimer votre annonce. Profitez-en pour répondre à notre enquête de succès pour nous permettre d'améliorer Objectif-Terres",
            'additional_action' => ['Désactiver mon annonce et répondre au questionnaire', route('ads.list'), 'error'],
            'salutation' => "Bonne chance dans vos projets !\nL’équipe Terre de Liens",
        ]);
    }
}
