@extends('default')
@section ('title', 'Réinitialisation mot de passe')

@section('main-content')

    <section class="mh-40 container is-flex is-flex-direction-column is-justify-content-center py-6">
        <div class="columns">
            <div class="column is-half mx-auto">

                <h1 class="title is-2 pb-2">Réinitialisation de votre mot de passe </h1>
                <h2 class="subtitle">Renseignez votre adresse email et votre nouveau mot
                    de
                    passe </h2>

                {!! Form::open(['route'=> 'password.update']) !!}
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="field">
                    <label class="label">Adresse email</label>
                    <p class="control has-icons-left has-icons-right">
                        <input id="email" class="input is-medium is-rounded @error('email') is-danger @enderror" type="email"
                               name="email" value="{{ $email ?? old('email') }}" required autocomplete="email"
                               autofocus
                               placeholder="Votre adresse email...">
                        <span class="icon is-small is-left">
                              <i class="fas fa-envelope"></i>
                            </span>
                    </p>
                </div>

                <div class="field">
                    <label class="label">Votre mot de passe</label>
                    <p class="control has-icons-left has-icons-right">
                        <input id="password" class="input is-medium is-rounded @error('password') is-danger @enderror" type="password"
                               name="password" required autocomplete="new-password" autofocus
                               placeholder="Votre nouveau mot de passe...">
                        <span class="icon is-small is-left">
                              <i class="fas fa-lock"></i>
                            </span>
                    </p>
                </div>

                <div class="field">
                    <label class="label">Confirmation mot de passe</label>
                    <p class="control has-icons-left has-icons-right">
                        <input id="password-confirm" class="input is-medium is-rounded"
                               type="password"
                               name="password_confirmation" required autocomplete="new-password" autofocus
                               placeholder="Saississez à nouveau votre mot de passe...">
                        <span class="icon is-small is-left">
                           <i class="fas fa-lock"></i>
                            </span>
                    </p>
                </div>
                <div class="field pt-3">
                    <div class="control">
                        <button type="submit" class="button is-medium is-primary is-rounded is-fullwidth">Valider</button>
                    </div>
                </div>
                {!! Form::close() !!}

            </div>
        </div>

        </div>
@endsection
