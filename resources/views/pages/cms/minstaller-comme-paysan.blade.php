
@extends ('default')

@section ('title', "M'installer comme paysan")

@section('head-script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma-carousel@4.0.4/dist/css/bulma-carousel.min.css">
@endsection

@section('main-content')
    <section class="section">
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
            <div class="columns">
                <div class="column">
                    @if($pageContent->count())
                        @if($pageContent->has('minstaller-comme-paysan-votre-projet-dinstallations'))
                            {!! $pageContent['minstaller-comme-paysan-votre-projet-dinstallations']->content !!}
                        @endif
                    @endif
                </div>
                <div class="column is-three-quarters has-text-centered">
                    <div class="columns is-centered">
                        @for ($i = 0; $i < 3; $i++)
                            <div class="column">
                                <a href="#">
                                    <div class="card">
                                        <div class="card-image">
                                            <figure class="image is-4by3">
                                                <img src="https://picsum.photos/200/300" alt="Placeholder image">
                                            </figure>
                                        </div>
                                        <div class="card-content">
                                            <p class="title is-4">Région ou département</p>
                                            <p class="subtitle is-6">Titre de l'actualité au-dessus</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="hero has_margin">
        <div class="hero-body block-video">
            @include('components.video')
        </div>
    </section>

    @include('components.double-pict-carrousel')

    @include ('components/block-contact')

    <section class="section">
        <div class="container block-numbers">
            <div class="container has-text-centered">
                <div class="rows">
                    <div class="row is-full">
                        <h2 class="title is-2 has_margin">Des résultats mesurables </h2>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                            incididunt ut labore et dolore magna aliquat enim ad minim.
                        </p>
                    </div>
                    @include('components/number-circle-percent')
                    <div class="row is-full has-text-centered has_margin">
                        <button class="button is-link">CHIFFRES CLÉS</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="rows">
                <div class="row is-full block-result-text">
                    @if($pageContent->count())
                        @if($pageContent->has('minstaller-comme-paysan-les-deux-textes-sous-les-chiffres'))
                            {!! $pageContent['minstaller-comme-paysan-les-deux-textes-sous-les-chiffres']->content !!}
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </section>

    @include('components/downloadPDF')

    @include('components/step-guide')

    @include('components/testimony')

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
