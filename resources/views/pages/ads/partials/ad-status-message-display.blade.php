@if($ad->is_draft === 0 && isset($ad->attributionAd))
    @if($ad->project)
        @if($ad->attributionAd->user_advisor_id)
            <article class="message is-success">
                <div class="message-body">
                    Votre demande d'accompagnement est prise en compte par un primo accueillant.
                </div>
            </article>
        @else
            <article class="message is-success">
                <div class="message-body">
                    Votre demande d'accompagnement est en attente d'être assignée à un primo-accueillant par un responsable territorial.
                </div>
            </article>
        @endif
    @else
        @if($ad->attributionAd->adStatus->id === 1)
            <article class="message is-success">
                <div class="message-body">
                    Votre annonce est en ligne !
                </div>
            </article>
        @elseif($ad->attributionAd->adStatus->id === 2)
            <article class="message is-warning">
                <div class="message-body">
                    Votre annonce nécessite quelques modifications, <a
                            href="{{route('threads.index')}}">consulter votre messagerie</a> pour
                    plus d'informations !
                </div>
            </article>

        @elseif($ad->attributionAd->adStatus->id === 3)
            <article class="message is-danger">
                <div class="message-body">
                    Votre annonce a été réfusée, <a href="{{route('threads.index')}}">consulter votre
                        messagerie</a> pour plus d'informations !
                </div>
            </article>
        @elseif($ad->attributionAd->adStatus->id === 6)
            <article class="message is-message">
                <div class="message-body">
                    Votre annonce n'est plus en ligne, elle a été archivée !
                </div>
            </article>
        @else
            <article class="message is-message">
                <div class="message-body">
                    Votre annonce n'est pas encore en ligne !
                </div>
            </article>
        @endif
    @endif
@else
    <article class="message is-warning">
        <div class="message-body">
            Votre annonce n'as pas encore été soumise, finaliser la création de votre annonce !
        </div>
    </article>
@endif


