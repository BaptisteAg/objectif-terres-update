
@extends ('default')

@section ('title', "Louer ou vendre mes terres")

@section('head-script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma-carousel@4.0.4/dist/css/bulma-carousel.min.css">
@endsection

@section('main-content')
    <section class="section">
        <div class="container">
            <div class="rows">
                <div class="row is-full">
                    @if($pageContent->count())
                        @if($pageContent->has('louer-ou-vendre-mes-terres-texte-dintroduction-sous-le-titre-principal-et-vos-terres-vont-nourrir-denvergure'))
                            {!! $pageContent['louer-ou-vendre-mes-terres-texte-dintroduction-sous-le-titre-principal-et-vos-terres-vont-nourrir-denvergure']->content !!}
                        @endif
                    @endif
            </div>
        </div>
    </section>

    @include('components.carrousel-large')

    @include('components.faq-frequentes')

    @include ('components/block-contact')

    <section class="section">
        <div class="container block-numbers">
            <div class="container has-text-centered">
                <div class="rows">
                    <div class="row is-full">
                        <h2 class="title is-2 has_margin">Un marché plus sain</h2>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                            incididunt ut labore et dolore magna aliquat enim ad minim.
                        </p>
                    </div>
                    @include('components/number-circle-percent')
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="rows">
                <div class="row is-full block-result-text">
                    @if($pageContent->count())
                        @if($pageContent->has('louer-ou-vendre-mes-terres-des-projets-partout-en-france'))
                            {!! $pageContent['louer-ou-vendre-mes-terres-des-projets-partout-en-france']->content !!}
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
