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

        <div class="columns">
            <div class="column is-flex is-flex-direction-column is-justify-content-space-between">
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
                <div>
                    <p class="pb-3">Référence : 1695-V</p>
                    <h1 class="title">
                        {{$ad->title}}
                    </h1>
                    <
                    <p>Publié le 1er juillet 2023</p>
                </div>
                <div>
                    <div class="is-flex is-justify-content-space-between pb-4">
                        <b-tag type="is-warning" size="is-medium"
                               class="has-text-weight-bold is-uppercase">{{ $ad->formatted_type }}
                        </b-tag>
                        <div class="title is-5" style="color: #A74B2B">
                            {{ $ad->formatted_price }}
                        </div>
                    </div>
                    <div class="is-flex is-flex-wrap-wrap gap-3 is-justify-content-space-between">
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
                            @if($ad->landOfferAd->altitude)
                                {{$ad->landOfferAd->altitude }} mètres
                            @else
                                Non renseignée
                            @endif
                        </div>
                        <div class="w-50">
                            <strong>Département : </strong>
                            Rhône
                        </div>
                    </div>
                </div>
                <div class="buttons mt-3-mobile">
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
                <b-taglist>
                    @if($ad->landOfferAd->productionGenres->count() || $ad->landOfferAd->production_type_add)
                        @foreach($ad->landOfferAd->productionGenres->pluck('name') as $productionGenre)
                            <b-tag type="is-primary" rounded size="is-medium">
                                {{$productionGenre}}
                            </b-tag>
                        @endforeach
                        @if($ad->landOfferAd->production_type_add)
                            <b-tag type="is-primary" rounded size="is-medium">
                                {{ ucfirst($ad->landOfferAd->production_type_add) }}
                            </b-tag>
                        @endif
                    @else
                        <b-tag type="is-primary" rounded size="is-medium">
                            Non renseigné
                        </b-tag>
                    @endif
                </b-taglist>
            </div>
            <div>
                <h3 class="title is-4">Production secondaires et envisageables</h3>
                <b-taglist>
                    @if($ad->landOfferAd->productionGenresPossible->count() || $ad->landOfferAd->production_type_wanted_add)
                        @foreach($ad->landOfferAd->productionGenresPossible->pluck('name') as $productionGenresPossible)
                            <b-tag type="is-primary" rounded size="is-medium">
                                {{$productionGenresPossible}}
                            </b-tag>
                        @endforeach
                        @if($ad->landOfferAd->production_type_wanted_add)
                            <b-tag type="is-primary" rounded size="is-medium">
                                {{ ucfirst($ad->landOfferAd->production_type_wanted_add) }}
                            </b-tag>
                        @endif
                    @else
                        <b-tag type="is-primary" rounded size="is-medium">
                            Non renseigné
                        </b-tag>
                    @endif
                </b-taglist>

            </div>
            <div class="is-flex is-flex-wrap-wrap gap-6-mobile">
                <div class="w-50">
                    <h3 class="title is-4">Certification des terres</h3>
                    @if($ad->landOfferAd->bioCertifications->count() || $ad->landOfferAd->production_type_add)
                        @foreach($ad->landOfferAd->bioCertifications as $bioCertification)
                            @if($bioCertification->icon == "")
                                <p>{{$bioCertification->name }}</p>
                            @endif
                            <img src="{{ $bioCertification->icon }}">
                        @endforeach
                    @else
                        <p>Aucune</p>
                    @endif
                </div>
                <div class="w-50">
                    <h3 class="title is-4">Accès à l’eau</h3>
                    @if($ad->landOfferAd->water_access === 1)
                        <p>{{ucfirst($ad->waterAccess)}}</p>
                    @else
                        <p>Non renseigné</p>
                    @endif
                </div>
            </div>
            <div class="is-flex is-flex-wrap-wrap gap-6-mobile">
                <div class="w-50">
                    <h3 class="title is-4">Présence d’habitations</h3>
                    <p>Oui</p>
                </div>
                <div class="w-50">
                    <h3 class="title is-4">Présence de bâtiments agricoles</h3>
                    @if($ad->landOfferAd->has_buildings)
                        <p>{{$ad->landOfferAd->building->description ?? "Non renseignée"}}</p>
                        @if($isSupportRequest)
                            , surface totale : {{empty($ad->landOfferAd->building->surface) ? "Non renseignée" : $ad->landOfferAd->building->surface.'m²'}}
                        @endif
                    @else
                        <p>Sans bâtiment agricole</p>
                    @endif
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
            {{--            <div class="columns columns-slider is-mobile">--}}
            {{--                @foreach ($ads as $ad)--}}
            {{--                    @include("pages.homepage_ad_thumbnail")--}}
            {{--                @endforeach--}}
            {{--            </div>--}}
        </div>
    </section>
    <section class="bg-beige is-flex is-justify-content-center newsletter mt-6">
        <div class="columns container is-desktop p-3-mobile">
            <div class="column px-0 is-three-fifths is-flex is-flex-direction-column is-justify-content-center">
                <h2 class="title has-text-centered has-text-left-desktop mb-5">Newsletter Terre de Liens</h2>
                <p class="has-text-centered has-text-left-desktop">Restez informé des campagnes et de l'actualité en
                    vous inscrivant à la newsletter.</p>
            </div>
            <div class="column is-flex is-flex-direction-column is-justify-content-center">
                <newsletter :csrf_token="'{{ csrf_token() }}'"></newsletter>
            </div>
        </div>
    </section>
@endsection

@section('script')
@endsection
