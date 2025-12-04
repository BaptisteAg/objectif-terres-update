@php
    $isThirdPartyAd = (bool)$ad->third_party_ad_user_id;
    $subtitle = $isThirdPartyAd ? "Cet annonceur doit être contacté manuellement :" : "Votre message";
@endphp
<modal
        title="Envoyer un message à l'annonceur"
        subtitle="{{$subtitle}}"
        button-label="Répondre à l'annonce"
        button-type="is-danger"
>
    @if($isThirdPartyAd)
        <div class="is-flex is-flex-direction-column">
            <strong>Téléphone : </strong>{{$ad->thirdPartyAdUser->phone}}
            @if($ad->thirdPartyAdUser->email)
            <strong>Email : </strong>{{$ad->thirdPartyAdUser->email}}
            @endif
        </div>
    @else
        <div class="notification is-warning is-light mb-4">
            <p class="is-size-7">
                <span class="icon"><i class="fas fa-exclamation-triangle"></i></span>
                <strong>Attention aux arnaques !</strong> Ne partagez jamais vos coordonnees bancaires et mefiez-vous des demandes de paiement ou de transfert d'argent. En cas de doute, <a href="mailto:objectif-terres@terredeliens.org">contactez-nous</a>.
            </p>
        </div>
        {!! Form::open(['route' => 'threads.create', 'method'=>'post', 'id' => 'form-new-thread-' . $ad->id, 'onsubmit' => 'return submitWithRecaptcha(event, this)']) !!}
        <input type="hidden" name="ad_id" value="{{$ad->id}}">
        <input type="hidden" name="recaptcha_token" id="recaptcha_token_{{$ad->id}}" value="">
        <textarea id="textearea_message" required name="content" class="textarea is-medium"
                  placeholder="Votre message..."></textarea>
        @if(auth()->user()->role >= 1 )
            <div class="field">
                <label class="label">Ou choisissez une réponse type :</label>
                <div class="control is-expanded ">
                    <div class="select">
                        <select id="response_templates_list" onchange="sendResponseTemplateMessage()">
                            <option disabled selected hidden>Choisir...</option>
                            @foreach($responseTemplates as $response)
                                <option value="{{$response->content}}"
                                        name="response_template">{{$response->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="field is-grouped">
                <p class="control is-expanded">
                    <a href="{{route('responseTemplates.index')}}">
										<span class="icon">
										<i class="fas fa-plus"></i>
									</span>
                        <span>Créer une nouvelle réponse type</span>
                    </a>
                </p>
            </div>
        @endif
        <b-button class="mt-3" rounded native-type="submit" expanded type="is-primary">Envoyer
        </b-button>
        {!! Form::close() !!}
    @endif
</modal>
