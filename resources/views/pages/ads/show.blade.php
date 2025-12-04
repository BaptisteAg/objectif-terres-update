@extends('default')

@section('title')
    {{ $ad->title }}
@endsection

@section('head-script')
@endsection

@php
    //Breadcrumb
        $offerType = Str::endsWith($ad->type, 'SeekAd') ? 'SeekAd' : 'OfferAd';
        $adCategory = Str::startsWith($ad->type, 'land') ? 'land' : 'job';
@endphp

@section('main-content')
    <section class="container pb-6" id="ad-show-page">

        @if(!isset($isPreview) || !$isPreview)
            @auth
                @if(auth()->user()->id === $ad->user_pp_id)
                    @include('pages.ads.partials.new-ad-status-message-display')
                @endif
            @endauth

            <div class="columns">

                <div class="column">
                    <b-breadcrumb
                            separator="chevron-right"
                            size="is-small"
                    >
                        <b-breadcrumb-item href="/">Page d’accueil</b-breadcrumb-item>
{{--                        <b-breadcrumb-item class="breadcrumb__link"--}}
{{--                                           href="{{route('researches.index',  ['offer_type' => $offerType, 'ad_category' => $adCategory])}}">--}}
{{--                            <span>{{$ad->ad_type_full_name}}</span>--}}
{{--                        </b-breadcrumb-item>--}}
                        <b-breadcrumb-item class="breadcrumb__link" @click="goBack">{{$ad->ad_type_full_name}}</b-breadcrumb-item>
                    </b-breadcrumb>
                </div>

                <div class="column">
                    @if($ad->canEdit())
                        <div class="buttons has-addons is-right">
                            @if($ad->is_draft === 0 && !isset($ad->attributionAd))
                                <b-button
                                        href="{{ route('ads.request-publishing', ["id" => $ad->id]) }}"
                                        tag="a" icon-left="check"
                                        rounded>Soumettre
                                </b-button>
                            @endif
                            <b-button
                                    href="{{ $isSupportRequest ? route('support-request.edit') : route('ads.edit', ["id" => $ad->id]) }}"
                                    tag="a" icon-left="pencil" rounded>Modifier
                            </b-button>
                            @if(!$ad->isArchived())
                                <b-button
                                          @click="openSurveyModal('archive')"
                                          icon-left="archive-arrow-down"
                                          rounded>
                                    Archiver
                                </b-button>
                            @else
                                <b-button
                                          href="{{route('ads.republish', $ad->id)}}"
                                          tag="a"
                                          icon-left="publish"
                                          rounded>
                                    Republier
                                </b-button>
                            @endif
                            <b-button
                                      @click="openSurveyModal('delete')"
                                      icon-left="delete" rounded>
                                Supprimer
                            </b-button>
                        </div>
                    @endif
                </div>
            </div>

            @auth
                @if(auth()->user()->role >= 1 )
                    @include('components.back-links')

                    @if($ad->isProject() && auth()->user()->role >= 2)
                        @include ('pages.ads.partials.attribution-project-options')
                    @elseif(! $ad->isProject() && $ad->attributionAd)
                        @include('pages.ads.partials.moderator-options')
                    @endif
                @endif
            @endauth
        @endif

        @if(isset($isPreview) && $isPreview)
            <b-message type="is-warning" has-icon>
                <h3 class="title is-5">Prévisualisation de l'annonce</h3>
                <p>Vous êtes en train de prévisualiser l'annonce publique qui apparaîtra sur Objectif Terres. Vous
                    pouvez soumettre la publication ou revenir à l'édition</p>
                <div class="buttons pt-4">
                    <b-button rounded tag="a" href="{{route('ads.edit', ['id' => $ad->id])}}">Modifier</b-button>
                    <b-button rounded type="is-success" tag="a"
                              href="{{route('ads.request-publishing', ['id' => $ad->id])}}">Demander la publication
                    </b-button>
                </div>
            </b-message>
        @endif

        @if(config('app.env') === 'local')
            <h1 class="title is-1 has-background-black has-text-white">Type : {{$ad->type}}</h1>
            <h1 class="title is-1 has-background-black has-text-white">accept_share_contact_infos
                : {{$ad->accept_share_contact_infos}}</h1>
        @endif

        @if($ad->type === 'landSeekAd')
            @include('pages.ads.partials.landSeek.landSeekShow')
        @endif
        @if($ad->type === 'landOfferAd')
            @include('pages.ads.partials.landOffer.landOfferShow')
        @endif
        @if($ad->type === 'jobSeekAd')
            @include('pages.ads.partials.jobSeek.jobSeekAdShow')
        @endif
        @if($ad->type === 'jobOfferAd')
            @include('pages.ads.partials.jobOffer.jobOfferAdShow')
        @endif
        @if($ad->type === 'associateSeekAd')
            @include('pages.ads.partials.associateSeek.associateSeekAdShow')
        @endif
        @if($ad->type === 'associateOfferAd')
            @include('pages.ads.partials.associateOffer.associateOfferAdShow')
        @endif

        @if($ad->canEdit())
            <survey-modal
                v-if="surveyModalOpen"
                :ad="ad"
                :action="surveyAction"
                @close="closeSurveyModal"
            ></survey-modal>
        @endif
    </section>

    @if(!isset($isPreview) || !$isPreview)
        <section class="container" id="messages-display">
            @include('pages.ads.partials.threadsDisplay')
        </section>

        @include('components.newsletter')
    @endif
@endsection

@section('script')
    @if($ad->canEdit())
        <script>
            // Initialize survey modal data for this page
            window.app.surveyModalOpen = false;
            window.app.surveyAction = null;
            window.app.ad = @json($ad);

            window.app.openSurveyModal = function(action) {
                this.surveyAction = action;
                this.surveyModalOpen = true;
            };

            window.app.closeSurveyModal = function() {
                this.surveyModalOpen = false;
                this.surveyAction = null;
            };
        </script>
    @endif
@endsection
