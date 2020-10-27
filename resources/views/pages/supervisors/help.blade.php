@extends('default')

@section('title', 'Espace aide & ressources | Objectif Terress')


@section('header')
    @include('components.supervisor-tabs')
@endsection

@section('main-content')

    <section class="mb-40">
        <div class="container">
            <h1 class="title is-2">Aide et ressources</h1>
            <p>Retrouvez sur le Centre de Ressources un dossier qui rassemble toutes les aides et informations utiles
                :</p>
            <ul class="ml-30">
                <li><strong>sur le site Objectif Terres</strong> : tutoriel d'utilisation, conditions d'utilisation,
                    etc.
                </li>
                <li>
                    <strong>autour de la modération des annonces</strong> : charte, ensemble des réponses types
                    disponibles, etc.
                </li>
                <li>
                    <strong>autour de l'accompagnement des porteurs de projet</strong> : les différentes fonctionnalités, ce que voit
                    ou non un porteur de projet dans son interface, etc.
                </li>
            </ul>

            <p>Cette section sera mise à jour progressivement. Pour faire remonter une ressource qui n'apparaît pas ici
                : objectif-terres@terredeliens.org </p>
            <p class="is-italic">NB : Les identifiants pour se connecter au Centre de Ressources sont les mêmes que ceux
                que vous utilisez pour vous connecter à Objectif Terres</p>
        </div>

        <div class="container">
            <div class="columns is-centered">
                <div class="column is-one-quarter">
                    <a target="_blank" class="tile__link card"
                       href="{{url('https://ressources.terredeliens.org/les-ressources/utiliser-objectif-terres')}}">
                        <div class="card-image vignette photo">
                            <figure class="">
                                <img class="vignette__image"
                                     src="{{asset('/images/cms/screenshot-objectif-terres.png')}}"
                                     alt="Placeholder image">
                            </figure>
                            <ul class="custom-tags custom-list custom-list_v ">
                                <li class="custom-tag success text_size x-large">
                                    <span>Dossiers</span> <span class="icon has-text-white">
                                        <i class="fas fa-lock-open"></i>
                                    </span>
                                </li>
                            </ul>
                        </div>
                        <div class="card-content  tile__container">
                            <div class="content text_danger_orange tile__content">
                                <h3 class="title is-3 tile__title has-text-danger mt-10">Utiliser Objectif Terres</h3>
                                <p class="button-wrap">
                                    <span class="button round small warning read-more">
                                        <span class="button__icon waves-effect waves-circle waves-light">
                                            <svg class="svg-inline--fa fa-arrow-right fa-w-14" aria-hidden="true"
                                                 data-prefix="fas" data-icon="arrow-right" role="img"
                                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                                 data-fa-i2svg="">
                                                <path fill="currentColor"
                                                      d="M190.5 66.9l22.2-22.2c9.4-9.4 24.6-9.4 33.9 0L441 239c9.4 9.4 9.4 24.6 0 33.9L246.6 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.2-22.2c-9.5-9.5-9.3-25 .4-34.3L311.4 296H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h287.4L190.9 101.2c-9.8-9.3-10-24.8-.4-34.3z"></path>
                                            </svg><!-- <i class="fas fa-arrow-right" aria-hidden="true"></i> -->
                                        </span>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

