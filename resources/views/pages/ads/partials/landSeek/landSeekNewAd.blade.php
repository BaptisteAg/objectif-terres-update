<div id="land_seek_form" class="form-container">
    <form-wizard
            title=""
            subtitle=""
            step-size="xs"
            @on-complete="$emit('form-complete')"
            @on-change="nextStep"
            color="#579ea5"
            ref="formWizard">

        <tab-content title="Localisation" icon="ti-location-arrow">
            @include('pages.ads.partials.inputs.locations')
        </tab-content>

        <tab-content title="Foncier" icon="ti-home">
            <section class="container">
                <div class="columns">
                    <div class="column"></div>
                    <div class="column is-half">
                        <div class="field">

                            <label for="land_seek[surface_range_min]"
                                   class='label has-tooltip has-tooltip-left'
                                   data-tooltip="Faites glisser les curseurs pour définir la surface recherchée">

                                Surface recherchée* (en hectares),
                                <i class="fas fa-info-circle has-text-info"></i>
                            </label>
                            <vue-slider-range
                                    ref="surfaceRangeMax"
                                    name-min="land_seek[surface_range_min]"
                                    name-max="land_seek[surface_range_max]"
                                    :data="{{ json_encode($surfaceRanges->pluck('label', 'value')) }}"
                                    :value="[formInput.surfaceRangeMin, formInput.surfaceRangeMax]"
                                    @input="v => (formInput.surfaceRangeMin = v[0]) && (formInput.surfaceRangeMax = v[1])"
                                    :disabled="isInputDisabled"
                            ></vue-slider-range>

                            <p class="help is-danger"
                               style="margin-top: 30px;"
                               v-if="$v.formInput.surfaceRangeMax.$error">
                                Indiquez une valeur supérieure à zéro.
                            </p>
                        </div>
                        <br>

                        <div class="field">
                            <label class="label is-inline-block has-tooltip-multiline has-tooltip-left"
                                   data-tooltip="Décrivez le type de surface agricole : altitude, type de terre, besoin en eau, certification...">
                                Description du terrain recherché
                                <i class="fas fa-info-circle has-text-info"></i>
                            </label>

                            <text-area-counter
                                    name="land_seek[land_description]"
                                    :max-length=1500
                                    :disabled="isInputDisabled"
                                    ref="landDescription"
                                    v-model="formInput.landDescription"
                                    :vuelidate="$v.formInput.landDescription">
                            </text-area-counter>
                        </div>

                        <div class="field">
                            {!! Form::label('land_seek_farms_and_buildings', 'Habitation(s) et bâti(s)', ['class' => 'label']); !!}

                            <table class="table">
                                <thead>
                                <tr>
                                    <td></td>
                                    @foreach($requirements as $requirement)
                                        <td>{{ $requirement->label }}</td>
                                    @endforeach
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($buildingTypes as $buildingType)
                                    <tr>
                                        <td>{{ $buildingType->label }}</td>
                                        @foreach($requirements as $requirement)
                                            <td style="text-align:center">
                                                <input type="radio"
                                                       name="land_seek[buildings][{{$buildingType->id}}]"
                                                       value="{{ $requirement->id }}"
                                                        {{ (string)($old['land_seek']["buildings"][(string)$buildingType->id] ?? 0) === (string)$requirement->id ? 'checked' : '' }}>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if(!empty($isSupportRequest))
                            <div class="field">
                                <label for="land_seek[offer_genres][]"
                                       class='label has-tooltip has-tooltip-left'
                                       data-tooltip=" Si vous ne savez pas cochez les deux">

                                    Accès au foncier souhaité*
                                    <i class="fas fa-info-circle has-text-info"></i>
                                </label>

                                <div class="columns">
                                    @foreach($offerGenres as $i => $offerGenre)
                                        @if($offerGenre["land_seek_display"])
                                            <div class="column">
                                                <custom-checkbox
                                                        name="land_seek[offer_genres][]"
                                                        input-value="{{$offerGenre["id"]}}"
                                                        v-model="formInput.offerGenres"
                                                        :disabled="isInputDisabled"
                                                        ref="offerGenres">

                                                    <i class="fa {{ $offerGenre["icon"] }}"
                                                       style="font-size: 30px;"></i><br><br>
                                                    <span style="font-size:16px">
                                                        {{ $offerGenre["name"] }}
                                                    </span>
                                                </custom-checkbox>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                <p id="offerGenreIdError" class="help is-danger" v-if="$v.formInput.offerGenres.$error">
                                    Ce champ est requis.
                                </p>
                            </div>

                            {{--                            <div class="field" v-show="formInput.offerGenres.includes('2')">--}}
                            {{--                                {!! Form::label('land_seek[rent_max]', 'Loyer maximum (en €)', ['class' => 'label']); !!}--}}
                            {{--                                {!! Form::text('land_seek[rent_max]',--}}
                            {{--                                          null,--}}
                            {{--                                          ['min'=>1,--}}
                            {{--                                          'class' => 'input',--}}
                            {{--                                          'ref' => 'rentMax',--}}
                            {{--                                          'v-model.trim' => 'formInput.rentMax',--}}
                            {{--                                          ':disabled' => 'isInputDisabled'] ) !!}--}}

                            {{--                                <p class="help is-danger" v-if="!$v.formInput.rentMax.numeric">Veuillez saisir des chiffres.</p>--}}
                            {{--                            </div>--}}

                            <div class="field"
                                 v-show="formInput.offerGenres.includes('1') || formInput.offerGenres.includes(1)">
                                {!! Form::label('land_seek[price_max]', 'Achat : quel est votre budget maximum ?', ['class' => 'label']); !!}

                                <div class="control has-icons-right">
                                    {!! Form::text('land_seek[price_max]',
                                              null,
                                              ['min'=>1,
                                              'class' => 'input',
                                              'ref' => 'priceMax',
                                              'v-model.trim' => 'formInput.priceMax',
                                              ':disabled' => 'isInputDisabled'] ) !!}
                                    <span class="icon is-small is-right" style="color: #4a4a4a;">
                                        €
                                    </span>
                                </div>


                                {{--                                <vue-slider--}}
                                {{--                                    name="land_seek[price_max]"--}}
                                {{--                                    :data="{--}}
                                {{--                                        '50000' : '< 50 000€',--}}
                                {{--                                        '100000' : '100 000 €',--}}
                                {{--                                        '200000' : '200 000 €',--}}
                                {{--                                        '300000' : '300 000 €',--}}
                                {{--                                        '10000000' : '> 300 000 €',--}}
                                {{--                                    }"--}}
                                {{--                                    v-model="formInput.priceMax">--}}
                                {{--                                </vue-slider>--}}
                            </div>
                        @endif
                    </div>
                    <div class="column"></div>
                </div>
            </section>
        </tab-content>

        <tab-content title="Votre projet" icon="ti-settings">

            <section class="container">
                <div class="columns">
                    <div class="column"></div>
                    <div class="column is-half">

                        <div class="field">
                            {!! Form::label('land_seek[is_bio]', "Votre projet est-il en agriculture biologique ?", ['class' => 'label']) !!}
                            <label>
                                {!! Form::radio('land_seek[is_bio]', '1', $old['land_seek']['is_bio'] ?? null , [':disabled' => 'isInputDisabled']) !!}
                                Oui
                            </label><br>
                            <label>
                                {!! Form::radio('land_seek[is_bio]', '0', $old['land_seek']['is_bio'] ?? null , [':disabled' => 'isInputDisabled']) !!}
                                Non
                            </label><br>
                            <label>
                                {!! Form::radio('land_seek[is_bio]', '-1', $old['land_seek']['is_bio'] ?? null , [':disabled' => 'isInputDisabled']) !!}
                                Je ne sais pas encore
                            </label>
                        </div>


                        <div class="field">
                            {!! Form::label('land_seek[production_genres][]', 'Production(s) envisagée(s)*', ['class' => 'label']); !!}

                            @include('pages.ads.partials.inputs.production_genres', ['name' => 'land_seek[production_genres][]', 'productionGenres' => $productionGenresWithOther])
                            {{--                            <multi-select--}}
                            {{--                                    :options="{{json_encode($productionGenresWithOther)}}"--}}
                            {{--                                    group-values="children"--}}
                            {{--                                    name="land_seek[production_genres][]"--}}
                            {{--                                    v-model="formInput.productionGenres"--}}
                            {{--                                    selected-count-text="productions sélectionnée(s)"--}}
                            {{--                                    placeholder="Sélectionnez au moins une production"--}}
                            {{--                                    ref="productionGenres">--}}
                            {{--                            </multi-select>--}}

                            <p class="help is-danger" id="productionGenresError"
                               v-if="$v.formInput.productionGenres.$error">
                                Ce champ est requis.
                            </p>
                        </div>

                        <div class="field" v-show="productionGenresHasOther">
                            {!! Form::label('land_seek[production_type_add]', 'Autre production : Veuillez préciser', ['class' => 'label']); !!}
                            {!! Form::text('land_seek[production_type_add]',
                                 null,
                                 [
                                    'class' => 'input',
                                    ':disabled' => 'isInputDisabled',
                                    'v-model' => 'formInput.productionTypeAdd'
                                 ]
                             ) !!}
                        </div>

                        <div class="field">
                            {!! Form::label('land_seek[installation_type_id]', 'Vous êtes installé·e(s) ou comptez vous installer...*', ['class' => 'label']); !!}

                            <div class="columns">
                                @foreach($installationTypes as $i => $installationType)
                                    <div class="column">
                                        <custom-checkbox
                                                name="land_seek[installation_type_id]"
                                                input-value="{{$installationType["id"]}}"
                                                :disabled="isInputDisabled"
                                                v-model="formInput.installationTypeId"
                                                ref="installationTypeId"
                                                :is-radio="true">

                                            <i class="fa {{ $installationType["icon"] }}"
                                               style="font-size: 30px;"></i><br><br>
                                            <span style="font-size:16px">
                                                {{ $installationType["name"] }}
                                            </span>
                                        </custom-checkbox>
                                    </div>
                                @endforeach
                            </div>

                            <p class="help is-danger" id="installationTypeIdError"
                               v-if="$v.formInput.installationTypeId.$error">
                                Ce champ est requis.
                            </p>
                        </div>
                        @php
                            if(empty($isSupportRequest)) {
                                $tooltip = "Pour donner envie à un cédant ou propriétaire de vous proposer " .
                                            "du foncier, décrivez votre projet, son histoire, ses valeurs, " .
                                            "votre date d'installation envisagée, etc.";
                            }
                            else {
                                $tooltip = "Décrivez votre projet, son histoire, ses valeurs, votre date d'installation envisagée, etc.";
                            }
                        @endphp
                        @include('pages.ads.partials.inputs.about_project_content', ['tooltip' => $tooltip])
                    </div>
                    <div class="column"></div>
                </div>
            </section>
        </tab-content>

        <tab-content title="Vous" icon="ti-menu-alt">
            <section class="container">
                <div class="columns">
                    <div class="column"></div>
                    <div class="column is-half">

                        @if(!empty($isSupportRequest))
                            <div class="field">
                                {!! Form::label('land_seek[education_levels][]', 'Niveau de formation', ['class' => 'label']); !!}

                                <div class="columns">
                                    @foreach($educationLevels as $i => $educationLevel)
                                        <div class="column">
                                            <custom-checkbox
                                                    name="land_seek[education_levels][]"
                                                    input-value="{{$educationLevel["id"]}}"
                                                    v-model="formInput.educationLevels"
                                                    :disabled="isInputDisabled"
                                                    ref="educationLevels">
                                                {{--<i class="fa {{$educationLevel["icon"]}}"--}}
                                                {{-- style="font-size: 30px;"></i><br><br>--}}
                                                <span style="font-size:16px">
                                                    {{ $educationLevel["name"] }}
                                                </span>
                                            </custom-checkbox>
                                        </div>
                                        @if($i % 2)
                                </div>
                                <div class="columns">
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

						<?php
						if (empty($isSupportRequest)) {
							$tooltip = "Pour les cédants ou propriétaires, l’expérience est un plus ! Détaillez ici vos expériences professionnelles agricoles, stages ou bénévolat sur des fermes et vos diplômes agricoles.";
						} else {
							$tooltip = "Détaillez ici vos formations, expériences professionnelles agricoles, stages ou bénévolat sur des fermes et vos diplômes agricoles.";
						}
						?>
                        <div class="field">
                            <label class="label is-inline-block has-tooltip-multiline has-tooltip-left"
                                   data-tooltip="{{$tooltip}}">
                                Expérience dans le domaine agricole
                                <i class="fas fa-info-circle has-text-info"></i>
                            </label>

                            <text-area-counter
                                    name="land_seek[experience_farming]"
                                    :max-length=1500
                                    :disabled="isInputDisabled"
                                    ref="experienceFarming"
                                    v-model="formInput.experienceFarming"
                                    :vuelidate="$v.formInput.experienceFarming">
                            </text-area-counter>
                        </div>

                        @include('pages.ads.partials.inputs.about_content', ["tooltip" => null])
                    </div>
                    <div class="column"></div>
                </div>
            </section>
        </tab-content>

        <tab-content title="C'est presque fini !" icon="ti-share">
            <section class="container">
                <div class="columns">
                    <div class="column"></div>
                    <div class="column is-half">
                        @include('pages.ads.partials.inputs.title')

                        @include('pages.ads.partials.inputs.documents')

                        @if(!empty($isSupportRequest))
                            @include('pages.ads.partials.inputs.support-request-text')
                        @endif

                        @if(!$isSupportRequest)
                            @include('pages.ads.partials.inputs.accept-share-contact-infos')
                        @endif

                        @include('pages.ads.partials.inputs.chart-confirmation', ['inputNamePrefix' => 'land_seek'])

                        <article class="message is-warning" v-if="$v.$error">
                            <div class="message-header">
                                <p>Veuillez revoir votre formulaire</p>
                            </div>
                            <div class="message-body">
                                Des erreurs empêchent la publication de votre annonce. Avez-vous tout vérifié ?
                            </div>
                        </article>
                    </div>
                    <div class="column"></div>
                </div>
            </section>
        </tab-content>

        @include('pages.ads.partials.form-wizard-footer', ["moveToRef"=>"land_seek"])

    </form-wizard>
</div>
