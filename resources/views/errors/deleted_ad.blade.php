@extends('default')

@section ('title', 'Cette annonce a été supprimée')

@section('main-content')
    <section class="container px-3-mobile">
        <div class="is-flex is-flex-direction-column is-justify-content-space-around my-8 is-align-items-center">
            <h1 class="title">ERREUR</h1>
            <p class="has-text-centered">
                L'annonce <em>{{ $ad->title ?? "" }}</em> n'est plus disponible.<br>
                Raison:
                @if($ad->trashed())
                    Annonce supprimée
                @else
                    Annonceur supprimé
                @endif
            </p>
            <b-button rounded class="mt-4" tag="a" href="{{ route('home') }}">
                Page d'accueil
            </b-button>
        </div>
    </section>
@endsection
