@extends('default')

@section ('title', 'Oops ! Une erreur est survenue.')

@section('main-content')
    <section class="container px-3-mobile">
        <div class="is-flex is-flex-direction-column is-justify-content-space-around my-8 is-align-items-center">
            <h1 class="title">ERREUR {{$exception->getStatusCode()}}</h1>
            <p>C'est peut être dû à une erreur de notre part, une page non trouvée, ou bien une interdiction
                d'accès</p>
            <b-button rounded class="mt-4" tag="a" href="{{route('home')}}">
                Page d'accueil
            </b-button>
        </div>
    </section>
@endsection