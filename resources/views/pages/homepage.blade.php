@extends('default')

@section('title', 'Bienvenue sur Objectif Terres')

@section('head-script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma-carousel@4.0.4/dist/css/bulma-carousel.min.css">
    <!-- Import Leaflet CSS Style Sheet -->
    <link rel="stylesheet" href="https://npmcdn.com/leaflet@1.0.0-rc.2/dist/leaflet.css"/>
@endsection


@section('main-content')

    @if(Route::currentRouteName() === "site-tour")
        <div id="vue-site-tour">
            <site-tour-shepherd inline-template
                                image-path="{{asset('/images/cms/screenshot-site-tour.png')}}">
                <template>

                </template>
            </site-tour-shepherd>
        </div>
    @endif


    <div id="global-map"></div>

    <section class="section">
        <div class="mr-10 ml-10">
            <div class="has-text-centered ">
                <h2 class="title is-1 text_warning_orange">Dernières annonces publiées</h2>
                {{--                <p>ASTUCE :--}}
                {{--                    <a href="{{url('/')}}">Créez votre compte gratuit</a>--}}
                {{--                    pour visualiser directement les annonces--}}
                {{--                    de votre région !--}}
                {{--                </p>--}}
            </div>
            <div class="columns is-multiline is-mobile">
                @foreach ($ads as $ad)
                    <div class="column is-one-quarter-desktop is-half-tablet  mb-60 tile tile_image">
                        <a href="{{route("ads.show", $ad->id)}}" class="tile__link card">
                            <div class="card-image vignette photo">
                                <figure class="image vignette__image-wrap vignette__ratio_4-3 is-square">
                                    @if($ad->hasImages)
                                        @if($ad->images[0]->path ==="0")
                                            @if($ad->ad_type == "landSeek" or $ad->ad_type == "landOffer")
                                                <img src="{{URL::asset('images/illustrations/ferme01.jpg')}}"
                                                     class="vignette__image" alt="image generic ferme"/>
                                            @else
                                                <img src="{{URL::asset("images/illustrations/photo_08_bandeau-maous_1920.jpg")}}"
                                                     class=" vignette__image" alt="image generic emploi ferme"/>
                                            @endif
                                        @else
                                            <img src="{{URL::asset($ad->images[0]->path)}}"
                                                 class=" vignette__image" alt="{{$ad->images[0]->name}}">
                                        @endif
                                    @else
                                        @if($ad->ad_type == "landSeek" or $ad->ad_type == "landOffer")
                                            <img src="{{URL::asset('images/illustrations/ferme01.jpg')}}"
                                                 class="vignette__image" alt="image generic ferme"/>
                                        @else
                                            <img src="{{URL::asset("images/illustrations/photo_08_bandeau-maous_1920.jpg")}}"
                                                 class=" vignette__image" alt="image generic emploi ferme"/>
                                        @endif
                                    @endif
                                </figure>
                                <ul class="custom-tags custom-list custom-list_v">
                                    <li class="custom-tag success">
                                        <i class="fas fa-map-marker-alt"></i>
                                        @if (is_null($ad->citiesList) and is_null($ad->departmentsList) and is_null($ad->regionsList)   )
                                            Non renseignée
                                        @else
                                            {{$ad->shortCitiesList ?? ""}}
                                            {{$ad->departmentsList ?? ""}}
                                            {{$ad->regionsList ?? ""}}
                                        @endif
                                    </li>
                                    @if($ad->landOfferAd)
                                        <li class="custom-tag warning">
                                            <i class="fas fa-piggy-bank"></i>
                                            @if(! is_null($ad->landOfferAd->price) || !is_null($ad->landOfferAd->rent_price))
                                                @if(! is_null($ad->landOfferAd->price))
                                                    {{number_format($ad->landOfferAd->price, 0, ",", " " )}} €
                                                @endif
                                                @if(! is_null($ad->landOfferAd->rent_price))
                                                    {{number_format($ad->landOfferAd->rent_price, 0, ",", " " )}} €/mois
                                                @endif
                                            @else
                                                Pix non renseigné
                                            @endif
                                        </li>
                                        <li class="custom-tag danger">
                                            <i class="fas fa-arrows-alt-h"></i>
                                            @if(!empty($ad->human_ha))
                                                {{$ad->human_ha}}
                                            @else
                                                Surface non renseignée
                                            @endif
                                        </li>
                                    @endif
                                    @if($ad->landSeekAd)
                                        <li class="custom-tag warning">
                                            <i class="fas fa-piggy-bank"></i>
                                            @if(isset($ad->landSeekAd->price_max))
                                                @if($ad->landSeekAd->price_max > 300000)
                                                    Plus de 300 000 €
                                                @else
                                                    Jusqu'à {{number_format($ad->landSeekAd->price_max, 2, ',', ' ')}}
                                                    €
                                                @endif
                                            @elseif(isset($ad->landSeekAd->rent_max))
                                                Jusqu'à {{number_format($ad->landSeekAd->rent_max, 2, ',', ' ')}}
                                                €/mois
                                            @else
                                                Budget non renseigné
                                            @endif
                                        </li>
                                        <li class="custom-tag danger">
                                            <i class="fas fa-arrows-alt-h"></i>
                                            @if(!empty($ad->human_ha))
                                                {{$ad->human_ha}}
                                            @else
                                                Surface non renseignée
                                            @endif
                                        </li>
                                    @endif
                                </ul>
                            </div>
                            <div class="card-content has-text-centered tile__container">
                                <div class="content text_danger_orange tile__content">
                                    <p class="title tile__title">{{ \Illuminate\Support\Str::limit($ad->title, 100, $end='...') }}</p>
                                    {{--                                    <div class="tile__intro">--}}
                                    {{--                                        <p>{{ \Illuminate\Support\Str::limit($ad->about_project_content, 200, $end='...') }}</p>--}}
                                    {{--                                    </div>--}}
                                    <p class="button-wrap">
                                        <span class="button round small warning read-more">
                                            <span class="button__icon">
                                                <i class="fas fa-arrow-right" aria-hidden="true"></i>
                                            </span>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="columns is-centered">
                <div class="column is-half has-text-centered">
                    <a href="{{route('researches.index', ['ad_category' => 'all'])}}">
                        <button class="button is-link is-medium basic secondary">

                            <span class="button__icon"><i class="fas fa-plus" aria-hidden="true"></i></span>
                            <span class="button__label">Toutes les annonces</span>
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </section>
    @if(!$adsPartner->isEmpty())
        <section class="section bg-l-pearl bg-trame_champs_light">
            <div class="">
                <div class="has-text-centered ">
                    <h2 class="title is-1 text_warning_orange">Annonces à la une</h2>
                </div>
                <div class="columns is-mobile is-centered">
                    @foreach ($adsPartner as $ad)
                        <div class="column is-one-quarter-desktop is-half-tablet  tile tile_image">
                            <a href="{{route("ads.show", $ad->id)}}" class="tile__link card">
                                <div class="card-image vignette photo">
                                    <figure class="image vignette__image-wrap vignette__ratio_4-3 is-square">
                                        @if($ad->hasImages)
                                            @if($ad->images[0]->path ==="0")
                                                @if($ad->ad_type == "landSeek" or $ad->ad_type == "landOffer")
                                                    <img src="{{URL::asset('images/illustrations/ferme01.jpg')}}"
                                                         class="vignette__image" alt="image generic ferme"/>
                                                @else
                                                    <img src="{{URL::asset("images/illustrations/photo_08_bandeau-maous_1920.jpg")}}"
                                                         class=" vignette__image" alt="image generic emploi ferme"/>
                                                @endif
                                            @else
                                                <img src="{{URL::asset($ad->images[0]->path)}}"
                                                     class=" vignette__image" alt="{{$ad->images[0]->name}}">
                                            @endif
                                        @else
                                            @if($ad->ad_type == "landSeek" or $ad->ad_type == "landOffer")
                                                <img src="{{URL::asset('images/illustrations/ferme01.jpg')}}"
                                                     class="vignette__image" alt="image generic ferme"/>
                                            @else
                                                <img src="{{URL::asset("images/illustrations/photo_08_bandeau-maous_1920.jpg")}}"
                                                     class=" vignette__image" alt="image generic emploi ferme"/>
                                            @endif
                                        @endif
                                    </figure>
                                    <ul class="custom-tags custom-list custom-list_v">
                                        @if(isset($ad->is_partner) && $ad->is_partner === 1 )
                                            <li class="custom-tag warning">Annonce certifiée</li>
                                        @endif
                                        <li class="custom-tag success">
                                            <i class="fas fa-map-marker-alt"></i>
                                            @if (is_null($ad->citiesList) and is_null($ad->departmentsList) and is_null($ad->regionsList)   )
                                                Non renseignée
                                            @else
                                                {{$ad->shortCitiesList ?? ""}}
                                                {{$ad->departmentsList ?? ""}}
                                                {{$ad->regionsList ?? ""}}
                                            @endif
                                        </li>
                                        @if($ad->landOfferAd)
                                            <li class="custom-tag warning">
                                                <i class="fas fa-piggy-bank"></i>
                                                @if(! is_null($ad->landOfferAd->price))
                                                    {{number_format($ad->landOfferAd->price, 0, ",", " " )}} €
                                                @else
                                                    Prix non renseigné
                                                @endif
                                                @if(! is_null($ad->landOfferAd->rent_price))
                                                    {{number_format($ad->landOfferAd->rent_price, 0, ",", " " )}} €/mois
                                                @else
                                                @endif
                                            </li>
                                            <li class="custom-tag danger">
                                                <i class="fas fa-arrows-alt-h"></i>
                                                @if(!empty($ad->human_ha))
                                                    {{$ad->human_ha}}
                                                @else
                                                    Surface non renseignée
                                                @endif
                                            </li>
                                        @endif
                                        @if($ad->landSeekAd)
                                            <li class="custom-tag warning">
                                                <i class="fas fa-piggy-bank"></i>
                                                @if(isset($ad->landSeekAd->price_max))
                                                    @if($ad->landSeekAd->price_max > 300000)
                                                        Plus de 300 000 €
                                                    @else
                                                        Jusqu'à {{number_format($ad->landSeekAd->price_max, 2, ',', ' ')}}
                                                        €
                                                    @endif
                                                @elseif(isset($ad->landSeekAd->rent_max))
                                                    Jusqu'à {{number_format($ad->landSeekAd->rent_max, 2, ',', ' ')}}
                                                    €/mois
                                                @else
                                                    Budget non renseigné
                                                @endif
                                            </li>
                                            <li class="custom-tag danger">
                                                <i class="fas fa-arrows-alt-h"></i>
                                                @if(!empty($ad->human_ha))
                                                    {{$ad->human_ha}}
                                                @else
                                                    Surface non renseignée
                                                @endif
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                                <div class="card-content has-text-centered tile__container">
                                    <div class="content text_danger_orange tile__content">
                                        <p class="title tile__title">{{ \Illuminate\Support\Str::limit($ad->title, 100, $end='...') }}</p>
                                        <div class="tile__intro">
                                            <p>{{ \Illuminate\Support\Str::limit($ad->about_project_content, 100, $end='...') }}</p>
                                        </div>
                                        <p class="button-wrap">
                                            <span class="button round small warning read-more">
                                                <span class="button__icon">
                                                    <i class="fas fa-arrow-right" aria-hidden="true"></i>
                                                </span>
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="columns is-centered">
                    <div class="column is-half has-text-centered">
                        <a href="{{route('researches.index', ['ad_category' => 'all'])}}">
                            <button class="button is-link is-medium basic secondary">
                                <span class="button__icon"><i class="fas fa-plus" aria-hidden="true"></i></span>
                                <span class="button__label">Toutes les annonces</span>
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    @endif
    {{--    @if(!$cmsFaq->isEmpty())--}}
    {{--        @include('components.faqAccordion')--}}
    {{--    @endif--}}


    @include('components.partnering')

    <div id="vue-rss">
        @include('components.rssNews')
    </div>
    @include('components.support-terre-liens')

@endsection

@section('script')
    <script src="{{ asset('js/bulma-accordion.js') }}"></script>
    <script>let accordions = bulmaAccordion.attach();</script>

    <script src="{{ asset('js/bulma-carousel.js') }}"></script>
    <script>
        bulmaCarousel.attach('#post_images', {
            slidesToScroll: 1,
            slidesToShow: 2,
            loop: true,
            navigation: true,
        });

        new Vue({
            el: '#vue-rss',
            data: {
                ready: true
            }
        });

    </script>

    <script defer>
        homepageMapInit('global-map');
    </script>
    @if(Route::currentRouteName() === "site-tour")
        <script>

            const vueSiteTour = new Vue({
                el: '#vue-site-tour',
                name: 'content'
            });
        </script>

    @endif

@endsection
