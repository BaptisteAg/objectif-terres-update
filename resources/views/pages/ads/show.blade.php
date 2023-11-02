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
    <section class="container pb-6">

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
                        <b-breadcrumb-item class="breadcrumb__link"
                                           href="{{route('researches.index',  ['offer_type' => $offerType, 'ad_category' => $adCategory])}}">
                            <span>{{$ad->ad_type_full_name}}</span>
                        </b-breadcrumb-item>
                    </b-breadcrumb>
                </div>

                <div class="column">
                    @if($ad->canEdit())
                        <div class="buttons has-addons is-right">
                            <b-button
                                    href="{{ $isSupportRequest ? route('support-request.edit') : route('ads.edit', ["id" => $ad->id]) }}"
                                    tag="a" icon-left="pencil" rounded>Modifier
                            </b-button>
                            <b-button onclick="return confirm('Êtes vous sûr·e ?')" tag="a"
                                      href="{{  route('ads.archive', [ $ad->id]) }}" icon-left="archive-arrow-down"
                                      rounded>
                                Archiver
                            </b-button>
                            <b-button onclick="return confirm('Êtes vous sûr·e ? Cette opération est irréversible.')"
                                      tag="a" href="{{  route('ads.delete', [ $ad->id]) }}" icon-left="delete" rounded>
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
                    @elseif(! $ad->isProject())
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
                    <b-button rounded type="is-success" tag="a" href="{{route('ads.request-publishing', ['id' => $ad->id])}}">Soumettre</b-button>
                </div>
            </b-message>
        @endif

{{--        <h1 class="title is-1 has-background-black has-text-white">Type : {{$ad->type}}</h1>--}}

        @if($ad->type === 'landSeekAd')
            @include('pages.ads.partials.landSeek.landSeekShow')
        @endif
        @if($ad->type === 'landOfferAd')
            @include('pages.ads.partials.landOffer.landOfferShow')
        @endif
        @if($ad->type === 'jobOfferAd')
            @include('pages.ads.partials.jobOffer.jobOfferAdShow')
        @endif
        @if($ad->type === 'jobSeekAd')
            @include('pages.ads.partials.jobSeek.jobSeekAdShow')
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
@endsection
