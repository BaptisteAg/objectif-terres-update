@extends ('default')

@section ('title', "Louer ou vendre mes terres")

@section('head-script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma-carousel@4.0.4/dist/css/bulma-carousel.min.css">
@endsection

@section('main-content')
    <section class=" cms-page">
        <div class="container">
            <div class="rows">
                <div class="row is-full">
                    @if($pageContent->count())
                        @if($pageContent->has('trouver-une-terre-ou-des-financements-texte-dintroduction-sous-le-titre-principal-et-vos-terres-vont-nourrir-denvergure'))
                            {!! $pageContent['trouver-une-terre-ou-des-financements-texte-dintroduction-sous-le-titre-principal-et-vos-terres-vont-nourrir-denvergure']->content !!}
                        @endif
                    @endif
                </div>
                <div class="columns is-centered">
                    <div class="column is-one-third">
                        <a target="_blank" class="tile__link card"
                           href="{{url('https://ressources.terredeliens.org/les-ressources/en-cours-je-recherche-des-terres-pour-mon-projet-agricole ')}}">
                            <div class="card-image vignette photo">
                                <figure class="">
                                    <img class="vignette__image"
                                         src="{{asset('/images/cms/ressources/couverture-cdts-xavierduboisutlisee-par-bluebees.jpg')}}"
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
                                    <h3 class="title is-3 tile__title has-text-danger">Je recherche des terres pour mon
                                        projet agricole</h3>
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

                <p>Quelques ressources issues de ce dossier :</p>
                <div class="columns is-centered mb-60">
                    <div class="column is-one-quarter">
                        <a target="_blank" class="tile__link card"
                           href="{{url('https://ressources.terredeliens.org/les-ressources/trouver-une-terre-pour-mon-projet-agricole')}}">
                            <div class="card-image vignette photo">
                                <figure class="image vignette__image-wrap vignette__ratio_4-3">
                                    <img class="vignette__image"
                                         src="{{asset('/images/cms/ressources/Capture d’écran 2019-02-27 à 18.22.19.png')}}"
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
                                    <h3 class="title is-3 tile__title has-text-danger">Trouver une terre pour mon projet
                                        agricole</h3>
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
                           href="{{url('https://ressources.terredeliens.org/les-ressources/recherche-une-terre-pour-accueillir-son-projet')}}">
                            <div class="card-image vignette photo">
                                <figure class="image vignette__image-wrap vignette__ratio_4-3">
                                    <img class="vignette__image"
                                         src="{{asset('/images/cms/ressources/Capture d’écran 2020-09-17 à 15.02.07.png')}}"
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
                                    <h3 class="title is-3 tile__title has-text-danger">Rechercher une terre pour
                                        accueillir son projet</h3>
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
                           href="{{url('https://ressources.terredeliens.org/les-ressources/et-si-on-restructurait-les-fermes ')}}">
                            <div class="card-image vignette photo">
                                <figure class="image vignette__image-wrap vignette__ratio_4-3">
                                    <img class="vignette__image"
                                         src="{{asset('/images/cms/ressources/Capture d’écran 2020-09-17 à 15.01.09.png')}}"
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
                                    <h3 class="title is-3 tile__title has-text-danger">Et si on restructurait les fermes
                                        ? </h3>
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
    @include('components.cms-page-cta')
    {{--    @include('components.carrousel-large')--}}

    {{--    @if(! $cmsFaq->isEmpty())--}}
    {{--        @include('components.faq-frequentes')--}}
    {{--    @endif--}}

    {{--    @include ('components/block-contact')--}}

    {{--    <section class="section">--}}
    {{--        <div class="container block-numbers">--}}
    {{--            <div class="container has-text-centered">--}}
    {{--                <div class="rows">--}}
    {{--                    <div class="row is-full">--}}
    {{--                        <h2 class="title is-2 has_margin">Un marché plus sain</h2>--}}
    {{--                        <p>--}}
    {{--                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor--}}
    {{--                            incididunt ut labore et dolore magna aliquat enim ad minim.--}}
    {{--                        </p>--}}
    {{--                    </div>--}}
    {{--                    @include('components/number-circle-percent')--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </section>--}}

    {{--    <section class="section">--}}
    {{--        <div class="container">--}}
    {{--            <div class="rows">--}}
    {{--                <div class="row is-full block-result-text">--}}
    {{--                    @if($pageContent->count())--}}
    {{--                        @if($pageContent->has('trouver-une-terre-ou-des-financements-des-projets-partout-en-france'))--}}
    {{--                            {!! $pageContent['trouver-une-terre-ou-des-financements-des-projets-partout-en-france']->content !!}--}}
    {{--                        @endif--}}
    {{--                    @endif--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </section>--}}

    {{--    @include('components/downloadPDF')--}}

    {{--    @include('components/step-guide')--}}

    {{--    @include('components/testimony')--}}

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
