@extends ('default')

@section ('title', "Contactez-nous")

@section('head-script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma-carousel@4.0.4/dist/css/bulma-carousel.min.css">
@endsection


@section('main-content')

    <div class="cms-page">
        <section class="section">
            <div class="container">
                <div class="rows">
                    <div class="row is-full">
                        @if($pageContent->count())
                            @if($pageContent->has('contactez-nous-texte-dintroduction-sous-le-titre-principal'))
                                {!! $pageContent['contactez-nous-texte-dintroduction-sous-le-titre-principal']->content !!}
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <section class="section">
            <div class="container">
                <p>Pour nous permettre de vous répondre au mieux, veuillez nous en dire un peu plus…</p>
            </div>
            <div class="container contact_form_background">
                <register-form id="contact-form" inline-template>
                    <div class="rows">
                        <div class="row is-full">
                            <div class="columns">
                                <div class="column is-6">
                                    <div class="field">
                                        <label class="radio">
                                            <input type="radio" id="monsieur" name="drone"
                                                   value="monsieur" {{old('civility') == 1 ? 'checked' : ''}}>
                                            <label for="monsieur">Monsieur</label>
                                            <input type="radio" id="madame" name="drone"
                                                   value="madame" {{old('civility') == 2 ? 'checked' : ''}}>
                                            <label for="madame">Madame</label>
                                        </label>
                                    </div>

                                    <div class="field">
                                        <input id="full_name" name="full_name"
                                               class="input @error('full_name')is-danger @enderror" type="text"
                                               value="{{ old('full_name') }}" required autocomplete="full_name"
                                               autofocus
                                               placeholder="Nom Prénom">
                                        @error('full_name')
                                        <article class="message is-danger" role="alert">
                                            <div class="message-body">
                                                {{ $message }}
                                            </div>
                                        </article>
                                        @enderror
                                    </div>

                                    <div class="field">
                                        <label class="label">EMAIL</label>
                                        <input id="email" class="input @error('email') is-danger @enderror" type="email"
                                               name="email" value="{{ old('email') }}" required autocomplete="email"
                                               autofocus
                                               placeholder="Votre adresse email...">
                                        @error('email')
                                        <article class="message is-danger" role="alert">
                                            <div class="message-body">
                                                {{ $message }}
                                            </div>
                                        </article>
                                        @enderror
                                    </div>


                                    <div class="field">
                                        <label class="label">VOUS ÊTES</label>
                                        <div class="select">
                                            <select id="profile" name="profile"
                                                    class="input @error('profile') is-danger @enderror "
                                                    required
                                                    @on-change="optionProfileSelected"
                                                    placeholder="Veuillez choisir">
                                                <option value="1" {{old('profile') == 1 ? 'selected' : ''}} >un candidat
                                                    à l’installation agricole
                                                </option>
                                                <option value="2" {{old('profile') == 2 ? 'selected' : ''}}>une personne
                                                    en recherche de travail ou d’expérience
                                                    professionnelle dans le
                                                    domaine agricole
                                                </option>
                                                <option value="3" {{old('profile') == 3 ? 'selected' : ''}}>un
                                                    agriculteur qui souhaite consolider sa ferme
                                                </option>
                                                <option value="4" {{old('profile') == 4 ? 'selected' : ''}}>un
                                                    agriculteur qui souhaite transmettre sa ferme
                                                </option>
                                                <option value="5" {{old('profile') == 5 ? 'selected' : ''}}>un
                                                    propriétaire foncier qui souhaite vendre ou louer
                                                    sa
                                                    terre
                                                </option>
                                                <option value="6" {{old('profile') == 6 ? 'selected' : ''}}>Autre
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div v-if="optionProfileSelected === '6'" class="column">
                                        <div class="field">
                                            <label class="label">Situation autre </label>
                                            <p class="control has-icons-left has-icons-right">
                                                <input id="other_profile"
                                                       class="input @error('other_profile') is-danger @enderror"
                                                       type="text"
                                                       name="other_profile" value="{{ old('other_profile') }}" required
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

                                    <div class="field">
                                        <label class="label">TYPE D'INSTALLATION</label>
                                        <div class="select  is-full-width">
                                            <select id="installation" name="installation"
                                                    class="input @error('installation') is-danger @enderror "
                                                    required
                                                    @on-change="optionInstallationSelected"
                                                    placeholder="Veuillez choisir">
                                                <option value="1" {{old('installation') == 1 ? 'selected' : ''}} >
                                                    Individuelle
                                                </option>
                                                <option value="2" {{old('installation') == 2 ? 'selected' : ''}}> 2
                                                </option>
                                                <option value="3" {{old('installation') == 3 ? 'selected' : ''}}>3
                                                </option>
                                                <option value="4" {{old('installation') == 4 ? 'selected' : ''}}>4
                                                </option>
                                                <option value="5" {{old('installation') == 5 ? 'selected' : ''}}>5
                                                </option>
                                                <option value="6" {{old('installation') == 6 ? 'selected' : ''}}>6
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <label class="label">PRODUCTION ENVISAGÉE</label>
                                        <div class="select  is-full-width">
                                            <select id="production" name="production"
                                                    class="input @error('production') is-danger @enderror "
                                                    required
                                                    @on-change="optionProductionSelected"
                                                    placeholder="Veuillez choisir">
                                                <option disabled="disabled" selected>Veuillez choisir...</option>
                                                <option value="1" {{old('production') == 1 ? 'selected' : ''}} >1
                                                </option>
                                                <option value="2" {{old('production') == 2 ? 'selected' : ''}}>2
                                                </option>
                                                <option value="3" {{old('production') == 3 ? 'selected' : ''}}>3
                                                </option>
                                                <option value="4" {{old('production') == 4 ? 'selected' : ''}}>4
                                                </option>
                                                <option value="5" {{old('production') == 5 ? 'selected' : ''}}>5
                                                </option>
                                                <option value="6" {{old('production') == 6 ? 'selected' : ''}}>6
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                </div>{{--End columns 6--}}

                                <div class="column is-6">

                                </div>


                            </div>{{--End Columns--}}
                        </div>

                        <div class="row">
                            <div class="column is-12">
                                <div class="columns">
                                    <div class="column is-3">
                                        <div class="field">
                                            <label class="label">COMMUNE</label>
                                            <div class="control has-icons-left">
                                                <div class="select  is-full-width">
                                                    <select id="city" name="city"
                                                            class="input @error('city') is-danger @enderror "
                                                            autocomplete="city">
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="column is-3">
                                        <div class="field">
                                            <label class="label">DANS UN RAYON DE</label>
                                            <label class="radio">
                                                <input type="radio" id="rayonCinq" name="drone"
                                                       value="rayonCinq" {{old('rayon') == 1 ? 'checked' : ''}}>
                                                <label for="rayonCinq">5 km</label>
                                                <input type="radio" id="rayonDix" name="drone"
                                                       value="rayonDix" {{old('rayon') == 2 ? 'checked' : ''}}>
                                                <label for="rayonDix">10 km</label>
                                                <input type="radio" id="rayonVingt" name="drone"
                                                       value="rayonVingt" {{old('rayon') == 3 ? 'checked' : ''}}>
                                                <label for="rayonVingt">20 km</label>
                                                <input type="radio" id="rayonCinquante" name="drone"
                                                       value="rayonCinquante" {{old('rayon') == 4 ? 'checked' : ''}}>
                                                <label for="rayonCinquante">50 km</label>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="column is-3">
                                        <div class="field">
                                            <label class="label">REGION</label>
                                            <div class="control has-icons-left">
                                                <div class="select  is-full-width">
                                                    <select id="city" name="city"
                                                            class="input @error('city') is-danger @enderror "
                                                            autocomplete="city">
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                                <div class="icon is-small is-left">
                                                    <i class="fas fa-city"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="column is-3">
                                        <div class="field">
                                            <label class="label">DEPARTEMENT</label>
                                            <div>
                                                <div class="control  is-full-width">
                                                    <autocomplete
                                                            name="citySelect"
                                                            id="citySelect"
                                                            class="input"
                                                            placeholder="Saisissez les premiers caractères"
                                                            ref='citySelect'
                                                            :disabled="false"
                                                            src="/locations/cities"
                                                            v-model="citySelect"
                                                            aria-describedby='citySelectError'
                                                            value="citySelect">
                                                    </autocomplete>
                                                    <input type="hidden" name="city_id" :value="zone.value.id"
                                                           v-for="(zone,i) in citySelect">
                                                    <div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>{{--End columns of 4 columns city--}}
                            </div>
                        </div>

                        <div class="row">
                            <div class="field">
                                <label class="label is-inline-block has-tooltip-multiline has-tooltip-left"
                                       data-tooltip="Détaillez votre projet.">
                                    QUEL EST VOTRE PROJET ?
                                    <i class="fas fa-info-circle has-text-info"></i>
                                </label>

                                <text-area-counter
                                        name="land_seek[experience_farming]"
                                        :max-length=1000
                                        :disabled="isInputDisabled"
                                        ref="experienceFarming"
                                        v-model="formInput.experienceFarming"
                                        :vuelidate="$v.formInput.experienceFarming">
                                </text-area-counter>
                            </div>
                        </div>

                        <div class="row">
                            <div class="field">
                                <label class="label is-inline-block has-tooltip-multiline has-tooltip-left"
                                       data-tooltip="">
                                    ET VOUS ?
                                    <i class="fas fa-info-circle has-text-info"></i>
                                </label>

                                <text-area-counter
                                        name="land_seek[experience_farming]"
                                        :max-length=1000
                                        :disabled="isInputDisabled"
                                        ref="experienceFarming"
                                        v-model="formInput.experienceFarming"
                                        :vuelidate="$v.formInput.experienceFarming">
                                </text-area-counter>
                            </div>
                        </div>

                        <div class="row">
                            <div class="field">
                                <label class="label">POURQUOI VOUS NOUS CONTACTEZ ?</label>
                                <div class="select">
                                    <select id="production" name="production"
                                            class="input @error('production') is-danger @enderror "
                                            required
                                            @on-change="optionProductionSelected"
                                            placeholder="Veuillez choisir">
                                        <option disabled="disabled" selected>Veuillez choisir...</option>
                                        <option value="1" {{old('production') == 1 ? 'selected' : ''}} >1
                                        </option>
                                        <option value="2" {{old('production') == 2 ? 'selected' : ''}}>2
                                        </option>
                                        <option value="3" {{old('production') == 3 ? 'selected' : ''}}>3
                                        </option>
                                        <option value="4" {{old('production') == 4 ? 'selected' : ''}}>4
                                        </option>
                                        <option value="5" {{old('production') == 5 ? 'selected' : ''}}>5
                                        </option>
                                        <option value="6" {{old('production') == 6 ? 'selected' : ''}}>6</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="field">
                                <label class="checkbox">
                                    <input type="checkbox" required>
                                    Je certifie que mon projet correspond à la charte d'Objectif Terres', <a href="{{URL::asset('docs/Charte_utilisation_d_Objectif_Terres-Validee_en_CIT_du_21_oct.pdf')}}" target="_blank"> lire la charte</a>.
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="field">
                                <label class="checkbox">
                                    <input type="checkbox" required>
                                    Je suis informé de conditions du traitement des données personnelles par Terre de
                                    Liens
                                    et j’en accepte les conditions d’utilisation.
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="field">
                                <label class="checkbox">
                                    <input type="checkbox" required>
                                    J'accepte de recevoir des informations de la part de Terre de Liens.
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="field is-right">
                                <div class="control">
                                    <button type="submit" class="is-pulled-right button is-link">ENVOYER</button>
                                </div>
                            </div>
                        </div>

                    </div>

                </register-form>
            </div>
        </section>


        @include('components.partnering')

        {{-- @include('components.support-terre-liens') --}}
    </div>

@endsection
@section('script')
    <script src="{{ asset('js/bulma-carousel.js') }}"></script>
@endsection

