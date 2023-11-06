<div id="associate_seek_ad_form" class="form-container pt-6">
    <form-wizard
            title=""
            subtitle=""
            step-size="xs"
            @on-complete="$emit('form-complete')"
            @on-change="nextStep"
            color="#A74B2B"
            ref="formWizard">

        <tab-content title="Votre projet agricole">

            @include('pages.ads.partials.inputs.main_department')

            @include('pages.ads.partials.inputs.other_locations', [
                'label' => 'Autre(s) localisation(s)',
                'tooltip' => 'Si vous souhaitez préciser la localisation de votre recherche, saisissez les 2 premiers chiffres du code postal'
            ])

            <section class="mb-6 field" ref="productionGenres">
                {!! Form::label('associate_seek[production_genres][]', 'Production agricole principale envisagée *', ['class' => 'label']); !!}
                @include('pages.ads.partials.inputs.production_genres', [
                    'name' => 'associate_seek[production_genres][]',
                    'productionGenres' => $productionGenres,
                    'vModel' => 'formInput.productionGenres',
                    'isRequired' => true,
                    'isUnique' => true,
                ])
            </section>

            <section class="mb-6 field" ref="secondaryProductionGenres">
                {!! Form::label('associate_seek[secondary_production_genres][]', 'Production agricole secondaire(s) envisagée(s)', ['class' => 'label']); !!}
                <?php
                $secondaryProductionGenresParams = [
                    'name' => 'associate_seek[secondary_production_genres][]',
                    'productionGenres' => $productionGenres,
                    'vModel' => 'formInput.secondaryProductionGenres'
                ];
                ?>
                @include('pages.ads.partials.inputs.production_genres', $secondaryProductionGenresParams)
            </section>

            <section class="mb-6 field">
                <b-checkbox true-value="0"
                            false-value="1" name="associate_seek[is_land_already_found]"
                            v-model="formInput.is_land_already_found"
                            class="is-size-6">
                    Avez-vous déjà trouvé un lieu et des terres agricoles ?
                </b-checkbox>
            </section>

            <section class="mb-6 field" v-if="formInput.is_land_already_found">
                {!! Form::label('associate_seek[land_description]', 'Pouvez-vous décrire le lieu et les terres ?', ['class' => 'label']); !!}
                <text-area-counter
                        name="associate_seek[land_description]"
                        :max-length="1500"
                        v-model="formInput.land_description">
                </text-area-counter>
            </section>

            <section class="mb-6 field" ref="aboutProject">
                @include('pages.ads.partials.inputs.about_project_content', ['title' => 'Et si vous nous en disiez un peu plus sur votre projet ?', 'tooltip' => ''])
            </section>

        </tab-content>

        <tab-content title="Profil recherché">

            <section class="mb-6 field" ref="associateDescription">
                <b-tooltip class="w-100"
                           label="Description du type d’associé.e.s recherché.e.s (le nombre, l’expérience ou la formation recherchée) et des activités à pourvoir sur la ferme">
                    <label class="label is-inline-block"
                           for="associate_seek[associate_description]">
                        Description du type d'associé.e.s recherché.e.s *
                        <i class="fas fa-info-circle has-text-info"></i>
                    </label>

                    <text-area-counter
                            name="associate_seek[associate_description]"
                            :max-length="1500"
                            v-model="formInput.associateDescription"
                            :vuelidate="$v.formInput.associateDescription">
                    </text-area-counter>
                </b-tooltip>
            </section>

            <section class="mb-6 field" ref="educationLevels">
                {!! Form::label('associate_seek[education_levels][]', 'Niveau de formation *', ['class' => 'label']); !!}

                <multi-select
                        :options="{{json_encode($educationLevels)}}"
                        name="associate_seek[education_levels][]"
                        v-model="formInput.educationLevels"
                        placeholder="Sélectionnez un ou plusieurs niveaux"
                >
                </multi-select>
            </section>

            <section class="mb-6 field" ref="experienceFarming">
                {!! Form::label('associate_seek[experience_farming]','Expérience dans le milieu agricole', ['class' => 'label']); !!}
                <text-area-counter
                        name="associate_seek[experience_farming]"
                        :max-length="1000"
                        v-model="formInput.experienceFarming"
                        :vuelidate="$v.formInput.experienceFarming">
                </text-area-counter>
            </section>

            <section class="mb-6 field" ref="aboutContent">
                <?php
                $aboutTitle = "Et si vous nous en disiez un peu plus sur vous ?";
                $aboutTooltip = "Présentez-vous en quelques lignes pour faciliter la mise en relation : valeurs, compétences spécifiques, mobilité, etc. ";
                ?>
                @include('pages.ads.partials.inputs.about_content', ['title' => $aboutTitle, 'tooltip' => $aboutTooltip])
            </section>

        </tab-content>

        <tab-content title="C'est presque fini !">
            <section class="field mb-6">
                @include('pages.ads.partials.inputs.title')
            </section>

            <section class="field mb-6">
                @include('pages.ads.partials.inputs.documents')
            </section>

            <section class="field" ref="chartConfirmation">
                @include('pages.ads.partials.inputs.chart-confirmation', ['inputNamePrefix' => 'associate_seek'])
            </section>
        </tab-content>

        @include('pages.ads.partials.new-form-wizard-footer', ["moveToRef"=>"associate_seek"])
    </form-wizard>
</div>
