<div id="land_seek_form">
    <form-wizard
            title=""
            subtitle=""
            next-button-text="Suivant"
            back-button-text="Précédent"
            finish-button-text="Demander la publication"
            step-size="xs"
            @on-complete="$emit('form-complete')"
            color="#3498db"
            ref="formWizard">

        <tab-content title="Localisation" icon="ti-location-arrow">
            <zone-select
                    name="land_seek[locationable]"
                    radius-name="land_seek[locationable_radius]"
                    json-name="land_seek[selected_zones]"
                    ref="selectedZones"
                    v-model="formInput.selectedZones"
                    :vuelidate="$v.formInput.selectedZones"
                    :disabled="isInputDisabled">
            </zone-select>
        </tab-content>

        <tab-content title="Foncier" icon="ti-settings">
            <div class="field">
                {!! Form::label('land_seek[surface_range][]', 'Surface recherchée (en hectares)', ['class' => 'label']); !!}
                <vue-slider-range
                        name-min="land_seek[surface_range_min]"
                        name-max="land_seek[surface_range_max]"
                        :data="{{ json_encode($surfaceRanges->pluck('label', 'value')) }}"
                        :value="[formInput.surfaceRangeMin, formInput.surfaceRangeMax]"
                ></vue-slider-range>
            </div>
            <br>

            <div class="field">
                {!! Form::label('land_seek_wants_farms_or_buildings', 'Habitation(s) et bâti(s)', ['class' => 'label']); !!}

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
                                           value="{{ $requirement->id }}">
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </tab-content>

        <tab-content title="Votre projet" icon="ti-settings">

            <div class="field">
                {!! Form::label('land_seek[is_bio]', "Votre projet est-il en agriculture biologique ?", ['class' => 'label']) !!}
                {!! Form::radio('land_seek[is_bio]', '1',old('land_seek[is_bio]') === '1', [':disabled' => 'isInputDisabled']) !!}
                oui
                {!! Form::radio('land_seek[is_bio]', '0', old('land_seek[is_bio]') === '0', [':disabled' => 'isInputDisabled']) !!}
                non
            </div>

            <div class="field">
                {!! Form::label('land_seek[production_genre][]', 'Production(s) envisagée(s)*', ['class' => 'label']); !!}

                <multi-select
                        :options="{{json_encode($productionGenres)}}"
                        group-values="children"
                        name="land_seek[production_genre][]"
                        v-model="selectedProductionGenres"
                        selected-count-text="productions sélectionnée(s)"
                        placeholder="Sélectionnez au moins une production"
                        ref="productionGenre">
                </multi-select>

                <p class="help is-danger" id="productionGenreError" v-if="$v.formInput.productionGenre.$error">
                    Ce champ est requis.
                </p>
            </div>

            <div class="field" v-show="isProductionGenreOther">
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
                {!! Form::label('land_seek[installation_type_id]', 'Vous êtes installé ou comptez vous installer...*', ['class' => 'label']); !!}

                <?php
                    $installationTypesFaIcons = ["fa-user", "fa-user-friends", "fa-users", "fa-times"]
                ?>

                @foreach($installationTypes as $i => $installationType)
                    <custom-radio
                            name="land_seek[installation_type_id]"
                            input-value="{{$installationType["id"]}}"
                            v-model="formInput.installationTypeId"
                            :disabled="isInputDisabled"
                            ref="installationTypeId">

                        <i class="fa {{ $installationTypesFaIcons[$i] }}" style="font-size: 30px;"></i><br>
                        <span style="font-size:14px">
                                {{ $installationType["name"] }}
                            </span>
                    </custom-radio>
                @endforeach

                <p class="help is-danger" id="installationTypeIdError" v-if="$v.formInput.installationTypeId.$error">
                    Ce champ est requis.
                </p>
            </div>
        </tab-content>

        <tab-content title="Documents" icon="ti-folder">
            @include('pages.ads.partials.inputs.documents')
        </tab-content>

        <tab-content title="Description" icon="ti-menu-alt">
            <div class="field">
                <label class="label is-inline-block has-tooltip-multiline has-tooltip-right"
                       data-tooltip="Pour certains cédants, l’expérience est
				un plus. N’hésitez pas à détailler ici de
				précédentes expériences
				professionnelles dans le domaine
				agricole, de stages ou de bénévolat sur
				des fermes ou encore si vous êtes
				titulaires de diplômes agricoles.">
                    Expérience dans le domaine agricole
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

            @include('pages.ads.partials.inputs.about_project_content')

            @include('pages.ads.partials.inputs.about_content')
        </tab-content>

        <tab-content title="Titre" icon="ti-share">
            @include('pages.ads.partials.inputs.title')

            <div class="field">
                <label class="checkbox">
                    <input type="checkbox"
                           id="certification_charte"
                           name="land_seek[chart_confirmation]"
                           :disabled="isInputDisabled"
                           v-model="formInput.chartConfirmation"
                           ref='chartConfirmation'
                           aria-describedby='chartConfirmationError'>

                    Je certifie que mon projet correspond à la <a href="/">charte de Terre de Liens</a>
                </label>
                <p class="help is-danger" id="chartConfirmationError" v-if="$v.formInput.chartConfirmation.$error">Vous
                    devez cocher cette case.</p>
            </div>

            <article class="message is-warning" v-if="$v.$error">
                <div class="message-header">
                    <p>Veuillez revoir votre formulaire</p>
                </div>
                <div class="message-body">
                    Des erreurs empêchent la publication de votre annonce. Avez-vous tout vérifié ?
                </div>
            </article>
        </tab-content>

        <template slot="custom-buttons-right">
            <button class="button is-light">Sauvegarder</button>
        </template>

    </form-wizard>
</div>