{{--    <div class="section">--}}
{{--        <h1 class="title is-2 has-text-link">Aide & ressources </h1>--}}
{{--        <div class="container ">--}}
{{--            <div class="content is-medium has-text-justified">--}}
{{--                @if($pageContents->count() > 0)--}}
{{--                    @if($pageContents->has('aide-et-ressources-responsable-territorial-text-dintroduction'))--}}
{{--                        {!!$pageContents['aide-et-ressources-responsable-territorial-text-dintroduction']->content !!}--}}
{{--                    @endif--}}
{{--                @endif--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="container is-fluid">--}}
{{--            @if($pageContents->count() > 0)--}}
{{--                @if($pageContents->has('aide-et-ressources-responsable-territorial-documents-utilisation-site-objectif-terres'))--}}
{{--                    <div class="columns is-centered mt-30 mb-30">--}}
{{--                        <div class="column is-one-third ">--}}
{{--                            <div class="content">--}}
{{--                                <div class="columns is-mobile is-centered">--}}
{{--                                    <div class="column is-three-quarters">--}}
{{--                                        <h2 class="title is-2 ">Utilisation du site d'Objectif Terres</h2>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="column">--}}
{{--                            @if($pageContents['aide-et-ressources-responsable-territorial-documents-utilisation-site-objectif-terres']->documents->count() > 0)--}}
{{--                                <div class="columns is-centered is-multiline">--}}
{{--                                    @foreach($pageContents['aide-et-ressources-responsable-territorial-documents-utilisation-site-objectif-terres']->documents as $document)--}}
{{--                                        <div class="column is-one-third ">--}}
{{--                                            <div class="card">--}}
{{--                                                <div class="card-image">--}}

{{--                                                    <figure class="image is-4by3">--}}
{{--                                                        <a href="{{URL::asset('storage/'.$document->path)}}"--}}
{{--                                                           download="{{$document->name}}">--}}
{{--                                                            @if(strpos($document->type, 'image') !== false)--}}
{{--                                                                <img src="{{URL::asset('storage/'.$document->path)}}"--}}
{{--                                                                     alt="">--}}
{{--                                                            @else--}}
{{--                                                                <img src="/images/placeholder-ad.png" alt="">--}}
{{--                                                            @endif--}}
{{--                                                        </a>--}}
{{--                                                    </figure>--}}
{{--                                                </div>--}}
{{--                                                <div class="card-content is-marginless">--}}
{{--                                                    <p class="title is-4 has-text-centered">{{$document->name}}</p>--}}
{{--                                                    @if($document->type === "application/pdf")--}}
{{--                                                        <p class="subtitle is-6 has-text-grey has-text-centered">Fichier--}}
{{--                                                            pdf</p>--}}
{{--                                                    @elseif($document->type === "application/msword")--}}
{{--                                                        <p class="subtitle is-6 has-text-grey has-text-centered">Fichier--}}
{{--                                                            word</p>--}}
{{--                                                    @elseif(strpos($document->type, 'image') !== false)--}}
{{--                                                        <p class="subtitle is-6 has-text-grey has-text-centered">Fichier--}}
{{--                                                            image</p>--}}
{{--                                                    @endif--}}
{{--                                                    <div class="content has-text-centered">--}}
{{--                                                        <a href="{{URL::asset('storage/'.$document->path)}}"--}}
{{--                                                           class="button is-link is-uppercase"--}}
{{--                                                           download="{{$document->name}}">--}}
{{--                                                            @if($document->type === "application/pdf")--}}
{{--                                                                <i class="fa fa-file-pdf"></i>--}}
{{--                                                            @elseif($document->type === "application/msword")--}}
{{--                                                                <i class="fa fa-file-word"></i>--}}
{{--                                                            @elseif(strpos($document->type, 'image') !== false)--}}
{{--                                                                <i class="far fa-file-image"></i>--}}
{{--                                                            @else--}}
{{--                                                                <i class="fas fa-file"></i>--}}
{{--                                                            @endif--}}
{{--                                                            <span class="ml-5"> Télécharger</span>--}}
{{--                                                        </a>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    @endforeach--}}
{{--                                </div>--}}
{{--                            @else--}}
{{--                                <p>Aucun document à afficher</p>--}}
{{--                            @endif--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--                @if($pageContents->has('aide-et-ressources-responsable-territorial-documents-moderation-des-annonces'))--}}
{{--                    <div class="columns is-centered mt-30 mb-30 ">--}}
{{--                        <div class="column is-one-third ">--}}
{{--                            <div class="content">--}}
{{--                                <div class="columns is-mobile is-centered">--}}
{{--                                    <div class="column is-three-quarters">--}}
{{--                                        <h2 class="title is-2 ">Modération des annonces</h2>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="column">--}}
{{--                            @if($pageContents['aide-et-ressources-responsable-territorial-documents-moderation-des-annonces']->documents->count() > 0)--}}
{{--                                <div class="columns is-centered is-multiline">--}}
{{--                                    @foreach($pageContents['aide-et-ressources-responsable-territorial-documents-moderation-des-annonces']->documents as $document)--}}
{{--                                        <div class="column is-one-third ">--}}
{{--                                            <div class="card">--}}
{{--                                                <div class="card-image">--}}

{{--                                                    <figure class="image is-4by3">--}}
{{--                                                        <a href="{{URL::asset('storage/'.$document->path)}}"--}}
{{--                                                           download="{{$document->name}}">--}}
{{--                                                            @if(strpos($document->type, 'image') !== false)--}}
{{--                                                                <img src="{{URL::asset('storage/'.$document->path)}}"--}}
{{--                                                                     alt="">--}}
{{--                                                            @else--}}
{{--                                                                <img src="/images/placeholder-ad.png" alt="">--}}
{{--                                                            @endif--}}
{{--                                                        </a>--}}
{{--                                                    </figure>--}}
{{--                                                </div>--}}
{{--                                                <div class="card-content is-marginless">--}}
{{--                                                    <p class="title is-4 has-text-centered">{{$document->name}}</p>--}}
{{--                                                    @if($document->type === "application/pdf")--}}
{{--                                                        <p class="subtitle is-6 has-text-grey has-text-centered">Fichier--}}
{{--                                                            pdf</p>--}}
{{--                                                    @elseif($document->type === "application/msword")--}}
{{--                                                        <p class="subtitle is-6 has-text-grey has-text-centered">Fichier--}}
{{--                                                            word</p>--}}
{{--                                                    @elseif(strpos($document->type, 'image') !== false)--}}
{{--                                                        <p class="subtitle is-6 has-text-grey has-text-centered">Fichier--}}
{{--                                                            image</p>--}}
{{--                                                    @endif--}}
{{--                                                    <div class="content has-text-centered">--}}
{{--                                                        <a href="{{URL::asset('storage/'.$document->path)}}"--}}
{{--                                                           class="button is-link is-uppercase"--}}
{{--                                                           download="{{$document->name}}">--}}
{{--                                                            @if($document->type === "application/pdf")--}}
{{--                                                                <i class="fa fa-file-pdf"></i>--}}
{{--                                                            @elseif($document->type === "application/msword")--}}
{{--                                                                <i class="fa fa-file-word"></i>--}}
{{--                                                            @elseif(strpos($document->type, 'image') !== false)--}}
{{--                                                                <i class="far fa-file-image"></i>--}}
{{--                                                            @else--}}
{{--                                                                <i class="fas fa-file"></i>--}}
{{--                                                            @endif--}}
{{--                                                            <span class="ml-5"> Télécharger</span>--}}
{{--                                                        </a>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    @endforeach--}}
{{--                                </div>--}}
{{--                            @else--}}
{{--                                <p>Aucun document à afficher</p>--}}
{{--                            @endif--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--                @if($pageContents->has('aide-et-ressources-responsable-territorial-documents-gestion-des-accompagnements'))--}}
{{--                    <div class="columns is-centered mt-30 mb-30">--}}
{{--                        <div class="column is-one-third ">--}}
{{--                            <div class="content">--}}
{{--                                <div class="columns is-mobile is-centered">--}}
{{--                                    <div class="column is-three-quarters">--}}
{{--                                        <h2 class="title is-2 ">Gestion des accompagnements</h2>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="column">--}}
{{--                            @if($pageContents['aide-et-ressources-responsable-territorial-documents-gestion-des-accompagnements']->documents->count() > 0)--}}
{{--                                <div class="columns is-centered is-multiline">--}}
{{--                                    @foreach($pageContents['aide-et-ressources-responsable-territorial-documents-gestion-des-accompagnements']->documents as $document)--}}
{{--                                        <div class="column is-one-third ">--}}
{{--                                            <div class="card">--}}
{{--                                                <div class="card-image">--}}

{{--                                                    <figure class="image is-4by3">--}}
{{--                                                        <a href="{{URL::asset('storage/'.$document->path)}}"--}}
{{--                                                           download="{{$document->name}}">--}}
{{--                                                            @if(strpos($document->type, 'image') !== false)--}}
{{--                                                                <img src="{{URL::asset('storage/'.$document->path)}}"--}}
{{--                                                                     alt="">--}}
{{--                                                            @else--}}
{{--                                                                <img src="/images/placeholder-ad.png" alt="">--}}
{{--                                                            @endif--}}
{{--                                                        </a>--}}
{{--                                                    </figure>--}}
{{--                                                </div>--}}
{{--                                                <div class="card-content is-marginless">--}}
{{--                                                    <p class="title is-4 has-text-centered">{{$document->name}}</p>--}}
{{--                                                    @if($document->type === "application/pdf")--}}
{{--                                                        <p class="subtitle is-6 has-text-grey has-text-centered">Fichier--}}
{{--                                                            pdf</p>--}}
{{--                                                    @elseif($document->type === "application/msword")--}}
{{--                                                        <p class="subtitle is-6 has-text-grey has-text-centered">Fichier--}}
{{--                                                            word</p>--}}
{{--                                                    @elseif(strpos($document->type, 'image') !== false)--}}
{{--                                                        <p class="subtitle is-6 has-text-grey has-text-centered">Fichier--}}
{{--                                                            image</p>--}}
{{--                                                    @endif--}}
{{--                                                    <div class="content has-text-centered">--}}
{{--                                                        <a href="{{URL::asset('storage/'.$document->path)}}"--}}
{{--                                                           class="button is-link is-uppercase"--}}
{{--                                                           download="{{$document->name}}">--}}
{{--                                                            @if($document->type === "application/pdf")--}}
{{--                                                                <i class="fa fa-file-pdf"></i>--}}
{{--                                                            @elseif($document->type === "application/msword")--}}
{{--                                                                <i class="fa fa-file-word"></i>--}}
{{--                                                            @elseif(strpos($document->type, 'image') !== false)--}}
{{--                                                                <i class="far fa-file-image"></i>--}}
{{--                                                            @else--}}
{{--                                                                <i class="fas fa-file"></i>--}}
{{--                                                            @endif--}}
{{--                                                            <span class="ml-5"> Télécharger</span>--}}
{{--                                                        </a>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    @endforeach--}}
{{--                                </div>--}}
{{--                            @else--}}
{{--                                <p>Aucun document à afficher</p>--}}
{{--                            @endif--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--            @endif--}}

{{--        </div>--}}
{{--    </div>--}}
{{--    <section class=" has-background-white-ter pt-50 pb-50">--}}
{{--        <div class="hero-body">--}}
{{--            <div class="container has-text-centered">--}}
{{--                <h1 class="title">--}}
{{--                    Besoin de prendre contact avec d'autres membres d'Objectif Terres?--}}
{{--                </h1>--}}
{{--                <h2 class="subtitle">--}}
{{--                    Démarrez une nouvelle discussion avec un ou plusieurs membres d'Objectif Terres--}}
{{--                </h2>--}}
{{--                <div id="vue-supervisor-help-new-message-modal">--}}
{{--                    <vue-threads inline-template>--}}
{{--                        <div>--}}
{{--                            <button class="open-modal-new-message button is-link ">--}}
{{--                                <span class="icon is-small">--}}
{{--                                    <i class="fa fa-paper-plane" aria-hidden="true"></i>--}}
{{--                                </span>--}}
{{--                                <span> Envoyer un message</span>--}}
{{--                            </button>--}}
{{--                            @include('pages.messages.partials.newMessageModal')--}}
{{--                        </div>--}}
{{--                    </vue-threads>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}

@endsection

{{--@section('script')--}}
{{--    <script>--}}
{{--        const vueThreads = new Vue({--}}
{{--            el: '#vue-supervisor-help-new-message-modal',--}}
{{--            name: 'content'--}}
{{--        });--}}

{{--        let buttons = document.querySelectorAll('.open-modal-new-message');--}}
{{--        buttons.forEach((button) => {--}}
{{--            button.addEventListener('click', function (event) {--}}
{{--                event.preventDefault();--}}
{{--                let modal = document.querySelector('.modal');--}}
{{--                let html = document.querySelector('html');--}}
{{--                modal.classList.add('is-active');--}}
{{--                html.classList.add('is-clipped');--}}
{{--            });--}}
{{--        });--}}
{{--        let modal = document.querySelector('.modal');--}}
{{--        let html = document.querySelector('html');--}}
{{--        modal.querySelector('.modal-background').addEventListener('click', function (e) {--}}
{{--            e.preventDefault();--}}
{{--            modal.classList.remove('is-active');--}}
{{--            html.classList.remove('is-clipped');--}}
{{--        });--}}
{{--        modal.querySelector('#close-modal').addEventListener('click', function (e) {--}}
{{--            e.preventDefault();--}}
{{--            modal.classList.remove('is-active');--}}
{{--            html.classList.remove('is-clipped');--}}
{{--        });--}}

{{--    </script>--}}
{{--@endsection--}}
