@extends('default')

@section('title', 'Accueil')

@section('head-script')
@endsection


@section('main-content')

    <global-map :regions="{{ $regionsWithAll }}"></global-map>

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
            <div class="columns is-desktop">
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
        <div class="columns is-desktop">
            @foreach ($ads as $ad)
                @include("pages.homepage_ad_thumbnail")
            @endforeach
        </div>
    </section>

    <section class="bg-beige is-flex is-justify-content-center newsletter">
        <div class="columns container is-desktop">
            <div class="column is-three-fifths is-flex is-flex-direction-column is-justify-content-center">
                <h2 class="title">Newsletter Terre de Liens</h2>
                <p>Restez informé des campagnes et de l'actualité en vous inscrivant à la newsletter.</p>
            </div>
            <div class="column is-flex is-flex-direction-column is-justify-content-center">
                <newsletter :csrf_token="'{{ csrf_token() }}'"></newsletter>
            </div>
        </div>
    </section>

@endsection

@section('script')
@endsection
