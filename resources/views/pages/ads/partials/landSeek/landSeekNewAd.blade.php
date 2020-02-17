<div id="land_seek_form">
    <form-wizard
            title=""
            subtitle=""
            step-size="xs"
            @on-complete="$emit('form-complete')"
            color="#3498db"
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
                                                       {{ in_array($requirement->id, old('land_seek[buildings]', [])) ? 'checked' : '' }}>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
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
                            {!! Form::radio('land_seek[is_bio]', '1', old('land_seek[is_bio]') , [':disabled' => 'isInputDisabled']) !!}
                            oui
                            {!! Form::radio('land_seek[is_bio]', '0', old('land_seek[is_bio]') , [':disabled' => 'isInputDisabled']) !!}
                            non
                        </div>

                        <div class="field">
                            {!! Form::label('land_seek[production_genres][]', 'Production(s) envisagée(s)*', ['class' => 'label']); !!}

                            <multi-select
                                    :options="{{json_encode($productionGenresWithOther)}}"
                                    group-values="children"
                                    name="land_seek[production_genres][]"
                                    v-model="formInput.productionGenres"
                                    selected-count-text="productions sélectionnée(s)"
                                    placeholder="Sélectionnez au moins une production"
                                    ref="productionGenres">
                            </multi-select>

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
                            {!! Form::label('land_seek[installation_type_id]', 'Vous êtes installé ou comptez vous installer...*', ['class' => 'label']); !!}

                            <?php
                            $installationTypesFaIcons = ["fa-user", "fa-user-friends", "fa-users", "fa-times"]
                            ?>

                            <div class="columns">
                                @foreach($installationTypes as $i => $installationType)
                                    <div class="column">
                                        <custom-checkbox
                                                name="land_seek[installation_type_id]"
                                                input-value="{{$installationType["id"]}}"
                                                v-model="formInput.installationTypeId"
                                                :disabled="isInputDisabled"
                                                ref="installationTypeId"
                                                :is-radio="true">

                                            <i class="fa {{ $installationTypesFaIcons[$i] }}"
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
                        @include('pages.ads.partials.inputs.about_project_content', ['tooltip' => "Pour donner envie à un cédant ou propriétaire de vous proposer du foncier, décrivez votre projet, son histoire, ses valeurs, votre date d'installation envisagée, etc."])
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
                        <div class="field">
                            <label class="label is-inline-block has-tooltip-multiline has-tooltip-left"
                                   data-tooltip="Pour les cédants ou propriétaires, l’expérience est un plus !
                       Détaillez ici vos expériences professionnelles agricoles, stages ou bénévolat sur des fermes et vos diplômes agricoles.">
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


                        @include('pages.ads.partials.inputs.about_content')
                    </div>
                    <div class="column"></div>
                </div>
            </section>
        </tab-content>

        <tab-content title="Finalisation" icon="ti-share">
            <section class="container">
                <div class="columns">
                    <div class="column"></div>
                    <div class="column is-half">
                        @include('pages.ads.partials.inputs.title')

                        @include('pages.ads.partials.inputs.documents')

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
                            <p class="help is-danger" id="chartConfirmationError"
                               v-if="$v.formInput.chartConfirmation.$error">Vous
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
                    </div>
                    <div class="column"></div>
                </div>
            </section>
        </tab-content>

        @include('pages.ads.partials.form-wizard-footer', ["moveToRef"=>"land_seek"])

    </form-wizard>
</div>
