@extends ('default')

@section ('title', "M'installer comme paysan")

@section('head-script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma-carousel@4.0.4/dist/css/bulma-carousel.min.css">
@endsection

@section('main-content')
    <section class="section cms-page">
        <div class="container">
            <div class="rows">
                <div class="row is-full">
                    @if($pageContent->count())
                        @if($pageContent->has('minstaller-comme-paysan-texte-dintroduction-sous-le-titre-principal'))
                            {!! $pageContent['minstaller-comme-paysan-texte-dintroduction-sous-le-titre-principal']->content !!}
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            @if($pageContent->count())
                @if($pageContent->has('minstaller-comme-paysan-votre-projet-dinstallations'))
                    {!! $pageContent['minstaller-comme-paysan-votre-projet-dinstallations']->content !!}
                @endif
            @endif
            <div class="columns is-centered">
                <div class="column is-one-third">
                    <a target="_blank" class="tile__link card"
                       href="{{url('https://ressources.terredeliens.org/les-ressources/je-souhaite-devenir-paysan ')}}">
                        <div class="card-image vignette photo">
                            <figure class="">
                                <img class="vignette__image"
                                     src="{{asset('/images/cms/ressources/13-DSC_0712.jpg')}}"
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
                                <h3 class="title is-3 tile__title has-text-danger">Je souhaite m'installer et devenir
                                    paysan-ne</h3>
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
        </div>
    </section>
    <div class="container">
        <p >Quelques ressources issues de ce dossier : </p>
    </div>
    <div class="columns is-centered">
        <div class="column is-one-quarter">
            <a target="_blank" class="tile__link card"
               href="{{url(':https://ressources.terredeliens.org/les-ressources/trouver-une-terre-pour-mon-projet-agricole')}}">
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
               href="{{url(' https://ressources.terredeliens.org/les-ressources/neo-paysans-le-guide-tres-pratique')}}">
                <div class="card-image vignette photo">
                    <figure class="image vignette__image-wrap vignette__ratio_4-3">
                        <img class="vignette__image"
                             src="{{asset('/images/cms/ressources/Couverture.png')}}"
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
                        <h3 class="title is-3 tile__title has-text-danger">Néo-paysans - le guide (très) pratique</h3>
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
               href="{{url('https://ressources.terredeliens.org/les-ressources/devenir-paysan-reconversions-professionnelles-vers-l-agriculture ')}}">
                <div class="card-image vignette photo">
                    <figure class="image vignette__image-wrap vignette__ratio_4-3">
                        <img class="vignette__image"
                             src="{{asset('/images/cms/ressources/devenir-paysan-livre.jpg')}}"
                             alt="Placeholder image">
                    </figure>
                    <ul class="custom-tags custom-list custom-list_v ">
                        <li class="custom-tag success text_size x-large">
                            Livres
                        </li>
                    </ul>
                </div>
                <div class="card-content  tile__container">
                    <div class="content text_danger_orange tile__content">
                        <h3 class="title is-3 tile__title has-text-danger">Devenir paysan, reconversions
                            professionnelles vers l'agriculture</h3>
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

{{--    <section class="hero has_margin">--}}
{{--        <div class="hero-body block-video">--}}
{{--            @include('components.video')--}}
{{--        </div>--}}
{{--    </section>--}}

{{--    @include('components.double-pict-carrousel')--}}

{{--    @include ('components/block-contact')--}}

{{--    <section class="section">--}}
{{--        <div class="container block-numbers">--}}
{{--            <div class="container has-text-centered">--}}
{{--                <div class="rows">--}}
{{--                    <div class="row is-full">--}}
{{--                        <h2 class="title is-2 has_margin">Des résultats mesurables </h2>--}}
{{--                        <p>--}}
{{--                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor--}}
{{--                            incididunt ut labore et dolore magna aliquat enim ad minim.--}}
{{--                        </p>--}}
{{--                    </div>--}}
{{--                    @include('components/number-circle-percent')--}}
{{--                    <div class="row is-full has-text-centered has_margin">--}}
{{--                        <button class="button is-link">CHIFFRES CLÉS</button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}

{{--    <section class="section">--}}
{{--        <div class="container">--}}
{{--            <div class="rows">--}}
{{--                <div class="row is-full block-result-text">--}}
{{--                    @if($pageContent->count())--}}
{{--                        @if($pageContent->has('minstaller-comme-paysan-les-deux-textes-sous-les-chiffres'))--}}
{{--                            {!! $pageContent['minstaller-comme-paysan-les-deux-textes-sous-les-chiffres']->content !!}--}}
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
