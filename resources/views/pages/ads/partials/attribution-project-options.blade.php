{!! Form::open(['route' => 'supervisor.attribute', 'method'=>'post']) !!}
<div class="box has-text-centered">
    <div class="container">
        <p class="title is-2 has-text-centered">Attribution de l'accompagnement</p>

        @if(!is_null($ad->support_request_text))
            <section class="mb-30">
                <p class="has-text-centered">Résumé : {{ $ad->support_request_text }}</p>
            </section>
        @endif

        @if($ad->isProjectAttributedToAdvisor)
            <p class="">Cette demande est attribuée à :</p>
                <ul style="list-style-type:none;">
                @foreach($ad->attributionAd->getAdvisors() as $i => $userAdvisor)
                    <li>
                        <strong>
                            {{$userAdvisor->first_name}} {{$userAdvisor->name}}
                            <a href="/mon-tableau-de-bord/supprimer-attribution/{{$ad->id}}/{{$i+1}}"><i class="fa fa-trash"></i></a>
                        </strong>
                    </li>
                @endforeach
                </ul>

            <br>
        @else
            <div class="notification is-danger is-light">
                Cette demande d'accompagnement n'a pas été encore attribuée à un primo-accueillant !
            </div>
        @endif

        @if(!$ad->isProjectInUserTerritories($currentUser->userTerritoryIds, $currentUser->userDepartmentsCodes))
            @if(isset($ad->attributionAd->user_supervisor_id))
                <p class="">Le responsable territorial de cette demande est
                    <strong>{{$ad->attributionAd->userSupervisor->first_name}} {{$ad->attributionAd->userSupervisor->name}}</strong>.
                </p>
            @elseif(isset($ad->support_request_territory_id))
                <p class="">Cette demande d'accomapgnement concerne les responsables territoriaux de :
                    <strong>{{$ad->supportRequestTerritoryId->name}} </strong>.
                </p>
            @else
                <p class="">Cette demande d'accomapgnement ne concerne pas votre terriotire.
                </p>
            @endif
            @if($ad->isProjectAttributedToAdvisor && $ad->attributionAd->userAdvisor)
                <a href="{{route('advisor.showSupport', $ad->id)}}" class="button is-link ">
                    <span class="icon is-small">
                        <i class="fas fa-search"></i>
                    </span>
                    <span>Accéder à l'espace de suivi</span>
                </a>
            @endif
        @endif

    </div>
    <br>
    @if($ad->isProjectInUserTerritories($currentUser->userTerritoryIds, $currentUser->userDepartmentsCodes ))
        <div class="columns is-centered ">
            <div class="column is-half has-text-centered ">
                <p class="">Vous souhaitez attribuer cette demande ?</p>
                @if(count($advisorUsers) > 0)
                    <div class="field">
                        <label class="label">Séléctionnez une personne parmi les primo-accueillants de votre
                            territoire</label>
                        <div class="select">
                            <select id="list_advisor_users" name="user_advisor_id"
                                    onchange="showValidationSupervisorModal()">
                                <option disabled selected hidden class="has-text-grey-light">Veuillez choisir...
                                </option>
                                @foreach ($advisorUsers as $advisor)
                                    @if(isset($ad->attributionAd->userAdvisor) and $ad->attributionAd->user_advisor_id === $advisor->id )
                                        <option disabled
                                                value="{{$advisor->id}}">{{$advisor->first_name}} {{$advisor->name}}</option>
                                    @else
                                        <option value="{{$advisor->id}}">{{$advisor->first_name}} {{$advisor->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <input value="{{$ad->id}}" name="ad_id" type="hidden">
                    </div>
                @else
                    <p class="has-text-weight-bold">Aucun primo-accueillant disponible sur ce territoire. Veuillez
                        contacter un administrateur.</p>
                @endif
            </div>
        </div>
    @endif
    <br>
</div>
<div id="modal-supervisor-validation" class="modal">
    <div id="modal-supervisor-validation-background" class="modal-background"></div>
    <div class="modal-content-validation">
        <div class="card">
            <div class="card-content">
                <div class="content">
                    <p class="title is-3 has-text-centered has-text-link">Confirmez-vous votre choix ?</p>
                    <p>Vous êtes sur le point d'attribuer cette demande à <span class="has-text-weight-bold"
                                                                                id="user_advisor_selected"></span></p>
                    <div class="content mt-30">
                        <p class="label has-text-centered">Laisser une note pour le primo accueillant</p>
                        <input value="{{auth()->id()}}" name="user_id" type="hidden">
                        <textarea class="textarea has-fixed-size" name="value" type="text"
                                  placeholder="Votre note..."></textarea>
                    </div>
                </div>
            </div>
            <footer class="card-footer">
                <div class="buttons card-footer-item">
                    <button type="submit" class="button is-link">
                        <span>Valider</span>
                    </button>
                    <a class="button is-link is-light" onclick="javascript:window.location.reload()">
                        <span>Annuler</span>
                    </a>
                </div>
                <a id="close-modal" class="modal-close is-large" aria-label="close"></a>
            </footer>
        </div>
    </div>
</div>
{!! Form::close() !!}