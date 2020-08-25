
@extends ('default')

@section ('title', "Céder ma ferme")

@section('head-script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma-carousel@4.0.4/dist/css/bulma-carousel.min.css">
@endsection

@section('main-content')
    <section class="section">
        <div class="container">
            <div class="rows">
                <div class="row is-full">
                    <h1 class="title is-1 has_margin">Céder ma ferme</h1>
                    <p>Transmettre c’est avant tout et eget risus varius blandit sit amet non magna. Sed
                        posuere consectetur est at lobortis. Vestibulum id ligula porta felis euismod
                        semper. Duis mollis, est non commodo luctus, nisi erat porttitor ligula,
                    </p>
                </div>
                <div class="row is-full">
                    @if($pageContent->count())
                        @if($pageContent->has('ceder-ma-ferme-votre-ferme-continuera-un-projet-solide'))
                            {!! $pageContent['ceder-ma-ferme-votre-ferme-continuera-un-projet-solide']->content !!}
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </section>

    @include('components.multiple-img-block')


    <section class="hero has_margin">
        <div class="hero-body block-video">
            @include('components.video')
        </div>
    </section>

    @include('components.faq-frequentes')

    <section class="section contactus-background">
        <div class="container">
            <div class="columns is-multiline is-mobile">
                <div class="column is-half">
                    @if($pageContent->count())
                        @if($pageContent->has('ceder-ma-ferme-trouver-le-candidat-ideal-de-cession'))
                            {!! $pageContent['ceder-ma-ferme-trouver-le-candidat-ideal-de-cession']->content !!}
                        @endif
                    @endif
                </div>
                <div class="column is-6 contactUs-button">
                    <button class="button is-link">CONTACTEZ-NOUS</button>
                </div>
            </div>
        </div>
    </section>

    @include('components/downloadPDF')

    @include('components/step-guide')

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
