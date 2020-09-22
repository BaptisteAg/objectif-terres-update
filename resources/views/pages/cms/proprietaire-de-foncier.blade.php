@extends ('default')

@section ('title', "Propriétaire de foncier")

@section('head-script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma-carousel@4.0.4/dist/css/bulma-carousel.min.css">
@endsection

@section('main-content')
    <section class="section cms-page">
        <div class="container">
            <div class="rows">
                <div class="row is-full">
                    <p>Pour vous aider, vous inspirer et vous outiller dans votre projet d’installation ou de
                        transmission agricole, Terre de Liens et ses partenaires du réseau InPACT (Initiatives pour une
                        Agriculture citoyenne et territoriale) ont édité un ensemble de guides méthodologiques et
                        recueilli une diversité de projets réussis et inspirants d’installations et de
                        transmissions.</p>

                    <p>
                        L’ensemble de ces ressources vous sont mises à disposition gratuitement sur le site du Centre de
                        Ressources Terre de Liens, dont la vocation est de “sensibiliser, documenter, inspirer et
                        outiller toute personne souhaitant s’engager pour la préservation des terres agricoles et
                        l’agroécologie”.
                    </p>

                    <p class="has-text-weight-bold">
                        Un dossier thématique à destination des propriétaires privés qui se posent la question du
                        devenir agricole de leur bien ou qui souhaitent en orienter l'usage, par exemple vers des
                        pratiques agricoles plus respectueuses de l'environnement sera bientôt disponible. Terre de
                        Liens éditera d'ici 2021 un guide de la propriété foncière agricole pour vous outiller en ce
                        sens. Patience !
                    </p>
                    <p>
                        En attendant, vous pouvez consulter ci-dessous le guide foncier pour proprié'terre, qui apporte
                        des éclairages techniques, méthodologiques et juridiques à des destination des propriétaires de
                        foncier :
                    </p>

                    <div class="columns is-centered">
                        <div class="column is-one-third">
                            <a target="_blank" class="tile__link card"
                               href="{{url('https://ressources.terredeliens.org/les-ressources/guide-foncier-proprieterres ')}}">
                                <div class="card-image vignette photo">
                                    <figure class="">
                                        <img class="vignette__image"
                                             src="{{asset('/images/cms/ressources/Capture d’écran 2020-09-18 à 09.12.31.png')}}"
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
                                        <h3 class="title is-3 tile__title has-text-danger">Guide foncier pour
                                            proprié'terre</h3>
                                        <p class="button-wrap">
                                            <span class="button round small warning read-more">
                                                <span class="button__icon waves-effect waves-circle waves-light">
                                                    <svg class="svg-inline--fa fa-arrow-right fa-w-14"
                                                         aria-hidden="true"
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
                    <p class="mt-30">
                        Pour plus d'informations sur la donation ou le legs à Terre de Liens, vous pouvez également
                        consulter <a href="{{route('confier-mes-terres')}}">cette page</a>.
                    </p>
                </div>
            </div>
        </div>
    </section>

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
    </script>
@endsection
