@extends('default')

@section('title', 'Profil de '. $user->first_name.' '.$user->name )

@section('main-content')
    <div class="section pt-0">
        <div class="section ">
            @include('components.back-links')
            <div class="columns is-mobile is-centered">
                <div class="column is-half ">
                    <div class="card ">
                        <div class="card-content">
                            <div class="media">
                                <div class="media-left">
                                    <span class="icon is-large text_primary" style="height: 4rem">
                                        <i class="fas fas fa-3x fa-user"></i>
                                    </span>
                                </div>
                                <div class="media-content">
                                    <div class="columns">
                                        <div class="column">
                                            <p class="text_size is-size-3">{{$user->first_name}} {{$user->name}}</p>
                                        </div>
                                        <div class="column is-offset-2">
                                            @if(auth()->user()->id == $user->id or auth()->user()->role >= 2)
                                                <a class="" href="{{route('user.edit', $user->id)}}">
                                                    <button class="button basic primary "
                                                            type="button">
                                                        <span class="icon is-small">
                                                            <i class="fa fa-user-edit" aria-hidden="true"></i>
                                                        </span>
                                                        <span>Modifier le profil</span>
                                                    </button>
                                                </a>
                                            @else
                                                <div id="vue-contact-user-modal">
                                                    <vue-threads inline-template>
                                                        <div>
                                                            <button class="open-modal-new-message button basic primary "
                                                                    type="button">
                                                                <span class="icon is-small">
                                                                    <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                                                </span>
                                                                <span> Envoyer un message</span>
                                                            </button>
                                                            @include('pages.users.partials.newMessageModal')
                                                        </div>
                                                    </vue-threads>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="content">
                                <div class="columns">
                                    <div class="column has-text-centered">
                                        <p>
                                            <span class="icon text_primary">
                                                <i class="fas fa-envelope"></i>
                                            </span>
                                            {{$user->email ?? "Adresse mail non renseignée"}}
                                        </p>
                                    </div>
                                    <div class="column has-text-centered">
                                        <span class="icon text_primary">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </span>
                                        {{$user->street ?? "Adresse non renseignée "}}
                                        <p>{{$user->city ?? "Ville non renseignée"}}</p>

                                    </div>
                                    <div class="column has-text-centered">
                                        <p>
                                            <span class="icon text_primary">
                                                <i class="fas fa-phone"></i>
                                            </span>
                                            {{$user->phone ?? "Numéro de téléphone non renseigné"}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @if(isset($user->created_at) && !empty($user->created_at))
                                <div class="card-footer is-marginless">
                                    <p class="card-footer-item ">Membre depuis le {{$user->created_at}}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container ">
            <nav class="level">
                <div class="level-left">
                    <div>
                        @if(auth()->user()->role <= 1)
                            @if(count($ads) <=1)
                                <h1 class="title"> {{ count($ads) }} annonce soumise</h1>
                            @else
                                <h2 class="title"> {{ count($ads) }} annonces soumises</h2>
                            @endif
                        @else
                            @if(count($ads) <=1)
                                <h1 class="title"> {{ count($ads) }} annonce ou demande d'accompagnement soumise</h1>
                            @else
                                <h2 class="title"> {{ count($ads) }} annonces ou demandes d'accompagnement soumises</h2>
                            @endif
                        @endif
                    </div>
                </div>
            </nav>
            <section class="section ">
                @foreach ($ads as $ad)
                    <ul class="list list_v tiles">
                        <li class="tile tile_text-image_h">
                            <div class="tile__link">
                                <div class="vignette photo is-flex">
                                    @include('pages.ads.partials.thumbnail_left')
                                </div>
                                <div class="tile__content large">
                                    @include('pages.ads.partials.thumbnail_right')

                                    <div class="tile__intro">
                                        @if(isset($ad->project))
                                            @if(isset($ad->project->support_stage_id))
                                                <p>
                                                    <span class="text_mouse">Stade de l'accompagnement :</span>
                                                    <span class="text_charcoal">{{$ad->project->supportStage->name ?? 'Non défini' }}</span>
                                                    <span class="has-tooltip-right"
                                                          data-tooltip="{{\App\Models\SupportStage::TOOLTIPS[$ad->project->supportStage->id]}}">
                                                        <i class="fas fa-info-circle text_primary "></i>
                                                    </span>
                                                </p>
                                            @endif
                                            @if(isset($ad->project->support_state_id))
                                                <p>
                                                    <span class="text_mouse">Etat de la demande :</span>
                                                    <span class="text_charcoal">{{ $ad->project->supportState->name ?? 'Non défini' }}</span>
                                                    <span class="has-tooltip-right"
                                                          data-tooltip="{{\App\Models\SupportState::TOOLTIPS[$ad->project->supportState->id]}}">
                                                        <i class="fas fa-info-circle text_primary "></i>
                                                    </span>
                                                </p>
                                            @endif
                                            @if(isset($ad->project->project_status_id))
                                                <p>
                                                    <span class="text_mouse">Statut du projet :</span>
                                                    <span class="text_charcoal">{{ $ad->project->projectStatus->name ?? 'Non défini' }}</span>
                                                    <span class="has-tooltip-right"
                                                          data-tooltip="{{\App\Models\ProjectStatus::TOOLTIPS[$ad->project->projectStatus->id]}}">
                                                        <i class="fas fa-info-circle text_primary "></i>
                                                    </span>
                                                </p>
                                            @endif
                                        @else
                                            <span class="text_mouse">Statut de l'annonce :</span>
                                            <span class="text_charcoal">{{ $ad->attributionAd->adStatus->name?? 'Non défini' }}</span>
                                            <span class="has-tooltip-right"
                                                  data-tooltip="{{\App\Models\AdStatus::TOOLTIPS[$ad->attributionAd->adStatus->id]}}">
                                                <i class="fas fa-info-circle text_primary "></i>
                                            </span>
                                        @endif

                                    </div>

                                    @if($ad->is_draft === 1)
                                        <article class="message is-warning">
                                            <div class="message-body">
                                                L'annonce est en mode brouillon, elle n'a pas été encore soumise à modération !
                                            </div>
                                        </article>
                                    @endif
                                    @if($ad->attributionAd->user_moderator_id === auth()->user()->id)
                                        <article class="message is-link">
                                            <div class="message-body">
                                                Vous êtes le modérateur de cette annonce !
                                            </div>
                                        </article>
                                    @elseif($ad->attributionAd->user_advisor_id === auth()->user()->id)
                                        <article class="message is-link">
                                            <div class="message-body">
                                                Vous êtes le primo-accueilant pour ce projet !
                                            </div>
                                        </article>
                                    @endif

                                    <p class="button__wrap button__wrap_right">
                                        @if(isset($ad->project))
                                            @if(isset($ad->attributionAd->user_advisor_id) && $ad->isProjectInUserTerritories($currentUser->userTerritoryIds, $currentUser->userDepartmentsCodes) )
                                                <a href="{{route("advisor.showSupport", $ad->id)}}">
                                                    <button class="button basic  small warning mr-20">
                                                        <span class="icon is-small">
                                                            <i class="fas fa-hands-helping text_white"></i>
                                                        </span>
                                                        <span>Espace de suivi</span>
                                                    </button>
                                                </a>
                                            @elseif($currentUser->role >= 3 && $ad->isProjectInUserTerritories($currentUser->userTerritoryIds, $currentUser->userDepartmentsCodes))
                                                <a href="{{route("ads.show", $ad->id)}}">
                                                    <button class="button basic  small warning mr-20">
                                                        <span class="icon is-small">
                                                            <i class="fas fa-hands-helping text_white"></i>
                                                        </span>
                                                        <span>Attribuer la demande</span>
                                                    </button>
                                                </a>
                                            @endif
                                        @else
                                            <a href="{{route("ads.show", $ad->id)}}">
                                                <button class="button basic  small warning mr-20">
                                                    <span class="icon is-small">
                                                        <i class="fas fa-eye text_white"></i>
                                                    </span>
                                                    <span>Voir l'annonce</span>
                                                </button>
                                            </a>
                                        @endif

                                    </p>
                                </div>
                            </div>
                        </li>
                    </ul>
                @endforeach
            </section>
        </div>

    </div>
@endsection

@section('script')
    <script>
        @if(auth()->user()->id != $user->id and auth()->user()->role < 2)
        const vueThreads = new Vue({
            el: '#vue-contact-user-modal',
            name: 'content'
        });

        let buttons = document.querySelectorAll('.open-modal-new-message');
        buttons.forEach((button) => {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                let modal = document.querySelector('.modal');
                let html = document.querySelector('html');
                modal.classList.add('is-active');
                html.classList.add('is-clipped');
            });
        });
        let modal = document.querySelector('.modal');
        let html = document.querySelector('html');
        modal.querySelector('.modal-background').addEventListener('click', function (e) {
            e.preventDefault();
            modal.classList.remove('is-active');
            html.classList.remove('is-clipped');
        });
        modal.querySelector('#close-modal').addEventListener('click', function (e) {
            e.preventDefault();
            modal.classList.remove('is-active');
            html.classList.remove('is-clipped');
        });
        @endif

    </script>
@endsection

