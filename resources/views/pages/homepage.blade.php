@extends('default')

@section('title', 'Accueil')

@section('head-script')
@endsection


@section('main-content')

    <global-map :regions="{{ $regionsWithAll }}"></global-map>

    <section class="container pt-5">
        <div class="columns is-desktop">
            <div class="column is-flex-grow-5">
                <h2 class="title">Les annonces à la une</h2>
                <p>Les annonces publiées par Terre de Liens et ses partenaires.</p>
            </div>
            <div class="column">
                <a href="/recherche?ad_category=all&certified=true" class="button is-light is-rounded">Voir toutes les
                    annonces à la une</a>
            </div>
        </div>

        <div class="columns is-desktop">
            @foreach ($ads as $ad)
                @include("pages.homepage_ad_thumbnail")
            @endforeach
        </div>
        @if(!$adsPartner->isEmpty())
            <div class="columns is-desktop">
                @foreach ($adsPartner as $ad)
                    @include("pages.homepage_ad_thumbnail")
                @endforeach
            </div>
        @endif
    </section>

@endsection

@section('script')
@endsection
