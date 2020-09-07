{!! Form::open(['route' => 'supervisor.attribute', 'method'=>'post']) !!}
<div class="box has-text-centered">
    <div class="container">
        <p class="title is-2 has-text-centered">Suivi de la demande d'accompagnement</p>
        @if($ad->isProjectInUserTerritories($currentUser->userTerritoryIds, $currentUser->userDepartmentsCodes) || $ad->attributionAd->user_supervisor_id === $currentUser->id)
            @if($ad->isProjectAttributedToAdvisor)
                <p class="">Cette demande est attribuée à
                    <strong>{{$ad->attributionAd->userAdvisor->first_name}} {{$ad->attributionAd->userAdvisor->name}}</strong>.
                </p>
                <p>Vous souhaitez attribuer cette demande à un autre primo-accueillant ?</p>
            @else
                <div class="notification is-danger is-light">
                    Cette demande d'accompagnement n'a pas été encore attribuée à un primo-accueillant !
                </div>
                <p class="">Vous souhaitez attribuer cette demande ?</p>
            @endif
        @else
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

            @if($ad->isProjectAttributedToAdvisor)
                <p class="">Cette demande est attribuée à
                    <strong>{{$ad->attributionAd->userAdvisor->first_name}} {{$ad->attributionAd->userAdvisor->name}}</strong>.
                </p>
                <br>
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
    @if($ad->attributionAd->user_supervisor_id === $currentUser->id || $ad->isProjectInUserTerritories($currentUser->userTerritoryIds, $currentUser->userDepartmentsCodes ))
        <div class="columns is-centered ">
            <div class="column is-half has-text-centered ">
                <div class="field">
                    <label class="label">Séléctionnez une personne parmi les primo-accueillants de votre
                        territoire</label>
                    <div class="select">

                        <select id="list_advisor_users" name="user_advisor_id"
                                onchange="showValidationSupervisorModal()">
                            <option disabled selected hidden class="has-text-grey-light">Veuillez choisir...</option>
                            @foreach ($advisorUsers as $advisor)
                                @if(isset($ad->attributionAd->userAdvisor) and $ad->attributionAd->user_advisor_id === $advisor->id )
                                    <option disabled
                                            value="{{$advisor->id}}">{{$advisor->first_name}} {{$advisor->name}}</option>
                                @else
                                    <option value="{{$advisor->id}}">{{$advisor->first_name}} {{$advisor->name}}</option>
                                @endif
                            @endforeach
                            <option value="{{$currentUser->id}}">{{$currentUser->first_name}} {{$currentUser->name}}</option>
                        </select>
                    </div>
                    <input value="{{$ad->id}}" name="ad_id" type="hidden">
                </div>
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
                        <textarea required class="textarea has-fixed-size" name="value" type="text"
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