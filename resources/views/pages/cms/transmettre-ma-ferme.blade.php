@extends ('default')

@section ('title', "Transmettre ma ferme")

@section('head-script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma-carousel@4.0.4/dist/css/bulma-carousel.min.css">
@endsection

@section('main-content')
    <section class=" cms-page">
        <div class="container">
            <div class="rows">
                <div class="row is-full">
                    @if($pageContent->count())
                        @if($pageContent->has('transmettre-ma-ferme'))
                            {!! $pageContent['transmettre-ma-ferme']->content !!}
                        @endif
                    @endif
                </div>
            </div>
        </div>
        <div class="columns is-centered">
            <div class="column is-one-third">
                <a target="_blank" class="tile__link card"
                   href="{{url('https://ressources.terredeliens.org/les-ressources/je-transmets-mes-terres-ou-ma-ferme')}}">
                    <div class="card-image vignette photo">
                        <figure class="">
                            <img class="vignette__image"
                                 src="{{asset('/images/cms/ressources/20191011-La Motte Éric et Grégoire-©TDL-Normandie-Alain Gautier web.jpg')}}"
                                 alt="Placeholder image">
                        </figure>
                        <ul class="custom-tags custom-list custom-list_v ">
                            <li class="custom-tag success text_size x-large">
                                Dossiers
                            </li>
                        </ul>
                    </div>
                    <div class="card-content  tile__container">
                        <div class="content text_danger_orange tile__content">
                            <h3 class="title is-3 tile__title has-text-danger">Je transmets mes terres ou ma ferme</h3>
                            <p class="button-wrap">
                                <span class="button round small warning read-more">
                                    <span class="button__icon waves-effect waves-circle waves-light">
                                        <svg class="svg-inline--fa fa-arrow-right fa-w-14" aria-hidden="true"
                                             data-prefix="fas" data-icon="arrow-right" role="img"
                                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                             data-fa-i2svg="">
                                            <path fill="currentColor"
                                                  d="M190.5 66.9l22.2-22.2c9.4-9.4 24.6-9.4 33.9 0L441 239c9.4 9.4 9.4 24.6 0 33.9L246.6 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.2-22.2c-9.5-9.5-9.3-25 .4-34.3L311.4 296H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h287.4L190.9 101.2c-9.8-9.3-10-24.8-.4-34.3z"></path>
                                        </svg><!-- <i class="fas fa-arrow-right" aria-hidden="true"></i> -->
                                    </span>
                                </span>
                            </p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>
    <div class="container">
        <p>Quelques ressources issues de ce dossier : </p>
    </div>
    <div class="columns is-centered">
        <div class="column is-one-quarter">
            <a target="_blank" class="tile__link card"
               href="{{url('https://ressources.terredeliens.org/les-ressources/des-idees-pour-transmettre-sa-ferme')}}">
                <div class="card-image vignette photo">
                    <figure class="image vignette__image-wrap vignette__ratio_4-3">
                        <img class="vignette__image"
                             src="{{asset('/images/cms/ressources/Capture d’écran 2020-09-17 à 15.21.57.png')}}"
                             alt="Placeholder image">
                    </figure>
                    <ul class="custom-tags custom-list custom-list_v ">
                        <li class="custom-tag success text_size x-large">
                            Guides
                        </li>
                    </ul>
                </div>
                <div class="card-content  tile__container">
                    <div class="content text_danger_orange tile__content">
                        <h3 class="title is-3 tile__title has-text-danger">Des idées pour transmettre sa ferme</h3>
                        <p class="button-wrap">
                            <span class="button round small warning read-more">
                                <span class="button__icon waves-effect waves-circle waves-light">
                                    <svg class="svg-inline--fa fa-arrow-right fa-w-14" aria-hidden="true"
                                         data-prefix="fas" data-icon="arrow-right" role="img"
                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                         data-fa-i2svg="">
                                        <path fill="currentColor"
                                              d="M190.5 66.9l22.2-22.2c9.4-9.4 24.6-9.4 33.9 0L441 239c9.4 9.4 9.4 24.6 0 33.9L246.6 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.2-22.2c-9.5-9.5-9.3-25 .4-34.3L311.4 296H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h287.4L190.9 101.2c-9.8-9.3-10-24.8-.4-34.3z"></path>
                                    </svg><!-- <i class="fas fa-arrow-right" aria-hidden="true"></i> -->
                                </span>
                            </span>
                        </p>
                    </div>
                </div>
            </a>
        </div>
        <div class="column is-one-quarter">
            <a target="_blank" class="tile__link card"
               href="{{url('https://ressources.terredeliens.org/les-ressources/le-chemin-de-l-installation-et-de-la-transmission')}}">
                <div class="card-image vignette photo">
                    <figure class="image vignette__image-wrap vignette__ratio_4-3">
                        <img class="vignette__image"
                             src="{{asset('/images/cms/ressources/Capture d’écran 2020-09-17 à 15.32.00.png')}}"
                             alt="Placeholder image">
                    </figure>
                    <ul class="custom-tags custom-list custom-list_v ">
                        <li class="custom-tag success text_size x-large">
                            Études et rapports
                        </li>
                    </ul>
                </div>
                <div class="card-content  tile__container">
                    <div class="content text_danger_orange tile__content">
                        <h3 class="title is-3 tile__title has-text-danger">Le chemin de l'installation et de la
                            transmission</h3>
                        <p class="button-wrap">
                            <span class="button round small warning read-more">
                                <span class="button__icon waves-effect waves-circle waves-light">
                                    <svg class="svg-inline--fa fa-arrow-right fa-w-14" aria-hidden="true"
                                         data-prefix="fas" data-icon="arrow-right" role="img"
                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                         data-fa-i2svg="">
                                        <path fill="currentColor"
                                              d="M190.5 66.9l22.2-22.2c9.4-9.4 24.6-9.4 33.9 0L441 239c9.4 9.4 9.4 24.6 0 33.9L246.6 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.2-22.2c-9.5-9.5-9.3-25 .4-34.3L311.4 296H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h287.4L190.9 101.2c-9.8-9.3-10-24.8-.4-34.3z"></path>
                                    </svg><!-- <i class="fas fa-arrow-right" aria-hidden="true"></i> -->
                                </span>
                            </span>
                        </p>
                    </div>
                </div>
            </a>
        </div>
        <div class="column is-one-quarter">
            <a target="_blank" class="tile__link card"
               href="{{url('https://ressources.terredeliens.org/les-ressources/preservons-nos-terres-agricoles')}}">
                <div class="card-image vignette photo">
                    <figure class="image vignette__image-wrap vignette__ratio_4-3">
                        <img class="vignette__image"
                             src="{{asset('/images/cms/ressources/Capture d’écran 2020-09-17 à 15.33.32.png')}}"
                             alt="Placeholder image">
                    </figure>
                    <ul class="custom-tags custom-list custom-list_v ">
                        <li class="custom-tag success text_size x-large">
                            Guides
                        </li>
                    </ul>
                </div>
                <div class="card-content  tile__container">
                    <div class="content text_danger_orange tile__content">
                        <h3 class="title is-3 tile__title has-text-danger">Préservons nos terres agricoles</h3>
                        <p class="button-wrap">
                            <span class="button round small warning read-more">
                                <span class="button__icon waves-effect waves-circle waves-light">
                                    <svg class="svg-inline--fa fa-arrow-right fa-w-14" aria-hidden="true"
                                         data-prefix="fas" data-icon="arrow-right" role="img"
                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                         data-fa-i2svg="">
                                        <path fill="currentColor"
                                              d="M190.5 66.9l22.2-22.2c9.4-9.4 24.6-9.4 33.9 0L441 239c9.4 9.4 9.4 24.6 0 33.9L246.6 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.2-22.2c-9.5-9.5-9.3-25 .4-34.3L311.4 296H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h287.4L190.9 101.2c-9.8-9.3-10-24.8-.4-34.3z"></path>
                                    </svg><!-- <i class="fas fa-arrow-right" aria-hidden="true"></i> -->
                                </span>
                            </span>
                        </p>
                    </div>
                </div>
            </a>
        </div>
    </div>
    @include('components.cms-page-cta')

    {{--    @include('components.multiple-img-block')--}}
    {{--    <section class="hero has_margin">--}}
    {{--        <div class="hero-body block-video">--}}
    {{--            @include('components.video')--}}
    {{--        </div>--}}
    {{--    </section>--}}
    {{--    @if(! $cmsFaq->isEmpty())--}}
    {{--        @include('components.faq-frequentes')--}}
    {{--    @endif--}}
    {{--    <section class="section contactus-background">--}}
    {{--        <div class="container">--}}
    {{--            <div class="columns is-multiline is-mobile">--}}
    {{--                <div class="column is-half">--}}
    {{--                    @if($pageContent->count())--}}
    {{--                        @if($pageContent->has('transmettre-ma-ferme-trouver-le-candidat-ideal-de-cession'))--}}
    {{--                            {!! $pageContent['transmettre-ma-ferme-trouver-le-candidat-ideal-de-cession']->content !!}--}}
    {{--                        @endif--}}
    {{--                    @endif--}}
    {{--                </div>--}}
    {{--                <div class="column is-6 contactUs-button">--}}
    {{--                    <button class="button basic small primary  waves-effect waves-button waves-float waves-light">--}}
    {{--                        CONTACTEZ-NOUS--}}
    {{--                    </button>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </section>--}}

    {{--    @include('components/step-guide')--}}

    @include('components.partnering')

    @include('components.support-terre-liens')


@endsection

@section('script')
    <script src="{{ asset('js/bulma-carousel.js') }}"></script>
    <script>
        bulmaCarousel.attach('#carousel-installations', {
            slidesToScroll: 1,
            slidesToShow: 1,
            loop: true,
            navigation: true,

        });
        bulmaCarousel.attach('#carousel-testimony', {
            slidesToScroll: 1,
            slidesToShow: 1,
            loop: true,
            navigation: true,

        });

    </script>
@endsection
