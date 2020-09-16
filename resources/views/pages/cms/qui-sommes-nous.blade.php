@extends ('default')

@section ('title', 'Qui sommes nous ?')

@section('head-script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma-carousel@4.0.4/dist/css/bulma-carousel.min.css">
@endsection

@section('main-content')
    <section class="section cms-page">
        <div class="container">
            <div class="rows margin-p">
                <div class="row is-full">
                        @if($pageContent->count())
                            @if($pageContent->has('qui-sommes-nous-texte-dintroduction-sous-le-titre-principal'))
                                {!! $pageContent['qui-sommes-nous-texte-dintroduction-sous-le-titre-principal']->content !!}
                            @endif
                        @endif
                </div>
            </div>
        </div>
    </section>

{{--    <section class="hero">--}}
{{--        <div class="hero-body market-background">--}}
{{--            <h2 class="title is-2">Mettre en relation l’offre et la demande du foncier agricole en France.</h2>--}}
{{--        </div>--}}
{{--    </section>--}}

    <section class="section" >
        <div class="container">
            <div class="rows margin-p">
                <div class="row is-full">
                    @if($pageContent->count())
                        @if($pageContent->has('qui-sommes-nous-les-deux-textes-situes-sous-la-banniere'))
                            {!! $pageContent['qui-sommes-nous-les-deux-textes-situes-sous-la-banniere']->content !!}
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div id="carousel-quiNousSommes" class="carousel">
                @for ($i = 0; $i < 4; $i++)
                    <div class="column is-12 ">
                        <div class="card">
                            <div class="card-content">
                                <div class="media">
                                    <figure class="image is-centered is-256x256">
                                        <img src="https://picsum.photos/800/600?random=1" alt="Placeholder image">
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
{{--            <div class="container has-text-centered ">--}}
{{--                <h2 class="title is-2 has_margin">Lorem ipsum pellentasque </h2>--}}
{{--                <p>--}}
{{--                    Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Cras mattis--}}
{{--                    consectetur purus sit amet fermentum. Donec sed odio dui.--}}
{{--                </p>--}}
{{--            </div>--}}
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="rows">
                <div class="row is-full margin-p">
                    @if($pageContent->count())
                        @if($pageContent->has('qui-sommes-nous-en-savoir-plus-sur-lassociation-terre-de-liens'))
                            {!! $pageContent['qui-sommes-nous-en-savoir-plus-sur-lassociation-terre-de-liens']->content !!}
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </section>

{{--    <section class="section">--}}
{{--        <div class="container">--}}
{{--            <div class="rows">--}}
{{--                <div class="rows is-full">--}}
{{--                    <h2 class="title is-2 has_margin has-text-centered">Les actualités de l’association</h2>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="row is-full">--}}
{{--                <div class="has-text-centered">--}}
{{--                    <div class="columns is-centered">--}}
{{--                        @for ($i = 0; $i < 3; $i++)--}}
{{--                            <div class="column">--}}
{{--                                <a href="#">--}}
{{--                                    <div class="card">--}}
{{--                                        <div class="card-image">--}}
{{--                                            <figure class="image is-4by3">--}}
{{--                                                <img src="https://picsum.photos/200/300" alt="Placeholder image">--}}
{{--                                            </figure>--}}
{{--                                        </div>--}}
{{--                                        <div class="card-content">--}}
{{--                                            <p class="title is-4">Région ou département</p>--}}
{{--                                            <p class="subtitle is-6">Titre de l'actualité au-dessus</p>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        @endfor--}}
{{--                    </div>--}}
{{--                    <div class="columns is-centered">--}}
{{--                        <div class="column is-half has-text-centered">--}}
{{--                            <button class="button is-link">TOUTES LES ACTUALITÉS DU MOUVEMENT</button>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}

    @include('components.partnering')

    @include('components.support-terre-liens')

@endsection

@section('script')
    <script src="{{ asset('js/bulma-carousel.js') }}"></script>
    <script>
        bulmaCarousel.attach('#carousel-quiNousSommes', {
            slidesToScroll: 1,
            slidesToShow: 1,
            loop: true,
            navigation: true,

        });
    </script>
@endsection
