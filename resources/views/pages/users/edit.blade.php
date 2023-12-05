@extends('default')
@section('title', 'Mon compte')

@section('main-content')

    <div id="vue-update-user-form" class="section  pt-0">
        <user-form id="update-form"
                   inline-template
                   :old-values="{{$user }}">
            <div class="container">
                @if($isUserConnectedEditHisOwnAccount)
                    <h1 class="title is-4">Vos informations personnelles</h1>
                    <h2 class="subtitle"> Modifiez si besoin les informations liées à votre compte</h2>
                @else
                    <h1 class="title is-4">Compte de {{$user->first_name ?: ""}} {{$user->name ?: ""}}</h1>
                    <h2 class="subtitle"> Modifiez si besoin les informations liées à ce porteur de projet</h2>
                @endif
                {!! Form::open(['route'=>'user.update', 'method'=>'post']) !!}
                @csrf
                <div class="columns mt-50">
                    <div class="column is-two-fifths">
                        <div class="field">
                            <label class="label">Nom</label>
                            <div class="control has-icons-left">
                                <input id="name" name="name" class="input @error('name')is-danger @enderror"
                                       type="text"
                                       value="{{ old('name') ?: ($user->name ?: "") }}" autocomplete="name"
                                       autofocus
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
                    <div class="column is-two-fifths">
                        <div class="field">
                            <label class="label">Prénom</label>
                            <div class="control has-icons-left">
                                <input id="first_name" name="first_name"
                                       class="input @error('first_name')is-danger @enderror" type="text"
                                       value="{{ old('first_name') ?: ($user->first_name ?: "") }}"
                                       autocomplete="first_name"
                                       autofocus
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
                    <div class="column is-one-fifths">
                        <div class="field">
                            <label class="label">Civilité</label>
                            <div class="control has-icons-left">
                                <div class="select">
                                    <select id="civility" name="civility"
                                            class="input @error('civility') is-danger @enderror ">
                                        <option value="1" {{old('civility') == 1 || $user->civility == 1 ? 'selected' : ''}}>
                                            Madame
                                        </option>
                                        <option value="2" {{old('civility') == 2 || $user->civility == 2 ? 'selected' : ''}}>
                                            Monsieur
                                        </option>
                                        <option value="3" {{old('civility') == 3 || $user->civility == 3 ?'selected' : ''}}>
                                            Autre
                                        </option>
                                    </select>
                                </div>
                                <div class="icon is-small is-left">
                                    <i class="fas fa-user"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="columns">
                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Numéro de téléphone </label>
                            <p class="control has-icons-left has-icons-right">
                                <input id="phone" class="input @error('phone') is-danger @enderror" type="text"
                                       name="phone" value="{{ old('phone') ?: ($user->phone ?: "") }}"
                                       autocomplete="phone" autofocus
                                       placeholder="Numéro de téléphone ...">
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
                    <div class="column ">
                        <div class="field">
                            <label class="label">Adresse email</label>
                            <p class="control has-icons-left has-icons-right">
                                <input id="email"
                                       class="input @error('email') is-danger @enderror"
                                       type="email"
                                       name="email"
                                       value="{{old('email') ?: ($user->email ?: "") }}"
                                       autocomplete="email"
                                       autofocus
                                       placeholder="Adresse email...">
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

                <div class="columns">
                    <div class="column">
                        <div class="field">
                            @if($isUserConnectedEditHisOwnAccount)
                                <label for="profile" class="label">Votre situation</label>
                            @else
                                <label for="profile" class="label">Situation</label>
                            @endif
                            <div class="control has-icons-left">
                                <div class="select">
                                    <select id="profile"
                                            name="profile"
                                            v-model="optionProfileSelected"
                                            class="input @error('profile') is-danger @enderror ">
                                        <option disabled="disabled" selected>Vous êtes...</option>
                                        @foreach(\App\Models\User::$profiles as $id => $prof)
                                            <option
                                                    value="{{$id}}" {{old('profile') === $id || $user->profile === $id ? 'selected' : ''}} >
                                                {{$prof}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="icon is-small is-left">
                                    <i class="fas fa-user"></i>
                                </div>
                            </div>
                            @error('profile')
                            <article class="message is-danger" role="alert">
                                <div class="message-body">
                                    {{ $message }}
                                </div>
                            </article>
                            @enderror
                        </div>
                    </div>
                    <div v-if="optionProfileSelected == {{array_search('autre', \App\Models\User::$profiles)}}"
                         class="column is-half">
                        <div class="field">
                            <label class="label">Situation autre </label>
                            <p class="control has-icons-left has-icons-right">
                                <input id="other_profile"
                                       class="input @error('other_profile') is-danger @enderror"
                                       type="text"
                                       name="other_profile"
                                       value="{{ old('other_profile') ?: ($user->other_profile ?: "") }}"
                                       required
                                       autocomplete="other_profile"
                                       placeholder="Veuillez préciser ...">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-pen"></i>
                                </span>
                            </p>
                            @error('other_profile')
                            <article class="message is-danger" role="alert">
                                <div class="message-body">
                                    {{ $message }}
                                </div>
                            </article>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="columns" v-if="optionProfileSelected == '1' || optionProfileSelected == '2'">
                    @include('auth.partials.inputs.formation')
                    @include('auth.partials.inputs.fromwhere')
                </div>

                <div class="columns">
                    <div class="column is-7">
                        <div class="field">
                            <label class="label">Adresse</label>
                            <p class="control has-icons-left">
                                <input id="street" class="input @error('street') is-danger @enderror" type="text"
                                       name="street" value="{{ old('street') ?: ($user->street ?: "") }}"
                                       autocomplete="street"
                                       autofocus
                                       placeholder="Votre adresse ...">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-map-marker-alt"></i>
                                </span>
                            </p>
                            @error('street')
                            <article class="message is-danger" role="alert">
                                <div class="message-body">
                                    {{ $message }}
                                </div>
                            </article>
                            @enderror
                        </div>
                    </div>
                    <div class="column is-5">
                        <div class="field">
                            <label class="label">Commune et Code postal</label>
                            <autocomplete
                                    name="citySelect"
                                    id="citySelect"
                                    class="@error('city_id') is-danger @enderror"
                                    placeholder="Saisissez les premiers caractères"
                                    ref='citySelect'
                                    src="/locations/cities"
                                    v-model="citySelect">

                                <input type="hidden" name="city_id" :value="zone.value.id"
                                       v-for="(zone,i) in citySelect">

                                <div class="tag autocomplete-input-tag is-info"
                                     v-for="(zone,i) in citySelect"
                                     @click="_ => citySelect.splice(i,1)">
                                    @{{ zone.label }}
                                    &nbsp;&nbsp;
                                    <i class="fa fa-trash" style="cursor:pointer"></i>
                                </div>
                            </autocomplete>
                            @error('city_id')
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
                    <label class="checkbox">
                        <input type="checkbox" name="accept_communication" id="accept_communication"
                               value="1" {{ $user->accept_communication ? 'checked' : '' }}>
                        Recevoir les communications de Terre de Liens
                    </label>
                </div>

                <div class="field">
                    <label class="label">Mot de passe actuel<span v-if="isPasswordToChange">*</span></label>
                    <p class="control has-icons-left">
                        <input id="current-password"
                               v-bind:disabled="! isPasswordToChange"
                               name="current_password"
                               class="input @error('current_password') is-danger @enderror "
                               type="password"
                               required
                               autocomplete="new-password"
                               placeholder="Votre mot de passe..."
                               value="{{ old('current_password') }}"
                               minlength="5">
                        <span class="icon is-small is-left">
                            <i class="fas fa-lock"></i>
                        </span>
                    </p>
                    @error('current_password')
                    <article class="message is-danger" role="alert">
                        <div class="message-body">
                            {{ $message }}
                        </div>
                    </article>
                    @enderror
                </div>
                <div v-if=isPasswordToChange>
                    <div class="field">
                        <label class="label">Nouveau mot de passe*</label>
                        <p class="control has-icons-left">
                            <input id="password"
                                   name="password"
                                   class="input @error('password') is-danger @enderror "
                                   type="password"
                                   required
                                   autocomplete="new-password"
                                   placeholder="Mot de passe..."
                                   value="{{ old('password') }}"
                                   minlength="5">
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
                        <label class="label">Confirmation nouveau mot de passe*</label>
                        <p class="control has-icons-left">
                            <input id="password-confirm"
                                   name="password_confirmation"
                                   class="input"
                                   type="password"
                                   value="{{ old('password_confirmation') }}"
                                   autocomplete="new-password"
                                   required
                                   placeholder="Ressaisissez mot de passe...">
                            <span class="icon is-small is-left">
                                <i class="fas fa-lock"></i>
                            </span>
                        </p>
                    </div>
                </div>
                <br>
                <a @click="show_password_inputs()">
                    <span v-if="isPasswordToChange">Annuler</span>
                    <span v-else>Modifier votre mot de passe</span>
                </a>
                <input type="hidden" value="{{$user->id}}" name="user_id">
                <div class="field is-grouped is-grouped-centered">
                    <div class="control is-pulled-right">
                        <button type="submit" class="button basic primary form-button">Enregistrer</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </user-form>
    </div>
@endsection
