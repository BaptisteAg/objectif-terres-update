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
                           label="Si votre bien se situe sur plusieurs communes, merci de nous les indiquées">
                    <zone-select
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
                $params = [
                    'name' => 'job_seek[production_genres][]',
                    'productionGenres' => $productionGenres,
                    'vModel' => 'formInput.productionGenres',
                    'isRequired' => true,
                    'isUnique' => true,
                ];
                ?>
                @include('pages.ads.partials.inputs.production_genres', $params)
            </section>

            <section class="mb-6 field" ref="productionTypeAdd">
                {!! Form::label('job_seek[secondary_production_genres][]', 'Production agricole secondaire envisagée *', ['class' => 'label']); !!}
                @include('pages.ads.partials.inputs.production_genres', ['name' => 'job_seek[secondary_production_genres][]', 'productionGenres' => $productionGenres, 'vModel' => 'formInput.secondProductionGenres'])
            </section>

        </tab-content>

        @include('pages.ads.partials.new-form-wizard-footer', ["moveToRef"=>"job_offer"])
    </form-wizard>
</div>
