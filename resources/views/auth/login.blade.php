@extends('default')
@section('title', 'Connexion')

@section('main-content')

    <div class="section" id="vue-login-page">
        <div class="container">
            <div class="columns is-mobile is-centered">
                <div class="column is-half">
                    <h1 class="title is-2 has-text-centered text_primary">Connexion </h1>
                    <h2 class="subtitle has-text-centered text_charcoal">Identifiez-vous pour accéder à votre compte Objectif
                        Terres </h2>
                    <login-form
                            :old-values="{{json_encode(count(old()) ? old() : new stdClass)}}"
                            inline-template>
                        {!! Form::open(['route'=>'login', 'v-on:submit'=>'onValidate']) !!}
                        @csrf
                        <div class="field">
                            <label class="label">Adresse email</label>
                            <p class="control has-icons-left has-icons-right">
                                <input id="email" class="input @error('email') is-danger @enderror"
                                       type="email"
                                       name="email"
                                       v-model="email"
                                       v-on:change="onEmailChange"
                                       required
                                       autocomplete="email"
                                       autofocus
                                       placeholder="Votre adresse email...">
                                <span class="icon is-small is-left">
                                  <i class="fas fa-envelope"></i>
                                </span>
                            </p>
                            @error('email')
                            <article class="message is-danger" role="alert">
                                <div class="message-body">
                                    {{ $message }}
                                </div>
                            </article>
                            @enderror
                        </div>
                        <div class="field" v-if="hasPassedCheckpoint">
                            <label class="label">Mot de passe</label>
                            <p class="control has-icons-left">
                                <input name="password" class="input @error('password') is-danger @enderror "
                                       type="password" required
                                       autocomplete="current-password" placeholder="Votre mot de passe...">
                                <span class="icon is-small is-left">
								  <i class="fas fa-lock"></i>
								</span>
                            </p>
                            @error('password')
                            <article class="message is-danger" role="alert">
                                <div class="message-body">
                                    {{ $message }}
                                </div>
                            </article>
                            @enderror
                        </div>

                        <div class="field is-grouped is-flex" style="justify-content: space-between;">
                            <div class="control">
                                <a href="{{ route('password.request') }}" class="button basic secondary form-button">
                                    Mot de
                                    passe
                                    oublié ?</a>
                            </div>
                            <div class="control">
                                <button type="submit" class="button basic primary form-button" :disabled="isLoading">
                                    <template v-if="isLoading">
                                        Chargement&nbsp;&nbsp;&nbsp;
                                        <span class="icon is-small right">
                                        <i class="fas fa-spinner fa-spin"></i>
                                    </span>
                                    </template>
                                    <template v-else-if="hasPassedCheckpoint">
                                        Valider
                                    </template>
                                    <template v-else>
                                        Suivant
                                    </template>
                                </button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </login-form>

                    <div class="section">
                        <h4 class="title is-4 has-text-centered">Vous n'avez pas encore de compte ?</h4>
                        <p class="has-text-centered">
                            <a class="button is-bordered basic secondary form-button" href="{{route('register')}}">Créer un compte</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="column"></div>
        </div>
    </div>
    @include('components.support-terre-liens')

@endsection

@section('script')
    <script>
        const vueLoginPage = new Vue({
            el: '#vue-login-page',
            name: 'content'
        });
    </script>
@endsection
