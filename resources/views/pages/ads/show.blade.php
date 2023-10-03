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
    <section class="container">
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

        @auth
            @if(auth()->user()->role >= 1 )
                @include('components.back-links')
            @endif

            @if($ad->isProject() && auth()->user()->role >= 2)
                @include ('pages.ads.partials.attribution-project-options')
            @elseif(! $ad->isProject())
                @include('pages.ads.partials.moderator-options')
            @endif
        @endauth

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

    @include('pages.ads.partials.threadsDisplay')

    @include('components.newsletter')
@endsection

@section('script')
@endsection
