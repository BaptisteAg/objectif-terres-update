@extends('default')

@section ('title', 'Oops ! Une erreur est survenue.')

@section('main-content')
    <div class="section pt-0">
        <div class="container">
            <div class="columns is-mobile is-centered">
                <div class="column is-two-thirds">
                    <h1 class="page__title">Erreur {{$exception->getStatusCode()}} </h1>
                    <h2 class="page__subtitle">
                        Une erreur est survenue.
                    </h2>
                    <p class="has-text-centered">
                        C'est peut être dû à une erreur de notre part, une page non trouvée, ou bien une interdiction d'accès.
                    </p>
                    <br>
                    <br>
                </div>
            </div>
        </div>
@endsection