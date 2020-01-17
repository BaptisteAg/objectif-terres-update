<div id="land_seek_form">
    <p class="is-size-7">Les champs marqués d'un astérisque (*) sont obligatoires</p>
    <div class="field">
        {!! Form::label('land_seek[installation_type_id]', 'Type d\'installation*', ['class' => 'label']); !!}
        <div class="select">
            {!! Form::select('land_seek[installation_type_id]',
                 $installationTypes->pluck('name', 'id'),
                 old('land_seek[installation_type]'),
                 ['placeholder' => 'Choisir un type d\'installation...',
                 "v-model.trim.lazy"=>"formInput.installationTypeId",
                 ':disabled' => 'isInputDisabled']); !!}
        </div>
        <p class="help is-danger" v-show="!$v.formInput.installationTypeId.required">Ce champs est requis.</p>
    </div>
    <div class="selected-zones card">
        <header class="card-header">
            <p class="card-header-title">
                Zones de recherche
            </p>
        </header>
        <div class="card-content">
            <div class="content">
                <div class="field">
                    {!! Form::label('zone-autocomplete', 'Code postal, commune, département ou région*', ['class' => 'label']); !!}
                    <autocomplete
                            id="zone-autocomplete"
                            class="input"
                            placeholder="Ajoutez une zone en saisissant les premières lettres"
                            :disabled="isInputDisabled"
                            src="/json/locationables"
                            :data-renderer="renderZoneItemData"
                            v-on:autocomplete-select="onZoneSelect"
                    >
                    </autocomplete>
                    <p class="help is-danger" v-show="!$v.selectedZones.hasZone">Vous devez sélectionner au minimum une zone géographique.</p>
                </div>

                <h4 v-if="selectedZones.length">Vous avez sélectionné :</h4>
                <h4 v-else>Vous n'avez encore sélectionné aucune zone.</h4>

                <div class="selected-zone" v-for="(zone,i) in selectedZones">
                    <span @click="_ => selectedZones.splice(i, 1)">
                        <i class="fa fa-trash-alt" style="cursor:pointer;"></i>
                    </span>
                    <b>@{{labelsByZoneType[zone.value.type]}}</b> : @{{zone.value.originalLabel}}
                    <input type="hidden" :name="'land_seek[locationable]['+zone.value.type+'][]'" :value="zone.value.id">
                </div>
            </div>
        </div>
        <input type="hidden" name="land_seek[selected_zones]" :value="JSON.stringify(selectedZones)">
        <div class="card-footer">
            <div class="card-footer-item">
                <div class="column">
                    <p class="label">Dans un rayon de </p>
                    <vue-slider
                            name="land_seek[locationable_radius]"
                            :data="['0km','5km','10km','20km','50km']"
                    ></vue-slider>
                </div>
            </div>
        </div>
    </div>
    <div class="field">
        {!! Form::label('land_seek[is_bio]', 'Je souhaite m\'installer en bio', ['class' => 'label']) !!}
        {!! Form::radio('land_seek[is_bio]', '1',old('land_seek[is_bio]'), [':disabled' => 'isInputDisabled']) !!}
        oui
        {!! Form::radio('land_seek[is_bio]', '0', old('land_seek[is_bio]'), [':disabled' => 'isInputDisabled']) !!}
        non
    </div>
    <div class="field">
        {!! Form::label('land_seek[surface_range][]', 'Surface recherchée(en ha)', ['class' => 'label']); !!}
        @foreach ($surfaceRanges->pluck('surface', 'id') as $id => $surface)
            {!! Form::checkbox(
                'land_seek[surface_range][]',
                $id,
                [
                    ':disabled' => 'isInputDisabled'
                ]
            ) !!}
            {{$surface}}
        @endforeach
    </div>
    <div class="field">
        {!! Form::label('land_seek[production_genre][]', 'Production(s) envisagée(s)*', ['class' => 'label']); !!}

        @foreach ($productionGenres->pluck('name', 'id') as $id => $productionGenre)
            {!! Form::checkbox('land_seek[production_genre][]',
                $id,
                null,
                [
                    ':disabled' => 'isInputDisabled',
                    'v-model'=>'formInput.productionGenre',
                ])
            !!}
            {{$productionGenre}}
        @endforeach
        {!! Form::checkbox('land_seek[production_genre_other]',
        '1',
        old('land_seek[production_genre_other]'),
        [':disabled' => 'isInputDisabled',
        'v-model.trim.lazy'=>'formInput.productionGenre']) !!}
        Autre
        <p class="help is-danger" v-show="!$v.formInput.productionGenre.required">Ce champs est requis.</p>
    </div>

    <div class="field" v-show="isProductionGenreOther">
        {!! Form::label('land_seek[production_type_add]', 'Veuillez préciser', ['class' => 'label']); !!}
        {!! Form::text('land_seek[production_type_add]',
                 old('land_seek[production_type_add]'),
                  ['class' => 'input',
                  ':disabled' => 'isInputDisabled']) !!}
    </div>
    <div class="field">
        {!! Form::label('land_seek_has_farms_or_buildings', 'Habitation(s) et bâti(s)', ['class' => 'label']); !!}
        {!! Form::checkbox('land_seek[has_farm_buildings]', '1', old('land_seek[has_farm_buildings]'), [':disabled' => 'isInputDisabled']) !!}
        Avec une maison d'habitation existante
        {!! Form::checkbox('land_seek[has_houses]', '1', old('land_seek[has_houses]'), [':disabled' => 'isInputDisabled']) !!}
        Avec des bâtis agricoles existants
    </div>
    <div class="field">
        {!! Form::label('land_seek[offer_genre]', 'Accès au foncier souhaité', ['class' => 'label']); !!}
        <div class="select">
            {!! Form::select('land_seek[offer_genre]',
                     $offerGenresLandSeek->pluck('name', 'id'),
                     null,
                      ['placeholder' => 'Veuillez choisir...',
                       ':disabled' => 'isInputDisabled',
                       'v-model'=> 'formInput.offerGenre']);!!}
        </div>
    </div>
    <div class="field" v-show="formInput.offerGenre === '1'">
        {!! Form::label('land_seek[price_range][]', 'Prix (en €)', ['class' => 'label']); !!}
        @foreach ($priceRanges->pluck('price', "id") as $priceId => $price)
            {!! Form::checkbox('land_seek[price_range][]', $priceId, in_array($priceId, old('land_seek[price_range]', [])), [':disabled' => 'isInputDisabled']) !!}
            {{$price}}
        @endforeach
    </div>
    <div class="columns">
        <div class="column is-half">
            <div class="field" v-show="formInput.offerGenre === '2'">
                {!! Form::label('land_seek[rent_min]', 'Loyer minimum (en €)', ['class' => 'label']); !!}
                {!! Form::number('land_seek[rent_min]', old('land_seek[rent_min]'), ['min'=>0,'class' => 'input', ':disabled' => 'isInputDisabled'] ) !!}
            </div>
        </div>
        <div class="column">
            <div class="field" v-show="formInput.offerGenre === '2'">
                {!! Form::label('land_seek[rent_max]', 'Loyer maximum', ['class' => 'label']); !!}
                {!! Form::number('land_seek[rent_max]', old('land_seek[rent_max]'), ['min'=>1,'class' => 'input', ':disabled' => 'isInputDisabled'] ) !!}
            </div>
        </div>
    </div>
    <div class="field">
        <label class="label">Expérience dans le domaine agricole</label>
        <button type="button" class="button icon has-text-info has-tooltip-multiline has-tooltip-left" data-tooltip="Pour certains cédants, l’expérience est
				un plus. N’hésitez pas à détailler ici de
				précédentes expériences
				professionnelles dans le domaine
				agricole, de stages ou de bénévolat sur
				des fermes ou encore si vous êtes
				titulaires de diplômes agricoles.">
            <i class="fas fa-info-circle"></i>
        </button>

        <text-area-counter
                name="land_seek[experience_farming]"
                old="{{ old('land_seek[experience_farming]') }}"
                :max-length=1000
                :disabled="isInputDisabled"
                :input-required=false
        >
        </text-area-counter>
    </div>
    <div class="field">
        <label class="label">Et si vous nous en disiez un peu plus sur votre projet ?*</label>
        <button type="button" class="button icon has-text-info has-tooltip-multiline has-tooltip-left" data-tooltip="Quel est le projet que vous portez ?
			Qu’est-ce qui motive votre projet ?
			Quelles sont les valeurs que vous
			défendez ? etc.">
            <i class="fas fa-info-circle"></i>
        </button>
        <text-area-counter
                name="land_seek[about_project]"
                old="{{ old('land_seek[about_project]') }}"
                :max-length=1000
                :disabled="isInputDisabled"
                :input-required=true
        >
        </text-area-counter>

    </div>
    <div class="field">
        <label class="label">Et si vous nous en disiez un peu plus sur vous ?*</label>
        <button type="button" class="button icon has-text-info has-tooltip-multiline has-tooltip-left"
                data-tooltip="Qui êtes-vous en quelques mots ?">
            <i class="fas fa-info-circle"></i>
        </button>

        <text-area-counter
                name="land_seek[about_content]"
                old="{{ old('land_seek[about_content]') }}"
                :max-length=1000
                :disabled="isInputDisabled"
                :input-required=true
        >
        </text-area-counter>
    </div>
    <div class="field">
        {!! Form::label('land_seek[title]', 'Titre de votre annonce*', ['class' => 'label']); !!}

        <button type="button" class="button icon has-text-info has-tooltip-multiline has-tooltip-left" data-tooltip="Le titre de l’annonce est primordial ! Il
				s’agit de votre carte de visite sur la
				plateforme. Un titre clair et bien
				formulé augmentera vos chances de
				contacts !">
            <i class="fas fa-info-circle"></i>
        </button>

        {!! Form::text('land_seek[title]',
                 old('land_seek[title]'),
                 ['class' => 'input',
                  "required",
                  ':disabled' => 'isInputDisabled',
                  'v-model.trim.lazy' => 'formInput.title']) !!}
        <p class="help is-danger" v-show="!$v.formInput.title.required">Ce champs est requis.</p>
        <p class="help is-danger" v-show="!$v.formInput.title.minLength">Le titre de votre annonce doit faire au minimum
            @{{$v.formInput.title.$params.minLength.min}} caractères .</p>
    </div>
    <div class="field">
        <span>Une photo de vous ? Une synthèse de votre projet ? Les photos sont importantes pour donner envie de consulter votre annonce.</span>
        <div class="file">
            <label class="file-label">
                {!! Form::file('land_seek[image]', ['class' => 'file-input', ':disabled' => 'isInputDisabled'] ) !!}
                <span class="file-cta">
                    <span class="file-icon">
                        <i class="fas fa-upload"></i>
                    </span>
                    <span class="file-label">
                        Importer une photo
                    </span>
                </span>
            </label>
        </div>
    </div>
    <div class="field">
        <label class="checkbox">
            <input type="checkbox"
                   name="confirm_project_follows_chart"
                   :disabled="isInputDisabled"
                   {{ old('confirm_project_follows_chart') ? 'checked' : '' }}
                   required>
            Je certifie que mon projet correspond à la <a href="/">charte de Terre de Liens</a>
        </label>
    </div>
</div>

