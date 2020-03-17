
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
                    <h1 class="title is-1 has_margin">M’installer comme paysan</h1>
                    <p>Terre de Liens eget risus varius blandit sit amet non magna. Sed posuere
                        consectetur est at lobortis. Vestibulum id ligula porta felis euismod semper. Duis
                        mollis, est non commodo luctus, nisi erat porttitor ligula,
                    </p>
                </div>
                <div class="row is-full">
                    <h3 class="title is-3 has_margin">Nascetur ridiculus venenatis blandit felis</h3>
                    <p>
                        Maecenas faucibus mollis interdum. Maecenas sed diam eget risus varius blandit
                        sit amet non magna. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed
                        posuere consectetur est at lobortis. Integer posuere erat a ante venenatis dapibus
                        posuere velit aliquet. Donec sed odio dui.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="columns">
                <div class="column">
                    <h2 class="title is-2">Votre projet d’installation</h2>
                    <p>
                        Donec ullamcorper nulla non metus auctor
                        fringilla. Maecenas sed diam eget risus varius
                        blandit sit amet non magna.
                    </p>
                    <p>
                        <span>Pour aller plus loin :</span> Terre de Liens vous met à
                        dispostion un <a href="#">Centre de Ressources</a> donec
                        ullamcorper nulla non metus auctor fringilla.
                    </p>
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
                    <h1 class="title is-2">Consecteur auctor fringilla Moderatus</h1>
                    <p>Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Integer posuere erat
                        a ante venenatis dapibus posuere velit aliquet. Maecenas faucibus mollis
                        interdum. Cras justo odio, dapibus ac facilisis in, egestas eget quam.
                    </p>
                    <p>
                        Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus
                        mus. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia
                        odio sem nec elit. Nulla vitae elit libero, a pharetra augue. Praesent commodo
                        cursus magna, vel scelerisque nisl consectetur et. Donec ullamcorper nulla non
                        metus auctor fringilla.
                    </p>
                    <p>
                        Maecenas sed diam eget risus varius blandit sit amet non magna. Sed posuere
                        consectetur est at lobortis. Vestibulum id ligula porta felis euismod semper. Duis
                        mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem
                        nec elit. Sed posuere consectetur est at lobortis. Nullam id dolor id nibh ultricies
                        vehicula ut id elit. Maecenas sed diam eget risus varius blandit sit amet non
                        magna.
                    </p>
                </div>
                <div class="row is-full">
                    <h3 class="title is-3 has_margin">Pellentasque sicuram ligula</h3>
                    <p>
                        Maecenas faucibus mollis interdum. Maecenas sed diam eget risus varius blandit
                        sit amet non magna. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed
                        posuere consectetur est at lobortis. Integer posuere erat a ante venenatis dapibus
                        posuere velit aliquet. Donec sed odio dui.
                        Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vestibulum
                        id ligula porta felis euismod semper. Morbi leo risus, porta ac consectetur ac,
                        vestibulum at eros. Cum sociis natoque penatibus et magnis dis parturient
                        montes, nascetur ridiculus mus. Nullam id dolor id nibh ultricies vehicula ut id elit.
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cum sociis natoque
                    </p>
                </div>
            </div>
        </div>
    </section>

    @include('components/downloadPDF')

    @include('components/step-guide')

    @include('components/testimony')

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
