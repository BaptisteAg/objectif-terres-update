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
                'label' => 'Communes concernées*',
                'tooltip' => 'Si votre bien se situe sur plusieurs communes, merci de nous les indiquer'
            ])

            <section class="field mb-6">
                <b-tooltip class="w-100"
                           label="Il est nécessaire que nous ayons les informations sur votre bien, à l'échelle de la commune mais l'annonce ne l'affichera pas si vous souhaitez rester plus général sur l'emplacement du foncier. Seul le département apparaitra.">
                    <div class="label">
                        {!! Form::label('associate_offer[accept_use_zip_code]', 'Confidentialité'); !!}
                        <i class="fas fa-info-circle has-text-info"></i>
                    </div>
                    <b-checkbox name="associate_offer[accept_use_zip_code]"
                                class="is-size-6" {{($old["associate_offer"]["accept_use_zip_code"] ?? null) == 1 ? 'checked' : ''}}>
                        Je ne souhaite pas que la localisation soit publique.
                    </b-checkbox>
                </b-tooltip>
            </section>

            <section class="field mb-6" ref="surface">
                <b-tooltip class="w-100"
                           label="Il est nécessaire que nous ayons les informations sur votre bien, à l'échelle de la commune mais l'annonce ne l'affichera pas si vous souhaitez rester plus général sur l'emplacement du foncier. Seul le département apparaitra.">
                    <div class="label">
                        {!! Form::label('associate_offer[surface]', 'Surface du foncier agricole *'); !!}
                        <i class="fas fa-info-circle has-text-info"></i>
                    </div>
                    <b-field>
                        <b-input name="associate_offer[surface]" v-model="formInput.surface" placeholder="1ha = 10 000m²"
                        ></b-input>
                        <p class="control">
                        <span style="border-bottom-right-radius: 999px; border-top-right-radius: 999px;"
                              class="button is-static">ha</span>
                        </p>
                    </b-field>
                    <template v-if="$v.formInput.surface?.$error">
                        <p class="help is-danger" v-if="!$v.formInput.surface.maxValue">
                            Surface maximum : @{{$v.formInput.surface.$params.maxValue.max}} hectares.
                        </p>
                        <p class="help is-danger" v-if="!$v.formInput.surface.required">
                            Ce champ est requis.
                        </p>
                        <p class="help is-danger" v-if="!$v.formInput.surface.numeric">
                            Veuillez saisir un nombre.
                        </p>
                    </template>
                </b-tooltip>
            </section>

            <section class="field mb-6" ref="altitude">
                <b-tooltip class="w-100"
                           label="Important pour savoir si votre terrain convient à certains projets agricoles">
                    <div class="label">
                        {!! Form::label('associate_offer[altitude]', 'Altitude'); !!}
                        <i class="fas fa-info-circle has-text-info"></i>
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
                </b-tooltip>
            </section>

            <section class="mb-6 is-flex gap-x-5 field is-flex-wrap-wrap" ref="waterAccess">
                {!! Form::label('associate_offer[water_access]', "Accès à l'eau existant *", ['class' => 'label w-100']) !!}
                <div>
                    {!! Form::radio('associate_offer[water_access]', '1', null , ['id' => 'associate_offer[water_access]_1', 'v-model' => 'formInput.waterAccess'] ) !!}
                    {!! Form::label('associate_offer[water_access]_1',  'Oui' ) !!}
                </div>
                <div>
                    {!! Form::radio('associate_offer[water_access]', '0', null , ['id' => 'associate_offer[water_access]_0', 'v-model' => 'formInput.waterAccess']) !!}
                    {!! Form::label('associate_offer[water_access]_0',  'Non' ) !!}
                </div>
                <div>
                    {!! Form::radio('associate_offer[water_access]', '-1', null , ['id' => 'associate_offer[water_access]__1', 'v-model' => 'formInput.waterAccess']) !!}
                    {!! Form::label('associate_offer[water_access]__1',  'Je ne sais pas' ) !!}
                </div>
                <p class="help is-danger w-100"
                   v-if="$v.formInput.waterAccess?.$error">
                    Ce champ est requis.
                </p>
            </section>

            <section class="mb-6 is-flex gap-x-5 field is-flex-wrap-wrap" ref="hasBuildings">
                {!! Form::label('associate_offer[has_buildings]', "Présence de bâtiment(s) agricole(s) *", ['class' => 'label w-100']) !!}
                <div>
                    {!! Form::radio('associate_offer[has_buildings]', '1', null , ['id' => 'associate_offer[has_buildings]_1', 'v-model' => 'formInput.hasBuildings', ':vuelidate' => '$v.formInput.hasBuildings'] ) !!}
                    {!! Form::label('associate_offer[has_buildings]_1',  'Oui' ) !!}
                </div>
                <div>
                    {!! Form::radio('associate_offer[has_buildings]', '0', null , ['id' => 'associate_offer[has_buildings]_0', 'v-model' => 'formInput.hasBuildings', ':vuelidate' => '$v.formInput.hasBuildings']) !!}
                    {!! Form::label('associate_offer[has_buildings]_0',  'Non' ) !!}
                </div>
            </section>

            <section class="mb-6 is-flex gap-x-5 field is-flex-wrap-wrap" ref="hasHouses">
                {!! Form::label('associate_offer[has_houses]', "Présence d'habitation(s) *", ['class' => 'label w-100']) !!}
                <div>
                    {!! Form::radio('associate_offer[has_houses]', '1', null , ['id' => 'associate_offer[has_houses]_1', 'v-model' => 'formInput.hasHouses', ':vuelidate' => '$v.formInput.hasHouses'] ) !!}
                    {!! Form::label('associate_offer[has_houses]_1',  'Oui' ) !!}
                </div>
                <div>
                    {!! Form::radio('associate_offer[has_houses]', '0', null , ['id' => 'associate_offer[has_houses]_0', 'v-model' => 'formInput.hasHouses', ':vuelidate' => '$v.formInput.hasHouses']) !!}
                    {!! Form::label('associate_offer[has_houses]_0',  'Non' ) !!}
                </div>
            </section>

            <section class="mb-6 field" ref="productionGenres">
                {!! Form::label('associate_offer[production_genres][]', 'Production agricole principale envisagée *', ['class' => 'label']); !!}
                <?php
                $params = [
                    'name' => 'associate_offer[production_genres][]',
                    'productionGenres' => $productionGenres,
                    'vModel' => 'formInput.productionGenres',
                    'isUnique' => 'true',
                    'isRequired' => true
                ];
                ?>
                @include('pages.ads.partials.inputs.production_genres', $params)
            </section>

            <section class="mb-6 field" ref="productionTypeAdd">
                {!! Form::label('associate_offer[secondary_production_genres][]', 'Productions agricoles secondaires envisagées', ['class' => 'label']); !!}
                @include('pages.ads.partials.inputs.production_genres', ['name' => 'associate_offer[secondary_production_genres][]', 'productionGenres' => $productionGenres, 'vModel' => 'formInput.productionGenresSecondary'])
            </section>

            <section class="mb-6 field" ref="bioCertifications">
                {!! Form::label('associate_offer[bio_certifications][]', 'Certification des terres *', ['class' => 'label']); !!}
                <multi-select
                        :options="{{json_encode($bioCertifications)}}"
                        group-values="children"
                        name="associate_offer[bio_certifications][]"
                        v-model="formInput.bioCertifications"
                        :clear-other-values="{{json_encode($bioCertifications->filter(function ($v) {
                                        return in_array($v->name, ['Aucune', 'En conversion', 'Je ne sais pas']);
                                    })->values())}}"
                        :show-icons="true"
                        placeholder="Sélectionnez une ou plusieurs certifications"
                        ref="bioCertifications">
                </multi-select>
                <p class="help is-danger" v-if="$v.formInput.bioCertifications?.$error">
                    Ce champ est requis.
                </p>
            </section>

        </tab-content>
        <tab-content title="Profil recherché">

            <section class="mb-6 field" ref="associateDescription">
                {!! Form::label('associate_offer[associate_description]',"Description du type d'associé.e.s recherché.e.s", ['class' => 'label']); !!}
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
                {!! Form::label('associate_offer[education_levels][]', 'Niveau de formation *', ['class' => 'label']); !!}

                <multi-select
                        :options="{{json_encode($educationLevels)}}"
                        name="associate_offer[education_levels][]"
                        v-model="formInput.educationLevels"
                        placeholder="Sélectionnez un ou plusieurs niveaux"
                >
                </multi-select>
            </section>

            <section class="mb-6 field" ref="isActivityTransmission">
                <b-field>
                    <b-checkbox name="associate_offer[is_activity_transmission]" v-model="formInput.isActivityTransmission"
                                :vuelidate="$v.formInput.isActivityTransmission"
                                class="is-size-6">
                        Une transmission de l’activité agricole est-elle envisagée par la suite ?*
                    </b-checkbox>
                </b-field>
            </section>

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
