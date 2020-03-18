@extends('default')

@section('title', 'Ressources utiles ')

@section('head-script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma-carousel@4.0.4/dist/css/bulma-carousel.min.css">
@endsection

@section('main-content')

    <div class="section">
        <div class="container margin-p">
            <div class="content is-medium has-text-justified">
                <h1 class="title is-2 has-text-link">Ressources utiles </h1>
                <p>Nous vous donnons accès à une série de ressources utiles pour vous aider et
                    accompagner dans votre projet. Eget risus varius blandit sit amet non magna. Sed
                    posuere consectetur est at lobortis. Vestibulum id ligula porta felis euismod
                    semper. Duis mollis, est non commodo luctus, nisi erat porttitor.</p>

                <p>Maecenas faucibus mollis interdum. Maecenas sed diam eget risus varius blandit
                    sit amet non magna. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed
                    posuere consectetur est at lobortis. Integer posuere erat a ante venenatis dapibus
                    posuere velit aliquet. Donec sed odio dui.</p>
            </div>
        </div>

        <div class="container is-fluid">
            <div class="columns is-centered">
                <div class="column is-one-third ">
                    <div class="content">
                        <div class="columns is-mobile is-centered">
                            <div class="column is-three-quarters">
                                <h2 class="title is-2 has-text-link">Réussir son projet agricole.</h2>
                                <p>Fusce dapibus, tellus ac cursus commodo,
                                    tortor mauris condimentum nibh, ut
                                    fermentum massa justo sit amet risus. Morbi
                                    leo risus, porta ac consectetur acvesti.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="columns is-centered">
                        @for ($i = 0; $i < 3; $i++)
                            <div class="column is-one-third ">
                                <div class="card">
                                    <div class="card-image">
                                        <figure class="image is-4by3">
                                            <a href="/" download="rapport2019"><img src="/images/placeholder-ad.png"
                                                                                    alt=""></a>
                                        </figure>
                                    </div>
                                    <div class="card-content is-marginless">
                                        <p class="title is-4 has-text-centered">Titre du document</p>
                                        <p class="subtitle is-6 has-text-grey">Lorem ipsum dolor sit amet, consectetur
                                            adipisicing
                                            elit. Accusamus corporis deleniti </p>
                                        <div class="content has-text-centered">
                                            <a href="/" class="button is-link is-uppercase"
                                               download="rapport2019">Télécharger</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="container is-fluid">
            <div class="section">
                <div class="columns is-centered ">
                    <div class="column is-one-third ">
                        <div class="content">
                            <div class="columns is-mobile is-centered">
                                <div class="column is-three-quarters">
                                    <h2 class="title is-2 has-text-link">Comment s’installer comme paysan ?</h2>
                                    <p>Fusce dapibus, tellus ac cursus commodo,
                                        tortor mauris condimentum nibh.
                                    </p>
                                    <br>
                                    <p>
                                        Fermentum massa justo sit amet risus. Morbi
                                        leo risus, porta ac consectetur ac, vestibulum
                                        at eros. Maecenas faucibus mollis interdum.
                                        Duis mollis, est non commodo luctus.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="columns is-centered">
                            @for ($i = 0; $i < 3; $i++)
                                <div class="column is-one-third ">
                                    <div class="card">
                                        <div class="card-image">
                                            <figure class="image is-4by3">
                                                <a href="/" download="rapport2019"><img src="/images/placeholder-ad.png"
                                                                                        alt=""></a>
                                            </figure>
                                        </div>
                                        <div class="card-content is-marginless">
                                            <p class="title is-4 has-text-centered">Titre du document</p>
                                            <p class="subtitle is-6 has-text-grey">Lorem ipsum dolor sit amet, consectetur
                                                adipisicing
                                                elit. Accusamus corporis deleniti </p>
                                            <div class="content has-text-centered">
                                                <a href="/" class="button is-link is-uppercase"
                                                   download="rapport2019">Télécharger</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>

            <div class="section">
                <div class="columns is-centered">
                    <div class="column is-one-third ">
                        <div class="content">
                            <div class="columns is-mobile is-centered">
                                <div class="column is-three-quarters">
                                    <h2 class="title is-2 has-text-link">Comment transmettre sa ferme ?</h2>
                                    <p>Fermentum massa justo sit amet risus. Morbi
                                        leo risus, porta ac consectetur ac, vestibulum
                                        at eros. Maecenas faucibus mollis interdum.
                                        Duis mollis, est non commodo luctus.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="columns is-centered">
                            @for ($i = 0; $i < 3; $i++)
                                <div class="column is-one-third ">
                                    <div class="card">
                                        <div class="card-image">
                                            <figure class="image is-4by3">
                                                <a href="/" download="rapport2019"><img src="/images/placeholder-ad.png"
                                                                                        alt=""></a>
                                            </figure>
                                        </div>
                                        <div class="card-content is-marginless">
                                            <p class="title is-4 has-text-centered">Titre du document</p>
                                            <p class="subtitle is-6 has-text-grey">Lorem ipsum dolor sit amet, consectetur
                                                adipisicing
                                                elit. Accusamus corporis deleniti </p>
                                            <div class="content has-text-centered">
                                                <a href="/" class="button is-link is-uppercase"
                                                   download="rapport2019">Télécharger</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>

            <div class="section">
                <div class="columns is-centered">
                    <div class="column is-one-third ">
                        <div class="content">
                            <div class="columns is-mobile is-centered">
                                <div class="column is-three-quarters">
                                    <h2 class="title is-2 has-text-link">Conseil juridique pour les propriétaires fonciers.</h2>
                                    <p>Fermentum massa justo sit amet risus. Morbi
                                        leo risus, porta ac consectetur avestibulum at
                                        eros. Maecenas faucibus mollis interdum.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="columns is-centered">
                            @for ($i = 0; $i < 3; $i++)
                                <div class="column is-one-third ">
                                    <div class="card">
                                        <div class="card-image">
                                            <figure class="image is-4by3">
                                                <a href="/" download="rapport2019"><img src="/images/placeholder-ad.png"
                                                                                        alt=""></a>
                                            </figure>
                                        </div>
                                        <div class="card-content is-marginless">
                                            <p class="title is-4 has-text-centered">Titre du document</p>
                                            <p class="subtitle is-6 has-text-grey">Lorem ipsum dolor sit amet, consectetur
                                                adipisicing
                                                elit. Accusamus corporis deleniti </p>
                                            <div class="content has-text-centered">
                                                <a href="/" class="button is-link is-uppercase"
                                                   download="rapport2019">Télécharger</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>

            <div class="section">
                <div class="columns is-centered">
                    <div class="column is-one-third ">
                        <div class="content">
                            <div class="columns is-mobile is-centered">
                                <div class="column is-three-quarters">
                                    <h2 class="title is-2 has-text-link">Allier agriculture et biodiversité.</h2>
                                    <p>Fermentum massa justo sit amet risus. Morbi
                                        leo risus, porta ac consectetur avestibulum at
                                        eros. Maecenas faucibus mollis interdum.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="columns is-centered">
                            @for ($i = 0; $i < 3; $i++)
                                <div class="column is-one-third ">
                                    <div class="card">
                                        <div class="card-image">
                                            <figure class="image is-4by3">
                                                <a href="/" download="rapport2019"><img src="/images/placeholder-ad.png"
                                                                                        alt=""></a>
                                            </figure>
                                        </div>
                                        <div class="card-content is-marginless">
                                            <p class="title is-4 has-text-centered">Titre du document</p>
                                            <p class="subtitle is-6 has-text-grey">Lorem ipsum dolor sit amet, consectetur
                                                adipisicing
                                                elit. Accusamus corporis deleniti </p>
                                            <div class="content has-text-centered">
                                                <a href="/" class="button is-link is-uppercase"
                                                   download="rapport2019">Télécharger</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>

            <section>
                <div class="columns">
                    <div class="column is-12 has-text-centered has_margin">
                        <button class="button is-link">Accéder au centre des ressources</button>
                    </div>
                </div>
            </section>
        </div><!--End section container-->
    </div><!--End section -->

    <section class="hero has_margin">
        <div class="hero-body block-video">
            @include('components.video')
        </div>
    </section>

    @include('components.double-pict-carrousel')

    @include('components.downloadPDF')

    @include('components.partnering')

    @include('components.supportTerreLiens')

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
