<div id="land_seek_form" class="form-container pt-6">
    <form-wizard
            title=""
            subtitle=""
            step-size="xs"
            @on-complete="$emit('form-complete')"
            @on-change="nextStep"
            color="#A74B2B"
            ref="formWizard"
            class="is-flex is-flex-direction-column">

        <tab-content title="Terres recherchées">

            <section class="mb-6 field">
                <department-select :departments="{{ $departments }}">
                </department-select>
            </section>

            <section class="mb-6 field">
                <zone-select
                        name="locationable"
                        label="{{$label ?? "Zones de recherche"}}"
                        radius-name="locationable_radius"
                        json-name="selected_zones"
                        ref="selectedZones"
                        v-model="formInput.selectedZones"
                        radius-value="{{$old['locationable_radius'] ?? 0}}"
                        :vuelidate="$v.formInput.selectedZones"
                        :disabled="isInputDisabled">
                </zone-select>
            </section>

            <b-tooltip class="w-100 mb-7 field" label="Faites glisser les curseurs pour définir la surface recherchée">
                {!! Form::label('land_seek[surface_range_min]', 'Surface recherchée (en hectares)', ['class' => 'label']); !!}
                <vue-slider-range
                        ref="surfaceRangeMax"
                        name-min="land_seek[surface_range_min]"
                        name-max="land_seek[surface_range_max]"
                        :data="{{ json_encode($surfaceRanges->pluck('label', 'value')) }}"
                        :value="[formInput.surfaceRangeMin, formInput.surfaceRangeMax]"
                        @input="v => (formInput.surfaceRangeMin = v[0]) && (formInput.surfaceRangeMax = v[1])"
                        :disabled="isInputDisabled"
                ></vue-slider-range>
            </b-tooltip>

            <b-tooltip class="w-100 mb-6 field"
                       label="Décrivez le type de surface agricole : altitude, type de terre, besoin en eau, certification...">
                {!! Form::label('land_seek[land_description]', "Description du terrain recherché", ['class' => 'label']) !!}
                <text-area-counter
                        name="land_seek[land_description]"
                        :max-length=1500
                        :disabled="isInputDisabled"
                        ref="landDescription"
                        v-model="formInput.landDescription"
                        :vuelidate="$v.formInput.landDescription">
                </text-area-counter>
            </b-tooltip>

            {!! Form::label('land_seek_farms_and_buildings', 'Présence d’habitations ?', ['class' => 'label']); !!}
            <section class="mb-6 is-flex gap-5 field">
                @foreach($requirements as $requirement)
                    <div>
                        {!! Form::radio('land_seek[buildings][1]', $requirement->id, null, [':disabled' => 'isInputDisabled', 'id' => 'buildings_1_'.$requirement->id]) !!}
                        {!! Form::label('buildings_1_'.$requirement->id,  $requirement->label ) !!}
                    </div>
                @endforeach
            </section>

            {!! Form::label('land_seek_farms_and_buildings', 'Présence de bâtiments agricoles ?', ['class' => 'label']); !!}
            <section class="is-flex gap-5 field">
                @foreach($requirements as $requirement)
                    <div>
                        {!! Form::radio('land_seek[buildings][2]', $requirement->id, null, [':disabled' => 'isInputDisabled', 'id' => 'buildings_2_'.$requirement->id]) !!}
                        {!! Form::label('buildings_2_'.$requirement->id,  $requirement->label ) !!}
                    </div>
                @endforeach
            </section>
        </tab-content>

        <tab-content title="Votre projet agricole">
            {!! Form::label('land_seek[production_genres][]', 'Production agricole principale envisagée', ['class' => 'label']); !!}
            <section class="mb-6 field">
                @include('pages.ads.partials.inputs.production_genres', ['name' => 'land_seek[production_genres][]', 'productionGenres' => $productionGenresWithOther])
            </section>

            {!! Form::label('land_seek[seconde_production_genres][]', 'Production agricole secondaire envisagée', ['class' => 'label']); !!}
            <section class="mb-6 field">
                @include('pages.ads.partials.inputs.production_genres', ['name' => 'land_seek[seconde_production_genres][]', 'productionGenres' => $productionGenresWithOther])
            </section>

            {!! Form::label('land_seek[is_bio]', "Votre projet est-il en agriculture biologique ?", ['class' => 'label']) !!}
            <section class="mb-6 is-flex gap-5 field">
                <div>
                    {!! Form::radio('land_seek[is_bio]', '1', (string)($old['land_seek']['is_bio'] ?? null) === "1" , ['id' => 'land_seek[is_bio]_1', ':disabled' => 'isInputDisabled'] ) !!}
                    {!! Form::label('land_seek[is_bio]_1',  'Oui' ) !!}
                </div>
                <div>
                    {!! Form::radio('land_seek[is_bio]', '0', (string)($old['land_seek']['is_bio'] ?? null) === "0" , ['id' => 'land_seek[is_bio]_0', ':disabled' => 'isInputDisabled']) !!}
                    {!! Form::label('land_seek[is_bio]_0',  'Non' ) !!}
                </div>
                <div>
                    {!! Form::radio('land_seek[is_bio]', '-1', (string)($old['land_seek']['is_bio'] ?? null) === "-1" , ['id' => 'land_seek[is_bio]__1', ':disabled' => 'isInputDisabled']) !!}
                    {!! Form::label('land_seek[is_bio]__1',  'Je ne sais pas encore' ) !!}
                </div>
            </section>

            {!! Form::label('land_seek[installation_type_id]', "Vous vous installez", ['class' => 'label']) !!}
            <section class="is-flex gap-5 mb-6 is-flex-wrap-wrap field">
                @foreach($installationTypes as $i => $installationType)
                    <div>
                        {!! Form::radio('land_seek[installation_type_id]', $installationType["id"], null, [':disabled' => 'isInputDisabled', 'id' => 'installation_type_id_'.$installationType["id"]]) !!}
                        {!! Form::label('installation_type_id_'.$installationType["id"], $installationType["name"]) !!}
                    </div>
                @endforeach
                <p class="help is-danger w-100" id="installationTypeIdError"
                   v-if="$v.formInput.installationTypeId.$error">
                    Ce champ est requis.
                </p>
            </section>

            @php
                if(empty($isSupportRequest)) {
                    $tooltip = "Pour donner envie à un cédant ou propriétaire de vous proposer du foncier, décrivez votre projet, son histoire, ses valeurs, votre date d'installation envisagées etc.";
                }
                else {
                    $tooltip = "Décrivez votre projet, son histoire, ses valeurs, votre date d'installation envisagée, etc.";
                }
            @endphp
            @include('pages.ads.partials.inputs.about_project_content', ['tooltip' => $tooltip])

            @include('pages.ads.partials.inputs.about_content')
        </tab-content>

        <tab-content title="C'est presque fini !">
            <section class="field">
                @include('pages.ads.partials.inputs.title')
            </section>

            <section class="mb-6 field">
                @include('pages.ads.partials.inputs.documents')
            </section>

            <section class="field">
                @include('pages.ads.partials.inputs.chart-confirmation', ['inputNamePrefix' => 'land_seek'])
            </section>
        </tab-content>

        @include('pages.ads.partials.new-form-wizard-footer', ["moveToRef"=>"land_seek"])

    </form-wizard>
</div>
