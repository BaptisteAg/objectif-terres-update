
@extends ('default')

@section ('title', "Céder mes terres")

@section('head-script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma-carousel@4.0.4/dist/css/bulma-carousel.min.css">
@endsection

@section('main-content')
    <section class="section">
        <div class="container">
            <div class="rows">
                <div class="row is-full">
                    <h1 class="title is-1 has_margin">Confier mes terres à TDL</h1>
                    <p>Faire un legs c’est avant tout et eget risus varius blandit sit amet non magna. Sed
                        posuere consectetur est at lobortis. Vestibulum id ligula porta felis euismod
                        semper. Duis mollis, est non commodo luctus, nisi erat porttitor ligula,
                    </p>
                </div>
                <div class="row is-full">
                    <h3 class="title is-3 has_margin">Partager son patrimoine, c’est faire acte de don</h3>
                    <p>
                        maecenas faucibus mollis interdum. Maecenas sed diam eget risus varius blandit
                        sit amet non magna. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed
                        posuere con, maecenas faucibus mollis interdum. Maecenas sed diam eget risus
                        varius blandit sit amet non magna. Lorem ipsum dolor sit amet, consectetur
                        adipiscing elit. Sed posuere consectetur est at lobortis. Integer posuere erat a
                        ante venenatis dapibus posuere velit aliquet. Donec sed odio dui.Vivamus sagittis
                        lacus vel augue laoreet rutrum faucibus dolor auctor. Nullam quis risus eget urna
                        mollis ornare vel eu leo. Maecenas faucibus mollis interdum. Maecenas sed diam
                        eget risus varius blandit sit amet non magna. Morbi leo risus, porta ac consectetur
                    </p>
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

    <section class="section">
        <div class="container">
            <div class="rows">
                <div class="columns">
                    <div class="column is-9 block-tdl-contact">
                        <div class="row">
                            <h2 class="title is-2"><span>Léguez vos terres à Terre de Liens:</span><br> nous allons vous guider étape par étape.</h2>
                            <p>
                                maecenas faucibus mollis interdum. Maecenas sed diam eget risus varius blandit
                                sit amet non magna. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed
                                posuere con, maecenas faucibus mollis interdum. Maecenas sed diam eget risus
                                varius blandit sit amet non magna. Lorem ipsum dolor sit amet, consectetur
                                adipiscing elit. Sed posuere consectetur est at lobortis. Integer posuere erat a
                                ante venenatis dapibus posuere velit aliquet. Donec sed odio dui.Vivamus sagittis
                                lacus vel augue laoreet rutrum faucibus dolor auctor. Nullam quis risus eget urna
                                mollis ornare vel eu leo. Maecenas faucibus mollis interdum. Maecenas sed diam
                                eget risus varius blandit sit amet non magna. Morbi leo risus, porta ac consectetur
                            </p>
                        </div>
                        <div class="row">
                            <button class="button is-link">CONTACTEZ-NOUS</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('components/downloadPDF')

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
