@extends('default')
@section('title', 'Mot de passe oublié')

@section('main-content')

    <section class="mh-40 container is-flex is-flex-direction-column is-justify-content-center py-6">
        <div class="columns">
            <div class="column is-half mx-auto">

                <h1 class="title is-2 pb-2">Mot de passe oublié ? </h1>
                <h2 class="subtitle">Renseignez votre adresse email pour générer un
                    nouveau mot de passe </h2>
{{--                @if(session('status'))--}}
{{--                    <article class="message is-succes" role="alert">--}}
{{--                        <div class="message-body">--}}
{{--                            {{ session('status') }}--}}
{{--                        </div>--}}
{{--                    </article>--}}
{{--                @endif--}}
                {!! Form::open(['route'=>'password.email']) !!}
                <div class="field">
                    <label class="label">Adresse email</label>
                    <p class="control has-icons-left has-icons-right">
                        <input id="email" class="input is-medium is-rounded @error('email') is-danger @enderror"
                               type="email"
                               name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                               placeholder="Votre adresse email...">
                        <span class="icon is-small is-left">
                              <i class="fas fa-envelope"></i>
                            </span>
                    </p>
                </div>

                <div class="field pt-3">
                    <div class="control">
                        <button type="submit" class="button is-medium is-rounded is-primary is-fullwidth">Réinitialiser
                            mon mot de passe
                        </button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </section>
@endsection
