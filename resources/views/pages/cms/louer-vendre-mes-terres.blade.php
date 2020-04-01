
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
                    <h1 class="title is-1 has_margin">Louer ou vendre mes terres</h1>
                    <p>Vous avez des terres et eget risus varius blandit sit amet non magna. Sed posuere
                        consectetur est at lobortis. Vestibulum id ligula porta felis euismod semper. Duis
                        mollis, est non commodo luctus, nisi erat porttitor ligula,
                    </p>
                </div>
                <div class="row is-full">
                    <h3 class="title is-3 has_margin">Vos terres vont nourrir un projet d’envergure</h3>
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
                    <h4 class="title is-4 has_margin">Des projets partout en France</h4>
                    <p>Maecenas faucibus mollis interdum. Maecenas sed diam eget risus varius blandit
                        sit amet non magna. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed
                        posuere consectetur est at lobortis. Integer posuere erat a ante venenatis dapibus
                        posuere velit aliquet. Donec sed odio dui.
                        Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vestibulum
                        id ligula porta felis euismod semper. Morbi leo risus, porta ac consectetur ac,
                        vestibulum at eros. Cum sociis natoque penatibus et magnis dis parturient
                        montes, nascetur ridiculus mus. Nullam id dolor id nibh ultricies vehicula ut id elit.
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cum sociis natoque
                        penatibus et magnis dis parturient montes, nascetur ridiculus mus.
                    </p>
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
