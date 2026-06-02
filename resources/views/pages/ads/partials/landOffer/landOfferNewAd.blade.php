<div id="land_offer_form" class="form-container pt-6">
    <form-wizard
            title=""
            subtitle=""
            step-size="xs"
            @on-complete="$emit('form-complete')"
            @on-change="nextStep"
            color="#A74B2B"
            ref="formWizard">

        <tab-content title="Terres proposées">

            @include('pages.ads.partials.inputs.main_department')

            @include('pages.ads.partials.inputs.other_locations', [
                'label' => 'Communes concernées *',
                'tooltip' => 'Si votre bien se situe sur plusieurs communes, merci de toutes les indiquer : Sélectionnez les communes dans la liste à partir du nom ou du code postal'
            ])

            @include('pages.ads.partials.inputs.accept_use_zip_code', [
                'name' => 'land_offer[accept_use_zip_code]',
                'vModel' => 'formInput.acceptUseZipCode',
            ])

            @include('pages.ads.partials.inputs.surface',[
                'adType' => 'land_offer',
            ])

            <section class="field mb-6" ref="altitude">
                <b-tooltip class="w-100"
                           label="Important pour savoir si votre terrain convient à certains projets agricoles">
                    <div class="label">
                        {!! Form::label('land_offer[altitude]', 'Altitude'); !!}
                        <i class="fas fa-info-circle has-text-info"></i>
                    </div>
                    <b-field>
                        <b-input name="land_offer[altitude]" v-model="formInput.altitude"
                        ></b-input>
                        <p class="control">
                        <span style="border-bottom-right-radius: 999px; border-top-right-radius: 999px;"
                              class="button is-static">m</span>
                        </p>
                    </b-field>
                    <template v-if="$v.formInput.altitude.$error">
                        <p class="help is-danger" v-if="$v.formInput.altitude.required">
                            Ce champ est requis.
                        </p>
                        <p class="help is-danger" v-if="!$v.formInput.altitude.numeric">
                            Veuillez saisir un nombre.
                        </p>
                    </template>
                </b-tooltip>
            </section>

            <section class="mb-6 field" ref="sauDescription">
                <b-tooltip class="w-100"
                           label="Décrivez la répartition de la SAU (Surface Agricole Utile) avec la nature des terres et leur mode de faire valoir : Propriétés, fermages.">
                    <div class="label">
                        {!! Form::label('land_offer[altitude]', 'Description du foncier agricole'); !!}
                        <i class="fas fa-info-circle has-text-info"></i>
                    </div>
                    <text-area-counter
                            name="land_offer[sau_description]"
                            :max-length="1000"
                            :disabled="isInputDisabled"
                            ref="sauDescription"
                            v-model="formInput.sauDescription"
                            :vuelidate="$v.formInput.sauDescription">
                    </text-area-counter>
                </b-tooltip>
            </section>

            <section class="mb-6 is-flex gap-x-5 field is-flex-wrap-wrap" ref="waterAccess">
                {!! Form::label('land_offer[water_access]', "Accès à l'eau existant *", ['class' => 'label w-100']) !!}
                <div>
                    {!! Form::radio('land_offer[water_access]', '1', null , ['id' => 'land_offer[water_access]_1', 'v-model' => 'formInput.waterAccess'] ) !!}
                    {!! Form::label('land_offer[water_access]_1',  'Oui' ) !!}
                </div>
                <div>
                    {!! Form::radio('land_offer[water_access]', '0', null , ['id' => 'land_offer[water_access]_0', 'v-model' => 'formInput.waterAccess']) !!}
                    {!! Form::label('land_offer[water_access]_0',  'Non' ) !!}
                </div>
                <div>
                    {!! Form::radio('land_offer[water_access]', '-1', null , ['id' => 'land_offer[water_access]__1', 'v-model' => 'formInput.waterAccess']) !!}
                    {!! Form::label('land_offer[water_access]__1',  'Je ne sais pas' ) !!}
                </div>
                <p class="help is-danger w-100"
                   v-if="$v.formInput.waterAccess.$error">
                    Ce champ est requis.
                </p>
            </section>

            <section class="field mb-6" ref="waterAccessDescription" v-show="hasWaterAccess">
                <b-tooltip class="w-100"
                           label="Indiquez les modalités d'accès à l'eau, ainsi qu'un rapide descriptif (forage, réserve d'eau, canal d'irrigation, borne, etc.)..">
                    {!! Form::label('land_offer[water_access_description]', "Précisez votre accès à l'eau", ['class' => 'label']) !!}
                    <text-area-counter
                            name="land_offer[water_access_description]"
                            :max-length="200"
                            :disabled="isInputDisabled"
                            ref="waterAccessDescription"
                            v-model="formInput.waterAccessDescription"
                            :vuelidate="$v.formInput.waterAccessDescription">
                    </text-area-counter>
                </b-tooltip>
            </section>

            <section class="mb-6 is-flex gap-x-5 field is-flex-wrap-wrap" ref="hasBuildings">
                {!! Form::label('land_offer[has_buildings]', "Présence de bâtiment(s) agricole(s) *", ['class' => 'label w-100']) !!}
                <div>
                    {!! Form::radio('land_offer[has_buildings]', '1', null , ['id' => 'land_offer[has_buildings]_1', 'v-model' => 'formInput.hasBuildings', ':vuelidate' => '$v.formInput.hasBuildings'] ) !!}
                    {!! Form::label('land_offer[has_buildings]_1',  'Oui' ) !!}
                </div>
                <div>

                    {!! Form::radio('land_offer[has_buildings]', '0', null , ['id' => 'land_offer[has_buildings]_0', 'v-model' => 'formInput.hasBuildings', ':vuelidate' => '$v.formInput.hasBuildings']) !!}
                    {!! Form::label('land_offer[has_buildings]_0',  'Non' ) !!}
                </div>
            </section>

            <section class="field mb-6" v-show="formInput.hasBuildings == '1'">
                <div class="label">
                    {!! Form::label('land_offer[building][description]', 'Description des bâtiments'); !!}
                    <i class="fas fa-info-circle has-text-info"></i>
                </div>
                <p>Vous pouvez indiquer ici le prix (vente ou location) de vos bâtiments agricoles</p>
                <text-area-counter
                        name="land_offer[building][description]"
                        :max-length="1000"
                        :disabled="isInputDisabled"
                        ref="buildingDescription"
                        v-model="formInput.buildingDescription"
                        :vuelidate="$v.formInput.buildingDescription">
                </text-area-counter>
            </section>

            <section class="mb-6 is-flex gap-x-5 field is-flex-wrap-wrap" ref="hasHouses">
                {!! Form::label('land_offer[has_houses]', "Présence d'habitation(s) *", ['class' => 'label w-100']) !!}
                <div>
                    {!! Form::radio('land_offer[has_houses]', '1', null , ['id' => 'land_offer[has_houses]_1', 'v-model' => 'formInput.hasHouses', ':vuelidate' => '$v.formInput.hasHouses'] ) !!}
                    {!! Form::label('land_offer[has_houses]_1',  'Oui' ) !!}
                </div>
                <div>
                    {!! Form::radio('land_offer[has_houses]', '0', null , ['id' => 'land_offer[has_houses]_0', 'v-model' => 'formInput.hasHouses', ':vuelidate' => '$v.formInput.hasHouses']) !!}
                    {!! Form::label('land_offer[has_houses]_0',  'Non' ) !!}
                </div>
            </section>

            <section class="field mb-6" v-show="formInput.hasHouses == '1'" ref="houseDescription">
                <div class="label">
                    {!! Form::label('land_offer[house][description]', 'Description des bâtiments d\'habitation'); !!}
                    <i class="fas fa-info-circle has-text-info"></i>
                </div>
                <p>Vous pouvez indiquer ici le prix (vente ou location) des habitations</p>
                <text-area-counter
                        name="land_offer[house][description]"
                        :max-length="1000"
                        v-model="formInput.houseDescription"
                        :vuelidate="$v.formInput.houseDescription">
                </text-area-counter>
            </section>


        </tab-content>
        <tab-content title="Potentiel agricole">

            <section class="mb-6 field" ref="productionGenres">
                @include('pages.ads.partials.inputs.production_genres', [
                    'name' => 'land_offer[production_genres][]',
                    'productionGenres' => $productionGenres,
                    'vModel' => 'formInput.productionGenres',
                    'isRequired' => true,
                    'isUnique' => true,
                    'label' => 'Production principale',
                ])
            </section>

            <section class="mb-6 field" ref="productionGenresSecondary">
                @include('pages.ads.partials.inputs.production_genres', [
                    'name' => 'land_offer[secondary_production_genres][]',
                    'productionGenres' => $productionGenres,
                    'vModel' => 'formInput.productionGenresSecondary',
                    'label' => 'Production(s) secondaire(s)',
                ])
            </section>

            @include('pages.ads.partials.inputs.bio_certifications', [
                "adType" => "land_offer",
            ])

            <section class="mb-6 field" ref="offerGenres">
                <div class="block">
                    {!! Form::label('land_offer[offer_genres][]', 'Vous proposez ces terres*', ['class' => 'label']); !!}
                    @foreach($offerGenres as $offerGenre)
                        <b-checkbox name="land_offer[offer_genres][]" native-value="{{ $offerGenre["id"] }}"
                                    v-model="formInput.offerGenres">
                            {{ $offerGenre["land_offer_label"] }}
                        </b-checkbox>
                    @endforeach
                </div>

                <p id="offerGenreIdError" class="help is-danger" v-if="$v.formInput.offerGenres.$error">
                    Ce champ est requis.
                </p>
            </section>

            <section class="mb-6 columns is-flex-wrap-wrap">
                <div class="column is-full" v-if="isSaleOffer">
                    <b-checkbox class="has-text-weight-bold"
                                v-model="formInput.isSaleOfferEvaluation">Prix de vente en cours d'évaluation
                    </b-checkbox>
                    <input type="hidden" name="land_offer[is_sales_offer_evaluation]"
                           :value="formInput.isSaleOfferEvaluation ? 1 : 0">
                </div>
                <div class="column field" v-if="isSaleOffer && !formInput.isSaleOfferEvaluation" ref="price">
                    {!! Form::label('land_offer[price]', 'Prix de vente *', ['class' => 'label']); !!}
                    {!! Form::text('land_offer[price]', null, [
                                                                'class' => 'input',
                                                                'v-model' => 'formInput.price',
                                                            ]) !!}
                    <template v-if="$v.formInput.price.$error">
                        <p class="help is-danger" v-if="$v.formInput.price.required">
                            Ce champ est requis.
                        </p>
                        <p class="help is-danger" v-if="!$v.formInput.price.numeric">
                            Veuillez saisir un nombre.
                        </p>
                    </template>
                    <p>
                        Vous pouvez vérifier votre prix de vente en consultant le site de la SAFER : <a
                                href="https://www.le-prix-des-terres.fr" target="_blank">Le prix des terres</a>.
                        <br>Si votre prix n'est pas dans la moyenne des prix de votre
                        département, nous pouvons refuser la publication de votre annonce.
                    </p>
                </div>
                <div class="column field" v-show="isRentOffer" ref="rentPrice">
                    <b-tooltip label="Les fermages sont définis avec les bâtiments agricoles qui se trouvent dessus.">
                        {!! Form::label('land_offer[rent_price]', 'Fermage annuel *', [
                                            'class' => 'label',
                                        ]); !!}
                        {!! Form::text('land_offer[rent_price]', null, [
                                                                    'class' => 'input',
                                                                    'v-model' => 'formInput.rentPrice',
                                                                ]) !!}
                    </b-tooltip>
                    <template v-if="$v.formInput.rentPrice.$error">
                        <p class="help is-danger" v-if="$v.formInput.rentPrice.required">
                            Ce champ est requis.
                        </p>
                        <p class="help is-danger" v-if="!$v.formInput.rentPrice.numeric">
                            Veuillez saisir un nombre.
                        </p>
                    </template>
                </div>
            </section>

            <section class="mb-6 field" ref="testDescription" v-show="isTestOffer">
                {!! Form::label('land_offer[test_description]', 'Modalité du test agricole *', [
                                                        'class' => 'label',
                                                    ]); !!}
                <text-area-counter
                        name="land_offer[test_description]"
                        :max-length="1000"
                        v-model="formInput.testDescription"
                        :vuelidate="$v.formInput.testDescription">
                </text-area-counter>
            </section>

        </tab-content>

        <tab-content title="C'est presque fini !">
            <section class="field mb-6" ref="aboutProject">
                <?php
                $aboutProjectTooltip = "N'oubliez pas de préciser le calendrier de transmission envisagée";
                ?>
                @include('pages.ads.partials.inputs.about_project_content', ['title'=> 'Et si vous nous en disiez un peu plus sur la transmission de ces terres ?','tooltip' => $aboutProjectTooltip])
            </section>

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
                @include('pages.ads.partials.inputs.chart-confirmation', ['inputNamePrefix' => 'land_seek'])
            </section>
        </tab-content>

        @include('pages.ads.partials.new-form-wizard-footer', ["moveToRef"=>"land_offer"])
    </form-wizard>
</div>
