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
            </div>
            <div class="columns is-multiline is-mobile">
                @foreach ($ads as $ad)
                    @include("pages.homepage_ad_thumbnail")
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
        <section class="section">
            <div class="">
                <div class="has-text-centered ">
                    <h2 class="title is-1 text_warning_orange">Annonces à la une</h2>
                </div>
                <div class="columns is-mobile is-centered">
                    @foreach ($adsPartner as $ad)
                        @include("pages.homepage_ad_thumbnail")
                    @endforeach
                </div>
                <div class="columns is-centered">
                    <div class="column is-half has-text-centered">
                        <a href="{{route('researches.index', ['ad_category' => 'all', 'certified' =>"true"])}}">
                            <button class="button is-link is-medium basic secondary">
                                <span class="button__icon"><i class="fas fa-plus" aria-hidden="true"></i></span>
                                <span class="button__label">Toutes les annonces certifiées</span>
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
