@extends('default')
@section('title', 'Inscription')

@section('main-content')
    <div class="section">
        <div class="container">
            <div class="columns is-mobile is-centered">
                <div class="column is-two-thirds">
                    <h1 class="title is-2 has-text-centered has-text-link">Inscription </h1>
                    <h2 class="subtitle has-text-centered">Créez votre compte pour profiter des services d'Objectif
                        Terres </h2>

                    {!! Form::open(['route'=>'register']) !!}
                    @csrf

                    <div class="columns">
                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Votre nom</label>
                                <div class="control has-icons-left">
                                    <input id="name" name="name" class="input @error('name')is-danger @enderror"
                                           type="text"
                                           value="{{ old('name') }}" required autocomplete="name" autofocus
                                           placeholder="Votre nom...">
                                    <span class="icon is-small is-left">
                                     <i class="fas fa-user"></i>
                                    </span>
                                </div>
                                @error('name')
                                <article class="message is-danger" role="alert">
                                    <div class="message-body">
                                        {{ $message }}
                                    </div>
                                </article>
                                @enderror
                            </div>
                        </div>
                        <div class="column">
                            <div class="field">
                                <label class="label">Votre prénom</label>
                                <div class="control has-icons-left">
                                    <input id="first_name" name="first_name"
                                           class="input @error('first_name')is-danger @enderror" type="text"
                                           value="{{ old('first_name') }}" required autocomplete="first_name" autofocus
                                           placeholder="Votre prénom...">
                                    <span class="icon is-small is-left">
                                     <i class="fas fa-user"></i>
                                    </span>
                                </div>
                                @error('first_name')
                                <article class="message is-danger" role="alert">
                                    <div class="message-body">
                                        {{ $message }}
                                    </div>
                                </article>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column is-half">
                            <div class="field">
                                <label class="label">Numéro de téléphone </label>
                                <p class="control has-icons-left has-icons-right">
                                    <input id="phone" class="input @error('phone') is-danger @enderror" type="text"
                                           name="phone" value="{{ old('phone') }}" autocomplete="phone" autofocus
                                           placeholder="Votre numéro de téléphone ...">
                                    <span class="icon is-small is-left">
                           <i class="fas fa-phone"></i>
                            </span>
                                </p>
                                @error('phone')
                                <article class="message is-danger" role="alert">
                                    <div class="message-body">
                                        {{ $message }}
                                    </div>
                                </article>
                                @enderror
                            </div>
                        </div>
                        <div class="column">
                            <div class="field">
                                <label class="label">Adresse email</label>
                                <p class="control has-icons-left has-icons-right">
                                    <input id="email" class="input @error('email') is-danger @enderror" type="email"
                                           name="email" value="{{ old('email') }}" required autocomplete="email"
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
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Adresse </label>
                        <p class="control has-icons-left has-icons-right">
                            <input id="address" class="input @error('address') is-danger @enderror" type="text"
                                   name="address" value="{{ old('address') }}" required autocomplete="address"
                                   autofocus
                                   placeholder="Votre adresse ...">
                            <span class="icon is-small is-left">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </span>
                        </p>
                        @error('address')
                        <article class="message is-danger" role="alert">
                            <div class="message-body">
                                {{ $message }}
                            </div>
                        </article>
                        @enderror
                    </div>
                    <div class="columns">
                        <div class="column is-two-thirds">
                            <div class="field">
                                <label class="label">Ville ou code postal</label>
                                <div id="vue-render">
                                    <ajax-multi-select
                                            :multiple="true"
                                            selected-count-text="Ville sélectionnée"
                                            placeholder="Choississez une ville"
                                            name-option-label="villes"
                                            src="/json/cities"
                                            name="cities_location_researches[]">
                                    </ajax-multi-select>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="field">
                                <label class="label">Pays</label>
                                <div class="control has-icons-left">
                                    <div class="select">
                                        <select id="country_id" name="country_id"
                                                class="input @error('country_id') is-danger @enderror "
                                                autocomplete="new-password">
                                            <option disabled="disabled" selected>Choississez votre pays...</option>
                                            @foreach($countries as $country)
                                                <option value="{{$country->id}}">{{$country->name_fr_fr}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="icon is-small is-left">
                                        <i class="fas fa-globe"></i>
                                    </div>
                                </div>
                                @error('country_id')
                                <article class="message is-danger" role="alert">
                                    <div class="message-body">
                                        {{ $message }}
                                    </div>
                                </article>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Mot de passe</label>
                        <p class="control has-icons-left">
                            <input id="password" name="password" class="input @error('password') is-danger @enderror "
                                   type="password"
                                   required
                                   autocomplete="new-password" placeholder="Votre mot de passe...">
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
                    <div class="field">
                        <label class="label">Confirmation mot de passe</label>
                        <p class="control has-icons-left">
                            <input id="password-confirm" name="password_confirmation"
                                   class="input" type="password"
                                   autocomplete="new-password"
                                   required
                                   placeholder="Ressaisissez mot de passe...">
                            <span class="icon is-small is-left">
                              <i class="fas fa-lock"></i>
                            </span>
                        </p>
                    </div>
                    <div class="field">
                        <label class="checkbox">
                            <input type="checkbox" required>
                            "J'ai pris connaissance de <a>la charte d'utilisation de la plateforme d'annonces du site
                                web de
                                Terre de Liens</a> ."
                        </label>
                    </div>
                    <div class="field">
                        <label class="checkbox">
                            <input type="checkbox" name="accept_communication" id="accept_communication"
                                   value="1">
                            J'accepte de recevoir les communications de Terre de Liens
                        </label>
                    </div>
                    <div class="field is-grouped is-centered">
                        <div class="control">
                            <button type="submit" class="button is-link">Valider</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                    <div class="section">
                        <h4 class="title is-4 has-text-centered">Vous avez déjà un compte ?</h4>
                        <p class="has-text-centered"><a href="{{route('signIn')}}">Se connecter</a></p>
                    </div>
                </div>
            </div>
            <div class="column"></div>
        </div>
    </div>
    @include('components.supportTerreLiens')

@endsection


}
