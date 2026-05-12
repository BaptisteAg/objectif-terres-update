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
                'tooltip' => 'Si vous souhaitez préciser la localisation de votre recherche, saisissez les 2 premiers chiffres du code postal',
                'withDepartments' => true
            ])

            <section class="mb-6 field" ref="productionGenres">
                @include('pages.ads.partials.inputs.production_genres', [
                    'name' => 'associate_seek[production_genres][]',
                    'productionGenres' => $productionGenres,
                    'vModel' => 'formInput.productionGenres',
                    'isRequired' => true,
                    'isUnique' => true,
                    'label' => 'Production agricole principale envisagée',
                ])
            </section>

            <section class="mb-6 field" ref="productionGenresSecondary">
                <?php
                $productionGenresSecondaryParams = [
                    'name' => 'associate_seek[secondary_production_genres][]',
                    'productionGenres' => $productionGenres,
                    'vModel' => 'formInput.productionGenresSecondary',
                    'label' => 'Production agricole secondaire(s) envisagée(s)',
                ];
                ?>
                @include('pages.ads.partials.inputs.production_genres', $productionGenresSecondaryParams)
            </section>

            <section class="mb-6 field">
                <input type="hidden" name="associate_seek[is_land_already_found]" value="0">
                <b-checkbox name="associate_seek[is_land_already_found]"
                            native-value="1"
                            v-model="formInput.isLandAlreadyFound"
                            class="is-size-6 has-text-weight-bold">
                    Cochez cette case si vous avez des pistes de fermes à reprendre
                </b-checkbox>
            </section>

            <section class="mb-6 field" v-if="formInput.isLandAlreadyFound">
                {!! Form::label('associate_seek[land_description]', 'Pouvez-vous décrire le lieu et les terres ?', ['class' => 'label']); !!}
                <text-area-counter
                        name="associate_seek[land_description]"
                        :max-length="1500"
                        v-model="formInput.landDescription">
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
                <?php
                $educationLevelsParams = [
                    'name' => 'associate_seek[education_levels][]',
                    'productionGenres' => $educationLevels,
                    'vModel' => 'formInput.educationLevels',
                    'isRequired' => true,
                    'label' => 'Niveau de formation',
                    'unitLabel' => 'formation',
                    'unitLabelGender' => 'f'
                ];
                ?>
                @include('pages.ads.partials.inputs.production_genres', $educationLevelsParams)
            </section>

            <section class="mb-6 field" ref="experienceFarming">
                {!! Form::label('associate_seek[experience_farming]','Expérience souhaitée dans le milieu agricole', ['class' => 'label']); !!}
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
