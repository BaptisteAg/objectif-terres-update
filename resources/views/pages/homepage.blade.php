@extends('default')

@section('title', 'Accueil')

@section('head-script')
@endsection


@section('main-content')

    <advanced-searchv1 :productions="{{$productionGenres}}" :regions="{{ $regionsWithAll }}"></advanced-searchv1>

    <section class="container mt-6">
        <div class="columns is-desktop">
            <div class="column is-flex-grow-5">
                <h2 class="title">Les annonces à la une</h2>
                <p>Les annonces publiées par Terre de Liens et ses partenaires.</p>
            </div>
            <div class="column">
                <a href="/recherche?ad_category=all&certified=true" class="button is-light is-rounded">Voir toutes les
                    annonces certifiées</a>
            </div>
        </div>
        @if(!$adsPartner->isEmpty())
            <div class="columns columns-slider is-mobile">
                @foreach ($adsPartner as $ad)
                    @include("pages.homepage_ad_thumbnail")
                @endforeach
            </div>
        @else
            <article class="message is-danger">
                <div class="message-body">
                    Aucune annonce à la une
                </div>
            </article>
        @endif
    </section>

    <section class="container mt-5">
        <div class="columns is-desktop mb-5">
            <div class="column is-flex-grow-5">
                <h2 class="title">Les dernières annonces publiées</h2>
            </div>
            <div class="column">
                <a href="/recherche?ad_category=all" class="button is-light is-rounded">Voir toutes les
                    annonces</a>
            </div>
        </div>
        <div class="columns columns-slider is-mobile">
            @foreach ($ads as $ad)
                @include("pages.homepage_ad_thumbnail")
            @endforeach
        </div>
    </section>

    @include('components.newsletter')

    @include('components.partnering')

@endsection

@section('script')
@endsection
