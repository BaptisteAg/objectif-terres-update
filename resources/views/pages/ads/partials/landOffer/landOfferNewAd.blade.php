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
                'label' => 'Communes concernées*',
                'tooltip' => 'Si votre bien se situe sur plusieurs communes, merci de nous les indiquer'
            ])

            <section class="field mb-6">
                <b-tooltip class="w-100"
                           label="Il est nécessaire que nous ayons les informations sur votre bien, à l'échelle de la commune mais l'annonce ne l'affichera pas si vous souhaitez rester plus général sur l'emplacement du foncier. Seul le département apparaitra.">
                    <div class="label">
                        {!! Form::label('land_offer[accept_use_zip_code]', 'Confidentialité'); !!}
                        <i class="fas fa-info-circle has-text-info"></i>
                    </div>
                    <b-checkbox name="land_offer[accept_use_zip_code]"
                                class="is-size-6" {{($old["land_offer"]["accept_use_zip_code"] ?? null) == 1 ? 'checked' : ''}}>
                        Je ne souhaite pas que la localisation soit publique.
                    </b-checkbox>
                </b-tooltip>
            </section>

            <section class="field mb-6" ref="surface">
                <b-tooltip class="w-100"
                           label="Il est nécessaire que nous ayons les informations sur votre bien, à l'échelle de la commune mais l'annonce ne l'affichera pas si vous souhaitez rester plus général sur l'emplacement du foncier. Seul le département apparaitra.">
                    <div class="label">
                        {!! Form::label('land_offer[surface]', 'Surface du foncier agricole *'); !!}
                        <i class="fas fa-info-circle has-text-info"></i>
                    </div>
                    <b-field>
                        <b-input name="land_offer[surface]" v-model="formInput.surface" placeholder="1ha = 10 000m²"
                        ></b-input>
                        <p class="control">
                        <span style="border-bottom-right-radius: 999px; border-top-right-radius: 999px;"
                              class="button is-static">ha</span>
                        </p>
                    </b-field>
                    <template v-if="$v.formInput.surface.$error">
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
                           label="Décrivez la répartition de la Surface Agricole Utile (SAU) : terres arables (qui peuvent être labourées ou cultivées),
                                   surfaces toujours en herbe (prairies naturelles),
                                   cultures pérennes (vignes, vergers)">
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
                <b-tooltip class="w-100"
                           label="Décrivez la nature des bâtiments agricoles présents sur la ferme (stabulation, hangar, tunnel, ...),
                                   leur surface ou leur prix si une estimation a déjà été réalisée, leur état (s'il y a des travaux à prévoir).">
                    {!! Form::label('land_offer[building][description]',  'Description des bâtiments' , [
                                                            'class' => 'label',
                                                        ]);  !!}
                    <text-area-counter
                            name="land_offer[building][description]"
                            :max-length="1000"
                            :disabled="isInputDisabled"
                            ref="buildingDescription"
                            v-model="formInput.buildingDescription"
                            :vuelidate="$v.formInput.buildingDescription">
                    </text-area-counter>
                </b-tooltip>
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
                <b-tooltip class="w-100"
                           label="Décrivez les habitations présentes sur la ferme (nombre de pièces, surface, état, prix ou modalité de cession imaginé, etc.).">
                    {!! Form::label('land_offer[house][description]',  'Description des habitations', [
                                                            'class' => 'label',
                                                        ]); !!}
                    <p>Vous pouvez mettre le prix de la location de votre habitation dans ce texte</p>
                    <text-area-counter
                            name="land_offer[house][description]"
                            :max-length="1000"
                            v-model="formInput.houseDescription"
                            :vuelidate="$v.formInput.houseDescription">
                    </text-area-counter>
                </b-tooltip>
            </section>


        </tab-content>
        <tab-content title="Potentiel agricole">
            <section class="mb-6 field" ref="productionGenres">
                {!! Form::label('land_offer[production_genres][]', 'Production agricole principale envisagée *', ['class' => 'label']); !!}
                <?php
                $params = [
                    'name' => 'land_offer[production_genres][]',
                    'productionGenres' => $productionGenres,
                    'vModel' => 'formInput.productionGenres',
                    'isUnique' => 'true',
                    'isRequired' => true
                ];
                ?>
                @include('pages.ads.partials.inputs.production_genres', $params)
            </section>

            <section class="mb-6 field" ref="productionTypeAdd">
                {!! Form::label('land_offer[secondary_production_genres][]', 'Productions agricoles secondaires envisagées', ['class' => 'label']); !!}
                @include('pages.ads.partials.inputs.production_genres', ['name' => 'land_offer[secondary_production_genres][]', 'productionGenres' => $productionGenres, 'vModel' => 'formInput.secondProductionGenres'])
            </section>

            <section class="mb-6 field" ref="bioCertifications">
                {!! Form::label('land_offer[bio_certifications][]', 'Certification des terres *', ['class' => 'label']); !!}
                <multi-select
                        :options="{{json_encode($bioCertifications)}}"
                        group-values="children"
                        name="land_offer[bio_certifications][]"
                        v-model="formInput.bioCertifications"
                        :clear-other-values="{{json_encode($bioCertifications->filter(function ($v) {
                                        return in_array($v->name, ['Aucune', 'En conversion', 'Je ne sais pas']);
                                    })->values())}}"
                        :show-icons="true"
                        placeholder="Sélectionnez une ou plusieurs certifications"
                        ref="bioCertifications">
                </multi-select>
                <p class="help is-danger" v-if="$v.formInput.bioCertifications.$error">
                    Ce champ est requis.
                </p>
            </section>

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
                <div class="column field" v-if="isSaleOffer" ref="price">
                    {!! Form::label('land_offer[price]', 'Prix de vente*', [
                                        'class' => 'label',
                                    ]); !!}
                    {!! Form::text('land_offer[price]', $old['land_offer']['price'] ?? null, [
                                                                'class' => 'input',
                                                                'v-model' => 'formInput.price',
                                                                ':disabled'=>'isInputDisabled',
                                                            ]) !!}
                    <template v-if="$v.formInput.price.$error">
                        <p class="help is-danger" v-if="$v.formInput.price.required">
                            Ce champ est requis.
                        </p>
                        <p class="help is-danger" v-if="!$v.formInput.price.numeric">
                            Veuillez saisir un nombre.
                        </p>
                    </template>
                </div>
                <div class="column field" v-if="isRentOffer" ref="rentPrice">
                    {!! Form::label('land_offer[rent_price]', 'Fermage annuel', [
                                        'class' => 'label',
                                    ]); !!}
                    {!! Form::text('land_offer[rent_price]', $old['land_offer']['rent_price'] ?? null, [
                                                                'class' => 'input',
                                                                'v-model' => 'formInput.rentPrice',
                                                                ':disabled'=>'isInputDisabled',
                                                            ]) !!}
                    <template v-if="$v.formInput.rentPrice.$error">
                        <p class="help is-danger" v-if="$v.formInput.rentPrice.required">
                            Ce champ est requis.
                        </p>
                        <p class="help is-danger" v-if="!$v.formInput.rentPrice.numeric">
                            Veuillez saisir un nombre.
                        </p>
                    </template>
                </div>
                <div class="column is-full" v-if="isSaleOffer">
                    <b-checkbox name="land_offer.is_sales_offer_evaluation"
                                v-model="formInput.is_sales_offer_evaluation">En cours d'évaluation
                    </b-checkbox>
                </div>
            </section>

            <section class="mb-6 field" ref="testDescription" v-if="isTestOffer">
                {!! Form::label('land_offer[test_description]', 'Modalité du test agricole', [
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
