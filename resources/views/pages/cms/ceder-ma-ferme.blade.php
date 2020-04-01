
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
                    <h3 class="title is-3 has_margin">Votre ferme continuera à exister grâce à un projet solide</h3>
                    <p>
                        Terre de Lien est là pour vous aider à trouver le candidat parfait pour reprendre
                        votre ferme, maecenas faucibus mollis interdum. Maecenas sed diam eget risus
                        varius blandit sit amet non magna. Lorem ipsum dolor sit amet, consectetur
                        adipiscing elit. Sed posuere consectetur est at lobortis. Integer posuere erat a
                        ante venenatis dapibus posuere velit aliquet. Donec sed odio dui.Vivamus sagittis
                        lacus vel augue laoreet rutrum faucibus dolor auctor. Nullam quis risus eget urna
                        mollis ornare vel eu leo. Maecenas faucibus mollis interdum. Maecenas sed diam
                        eget risus varius blandit sit amet non magna. Morbi leo risus, porta ac consectetur
                        ac, vestibulum at eros. Nullam quis risus eget urna mollis ornare vel eu leo.
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

    <section class="section contactus-background">
        <div class="container">
            <div class="columns">
                <div class="column is-6">
                    <h2 class="title is-2">Trouvez le candidat idéal pour votre projet de cession.</h2>
                    <p>
                        Votre meilleur option pour réaliser avec succès votre cession c’est de nous
                        faire confiance. Avec nous une chose est sûre : vous êtes accompagné et suivi
                        du début de votre projet jusqu’à son aboutissement.
                    </p>
                    <br>
                    <p>
                        Notre réseau territorial, nos bénévoles et nos partenaires sont tous là pour
                        vous aider à trouver le meilleur candidat en mesure de reprendre votre
                        ferme avec un projet sérieux et solide à la base.
                    </p>
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
