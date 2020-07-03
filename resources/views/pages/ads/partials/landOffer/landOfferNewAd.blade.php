<div id="land_offer_form" class="form-container">
    <form-wizard
            title=""
            subtitle=""
            step-size="xs"
            @on-complete="$emit('form-complete')"
            @on-change="nextStep"
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
                            {!! Form::label('land_offer[surface]', 'Surface du foncier agricole*', [
                                'class' => 'label has-tooltip-left',
                                'data-tooltip' => '1ha = 10 000m²'
                            ]); !!}

                            <div class="columns">
                                <div class="column is-half">
                                    <div class="control has-icons-right">
                                        {!! Form::text('land_offer[surface]', null, [
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
                                        <p class="help is-danger" v-if="!$v.formInput.surface.numeric">
                                            Veuillez saisir un nombre.
                                        </p>
                                    </template>
                                </div>
                                <div class="column is-half">
                                    <p v-if="formInput.surface">
                                        = @{{ isNaN(formInput.surface) ? 0 : (formInput.surface*10000).toLocaleString() }}m²
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label is-inline-block has-tooltip-multiline has-tooltip-left"
                                   data-tooltip="Décrivez la répartition de la Surface Agricole Utile (SAU) : terres arables (qui peuvent être labourées ou cultivées),
                                   surfaces toujours en herbe (prairies naturelles),
                                   cultures pérennes (vignes, vergers)">
                                Description du foncier agricole
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

                        <div class="field">
                            <label for="land_offer[altitude]"
                                    ref="altitude"
                                    class="label has-tooltip has-tooltip-left"
                                    data-tooltip="Important pour savoir si votre terrain convient à certains projets agricoles">
                                Altitude
                                <i class="fas fa-info-circle has-text-info"></i>
                            </label>

                            <div class="columns">
                                <div class="column is-half">
                                    <div class="control has-icons-right">
                                        {!! Form::text('land_offer[altitude]',null, [
                                            'v-model' => 'formInput.altitude',
                                            'class' => 'input',
                                            ':disabled'=>'isInputDisabled',
                                            'ref' => 'altitude'
                                        ]) !!}
                                        <span class="icon is-small is-right" style="color: #4a4a4a;">
                                          m
                                        </span>
                                    </div>
                                    <template v-if="$v.formInput.altitude.$error">
                                        <p class="help is-danger" v-if="$v.formInput.altitude.required">
                                            Ce champ est requis.
                                        </p>
                                        <p class="help is-danger" v-if="!$v.formInput.altitude.numeric">
                                            Veuillez saisir un nombre.
                                        </p>
                                    </template>
                                </div>
                                <div class="column"></div>
                            </div>
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
                        @if(!empty($isSupportRequest))
                            <div class="field">
                                {!! Form::label('landOffer[is_activity_transfer]', 'Transmission d\'activité (ferme toujours en fonctionnement)*', ['class' => 'label']) !!}

                                {!! Form::radio('landOffer[is_activity_transfer]',
                                    1,
                                    old('landOffer[is_activity_transfer]'),
                                    [':disabled' => 'isInputDisabled',
                                    'v-model' => 'formInput.isActivityTransfer',
                                    'ref' => 'formInput.isActivityTransfer',
                                    'aria-describedby'=>'isActivityTransferError'])
                                !!} Oui

                                {!! Form::radio('landOffer[is_activity_transfer]',
                                    0,
                                    old('landOffer[is_activity_transfer]'),
                                    [':disabled' => 'isInputDisabled',
                                    'v-model' => 'formInput.isActivityTransfer',
                                    'ref' => 'formInput.isActivityTransfer',
                                    'aria-describedby'=>'isActivityTransferError'])
                                !!} Non

                                <p class="help is-danger" v-if="$v.formInput.isActivityTransfer.$error">
                                    Ce champ est requis.
                                </p>
                            </div>
                        @endif

                        <div class="field">
                            {!! Form::label('land_offer[production_genres][]', 'Production(s) en place*', [
                                'class' => 'label tooltip has-tooltip-left has-tooltip-multiline',
                                'data-tooltip' => "Sélectionner la ou les productions actuellement en cours sur la ferme ou le terrain."
                            ]); !!}

{{--                            <multi-select--}}
{{--                                    :options="{{json_encode($productionGenres)}}"--}}
{{--                                    group-values="children"--}}
{{--                                    name="land_offer[production_genres][]"--}}
{{--                                    v-model="formInput.productionGenres"--}}
{{--                                    placeholder="Sélectionnez une ou plusieurs productions"--}}
{{--                                    ref="productionGenres">--}}
{{--                            </multi-select>--}}

                            @include('pages.ads.partials.inputs.production_genres', ['name' => 'land_offer[production_genres][]', 'productionGenres' => $productionGenres])
                            <p class="help is-danger" v-if="$v.formInput.productionGenres.$error">
                                Ce champ est requis.
                            </p>
                        </div>

                        <div class="field">
                            {!! Form::label('land_offer[production_genres_wanted][]', 'Production(s) possibles', [
                                'class' => 'label tooltip has-tooltip-left has-tooltip-multiline',
                                'data-tooltip' => 'Sélectionner les productions envisageables sur la ferme ou le terrain.'
                            ]); !!}

                            @include('pages.ads.partials.inputs.production_genres', ['name' => 'land_offer[production_genres_wanted][]', 'inputName' => array_slice((array)$productionGenres, 1)])
{{--                            <multi-select--}}
{{--                                    :options="{{json_encode($productionGenres)}}"--}}
{{--                                    group-values="children"--}}
{{--                                    name="land_offer[production_genres_wanted][]"--}}
{{--                                    v-model="formInput.productionGenresWanted"--}}
{{--                                    placeholder="Sélectionnez une ou plusieurs productions"--}}
{{--                                    ref="productionGenresWanted">--}}
{{--                            </multi-select>--}}
                        </div>

                        <div class="field">
                            {!! Form::label('land_offer[bio_certifications][]', 'Certification des terres*', ['class' => 'label']); !!}

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
                            <p class="help is-danger" v-if="$v.formInput.bioCertifications.$error">
                                Ce champ est requis.
                            </p>
                        </div>

                        <div class="field">
                            {!! Form::label('land_offer[water_access]', "Accès à l'eau existant*", ['class' => 'label']); !!}
                            <div>
                                <label>
                                    {!! Form::radio('land_offer[water_access]', 1, null, [
                                            'v-model' => 'formInput.waterAccess',
                                            'ref' => 'waterAccess',
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
                                <label>
                                    {!! Form::radio('land_offer[water_access]', -1, null, [
                                            'v-model' => 'formInput.waterAccess',
                                            ':disabled' => 'isInputDisabled'
                                        ]);
                                    !!}
                                    Je ne sais pas
                                </label>
                            </div>
                            <p class="help is-danger" v-if="$v.formInput.waterAccess.$error">
                                Ce champ est requis.
                            </p>
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
                                    :max-length="200"
                                    :disabled="isInputDisabled"
                                    ref="waterAccessDescription"
                                    v-model="formInput.waterAccessDescription"
                                    :vuelidate="$v.formInput.waterAccessDescription">
                            </text-area-counter>
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
                        <div v-show="formInput.hasBuildings === '1'">
                            <div class="field">
                                <label for='land_offer[building][description]'
                                       class="tooltip has-tooltip-multiline has-tooltip-left"
                                       data-tooltip="Décrivez la nature des bâtiments agricoles présents sur la ferme (stabulation, hangar, tunnel, ...),
                                   leur surface ou leur prix si une estimation a déjà été réalisée, leur état (s'il y a des travaux à prévoir).">
                                    Description des bâtiments
                                    <i class="fas fa-info-circle has-text-info"></i>
                                </label>
                                <text-area-counter
                                        name="land_offer[building][description]"
                                        :max-length="1000"
                                        :disabled="isInputDisabled"
                                        ref="buildingDescription"
                                        v-model="formInput.buildingDescription"
                                        :vuelidate="$v.formInput.buildingDescription">
                                </text-area-counter>
                            </div>

                            @if(!empty($isSupportRequest))
                                <div class="field">
                                    {!! Form::label('land_offer[building][surface]', 'Surface totale', [
                                        'class' => 'label',
                                    ]); !!}

                                    <div class="control has-icons-right">
                                        {!! Form::text('land_offer[building][surface]', null, [
                                            'class' => 'input',
                                            ':disabled'=>'isInputDisabled',
                                            'v-model' => 'formInput.buildingSurface',
                                            'ref' => 'buildingSurface'
                                        ]) !!}
                                        <span class="icon is-small is-right" style="color: #4a4a4a;">
                                              m²
                                        </span>
                                    </div>

                                    <template v-if="$v.formInput.buildingSurface.$error">
                                        <p class="help is-danger" v-if="!$v.formInput.buildingSurface.numeric">
                                            Veuillez saisir un nombre.
                                        </p>
                                    </template>
                                </div>

                                <div class="field">
                                    {!! Form::label('land_offer[building][offer_genres][]', 'Type de cession', ['class' => 'label']); !!}

                                    <div class="columns">
                                        @foreach($offerGenres as $i => $offerGenre)
                                            <div class="column">
                                                <custom-checkbox
                                                        name="land_offer[building][offer_genres][]"
                                                        input-value="{{$offerGenre["id"]}}"
                                                        v-model="formInput.buildingOfferGenres"
                                                        :disabled="isInputDisabled"
                                                        ref="buildingOfferGenres">

                                                    <i class="fa {{ $offerGenre["icon"] }}"
                                                       style="font-size: 30px;"></i><br><br>
                                                    <span style="font-size:16px">
                                                    {{ $offerGenre["land_offer_label"] }}
                                                </span>
                                                </custom-checkbox>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
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
                        <div v-show="formInput.hasHouses === '1'">
                            <div class="field">
                                <label for='land_offer[house][description]'
                                       class="tooltip has-tooltip-multiline has-tooltip-left"
                                       data-tooltip="Décrivez les habitations présentes sur la ferme (nombre de pièces, surface, état, prix ou modalité de cession imaginé, etc.).">
                                    Description des habitations
                                    <i class="fas fa-info-circle has-text-info"></i>
                                </label>
                                <text-area-counter
                                        name="land_offer[house][description]"
                                        :max-length="1000"
                                        :disabled="isInputDisabled"
                                        ref="houseDescription"
                                        v-model="formInput.houseDescription"
                                        :vuelidate="$v.formInput.houseDescription">
                                </text-area-counter>
                            </div>

                            @if(!empty($isSupportRequest))
                                <div class="field">
                                    {!! Form::label('land_offer[house][surface]', 'Surface totale', [
                                        'class' => 'label',
                                    ]); !!}

                                    <div class="control has-icons-right">
                                        {!! Form::text('land_offer[house][surface]', null, [
                                            'class' => 'input',
                                            ':disabled'=>'isInputDisabled',
                                            'v-model' => 'formInput.houseSurface',
                                            'ref' => 'houseSurface'
                                        ]) !!}
                                        <span class="icon is-small is-right" style="color: #4a4a4a;">
                                              m²
                                        </span>
                                    </div>

                                    <template v-if="$v.formInput.houseSurface.$error">
                                        <p class="help is-danger" v-if="!$v.formInput.houseSurface.numeric">
                                            Veuillez saisir un nombre.
                                        </p>
                                    </template>
                                </div>

                                <div class="field">
                                    {!! Form::label('land_offer[house][offer_genres][]', 'Type de cession', ['class' => 'label']); !!}

                                    <div class="columns">
                                        @foreach($offerGenres as $i => $offerGenre)
                                            <div class="column">
                                                <custom-checkbox
                                                        name="land_offer[house][offer_genres][]"
                                                        input-value="{{$offerGenre["id"]}}"
                                                        v-model="formInput.houseOfferGenres"
                                                        :disabled="isInputDisabled"
                                                        ref="houseOfferGenres">

                                                    <i class="fa {{ $offerGenre["icon"] }}"
                                                       style="font-size: 30px;"></i><br><br>
                                                    <span style="font-size:16px">
                                                    {{ $offerGenre["land_offer_label"] }}
                                                </span>
                                                </custom-checkbox>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
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

                            <div class="columns">
                                @foreach($offerGenres as $i => $offerGenre)
                                    <div class="column">
                                        <custom-checkbox
                                                name="land_offer[offer_genres][]"
                                                input-value="{{$offerGenre["id"]}}"
                                                v-model="formInput.offerGenres"
                                                :disabled="isInputDisabled"
                                                ref="offerGenres">

                                            <i class="fa {{ $offerGenre["icon"] }}"
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
                                        {!! Form::text('land_offer[price]', old('land_offer[price]'), [
                                            'class' => 'input',
                                            'ref' => 'price',
                                            'v-model' => 'formInput.price',
                                            ':disabled'=>'isInputDisabled',
                                        ]) !!}
                                        <span class="icon is-small is-right" style="color: #4a4a4a;">
                                          €
                                        </span>
                                    </div>

                                    <template v-if="$v.formInput.price.$error">
                                        <p class="help is-danger" v-if="$v.formInput.price.required">
                                            Ce champ est requis.
                                        </p>
                                        <p class="help is-danger" v-if="!$v.formInput.price.numeric">
                                            Veuillez saisir un nombre.
                                        </p>
                                    </template>
                                </div>
                            </div>
                            <div class="column is-half" v-if="isRentOffer">
                                <div class="field">
                                    {!! Form::label('land_offer[rent_price]', 'Loyer mensuel*', [
                                        'class' => 'label',
                                    ]); !!}

                                    <div class="control has-icons-right">
                                        {!! Form::text('land_offer[rent_price]', old('land_offer[rent_price]'), [
                                            'class' => 'input',
                                            'ref' => 'rentPrice',
                                            'v-model' => 'formInput.rentPrice',
                                            ':disabled'=>'isInputDisabled',
                                        ]) !!}
                                        <span class="icon is-small is-right" style="color: #4a4a4a;">
                                          €
                                        </span>
                                    </div>
                                    <template v-if="$v.formInput.rentPrice.$error">
                                        <p class="help is-danger" v-if="$v.formInput.rentPrice.required">
                                            Ce champ est requis.
                                        </p>
                                        <p class="help is-danger" v-if="!$v.formInput.rentPrice.numeric">
                                            Veuillez saisir un nombre.
                                        </p>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <div class="field" v-if="isTestOffer">
                            <label for='land_offer[test_description]'
                                   class="has-tooltip-multiline has-tooltip-left"
                                   data-tooltip="Décrivez ici le cadre administratif du test agricole : statut, durée...">
                                Modalité du test agricole
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


                        @if(!empty($isSupportRequest))
                            <div class="field">
                                <label class="label">Appel à candidature</label>

                                <label style="font-size: 1.1rem;">
                                    {!! Form::checkbox('land_offer[is_call_for_application_community]',
                                    '1',
                                    old('land_offer[is_call_for_application_community]'),
                                    [':disabled' => 'isInputDisabled']) !!}
                                    Il s'agit d’un appel à candidatures dans le cadre d'un projet soutenu par une collectivité
                                </label>
                            </div>
                            <div class="field">
                                <label style="font-size: 1.1rem;">
                                    {!! Form::checkbox('land_offer[is_call_for_application_terre_de_liens]',
                                    '1',
                                    old('land_offer[is_call_for_application_terre_de_liens]'),
                                    [':disabled' => 'isInputDisabled']) !!}
                                    Il s’agit d’un appel à candidatures pour une ferme Terre de Liens
                                </label>
                            </div>
                            <div class="field">
                                <label style="font-size: 1.1rem;">
                                    {!! Form::checkbox('land_offer[is_call_for_application_test_area]',
                                    '1',
                                    old('land_offer[is_call_for_application_test_area]'),
                                    [':disabled' => 'isInputDisabled']) !!}
                                    Il s’agit d’un appel à candidatures dans le cadre d'un Espace test
                                </label>
                            </div>
                        @endif
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

                        @if(!empty($isSupportRequest))
                            <div class="field">
                                {!! Form::label('land_offer[is_beneficiary]', 'Je poste l\'annonce', ['class' => 'label']); !!}
                                <div class="select">
                                    {!! Form::select('land_offer[is_beneficiary]',
                                             ['1' => 'En mon nom',
                                             '0' => 'Pour le compte d\'une autre personne'],
                                              old('land_offer[is_beneficiary]'),
                                              [
                                                  'placeholder' => 'Veuillez sélectionner...',
                                                  ':disabled' => 'isInputDisabled',
                                                  'aria-describedby'=>'isBeneficiaryError'
                                      ]); !!}
                                </div>
                            </div>
                        @endif

                        @include('pages.ads.partials.inputs.documents')

                        @if(!$isSupportRequest)
                            @include('pages.ads.partials.inputs.accept-share-contact-infos')
                        @endif

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
