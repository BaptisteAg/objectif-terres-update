@extends('default')

@section('title', 'Espace aide & ressources ')


@section('header')
    @include('components.moderator-tabs')
@endsection

@section('main-content')

    <div class="section">
        <h1 class="title is-2 has-text-link">Aide & ressources </h1>
        <div class="container ">
            <div class="content is-medium has-text-justified">
                @if($pageContents->count() > 0)
                    @if($pageContents->has('aide-et-ressources-moderateur-text-dintroduction'))
                        {!!$pageContents['aide-et-ressources-moderateur-text-dintroduction']->content !!}
                    @endif
                @endif
            </div>
            <br>
            <br>
        </div>
    </div>
    <div class="">
        <div class="container is-fluid">
            @if($pageContents->count() > 0)
                @if($pageContents->has('aide-et-ressources-moderateur-documents-moderation-des-annonces'))
                    <div class="mb-30">
                        <div class="columns is-centered ">
                            <div class="column is-one-third ">
                                <div class="content">
                                    <div class="columns is-mobile is-centered">
                                        <div class="column is-three-quarters">
                                            <h2 class="title is-2 ">Modération des annonces </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                @if($pageContents['aide-et-ressources-moderateur-documents-moderation-des-annonces']->documents->count() > 0)
                                <div class="columns is-centered is-multiline">
                                    @foreach($pageContents['aide-et-ressources-moderateur-documents-moderation-des-annonces']->documents as $document)
                                        <div class="column is-one-third ">
                                            <div class="card">
                                                <div class="card-image">

                                                    <figure class="image is-4by3">
                                                        <a href="{{URL::asset('storage/'.$document->path)}}"
                                                           download="{{$document->name}}">
                                                            @if(strpos($document->type, 'image') !== false)
                                                                <img src="{{URL::asset('storage/'.$document->path)}}"
                                                                     alt="">
                                                            @else
                                                                <img src="/images/placeholder-ad.png" alt="">
                                                            @endif
                                                        </a>
                                                    </figure>
                                                </div>
                                                <div class="card-content is-marginless">
                                                    <p class="title is-4 has-text-centered">{{$document->name}}</p>
                                                    @if($document->type === "application/pdf")
                                                        <p class="subtitle is-6 has-text-grey has-text-centered">Fichier
                                                            pdf</p>
                                                    @elseif($document->type === "application/msword")
                                                        <p class="subtitle is-6 has-text-grey has-text-centered">Fichier
                                                            word</p>
                                                    @elseif(strpos($document->type, 'image') !== false)
                                                        <p class="subtitle is-6 has-text-grey has-text-centered">Fichier
                                                            image</p>
                                                    @endif
                                                    <div class="content has-text-centered">
                                                        <a href="{{URL::asset('storage/'.$document->path)}}"
                                                           class="button is-link is-uppercase"
                                                           download="{{$document->name}}">
                                                            @if($document->type === "application/pdf")
                                                                <i class="fa fa-file-pdf"></i>
                                                            @elseif($document->type === "application/msword")
                                                                <i class="fa fa-file-word"></i>
                                                            @elseif(strpos($document->type, 'image') !== false)
                                                                <i class="far fa-file-image"></i>
                                                            @else
                                                                <i class="fas fa-file"></i>
                                                            @endif
                                                            <span class="ml-5"> Télécharger</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @else
                                    <p>Aucun document à afficher</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
                @if($pageContents->has('aide-et-ressources-moderateur-documents-utilisation-du-site'))
                    <div class="mt-60">
                        <div class="columns is-centered">
                            <div class="column is-one-third ">
                                <div class="content">
                                    <div class="columns is-mobile is-centered">
                                        <div class="column is-three-quarters">
                                            <h2 class="title is-2 ">Utilisation du site d'Objectif Terres</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                @if($pageContents['aide-et-ressources-moderateur-documents-utilisation-du-site']->documents->count() >0)
                                    <div class="columns is-centered">
                                        @foreach($pageContents['aide-et-ressources-moderateur-documents-utilisation-du-site']->documents as $document)
                                            <div class="column is-one-third ">
                                                <div class="card">
                                                    <div class="card-image">

                                                        <figure class="image is-4by3">
                                                            <a href="{{URL::asset('storage/'.$document->path)}}"
                                                               download="{{$document->name}}">
                                                                @if(strpos($document->type, 'image') !== false)
                                                                    <img src="{{URL::asset('storage/'.$document->path)}}"
                                                                         alt="">
                                                                @else
                                                                    <img src="/images/placeholder-ad.png" alt="">
                                                                @endif
                                                            </a>
                                                        </figure>
                                                    </div>
                                                    <div class="card-content is-marginless">
                                                        <p class="title is-4 has-text-centered">{{$document->name}}</p>
                                                        @if($document->type === "application/pdf")
                                                            <p class="subtitle is-6 has-text-grey has-text-centered">
                                                                Fichier
                                                                pdf</p>
                                                        @elseif($document->type === "application/msword")
                                                            <p class="subtitle is-6 has-text-grey has-text-centered">
                                                                Fichier
                                                                word</p>
                                                        @elseif(strpos($document->type, 'image') !== false)
                                                            <p class="subtitle is-6 has-text-grey has-text-centered">
                                                                Fichier
                                                                image</p>
                                                        @endif
                                                        <div class="content has-text-centered">
                                                            <a href="{{URL::asset('storage/'.$document->path)}}"
                                                               class="button is-link is-uppercase"
                                                               download="{{$document->name}}">
                                                                @if($document->type === "application/pdf")
                                                                    <i class="fa fa-file-pdf"></i>
                                                                @elseif($document->type === "application/msword")
                                                                    <i class="fa fa-file-word"></i>
                                                                @elseif(strpos($document->type, 'image') !== false)
                                                                    <i class="far fa-file-image"></i>
                                                                @else
                                                                    <i class="fas fa-file"></i>
                                                                @endif
                                                                <span class="ml-5"> Télécharger</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p>Aucun document à afficher</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <p>Aucun document à afficher</p>
            @endif
            <br>
        </div>
    </div>
    <section class="hero has-background-white-ter">
        <div class="hero-body">
            <div class="container has-text-centered">
                <h1 class="title">
                    Besoin de prendre contact avec d'autres membres d'Objectif Terres?
                </h1>
                <h2 class="subtitle">
                    Démarrez une nouvelle discussion avec un ou plusieurs membres d'Objectif Terres
                </h2>
                <div id="vue-moderator-help-new-message-modal">
                    <vue-threads inline-template>
                        <div>
                            <button class="open-modal-new-message button is-link is-large" type="button">
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

@endsection

@section('script')
    <script>
        const vueThreads = new Vue({
            el: '#vue-moderator-help-new-message-modal',
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
