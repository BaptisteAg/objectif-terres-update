<div id="job_offer_ad_form" class="form-container pt-6">
    <form-wizard
            title=""
            subtitle=""
            step-size="xs"
            @on-complete="$emit('form-complete')"
            @on-change="nextStep"
            color="#A74B2B"
            ref="formWizard">

        <tab-content title="Expérience proposée">
            <section class="field mb-6">
                <b-tooltip class="w-100"
                           label="Si vous souhaitez préciser la localisation de votre recherche, saisissez les 2 premiers chiffres du code postal">
                    <zone-select
                            src="/locations/cities-and-regions"
                            name="locationable"
                            label="Code Postal, Commune *"
                            json-name="selected_zones"
                            ref="selectedZones"
                            :vuelidate="$v.formInput.selectedZones"
                            v-model="formInput.selectedZones">
                    </zone-select>
                </b-tooltip>
            </section>

            <section class="mb-6 field" ref="offerTypes">
                {!! Form::label('job_seek[building][offer_genres][]', 'Quel type d\'expérience professionnelle recherchez-vous ? *', [
                'class' => 'label',
            ]); !!}

                @foreach($jobOfferTypes as $jobOfferType)
                    @if($jobOfferType["id"] !== 3)
                        <b-checkbox name="job_seek[offer_types][]" native-value="{{ $jobOfferType["id"] }}"
                                    v-model="formInput.offerTypes">
                            {{ $jobOfferType["name"] }}
                        </b-checkbox>
                    @endif
                @endforeach
            </section>

            <section class="mb-6 field" ref="productionGenres">
                {!! Form::label('job_seek[production_genres][]', 'Production agricole principale envisagée *', ['class' => 'label']); !!}
                <?php
                $productionGenresParams = [
                    'name' => 'job_seek[production_genres][]',
                    'productionGenres' => $productionGenres,
                    'vModel' => 'formInput.productionGenres',
                    'isRequired' => true,
                    'isUnique' => true,
                ];
                ?>
                @include('pages.ads.partials.inputs.production_genres', $productionGenresParams)
            </section>

            <section class="mb-6 field" ref="productionTypeAdd">
                {!! Form::label('job_seek[secondary_production_genres][]', 'Production agricole secondaire envisagée *', ['class' => 'label']); !!}
                <?php
                $productionGenresSecondaryParams = [
                    'name' => 'job_seek[secondary_production_genres][]',
                    'productionGenres' => $productionGenres,
                    'vModel' => 'formInput.productionGenresSecondary',
                ];
                ?>
                @include('pages.ads.partials.inputs.production_genres', $productionGenresSecondaryParams)
            </section>

            <section class="mb-6 is-flex gap-x-5 field is-flex-wrap-wrap" ref="isActivityTransmission">
                {!! Form::label('job_offer[is_activity_transmission]', "S'agit-il d'une transmission ou d'une possibilité de transmission de l'activité agricole ? *", ['class' => 'label w-100']) !!}
                <div>
                    {!! Form::radio('job_offer[is_activity_transmission]', 1, (string)($old['job_offer']['is_activity_transmission'] ?? null) === "1" , ['id' => 'job_offer[is_activity_transmission]_1', 'v-model' => 'formInput.isActivityTransmission'] ) !!}
                    {!! Form::label('job_offer[is_activity_transmission]_1',  'Oui' ) !!}
                </div>
                <div>
                    {!! Form::radio('job_offer[is_activity_transmission]', 0, (string)($old['job_offer']['is_activity_transmission'] ?? null) === "0"  , ['id' => 'job_offer[is_activity_transmission]_0', 'v-model' => 'formInput.isActivityTransmission']) !!}
                    {!! Form::label('job_offer[is_activity_transmission]_0',  'Non' ) !!}
                </div>
                <p class="help is-danger w-100"
                   v-if="$v.formInput.isActivityTransmission?.$error">
                    Ce champ est requis.
                </p>
            </section>

            <section class="mb-6 field" ref="jobDescription">
                {!! Form::label('job_offer[job_description]', "Niveau de formation souhaité *", ['class' => 'label']) !!}
                <text-area-counter
                        name="job_offer[job_description]"
                        :max-length="1000"
                        :disabled="isInputDisabled"
                        v-model="formInput.jobDescription"
                        :vuelidate="$v.formInput.jobDescription">
                </text-area-counter>
            </section>
        </tab-content>

        <tab-content title="Profil recherché">
            <section class="mb-6 field" ref="educationLevels">
                {!! Form::label('job_offer[education_levels][]', "Description du poste proposé *", ['class' => 'label']) !!}
                <?php
                $educationLevelsParams = [
                    'name' => 'job_offer[education_levels][]',
                    'productionGenres' => $educationLevels,
                    'vModel' => 'formInput.educationLevels',
                    'isRequired' => true,
                ];
                ?>
                @include('pages.ads.partials.inputs.production_genres', $educationLevelsParams)
            </section>

            <section class="mb-6 field" ref="experienceFarming">
                {!! Form::label('job_offer[experience_farming]', "Expérience souhaitée dans le milieu agricole *", ['class' => 'label']) !!}
                <text-area-counter
                        name="job_offer[experience_farming]"
                        :max-length="1000"
                        v-model="formInput.experienceFarming"
                        :vuelidate="$v.formInput.experienceFarming">
                </text-area-counter>
            </section>

            <section>
                <?php
                $aboutFarmLabel = "Et si vous nous en disiez un peu plus sur votre projet et vos attentes ?";
                $aboutFarmTooltip = "Quelles sont les principales activités de la ferme ? Ses spécificités ?
													Les possibilités de logement sur place ?";
                ?>
                @include('pages.ads.partials.inputs.about_project_content', ['title' => $aboutFarmLabel, 'tooltip' => $aboutFarmTooltip])
            </section>
        </tab-content>

        <tab-content title="C'est presque fini !">
            <section>
                <?php
                $aboutTooltip = "Vous travaillez sur la ferme ?
							Dites-en un peu plus sur vous (votre parcours, vos motivations...) et/ou vos associés.
							Vous êtes une personne morale dans le cadre d’un appel à candidatures ?
							Présentez votre structure et vos missions principales en quelques lignes.";
                ?>
                @include('pages.ads.partials.inputs.about_content', ['tooltip' => $aboutTooltip])
            </section>

            <section class="field mb-6">
                @include('pages.ads.partials.inputs.title')
            </section>

            <section class="field mb-6">
                @include('pages.ads.partials.inputs.documents')
            </section>

            <section class="field" ref="chartConfirmation">
                @include('pages.ads.partials.inputs.chart-confirmation', ['inputNamePrefix' => 'job_offer'])
            </section>
        </tab-content>

        @include('pages.ads.partials.new-form-wizard-footer', ["moveToRef"=>"job_offer"])
    </form-wizard>
</div>
