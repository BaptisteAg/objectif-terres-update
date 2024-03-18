<div id="job_seek_ad_form" class="form-container pt-6">
    <form-wizard
            title=""
            subtitle=""
            step-size="xs"
            @on-complete="$emit('form-complete')"
            @on-change="nextStep"
            color="#A74B2B"
            ref="formWizard">

        <tab-content title="Expérience recherchée">

            @include('pages.ads.partials.inputs.main_department')

    {{--            <section class="field mb-6">--}}
    {{--                <b-tooltip class="w-100"--}}
    {{--                           label="Si vous souhaitez préciser la localisation de votre recherche, saisissez les 2 premiers chiffres du code postal">--}}
    {{--                    <zone-select--}}
    {{--                            name="locationable"--}}
    {{--                            label="Autre(s) localisation(s)"--}}
    {{--                            json-name="selected_zones"--}}
    {{--                            ref="selectedZones"--}}
    {{--                            :vuelidate="$v.formInput.selectedZones"--}}
    {{--                            v-model="formInput.selectedZones">--}}
    {{--                    </zone-select>--}}
    {{--                </b-tooltip>--}}
    {{--            </section>--}}

            @include('pages.ads.partials.inputs.other_locations', [
                'label' => 'Autre(s) localisation(s)',
                'tooltip' => 'Si vous souhaitez préciser la localisation de votre recherche, saisissez les 2 premiers chiffres du code postal',
                'withDepartments' => true
            ])

            <section class="mb-6 field" ref="offerTypes">
                {!! Form::label('job_seek[offer_types][]', 'Quel type d\'expérience professionnelle recherchez-vous ? *', [
                    'class' => 'label',
                ]); !!}

                @foreach($jobOfferTypes as $jobOfferType)
                    {{-- TODO: remove later when there isn't anymore ads with value 3 --}}
                    @if($jobOfferType["id"] !== 3)
                        <b-checkbox name="job_seek[offer_types][]" native-value="{{ $jobOfferType["id"] }}"
                                    v-model="formInput.offerTypes">
                            {{ $jobOfferType["name"] }}
                        </b-checkbox>
                    @endif
                @endforeach
            </section>

            <section class="mb-6 field" ref="productionGenres">
                @include('pages.ads.partials.inputs.production_genres', [
                    'name' => 'job_seek[production_genres][]',
                    'productionGenres' => $productionGenres,
                    'vModel' => 'formInput.productionGenres',
                    'isRequired' => true,
                    'isUnique' => true,
                    'label' => 'Production agricole principale envisagée'
                ])
            </section>

            <section class="mb-6 field" ref="productionGenresSecondary">
                <?php
                $productionGenresSecondaryParams = [
                    'name' => 'job_seek[secondary_production_genres][]',
                    'productionGenres' => $productionGenres,
                    'vModel' => 'formInput.productionGenresSecondary',
                    'isRequired' => true,
                    'label' => 'Production agricole secondaire envisagée',
                ];
                ?>
                @include('pages.ads.partials.inputs.production_genres', $productionGenresSecondaryParams)
            </section>

        </tab-content>

        <tab-content title="Votre parcours">
            <section class="mb-6 field" ref="educationLevels">
                <?php
                $educationLevelsParams = [
                    'name' => 'job_seek[education_levels][]',
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
                {!! Form::label('job_seek[experience_farming]','Expérience dans le milieu agricole *', ['class' => 'label']); !!}
                <text-area-counter
                        name="job_seek[experience_farming]"
                        :max-length="1000"
                        v-model="formInput.experienceFarming"
                        :vuelidate="$v.formInput.experienceFarming">
                </text-area-counter>
            </section>

            <section class="mb-6 field" ref="aboutProject">
                <?php
                $aboutFarmLabel = "Et si vous nous en disiez un peu plus sur votre projet et vos attentes ?";
                $aboutFarmTooltip = "N'hésitez pas à préciser votre projet d'installation si vous l'envisagez. (Calendrier d'installation si prévu)";
                ?>
                @include('pages.ads.partials.inputs.about_project_content', ['title' => $aboutFarmLabel, 'tooltip' => $aboutFarmTooltip])
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
                @include('pages.ads.partials.inputs.chart-confirmation', ['inputNamePrefix' => 'job_seek'])
            </section>
        </tab-content>

        @include('pages.ads.partials.new-form-wizard-footer', ["moveToRef"=>"job_seek"])
    </form-wizard>
</div>
