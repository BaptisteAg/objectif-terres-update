@extends ('default')

@section ('title', 'Qui sommes nous ?')

@section('head-script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma-carousel@4.0.4/dist/css/bulma-carousel.min.css">
@endsection

@section('main-content')
    <section class="section">
        <div class="container">
            <div class="rows margin-p">
                <div class="row is-full">
                    <h1 class="title is-1 has_margin">Qui sommes-nous ?</h1>
                    <p>Objectif Terre est une initiative créée par Terre de Lien eget risus varius blandit sit
                        amet non magna. Sed posuere consectetur est at lobortis. Vestibulum id ligula
                        porta felis euismod semper. Duis mollis, est non commodo luctus, nisi erat
                        porttitor.
                    </p>
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

    <section class="hero">
        <div class="hero-body market-background">
            <h2 class="title is-2">Mettre en relation l’offre et la demande du foncier agricole en France.</h2>
        </div>
    </section>

    <section section>
        <div class="container">
            <div class="rows margin-p">
                <div class="row is-full">
                    <h3 class="title is-3 has_margin">Consecteur auctor fringilla Moderatus</h3>
                    <p>
                        Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Integer posuere erat
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
                    </p>
                    <p>
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
            <div class="container has-text-centered ">
                <h2 class="title is-2 has_margin">Lorem ipsum pellentasque </h2>
                <p>
                    Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Cras mattis
                    consectetur purus sit amet fermentum. Donec sed odio dui.
                </p>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="rows">
                <div class="row is-full margin-p">
                    <h2 class="title is-2 has_margin">En savoir plus sur l’association Terre de Liens</h2>
                    <p>
                        Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Integer posuere erat
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
                </div>
                <div class="row is-full">
                    <p>POUR EN SAVOIR PLUS</p>
                    <a href="#">www.terredeliens.org</a>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="rows">
                <div class="rows is-full">
                    <h2 class="title is-2 has_margin has-text-centered">Les actualités de l’association</h2>
                </div>
            </div>
            <div class="row is-full">
                <div class="has-text-centered">
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
                    <div class="columns is-centered">
                        <div class="column is-half has-text-centered">
                            <button class="button is-link">TOUTES LES ACTUALITÉS DU MOUVEMENT</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('components.partnering')

    @include('components.supportTerreLiens')

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
