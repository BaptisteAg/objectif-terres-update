<div id="associate_offer_form" class="form-container pt-6">
    <form-wizard
            title=""
            subtitle=""
            step-size="xs"
            @on-complete="$emit('form-complete')"
            @on-change="nextStep"
            color="#A74B2B"
            ref="formWizard">

        <tab-content title="Votre ferme">

            @include('pages.ads.partials.inputs.main_department')

            @include('pages.ads.partials.inputs.other_locations', [
                'label' => 'Communes concernées *',
                'tooltip' => 'Si votre bien se situe sur plusieurs communes, merci de nous les indiquer',
                'withDepartments' => false
            ])

            @include('pages.ads.partials.inputs.accept_use_zip_code', [
                'name' => 'associate_offer[accept_use_zip_code]',
                'vModel' => 'formInput.acceptUseZipCode',
            ])

            @include('pages.ads.partials.inputs.surface',[
                'adType' => 'associate_offer',
            ])

            <section class="field mb-6" ref="altitude">
                <div class="label">
                    {!! Form::label('associate_offer[altitude]', 'Altitude'); !!}
                </div>
                <b-field>
                    <b-input name="associate_offer[altitude]" v-model="formInput.altitude"
                    ></b-input>
                    <p class="control">
                    <span style="border-bottom-right-radius: 999px; border-top-right-radius: 999px;"
                          class="button is-static">m</span>
                    </p>
                </b-field>
                <template v-if="$v.formInput.altitude?.$error">
                    <p class="help is-danger" v-if="$v.formInput.altitude.required">
                        Ce champ est requis.
                    </p>
                    <p class="help is-danger" v-if="!$v.formInput.altitude.numeric">
                        Veuillez saisir un nombre.
                    </p>
                </template>
            </section>

            @include('pages.ads.partials.inputs.yes_no', [
                'ref' => 'waterAccess',
                'name' => 'associate_offer[water_access]',
                'label' => "Accès à l'eau existant *",
                'vModel' => 'formInput.waterAccess',
                'vuelidate' => '$v.formInput.waterAccess',
                'maybe' => true
            ])

            @include('pages.ads.partials.inputs.yes_no', [
                'ref' => 'hasBuildings',
                'name' => 'associate_offer[has_buildings]',
                'label' => "Présence de bâtiment(s) agricole(s) *",
                'vModel' => 'formInput.hasBuildings',
                'vuelidate' => '$v.formInput.hasBuildings'
            ])

            @include('pages.ads.partials.inputs.yes_no', [
                'ref' => 'hasHouses',
                'name' => 'associate_offer[has_houses]',
                'label' => "Présence d'habitation(s) *",
                'vModel' => 'formInput.hasHouses',
                'vuelidate' => '$v.formInput.hasHouses'
            ])

            <section class="mb-6 field" ref="productionGenres">
                <?php
                $params = [
                    'name' => 'associate_offer[production_genres][]',
                    'productionGenres' => $productionGenres,
                    'vModel' => 'formInput.productionGenres',
                    'isUnique' => 'true',
                    'isRequired' => true,
                    'label' => 'Production agricole principale envisagée'
                ];
                ?>
                @include('pages.ads.partials.inputs.production_genres', $params)
            </section>

            <section class="mb-6 field" ref="productionGenresSecondary">
                @include('pages.ads.partials.inputs.production_genres',[
                'name' => 'associate_offer[secondary_production_genres][]',
                'productionGenres' => $productionGenres,
                'vModel' => 'formInput.productionGenresSecondary',
                'label' => 'Productions agricoles secondaires envisagées'
                ])
            </section>

            @include('pages.ads.partials.inputs.bio_certifications')

        </tab-content>
        <tab-content title="Profil recherché">

            <section class="mb-6 field" ref="associateDescription">
                {!! Form::label('associate_offer[associate_description]',"Description du type d'associé.e.s recherché.e.s *", ['class' => 'label']); !!}
                <text-area-counter
                        name="associate_offer[associate_description]"
                        :max-length="1000"
                        v-model="formInput.associateDescription"
                        :vuelidate="$v.formInput.associateDescription">
                </text-area-counter>
            </section>

            <section class="mb-6 field" ref="experienceFarming">
                {!! Form::label('associate_offer[experience_farming]','Expérience dans le milieu agricole', ['class' => 'label']); !!}
                <text-area-counter
                        name="associate_offer[experience_farming]"
                        :max-length="1000"
                        v-model="formInput.experienceFarming">
                </text-area-counter>
            </section>

            <section class="mb-6 field" ref="educationLevels">
                <?php
                $educationLevelsParams = [
                    'name' => 'associate_offer[education_levels][]',
                    'productionGenres' => $educationLevels,
                    'vModel' => 'formInput.educationLevels',
                    'isRequired' => true,
                    'label' => 'Niveau de formation'
                ];
                ?>
                @include('pages.ads.partials.inputs.production_genres', $educationLevelsParams)
            </section>

            @include('pages.ads.partials.inputs.yes_no', [
                'ref' => 'isActivityTransmission',
                'name' => 'associate_offer[is_activity_transmission]',
                'label' => "Une transmission de l’activité agricole est-elle envisagée par la suite ?*",
                'vModel' => 'formInput.isActivityTransmission',
                'vuelidate' => '$v.formInput.isActivityTransmission'
            ])

            <section class="field mb-6" ref="aboutProject">
                <?php
                $aboutProjectTooltip = "";
                ?>
                @include('pages.ads.partials.inputs.about_project_content', ['title'=> 'Et si vous nous en disiez un peu plus sur votre projet et vos atttentes ?','tooltip' => $aboutProjectTooltip])
            </section>

        </tab-content>

        <tab-content title="C'est presque fini !">

            <section class="field" ref="aboutContent">
                @include('pages.ads.partials.inputs.about_content', ['tooltip' => "Présentez vous brièvement : êtes-vous agriculteur, êtes-vous propriétaires, depuis quand, ..."])
            </section>

            <section class="field mb-6">
                @include('pages.ads.partials.inputs.title')
            </section>

            <section class="field mb-6">
                @include('pages.ads.partials.inputs.documents')
            </section>

            <section class="field" ref="chartConfirmation">
                @include('pages.ads.partials.inputs.chart-confirmation', ['inputNamePrefix' => 'assocciate_seek'])
            </section>
        </tab-content>

        @include('pages.ads.partials.new-form-wizard-footer', ["moveToRef"=>"associate_offer"])
    </form-wizard>
</div>
