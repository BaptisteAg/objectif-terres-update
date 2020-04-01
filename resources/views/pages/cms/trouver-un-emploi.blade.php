
@extends ('default')

@section ('title', "Trouver un emploi")

@section('head-script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma-carousel@4.0.4/dist/css/bulma-carousel.min.css">
@endsection

@section('main-content')
    <section class="section">
        <div class="container">
            <div class="rows">
                <div class="row is-full">
                    <h1 class="title is-1 has_margin">Trouver un emploi</h1>
                    <p>Le milieu agricole et eget risus varius blandit sit amet non magna. Sed posuere
                        consectetur est at lobortis. Vestibulum id ligula porta felis euismod semper. Duis
                        mollis, est non commodo luctus, nisi erat porttitor ligula,
                    </p>
                </div>
                <div class="row is-full">
                    <h3 class="title is-3 has_margin">Votre plateforme de choix pour le monde agricole</h3>
                    <p>
                        Avec Objectif Terre vous allez être mis en relation avec maecenas faucibus mollis
                        interdum. Maecenas sed diam eget risus varius blandit sit amet non magna. Lorem
                        ipsum dolor sit amet, consectetur adipiscing elit. Sed posuere consectetur est at
                        lobortis. Integer posuere erat a ante venenatis dapibus posuere velit aliquet.
                        Donec sed odio dui.Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor
                        auctor. Nullam quis risus eget urna mollis ornare vel eu leo. Maecenas faucibus
                        mollis interdum. Maecenas sed diam eget risus varius blandit sit amet non magna.
                        Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Nullam quis risus eget
                        urna mollis ornare vel eu leo.
                    </p>
                </div>
            </div>
        </div>
    </section>

    @include('components.multiple-img-block')

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
                    <h2 class="title is-2">Avez-vous besoin d'un conseil ou d'une orientation dans votre recherche d'emploi ?</h2>
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
