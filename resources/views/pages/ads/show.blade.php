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

        <div class="columns">
            <div class="column">
                <div class="buttons is-justify-content-space-between is-hidden-touch">
                    <b-button rounded icon-left="share-variant-outline">
                        Partager
                    </b-button>
                    <b-button rounded icon-left="download">
                        Télécharger en PDF
                    </b-button>
                </div>
                <div class="buttons is-hidden-desktop">
                    <b-button rounded icon-left="share-variant-outline" style="padding-left: 1em; padding-right: 1em;">
                    </b-button>
                    <b-button rounded icon-left="download" style="padding-left: 1em; padding-right: 1em;">
                    </b-button>
                </div>
                <p>Référence : 1695-V</p>
                <h1 class="title">
                    {{$ad->title}}
                </h1>
                <p>Publié le 1er juillet 2023</p>
                <div class="is-flex is-justify-content-space-between">
                    <b-tag type="is-warning" size="is-medium"
                           class="has-text-weight-bold is-uppercase">{{ $ad->formatted_type }}
                    </b-tag>
                    <div class="title is-5" style="color: #A74B2B">
                        {{ $ad->formatted_price }}
                    </div>
                </div>
                <div class="is-flex is-flex-wrap-wrap gap-3">
                    <div class="w-50">
                        <strong>Surface : </strong>
                        42 mètres
                    </div>
                    <div class="w-50">
                        <strong>Région : </strong>
                        Auvergne-Rhône-Alpes
                    </div>
                    <div class="w-50">
                        <strong>Altitude : </strong>
                        750 mètres
                    </div>
                    <div class="w-50">
                        <strong>Département : </strong>
                        Rhône
                    </div>
                </div>
                <div class="buttons">
                    <b-button rounded type="is-danger">
                        Répondre à l’annonce
                    </b-button>
                    <b-button rounded icon-left="star-outline" style="padding-left: 1em; padding-right: 1em;">
                    </b-button>
                </div>
            </div>
            <div class="column">
                <ads-carousel :images="{{ json_encode($ad->images ?? []) }}"></ads-carousel>
            </div>
        </div>
        <div class="is-flex is-flex-direction-column gap-6 bg-beige py-7 px-8 objT-border p-6-mobile mx-3-mobile px-1-mobile">
            <div>
                <h3 class="title is-4">Production principale</h3>
                <b-tag type="is-primary" rounded size="is-medium">Medium</b-tag>
            </div>
            <div>
                <h3 class="title is-4">Production secondaires et envisageables</h3>
                <b-taglist>
                    <b-tag type="is-primary" rounded size="is-medium">Default</b-tag>
                    <b-tag type="is-primary" rounded size="is-medium">Medium</b-tag>
                    <b-tag type="is-primary" rounded size="is-medium">Large</b-tag>
                </b-taglist>
            </div>
            <div class="is-flex is-flex-wrap-wrap gap-6-mobile">
                <div class="w-50">
                    <h3 class="title is-4">Certification des terres</h3>
                    <p></p>
                </div>
                <div class="w-50">
                    <h3 class="title is-4">Accès à l’eau</h3>
                    <p>Oui</p>
                </div>
            </div>
            <div class="is-flex is-flex-wrap-wrap gap-6-mobile">
                <div class="w-50">
                    <h3 class="title is-4">Présence d’habitations</h3>
                    <p>Oui</p>
                </div>
                <div class="w-50">
                    <h3 class="title is-4">Présence de bâtiments agricoles</h3>
                    <p>Oui</p>
                </div>
            </div>
            <div>
                <h3 class="title is-4">Description de la terre</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                    et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                    aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur.</p>
            </div>
            <div>
                <h3 class="title is-4">Description de la transmission agricole</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                    et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                    aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur.</p>
            </div>
            <div>
                <h3 class="title is-4">Description du porteur de projet</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                    et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                    aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur.</p>
            </div>
            <div class="is-flex is-justify-content-space-between is-align-items-center pt-3">
                <div class="buttons mb-0">
                    <b-button rounded type="is-danger">
                        Répondre à l’annonce
                    </b-button>
                    <b-button rounded icon-left="star-outline" style="padding-left: 1em; padding-right: 1em;">
                    </b-button>
                </div>
                <a class="is-underlined is-hidden-touch">Signaler un abus</a>
            </div>
            <div class="columns columns-slider is-mobile">
{{--                @foreach ($ads as $ad)--}}
{{--                    @include("pages.homepage_ad_thumbnail")--}}
{{--                @endforeach--}}
            </div>
        </div>
    </section>

@endsection

@section('script')
@endsection
