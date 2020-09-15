@extends('default')

@section('title', 'Espace aide & ressources | Objectifs Terres')


@section('header')
    @include('components.supervisor-tabs')
@endsection

@section('main-content')

    <div class="section">
        <h1 class="title is-2 has-text-link">Aide & ressources </h1>
        <div class="container ">
            <div class="content is-medium has-text-justified">
                @if(isset($pageContent))
                    {!! $pageContent->content !!}
                @endif
            </div>
            <br>
            <br>
        </div>
        <div class="container is-fluid">
            <div class="columns is-centered">
                <div class="column is-one-third ">
                    <div class="content">
                        <div class="columns is-mobile is-centered">
                            <div class="column is-three-quarters">
                                <h2 class="title is-2 has-text-link">Conseiller un primo-accueillant</h2>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores cupiditate
                                    debitis
                                    deleniti dicta, error exercitationem fugit illo labore laudantium modi</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="columns is-centered">
                        @for ($i = 0; $i < 3; $i++)
                            <div class="column is-one-third ">
                                <div class="card">
                                    <div class="card-image">
                                        <figure class="image is-4by3">
                                            <a href="/" download="rapport2019"><img src="/images/placeholder-ad.png"
                                                                                    alt=""></a>
                                        </figure>
                                    </div>
                                    <div class="card-content is-marginless">
                                        <p class="title is-4 has-text-centered">Titre du document</p>
                                        <p class="subtitle is-6 has-text-grey">Lorem ipsum dolor sit amet, consectetur
                                            adipisicing
                                            elit. Accusamus corporis deleniti </p>
                                        <div class="content has-text-centered">
                                            <a href="/" class="button is-link is-uppercase"
                                               download="rapport2019">Télécharger</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <section class=" has-background-white-ter pt-50 pb-50">
        <div class="hero-body">
            <div class="container has-text-centered">
                <h1 class="title">
                    Besoin de prendre contact avec d'autres membres d'Objectif Terres?
                </h1>
                <h2 class="subtitle">
                    Démarrez une nouvelle discussion avec un ou plusieurs membres d'Objectif Terres
                </h2>
                <div id="vue-supervisor-help-new-message-modal">
                    <vue-threads inline-template>
                        <div>
                            <button class="open-modal-new-message button is-link " >
                                <span class="icon is-small">
                                    <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                </span>
                                <span> Envoyer un message</span>
                            </button>
                            @include('pages.messages.partials.newMessageModal')
                        </div>
                    </vue-threads>
                </div>
            </div>
        </div>
    </section>
    <br>
    <div class="section">
        <div class="container is-fluid">
            <div class="section">
                <div class="columns is-centered ">
                    <div class="column is-one-third ">
                        <div class="content">
                            <div class="columns is-mobile is-centered">
                                <div class="column is-three-quarters">
                                    <h2 class="title is-2 has-text-link">Conseils sur la gestion de votre
                                        territoire</h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores cupiditate
                                        debitis
                                        deleniti dicta, error exercitationem fugit illo labore laudantium modi</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="columns is-centered">
                            @for ($i = 0; $i < 3; $i++)
                                <div class="column is-one-third ">
                                    <div class="card">
                                        <div class="card-image">
                                            <figure class="image is-4by3">
                                                <a href="/" download="rapport2019"><img src="/images/placeholder-ad.png"
                                                                                        alt=""></a>
                                            </figure>
                                        </div>
                                        <div class="card-content is-marginless">
                                            <p class="title is-4 has-text-centered">Titre du document</p>
                                            <p class="subtitle is-6 has-text-grey">Lorem ipsum dolor sit amet,
                                                consectetur
                                                adipisicing
                                                elit. Accusamus corporis deleniti </p>
                                            <div class="content has-text-centered">
                                                <a href="/" class="button is-link is-uppercase"
                                                   download="rapport2019">Télécharger</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
            <div class="section">
                <div class="columns is-centered">
                    <div class="column is-one-third ">
                        <div class="content">
                            <div class="columns is-mobile is-centered">
                                <div class="column is-three-quarters">
                                    <h2 class="title is-2 has-text-link">Utilisation du site d'Objectif Terres</h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores cupiditate
                                        debitis
                                        deleniti dicta, error exercitationem fugit illo labore laudantium modi</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="columns is-centered">
                            @for ($i = 0; $i < 3; $i++)
                                <div class="column is-one-third ">
                                    <div class="card">
                                        <div class="card-image">
                                            <figure class="image is-4by3">
                                                <a href="/" download="rapport2019"><img src="/images/placeholder-ad.png"
                                                                                        alt=""></a>
                                            </figure>
                                        </div>
                                        <div class="card-content is-marginless">
                                            <p class="title is-4 has-text-centered">Titre du document</p>
                                            <p class="subtitle is-6 has-text-grey">Lorem ipsum dolor sit amet,
                                                consectetur
                                                adipisicing
                                                elit. Accusamus corporis deleniti </p>
                                            <div class="content has-text-centered">
                                                <a href="/" class="button is-link is-uppercase"
                                                   download="rapport2019">Télécharger</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
            <br>
        </div>
    </div>

@endsection

@section('script')
    <script>
        const vueThreads = new Vue({
            el: '#vue-supervisor-help-new-message-modal',
            name: 'content'
        });

        let buttons = document.querySelectorAll('.open-modal-new-message');
        buttons.forEach((button) => {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                let modal = document.querySelector('.modal');
                let html = document.querySelector('html');
                modal.classList.add('is-active');
                html.classList.add('is-clipped');
            });
        });
        let modal = document.querySelector('.modal');
        let html = document.querySelector('html');
        modal.querySelector('.modal-background').addEventListener('click', function (e) {
            e.preventDefault();
            modal.classList.remove('is-active');
            html.classList.remove('is-clipped');
        });
        modal.querySelector('#close-modal').addEventListener('click', function (e) {
            e.preventDefault();
            modal.classList.remove('is-active');
            html.classList.remove('is-clipped');
        });

    </script>
@endsection
