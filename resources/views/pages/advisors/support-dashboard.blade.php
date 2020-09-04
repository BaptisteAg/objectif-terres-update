@extends ('default')

@section ('title', 'Espace de suivi')

@section('head-script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma-carousel@4.0.4/dist/css/bulma-carousel.min.css">
@endsection


<?php
/** @var \App\Models\Ad $ad * */
?>
@section('header')
    @if(auth()->user()->role >= 3)
        @include('components.supervisor-tabs')
    @elseif (auth()->user()->role ===2)
        @include('components.advisor-tabs')
    @endif
@endsection


@section('main-content')

    <section class="section pt-0">


        <div class="content">
            @include('components.back-links')
            @if($ad->userPp->trashed())
                <h1 class="title is-1 has-text-link">Suivi
                    de {{$ad->userPp->getWrappedObject()->first_name}} {{$ad->userPp->getWrappedObject()->name}} </h1>
            @else
                <h1 class="title is-1 has-text-link">Suivi de {{$ad->userPp->first_name}} {{$ad->userPp->name}} </h1>
            @endif

            <h3 class="subtitle is-3 ">{{$ad->title}}</h3>
            @if(!is_null($ad->attributionAd->userAdvisor))
                @if($ad->attributionAd->userAdvisor->id === auth()->user()->id)
                    <div class="notification is-primary">
                        Vous êtes le primo-accueillant pour cette demande ! <br>
                        N'oubliez pas de mettre à jour le stade et l'état de la demande ainsi que l'avancement du projet !
                    </div>
                    <p class="has-text-weight-bold"></p>

                @else
                    <p>Cette demande est attribuée
                        à
                        <span class="has-text-weight-bold">{{$ad->attributionAd->userAdvisor->first_name}} {{$ad->attributionAd->userAdvisor->name}}</span>.
                    </p>
                @endif
            @else
                <p>Cette demande n'a pas été encore attribuée à un primo-accueillant</p>
            @endif
        </div>
        @if($ad->userPp->trashed())
            <div class="notification is-danger ">
                L'utilisateur <strong>{{$ad->userPp->first_name}} {{$ad->userPp->name}}</strong> a été bannî le
                <strong> {{ \Carbon\Carbon::parse($ad->userPp->deleted_at)->format('d/m/Y')}} </strong>.
                L'ensemble de ces annonces ne sont plus visibles par les membres et visiteurs d'Objectif Terres.
                Contacter l'administrateur pour plus d'informations.
            </div>
        @endif

        <div id="advisor-support-request-dashboard">
            <support-request-dashboard
                    inline-template
                    :thread='{{ $thread->id ?? 'undefined' }}'
                    :ad-id="{{$ad->id}}"
                    v-bind:is-user-advisor-in-charge="{{auth()->id() === $ad->attributionAd->user_advisor_id ? 'true' : 'false'}}"
            >
                <div>
                    {!! Form::open(['route' => 'advisor.updateSupport', 'method'=>'post']) !!}
                    <div class="columns ">
                        <div class="column "></div>
                        <div class="column is-3 ">
                            <div class="content">
                                <p class=" has-text-centered">Stade de l'accompagnement :
                                    @if(isset($ad->project->supportStage))
                                        <span class="tag has-text-white bg-d-warning_dark has-tooltip-top"
                                              data-tooltip="{{\App\Models\SupportStage::TOOLTIPS[$ad->project->supportStage->id]}}">{{$ad->project->supportStage->name}}</span>
                                    @else
                                        <span class="tag is-light">Non définis</span>
                                    @endif
                                    @if(! $ad->userPp->trashed())
                                        <a>
                                            <span v-on:click='isSupportStageSelectOpen = !isSupportStageSelectOpen'
                                                  class="icon text_warning_dark">
                                                <i class="fas fa-pen"></i>
                                            </span>
                                        </a>
                                    @endif
                                </p>
                            </div>
                            <div v-show="isSupportStageSelectOpen === true" class="field">
                                <div class="control has-text-centered">
                                    <div class="select">
                                        <select name="support_stage" v-on:change="showValidationModal()">
                                            @foreach ($supportStages as $supportStage)
                                                @if(isset($ad->project->supportStage) and $supportStage->id === $ad->project->supportStage->id)
                                                    <option disabled selected
                                                            value="{{$supportStage->id}}">{{$supportStage->name}}</option>
                                                @else
                                                    <option value="{{$supportStage->id}}">{{$supportStage->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="column is-3">
                            <div class="content">
                                <p class=" has-text-centered">État de la demande :
                                    @if(isset($ad->project->supportState))
                                        <span class="tag has-text-white bg-d-warning_dark has-tooltip-top"
                                              data-tooltip="{{\App\Models\SupportState::TOOLTIPS[$ad->project->supportState->id]}}">{{$ad->project->supportState->name}}</span>
                                    @else
                                        <span class="tag is-light">Non définis</span>
                                    @endif
                                    @if(! $ad->userPp->trashed())
                                        <a>
                                            <span v-on:click='isSupportStateSelectOpen = !isSupportStateSelectOpen'
                                                  class="icon text_warning_dark">
                                                <i class="fas fa-pen"></i>
                                            </span>
                                        </a>
                                    @endif
                                </p>
                            </div>
                            <div v-show="isSupportStateSelectOpen === true" class="field">
                                <div class="control  has-text-centered">
                                    <div class="select">
                                        <select name="support_state" v-on:change="showValidationModal()">
                                            @foreach ($supportStates as $supportState)
                                                @if(isset($ad->project->supportState) and $supportState->id === $ad->project->supportState->id)
                                                    <option disabled selected
                                                            value="{{$supportState->id}}">{{$supportState->name}}</option>
                                                @else
                                                    <option value="{{$supportState->id}}">{{$supportState->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="column is-3">
                            <div class="content">
                                <p class=" has-text-centered">Avancement du projet :
                                    @if(isset($ad->project->projectStatus))
                                        <span class="tag has-text-white bg-d-warning_dark has-tooltip-top"
                                              data-tooltip="{{\App\Models\ProjectStatus::TOOLTIPS[$ad->project->projectStatus->id]}}">{{$ad->project->projectStatus->name}}</span>
                                    @else
                                        <span class="tag is-light">Non définis</span>
                                    @endif
                                    @if(! $ad->userPp->trashed())
                                        <a>
                                            <span v-on:click='isProjectStatusSelectOpen = !isProjectStatusSelectOpen'
                                                  class="icon text_warning_dark">
                                                <i class="fas fa-pen"></i>
                                            </span>
                                        </a>
                                    @endif
                                </p>
                            </div>
                            <div v-show="isProjectStatusSelectOpen === true" class="field">
                                <div class="control  has-text-centered">
                                    <div class="select ">
                                        <select name="project_status" v-on:change="showValidationModal()">
                                            @foreach ($projectStatuses as $projectStatus)
                                                @if(isset($ad->project->projectStatus) and $projectStatus->id === $ad->project->projectStatus->id)
                                                    <option disabled selected
                                                            value="{{$projectStatus->id}}">{{$projectStatus->name}}</option>
                                                @else
                                                    <option value="{{$projectStatus->id}}">{{$projectStatus->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input value="{{$ad->id}}" name="ad_id" type="hidden">
                        @include('pages.advisors.partials.validation-modal')
                    </div>
                    {!! Form::close() !!}
                    <div class="columns">
                        <div class="column is-half">
                            <div class="card">
                                <div class="tabs is-toggle is-fullwidth">
                                    <ul>
                                        <li :class="{ 'is-active' : tabsOpen.infoTabOpen === 'user-pp-info-tab'}">
                                            <a v-on:click="openInfoTab('user-pp-info-tab')">
                                                <span class="icon is-small"><i class="fas fa-user"></i></span>
                                                <span>Profil du porteur de projet</span>
                                            </a>
                                        </li>
                                        <li :class="{ 'is-active' : tabsOpen.infoTabOpen === 'support-info-tab'}">
                                            <a v-on:click="openInfoTab('support-info-tab')">
                                                <span class="icon is-small"><i class="fas fa-hands-helping"></i></span>
                                                <span>Son projet</span>
                                            </a>
                                        </li>
                                        <li :class="{ 'is-active' : tabsOpen.infoTabOpen === 'support-pp-ads-tab'}">
                                            <a v-on:click="openInfoTab('support-pp-ads-tab')">
                                                <span class="icon is-small"><i class="fas fa-newspaper"></i></span>
                                                <span>Annonces</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div v-show="tabsOpen.infoTabOpen === 'user-pp-info-tab'" class=" user-info-tab">
                                    @include('pages.advisors.partials.user-pp-info-tab')
                                </div>
                                <div v-show="tabsOpen.infoTabOpen === 'support-info-tab'"
                                     class="support-info-tab">
                                    @include('pages.advisors.partials.support-info-tab')
                                </div>
                                <div v-show="tabsOpen.infoTabOpen === 'support-pp-ads-tab'"
                                     class="support-pp-ads-tab">
                                    @include('pages.advisors.partials.support-pp-ads-tab')
                                </div>

                            </div>
                        </div>
                        <div class="column is-half">
                            <div class="card">
                                <div class="tabs is-toggle is-fullwidth">
                                    <ul>
                                        <li :class="{ 'is-active' : tabsOpen.supportTabOpen === 'support-notes-tab'}">
                                            <a v-on:click="openSupportTab('support-notes-tab')">
                                                <span class="icon is-small"><i class="fas fa-sticky-note"></i></span>
                                                <span>Notes</span>
                                            </a>
                                        </li>
                                        <li :class="{ 'is-active' : tabsOpen.supportTabOpen === 'support-thread-tab'}">
                                            <a v-on:click="openSupportTab('support-thread-tab')">
                                                <span class="icon is-small"><i class="fas fa-comments"></i></span>
                                                <span>Messages</span>
                                            </a>
                                        </li>
                                        <li :class="{ 'is-active' : tabsOpen.supportTabOpen === 'support-documents-tab'}">
                                            <a v-on:click="openSupportTab('support-documents-tab')">
                                                <span class="icon is-small"><i class="fas fa-paperclip"></i></span>
                                                <span>Documents</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div v-show="tabsOpen.supportTabOpen === 'support-notes-tab'"
                                     class="support-notes-tab">
                                    @include('pages.advisors.partials.support-notes-tab')
                                </div>
                                <div v-show="tabsOpen.supportTabOpen === 'support-thread-tab'"
                                     class="support-thread-tab">
                                    @include('pages.advisors.partials.support-thread-tab')
                                </div>
                                <div v-show="tabsOpen.supportTabOpen === 'support-documents-tab'"
                                     class="support-documents-tab">
                                    @include('pages.advisors.partials.support-documents-tab')

                                </div>
                            </div>
                        </div>
                    </div>
            </support-request-dashboard>
        </div>
    </section>
@endsection

@section('script')

    <script>
        const vueAdvisorSupportRequestDashboard = new Vue({
            el: '#advisor-support-request-dashboard',
            name: 'content'
        });
    </script>
    @if(count($ad->images) > 1)
        <script src="{{asset('/js/bulma-carousel.js')}}"></script>
        <script>
            const carouselSupportRequestDashboard = bulmaCarousel.attach('#support-request-dashboard-ad-images', {
                slidesToScroll: 1,
                slidesToShow: 1,
                loop: true,
                navigation: true,
            });
        </script>

    @endif
@endsection