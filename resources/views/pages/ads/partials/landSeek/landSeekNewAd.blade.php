<?php /** @var \App\Models\Ad $ad */ ?>

<div id="land_seek_form" class="form-container pt-6">
    <form-wizard
            title=""
            subtitle=""
            step-size="xs"
            @on-complete="$emit('form-complete')"
{{--            @on-change="nextStep"--}}
            color="#A74B2B"
            ref="formWizard"
            class="is-flex is-flex-direction-column">

        <tab-content title="Terres recherchées">

            <section class="mb-6 field" ref="selectedDepartments">
                <label class="label">Département de référence *</label>
                <autocomplete
                        name="department_id"
                        id="department_id"
                        autocomplete="off"
                        src="/locations/departments"
                        placeholder="Saisissez au moins 2 caractères pour faire apparaître la liste"
                        v-model="formInput.selectedDepartments"
                        :vuelidate="$v.formInput.selectedDepartments"
                >
                    <template v-for="(zone, i) in formInput.selectedDepartments">
                        <input
                                key="zone.id"
                                autocomplete="off"
                                type="hidden"
                                name="department_id"
                                :value="zone.value.id"
                        >
                        <div
                                key="zone.label"
                                class="tag autocomplete-input-tag is-info"
                                @click="_ => formInput.selectedDepartments.splice(i, 1)"
                        >
                            @{{ zone.label }}
                            <i class="fa fa-trash" style="cursor:pointer; margin-left: 0.5em;"></i>
                        </div>
                    </template>
                </autocomplete>
            </section>

            <section class="mb-6 field" v-if="formInput.selectedDepartments.length">
                <zone-select
                        src="/locations/cities"
                        name="land_seek[locationable]"
                        label="Autre localisation"
                        json-name="selected_zones"
                        ref="selectedZones"
                        v-model="formInput.selectedZones">
                </zone-select>
            </section>

            <section class="mb-6 field" ref="surfaceRangeMax">
                <b-tooltip class="w-100" label="Faites glisser les curseurs pour définir la surface recherchée">
                    <div class="label">
                        {!! Form::label('land_seek[surface_range_min]', 'Surface recherchée (en hectares) *', ['class' => '']); !!}
                        <i class="fas fa-info-circle has-text-info"></i>
                    </div>
                    <vue-slider-range
                            name-min="land_seek[surface_range_min]"
                            name-max="land_seek[surface_range_max]"
                            :data="{{ json_encode($surfaceRanges->pluck('label', 'value')) }}"
                            :value="[formInput.surfaceRangeMin, formInput.surfaceRangeMax]"
                            @input="v => (formInput.surfaceRangeMin = v[0]) && (formInput.surfaceRangeMax = v[1])"
                    ></vue-slider-range>
                </b-tooltip>
            </section>

            <section class="mb-6 field">
                <b-tooltip class="w-100"
                           label="Décrivez le type de surface agricole : altitude, type de terre, besoin en eau, certification...">
                    <div class="label">
                        {!! Form::label('land_seek[land_description]', "Description du terrain recherché", ['class' => '']) !!}
                        <i class="fas fa-info-circle has-text-info"></i>
                    </div>
                    <text-area-counter
                            name="land_seek[land_description]"
                            :max-length=1500
                            ref="landDescription"
                            v-model="formInput.landDescription"
                            :vuelidate="$v.formInput.landDescription">
                    </text-area-counter>
                </b-tooltip>
            </section>

            <section class="mb-6 is-flex gap-x-5 field is-flex-wrap-wrap" ref="buildingRequirement">
                {!! Form::label('land_seek_farms_and_buildings', 'Présence d’habitations ? *', ['class' => 'label w-100']); !!}
                @foreach($requirements as $requirement)
                    <div>
                        {!! Form::radio('land_seek[buildings][1]', $requirement->id, false, ['id' => 'buildings_1_'.$requirement->id, 'v-model' => 'formInput.buildingRequirement']) !!}
                        {!! Form::label('buildings_1_'.$requirement->id,  $requirement->label ) !!}
                    </div>
                @endforeach
                <p class="help is-danger w-100"
                   v-if="$v.formInput.buildingRequirement.$error">
                    Ce champ est requis.
                </p>
            </section>

            <section class="is-flex gap-x-5 field is-flex-wrap-wrap" ref="farmsRequirement">
                {!! Form::label('land_seek_farms_and_buildings', 'Présence de bâtiments agricoles ? *', ['class' => 'label w-100']); !!}
                @foreach($requirements as $requirement)
                    <div>
                        {!! Form::radio('land_seek[buildings][2]', $requirement->id, false, ['id' => 'buildings_2_'.$requirement->id, 'v-model' => 'formInput.farmsRequirement']) !!}
                        {!! Form::label('buildings_2_'.$requirement->id,  $requirement->label ) !!}
                    </div>
                @endforeach
                <p class="help is-danger w-100"
                   v-if="$v.formInput.farmsRequirement.$error">
                    Ce champ est requis.
                </p>
            </section>
        </tab-content>

        <tab-content title="Votre projet agricole">
            <section class="mb-6 field" ref="productionGenres">
                {!! Form::label('land_seek[production_genres][]', 'Production agricole principale envisagée *', ['class' => 'label']); !!}
                @include('pages.ads.partials.inputs.production_genres', [
                    'name' => 'land_seek[production_genres][]',
                    'productionGenres' => $productionGenres,
                    'vModel' => 'formInput.productionGenres',
                    'isRequired' => true,
                    'isUnique' => true,
                ])
            </section>

            <section class="mb-6 field" v-show="productionGenresHasOther">
                {!! Form::label('land_seek[production_type_add]', 'Autre production principale : Veuillez préciser', ['class' => 'label']); !!}
                {!! Form::text('land_seek[production_type_add]',
                     null, [
                     'class' => 'input',
                     'v-model' => 'formInput.productionTypeAdd'
                     ]) !!}
            </section>

            <section class="mb-6 field" ref="productionTypeAdd">
                {!! Form::label('land_seek[secondary_production_genres][]', 'Production agricole secondaire envisagée', ['class' => 'label']); !!}
                @include('pages.ads.partials.inputs.production_genres', [
                    'name' => 'land_seek[secondary_production_genres][]',
                    'productionGenres' => $productionGenres,
                    'vModel' => 'formInput.secondProductionGenres'
                ])
            </section>

            <section class="mb-6 field" v-show="secondProductionGenresHasOther">
                {!! Form::label('land_seek[secondary_production_type_add]', 'Autre production secondaire : Veuillez préciser', ['class' => 'label']); !!}
                {!! Form::text('land_seek[secondary_production_type_add]',
                     null, [
                     'class' => 'input',
                     'v-model' => 'formInput.secondProductionTypeAdd'
                     ]) !!}
            </section>

            <section class="mb-6 is-flex gap-x-5 field is-flex-wrap-wrap" ref="isBio">
                {!! Form::label('land_seek[is_bio]', "Votre projet est-il en agriculture biologique ? *", ['class' => 'label w-100']) !!}
                <div>
                    {!! Form::radio('land_seek[is_bio]', '1', ((string)($old['land_seek']['is_bio'] ?? null) === "1") , ['id' => 'land_seek[is_bio]_1', 'v-model' => 'formInput.isBio'] ) !!}
                    {!! Form::label('land_seek[is_bio]_1',  'Oui' ) !!}
                </div>
                <div>
                    {!! Form::radio('land_seek[is_bio]', '0', ((string)($old['land_seek']['is_bio'] ?? null) === "0") , ['id' => 'land_seek[is_bio]_0', 'v-model' => 'formInput.isBio']) !!}
                    {!! Form::label('land_seek[is_bio]_0',  'Non' ) !!}
                </div>
                <div>
                    {!! Form::radio('land_seek[is_bio]', '-1', ((string)($old['land_seek']['is_bio'] ?? null) === "-1") , ['id' => 'land_seek[is_bio]__1', 'v-model' => 'formInput.isBio']) !!}
                    {!! Form::label('land_seek[is_bio]__1',  'Je ne sais pas encore' ) !!}
                </div>
                <p class="help is-danger w-100" id="isBioEror"
                   v-if="$v.formInput.isBio.$error">
                    Ce champ est requis.
                </p>
            </section>

            <section class="is-flex gap-x-5 mb-6 is-flex-wrap-wrap field" ref="installationTypeId">
                {!! Form::label('land_seek[installation_type_id]', "Vous vous installez*", ['class' => 'label w-100']) !!}
                @foreach($installationTypes as $i => $installationType)
                    <div>
                        {!! Form::radio('land_seek[installation_type_id]', $installationType["id"], null, ['id' => 'installation_type_id_'.$installationType["id"], 'v-model' => 'formInput.installationTypeId']) !!}
                        {!! Form::label('installation_type_id_'.$installationType["id"], $installationType["name"]) !!}
                    </div>
                @endforeach
                <p class="help is-danger w-100" id="installationTypeIdError"
                   v-if="$v.formInput.installationTypeId.$error">
                    Ce champ est requis.
                </p>
            </section>

            <section class="field mb-6" ref="aboutProject">
                @php
                    if(empty($isSupportRequest)) {
                        $tooltip = "Pour donner envie à un cédant ou propriétaire de vous proposer du foncier, décrivez votre projet, son histoire, ses valeurs, votre date d'installation envisagées etc.";
                    }
                    else {
                        $tooltip = "Décrivez votre projet, son histoire, ses valeurs, votre date d'installation envisagée, etc.";
                    }
                @endphp
                @include('pages.ads.partials.inputs.about_project_content', ['tooltip' => $tooltip])
            </section>

            <section class="field" ref="aboutContent">
                @include('pages.ads.partials.inputs.about_content')
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
                @include('pages.ads.partials.inputs.chart-confirmation', ['inputNamePrefix' => 'land_seek'])
            </section>
        </tab-content>

        @include('pages.ads.partials.new-form-wizard-footer', ["moveToRef"=>"land_seek"])

    </form-wizard>
</div>
