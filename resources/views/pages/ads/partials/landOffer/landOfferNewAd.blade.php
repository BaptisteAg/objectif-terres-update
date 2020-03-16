<div id="land_offer_form">
    <form-wizard
            title=""
            subtitle=""
            step-size="xs"
            @on-complete="$emit('form-complete')"
            color="#3498db"
            ref="formWizard">
        <tab-content title="Foncier" icon="ti-location-arrow">
            <section class="container">
                <div class="columns">
                    <div class="column"></div>
                    <div class="column is-half">

                        @include('pages.ads.partials.inputs.zip_code', ["uri"=>"cities-and-departments"])

                        <div class="field has-tooltip-left" data-tooltip="Ce choix peut rendre votre annonce moins visible lors des recherches.">
                            <label for="land_offer[accept_use_zip_code]" class="checkbox">
                                {!! Form::checkbox('land_offer[accept_use_zip_code]', '0', old('land_offer[accept_use_zip_code]'), [
                                    "id" =>"land_offer[accept_use_zip_code]",
                                    ':disabled'=>'isInputDisabled'
                                ]) !!}
                                <span>
                                    Je ne souhaite pas que le code postal de mon bien soit rendu public. Dans ce cas, mon
                                    annonce sera
                                    référencée au niveau du département.
                                </span>
                            </label>
                        </div>

                        <div class="field">
                            {!! Form::label('land_offer[surface]', 'Surface totale du foncier agricole*', [
                                'class' => 'label has-tooltip-left',
                                'data-tooltip' => '1ha = 10 000m²'
                            ]); !!}

                            <div class="columns">
                                <div class="column is-half">
                                    <div class="control has-icons-right">
                                        {!! Form::number('land_offer[surface]', null, [
                                            'class' => 'input',
                                            ':disabled'=>'isInputDisabled',
                                            'v-model' => 'formInput.surface',
                                            'ref' => 'surface'
                                        ]) !!}
                                        <span class="icon is-small is-right" style="color: #4a4a4a;">
                                          ha
                                        </span>
                                    </div>

                                    <template v-if="$v.formInput.surface.$error">
                                        <p class="help is-danger" v-if="!$v.formInput.surface.maxValue">
                                            Surface maximum : @{{$v.formInput.surface.$params.maxValue.max}} hectares.
                                        </p>
                                        <p class="help is-danger" v-if="!$v.formInput.surface.required">
                                            Ce champ est requis.
                                        </p>
                                    </template>
                                </div>
                                <div class="column is-half">
                                    <p v-if="formInput.surface">
                                        = @{{ (formInput.surface*10000).toLocaleString() }}m²
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label is-inline-block has-tooltip-multiline has-tooltip-left"
                                   data-tooltip="Décrivez la répartition de la SAU :
                                   terres arables (qui peuvent être labourées ou cultivées),
                                   surfaces toujours en herbe (prairies naturelles),
                                   cultures pérennes (vignes, vergers)"
                                   for="about_project_content">
                                Description de la Surface Agricole Utile (SAU)
                                <i class="fas fa-info-circle has-text-info"></i>
                            </label>

                            <text-area-counter
                                    name="land_offer[sau_description]"
                                    :max-length="1000"
                                    :disabled="isInputDisabled"
                                    ref="sauDescription"
                                    v-model="formInput.sauDescription"
                                    :vuelidate="$v.formInput.sauDescription">
                            </text-area-counter>
                        </div>
                    </div>
                    <div class="column"></div>
                </div>
            </section>
        </tab-content>

        <tab-content title="Production Agricole" icon="ti-location-arrow">
            <section class="container">
                <div class="columns">
                    <div class="column"></div>
                    <div class="column is-half">
                        <div class="field">
                            {!! Form::label('land_offer[production_genres][]', 'Système de production en place', ['class' => 'label']); !!}

                            <multi-select
                                    :options="{{json_encode($productionGenres)}}"
                                    group-values="children"
                                    name="land_offer[production_genres][]"
                                    v-model="formInput.productionGenres"
                                    placeholder="Sélectionnez une ou plusieurs productions"
                                    ref="productionGenres">
                            </multi-select>

                            {{--                            <p class="help is-danger" id="productionGenresError"--}}
                            {{--                               v-if="$v.formInput.productionGenres.$error">--}}
                            {{--                                Ce champ est requis.--}}
                            {{--                            </p>--}}
                        </div>

                        <div class="field">
                            {!! Form::label('land_offer[production_genres_wanted][]', 'Productions possibles sur la ferme', ['class' => 'label']); !!}

                            <multi-select
                                    :options="{{json_encode($productionGenres)}}"
                                    group-values="children"
                                    name="land_offer[production_genres_wanted][]"
                                    v-model="formInput.productionGenresWanted"
                                    placeholder="Sélectionnez une ou plusieurs productions"
                                    ref="productionGenresWanted">
                            </multi-select>
                        </div>

                        <div class="field">
                            {!! Form::label('land_offer[bio_certifications][]', 'Certification des terres', ['class' => 'label']); !!}

                            <multi-select
                                    :options="{{json_encode($bioCertifications)}}"
                                    group-values="children"
                                    name="land_offer[bio_certifications][]"
                                    v-model="formInput.bioCertifications"
                                    :clear-other-values="{{json_encode($bioCertifications->filter(function ($v) {
                                        return in_array($v->name, ['Aucune', 'En conversion']);
                                    }))}}"
                                    :show-icons="true"
                                    placeholder="Sélectionnez une ou plusieurs certifications"
                                    ref="bioCertifications">
                            </multi-select>
                        </div>

                        <div class="field">
                            {!! Form::label('land_offer[water_access]', "Accès à l'eau existant", ['class' => 'label']); !!}
                            <div>
                                <label>
                                    {!! Form::radio('land_offer[water_access]', 1, null, [
                                            'v-model' => 'formInput.waterAccess',
                                            ':disabled' => 'isInputDisabled'
                                        ]);
                                    !!}
                                    Oui
                                </label>
                                <label>
                                    {!! Form::radio('land_offer[water_access]', 0, null, [
                                            'v-model' => 'formInput.waterAccess',
                                            ':disabled' => 'isInputDisabled'
                                        ]);
                                    !!}
                                    Non
                                </label>
                            </div>
                        </div>
                        <div class="field" v-show="hasWaterAccess">
                            <label for='land_offer[water_access_description]'
                                   class="tooltip has-tooltip-left has-tooltip-multiline"
                                   data-tooltip="Indiquez les modalités d'accès à l'eau, ainsi qu'un rapide descriptif (forage, réserve d'eau, canal d'irrigation, borne, etc.)..">
                                Précisez votre accès à l'eau
                                <i class="fas fa-info-circle has-text-info"></i>
                            </label>
                            <text-area-counter
                                    name="land_offer[water_access_description]"
                                    :max-length="1000"
                                    :disabled="isInputDisabled"
                                    ref="waterAccessDescription"
                                    v-model="formInput.waterAccessDescription"
                                    :vuelidate="$v.formInput.waterAccessDescription">
                            </text-area-counter>
                        </div>

                        <div class="field">
                            {!! Form::label('land_offer[altitude]', 'Altitude*', [
                                'ref' => 'altitude',
                                'class' => 'label',
                            ]); !!}

                            <div class="columns">
                                <div class="column is-half">
                                    <div class="control has-icons-right">
                                        {!! Form::number('land_offer[altitude]',null, [
                                            'v-model' => 'formInput.altitude',
                                            'class' => 'input',
                                            ':disabled'=>'isInputDisabled',
                                        ]) !!}
                                        <span class="icon is-small is-right" style="color: #4a4a4a;">
                                          m
                                        </span>
                                    </div>

                                    <p class="help is-danger" v-if="$v.formInput.altitude.$error">
                                        Ce champ est requis.
                                    </p>
                                </div>
                                <div class="column"></div>
                            </div>
                        </div>
                    </div>
                    <div class="column"></div>
                </div>
            </section>
        </tab-content>

        <tab-content title="Bâtiment(s)" icon="ti-share">
            <section class="container">
                <div class="columns">
                    <div class="column"></div>
                    <div class="column is-half">
                        <div class="field">
                            {!! Form::label('land_offer[has_buildings]', "Présence de bâtiment(s) agricole(s)", ['class' => 'label']) !!}
                            {!! Form::radio('land_offer[has_buildings]', 1, null , [
                                'v-model' => 'formInput.hasBuildings',
                                ':disabled' => 'isInputDisabled'
                            ]) !!}
                            oui
                            {!! Form::radio('land_offer[has_buildings]', 0, null , [
                                'v-model' => 'formInput.hasBuildings',
                                ':disabled' => 'isInputDisabled'
                            ]) !!}
                            non
                        </div>
                        <div class="field" v-show="formInput.hasBuildings == 1">
                            <label for='land_offer[buildings_description]'
                                   class="tooltip has-tooltip-multiline has-tooltip-left"
                                   data-tooltip="Décrivez la nature des bâtiments agricoles présents sur la ferme (stabulation, hangar, tunnel, ...),
                                   leur surface ou leur prix si une estimation a déjà été réalisée, leur état (s'il y a des travaux à prévoir).">
                                Description des bâtiments
                                <i class="fas fa-info-circle has-text-info"></i>
                            </label>
                            <text-area-counter
                                    name="land_offer[buildings_description]"
                                    :max-length="1000"
                                    :disabled="isInputDisabled"
                                    ref="buildingsDescription"
                                    v-model="formInput.buildingsDescription"
                                    :vuelidate="$v.formInput.buildingsDescription">
                            </text-area-counter>
                        </div>

                        <div class="field">
                            {!! Form::label('land_offer[has_houses]', "Présence d'habitation(s)", ['class' => 'label']) !!}
                            {!! Form::radio('land_offer[has_houses]', 1, null, [
                                'v-model' => 'formInput.hasHouses',
                                ':disabled' => 'isInputDisabled'
                            ]) !!}
                            oui
                            {!! Form::radio('land_offer[has_houses]', 0, null, [
                                'v-model' => 'formInput.hasHouses',
                                ':disabled' => 'isInputDisabled'
                            ]) !!}
                            non
                        </div>
                        <div class="field" v-show="formInput.hasHouses == 1">
                            <label for='land_offer[houses_description]'
                                   class="tooltip has-tooltip-multiline has-tooltip-left"
                                   data-tooltip="Décrivez les habitations présentes sur la ferme (nombre de pièces, surface, état, prix ou modalité de cession imaginé, etc.).">
                                Description des habitations
                                <i class="fas fa-info-circle has-text-info"></i>
                            </label>
                            <text-area-counter
                                    name="land_offer[houses_description]"
                                    :max-length="1000"
                                    :disabled="isInputDisabled"
                                    ref="housesDescription"
                                    v-model="formInput.housesDescription"
                                    :vuelidate="$v.formInput.housesDescription">
                            </text-area-counter>
                        </div>
                    </div>
                    <div class="column"></div>
                </div>
            </section>
        </tab-content>

        <tab-content title="Prix et modalités" icon="ti-share">
            <section class="container">
                <div class="columns">
                    <div class="column"></div>
                    <div class="column is-half">

                        <div class="field">
                            {!! Form::label('land_offer[offer_genres][]', 'Vous proposez ce bien*', ['class' => 'label']); !!}

                            <?php
                            $offerGenresFaIcons = ["fa-user", "fa-user-friends", "fa-users"]
                            ?>

                            <div class="columns">
                                @foreach($offerGenres as $i => $offerGenre)
                                    <div class="column">
                                        <custom-checkbox
                                                name="land_offer[offer_genres][]"
                                                input-value="{{$offerGenre["id"]}}"
                                                v-model="formInput.offerGenres"
                                                :disabled="isInputDisabled"
                                                ref="offerGenres">

                                            <i class="fa {{ $offerGenresFaIcons[$i] }}"
                                               style="font-size: 30px;"></i><br><br>
                                            <span style="font-size:16px">
                                                {{ $offerGenre["land_offer_label"] }}
                                            </span>
                                        </custom-checkbox>
                                    </div>
                                @endforeach
                            </div>

                            <p id="offerGenreIdError" class="help is-danger" v-if="$v.formInput.offerGenres.$error">
                                Ce champ est requis.
                            </p>
                        </div>

                        <div class="columns">
                            <div class="column is-half" v-if="isSaleOffer">
                                <div class="field">
                                    {!! Form::label('land_offer[price]', 'Prix de vente*', [
                                        'class' => 'label',
                                    ]); !!}

                                    <div class="control has-icons-right">
                                        {!! Form::number('land_offer[price]', old('land_offer[price]'), [
                                            'class' => 'input',
                                            'ref' => 'price',
                                            'v-model' => 'formInput.price',
                                            ':disabled'=>'isInputDisabled',
                                        ]) !!}
                                        <span class="icon is-small is-right" style="color: #4a4a4a;">
                                          €
                                        </span>
                                    </div>

                                    <p class="help is-danger" v-if="$v.formInput.price.$error">
                                        Ce champ est requis.
                                    </p>
                                </div>
                            </div>
                            <div class="column is-half" v-if="isRentOffer">
                                <div class="field">
                                    {!! Form::label('land_offer[rent_price]', 'Loyer mensuel*', [
                                        'class' => 'label',
                                    ]); !!}

                                    <div class="control has-icons-right">
                                        {!! Form::number('land_offer[rent_price]', old('land_offer[rent_price]'), [
                                            'class' => 'input',
                                            'ref' => 'rentPrice',
                                            'v-model' => 'formInput.rentPrice',
                                            ':disabled'=>'isInputDisabled',
                                        ]) !!}
                                        <span class="icon is-small is-right" style="color: #4a4a4a;">
                                          €
                                        </span>
                                    </div>
                                    <p class="help is-danger" v-if="$v.formInput.rentPrice.$error">
                                        Ce champ est requis.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="field" v-if="isTestOffer">
                            <label for='land_offer[test_description]'
                                   class="has-tooltip-multiline has-tooltip-left"
                                   data-tooltip="Décrivez les habitations présentes sur la ferme (nombre de pièces, surface, état, prix ou modalité de cession imaginé, etc.).">
                                Description du test agricole
                                <i class="fas fa-info-circle has-text-info"></i>
                            </label>
                            <text-area-counter
                                    name="land_offer[test_description]"
                                    :max-length="1000"
                                    :disabled="isInputDisabled"
                                    ref="testDescription"
                                    v-model="formInput.testDescription"
                                    :vuelidate="$v.formInput.testDescription">
                            </text-area-counter>
                        </div>
                    </div>
                    <div class="column"></div>
                </div>
            </section>
        </tab-content>


        <tab-content title="Autres informations" icon="ti-share">
            <section class="container">
                <div class="columns">
                    <div class="column"></div>
                    <div class="column is-half">
                        <?php
                            $aboutProjectTooltip = "Parce qu’il y a derrière chaque projet et chaque lieu des personnes
                                                    et des histoires, nous vous invitons ici à en dire un peu plus sur votre projet :
                                                    qu’est-ce qui motive votre projet ? Quelles sont vos attentes ?
                                                    Quelles sont les valeurs qui vous portent ?
                                                    Quelle est l’histoire du lieu ?
                                                    Quelles sont les conditions de la transmission le cas échéant  ?
                                                    Quel type de personnes et de projet agricole recherchez-vous ?";
                        ?>
                        @include('pages.ads.partials.inputs.about_project_content', ['tooltip' => $aboutProjectTooltip])

                        @include('pages.ads.partials.inputs.about_content')
                    </div>
                    <div class="column"></div>
                </div>
            </section>
        </tab-content>


        <tab-content title="C'est presque fini !" icon="ti-share">
            <section class="container">
                <div class="columns">
                    <div class="column"></div>
                    <div class="column is-half">
                        <?php
                            $titleTooltip = 'Décrivez précisément et succintement le bien proposé. Ne pas mentionner "Vente" ou "Location" dans le titre.';
                        ?>
                        @include('pages.ads.partials.inputs.title', ["tooltip"=>$titleTooltip])

                        @include('pages.ads.partials.inputs.documents')

                        @include('pages.ads.partials.inputs.accept-share-contact-infos')

                        @include('pages.ads.partials.inputs.chart-confirmation', ['inputNamePrefix' => 'land_offer'])

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

        @include('pages.ads.partials.form-wizard-footer', ["moveToRef"=>"land_offer"])
    </form-wizard>
</div>
