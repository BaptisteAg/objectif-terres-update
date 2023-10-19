@extends('default')
@section('title', 'Inscription')

@section('main-content')
    <div class="container pt-5">
        <user-form
                inline-template
                :old-values="{{json_encode(count(old()) ? old() : new stdClass)}}">
            <div>
                <h1 class="title is-2 px-3-mobile">Créer votre compte</h1>
                <p class="is-size-7 text_charcoal px-3-mobile">Les champs marqués d'un astérisque <strong>(*)</strong>
                    sont
                    obligatoires.
                </p>
                <br>
                {!! Form::open(['route'=>'register']) !!}
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
                    <div class="column is-half">
                        @include('auth.partials.inputs.email')
                    </div>
                </div>
                <div class="columns">
                    <div class="column is-half">
                        @include('auth.partials.inputs.birthday')
                    </div>
                    <div class="column is-half">
                        @include('auth.partials.inputs.address')
                    </div>
                </div>
                <div class="columns">
                    <div class="column is-half">
                        @include('auth.partials.inputs.zipcode')
                    </div>
                    <div class="column is-half">
                        @include('auth.partials.inputs.country')
                    </div>
                </div>
                <div class="columns">
                    @include('auth.partials.inputs.profile')
                </div>
                <div class="columns" v-if="optionProfileSelected === '1' || optionProfileSelected === '2'">
                    @include('auth.partials.inputs.formation')
                </div>

                <div class="columns" v-if="optionProfileSelected === '1' || optionProfileSelected === '2'">
                    @include('auth.partials.inputs.fromwhere')
                </div>

                <div class="px-3-mobile pb-4">
                    @include('auth.partials.inputs.password')
                </div>

                <div class="field px-3-mobile">
                    <label class="checkbox">
                        <input type="checkbox" required>
                        <span>J'accepte la
                                    <a href="{{URL::asset('docs/Charte_utilisation_d_Objectif_Terres-Validee_en_CIT_du_21_oct.pdf')}}"
                                       target="_blank">Charte d'utilisation</a>
                                    et les <a href="{{route('conditions-utilisation')}}" target="_blank">CGU</a> du site d'annonces du site web de Terre de Liens
                                    .*</span>
                    </label>
                </div>
                <div class="field px-3-mobile">
                    <label class="checkbox">
                        <input type="checkbox"
                               name="accept_communication"
                               id="accept_communication"
                               value="1"
                                {{old('accept_communication') === "1" ? "checked" : ''}}>
                        J'accepte de recevoir les communications de Terre de Liens
                    </label>
                </div>

                <br>
                <div class="field">
                    <div class="control">
                        <button type="submit" class="is-rounded is-fullwidth button is-medium is-primary">
                            Valider
                        </button>
                    </div>
                </div>
                {!! Form::close() !!}
                <div class="section">
                    <h4 class="title is-4 has-text-centered">Vous avez déjà un compte ?</h4>
                    <p class="has-text-centered"><a href="{{route('login')}}">Se connecter</a></p>
                </div>
            </div>
        </user-form>
    </div>
@endsection
