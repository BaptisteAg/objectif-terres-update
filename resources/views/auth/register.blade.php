@extends('default')
@section('title', 'Inscription')

@section('main-content')
    <div id="vue-register-form" class="section">
        <user-form id="register-form"
                   inline-template
                   :old-values="{{json_encode(count(old()) ? old() : new stdClass)}}">
            <div class="container">
                <div class="columns is-mobile is-centered">
                    <div class="column is-two-thirds">
                        <h1 class="title is-2 has-text-centered text_primary">Inscription </h1>
                        <h2 class="subtitle has-text-centered text_charcoal">Créez votre compte pour profiter des
                            services d'Objectif
                            Terres </h2>
                        <p class="is-size-7 text_charcoal">Les champs marqués d'un astérisque <strong>(*)</strong> sont
                            obligatoires.
                        </p>
                        <br>
                        {!! Form::open(['route'=>'register']) !!}
                        @csrf
                        <div class="columns">
                            <div class="column is-one-fifths">
                                @include('auth.partials.inputs.civility')
                            </div>
                            <div class="column is-two-fifths">
                                @include('auth.partials.inputs.lastname')

                            </div>
                            <div class="column is-two-fifths">
                                @include('auth.partials.inputs.firstname')
                            </div>
                        </div>
                        <div class="columns">
                            <div class="column is-half">
                                @include('auth.partials.inputs.phone')
                            </div>
                            <div class="column ">
                                @include('auth.partials.inputs.email')
                            </div>
                        </div>
                        <div class="columns">
                            <div class="column is-7">
                                @include('auth.partials.inputs.address')
                            </div>
                            <div class="column is-5">
                                @include('auth.partials.inputs.zipcode')
                            </div>
                        </div>
                        <div class="columns">
                            @include('auth.partials.inputs.profile')
                        </div>



                        {{--								TODO delete if information about country is not necessary
                                                                <div class="field">--}}
                        {{--									<label class="label">Pays*</label>--}}
                        {{--									<div class="control has-icons-left">--}}
                        {{--										<div class="select">--}}
                        {{--											<select id="country_id" name="country_id"--}}
                        {{--													class="input @error('country_id') is-danger @enderror "--}}
                        {{--													required>--}}
                        {{--												<option disabled="disabled" selected>Choississez votre pays...</option>--}}
                        {{--												@foreach($countries as $country)--}}
                        {{--													<option value="{{$country->id}}" {{old('country_id') == $country->id ? 'selected' : ''}}>{{$country->name_fr_fr}}</option>--}}
                        {{--												@endforeach--}}
                        {{--											</select>--}}
                        {{--										</div>--}}
                        {{--										<div class="icon is-small is-left">--}}
                        {{--											<i class="fas fa-globe"></i>--}}
                        {{--										</div>--}}
                        {{--									</div>--}}
                        {{--								</div>--}}
                        @include('auth.partials.inputs.password')

                        <div class="field">
                            <label class="checkbox">
                                <input type="checkbox" required>
                                <span>J'ai pris connaissance de
                                    <a href="{{URL::asset('docs/OT_charte_oct2020.pdf')}}" target="_blank"> la charte
                                        d'utilisation de la plateforme d'annonces du site web de Terre de Liens</a>
                                    .* </span>
                            </label>
                        </div>
                        <div class="field">
                            <label class="checkbox">
                                <input type="checkbox"
                                       name="accept_communication"
                                       id="accept_communication"
                                       value="1"
                                        {{old('accept_communication') === "1" ? "checked" : ''}}>
                                J'accepte de recevoir les communications de Terre de Liens
                            </label>
                        </div>

                        <p>En appuyant sur valider, vous consentez <a href="{{route('conditions-utilisation')}}">à
                                l'utilisation de vos données personnelles</a> par Objectif Terres </p>
                        <br>
                        <div class="field is-grouped is-grouped-centered">
                            <div class="control is-pulled-right">
                                <button type="submit" class="button basic primary form-button is-size-3">Valider
                                </button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                        <div class="section">
                            <h4 class="title is-4 has-text-centered">Vous avez déjà un compte ?</h4>
                            <p class="has-text-centered"><a href="{{route('login')}}">Se connecter</a></p>
                        </div>
                    </div>
                </div>
                <div class="column"></div>
            </div>
        </user-form>
    </div>
    @include('components.support-terre-liens')
@endsection

@section('script')
    <script>
        const vueRegisterForm = new Vue({
            el: '#vue-register-form',
            name: 'content'
        });
    </script>
@endsection
