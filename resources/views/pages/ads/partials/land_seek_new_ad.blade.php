<div id="land_seek_form">
    <p class="is-size-7">Les champs marqués d'un astérisque (*) sont obligatoires</p>
    <div class="field">
        {!! Form::label('land_seek[installation_type_id]', 'Type d\'installation*', ['class' => 'label']); !!}
        <div class="select">
            {!! Form::select('land_seek[installation_type_id]',
                 $installationTypes->pluck('name', 'id'),
                 old('land_seek[installation_type_id]'),
                 [
                     'placeholder' => 'Choisir un type d\'installation...',
                     'required',
                     ':disabled' => 'isInputDisabled'
                 ]); !!}
        </div>
    </div>
    <div class="columns">
        <div class=" column is-one-quarter">
            <div class="field">
                {!! Form::label('land_seek[cities]', 'Commune ou Code postal*', ['class' => 'label']); !!}
                <autocomplete
                    name="land_seek[cities]"
                    src="/json/cities"
                    old="{{json_encode(old('land_seek[cities]'))}}"
                    class="input"
                    required
                    :disabled="isInputDisabled"
                >
                </autocomplete>
            </div>
        </div>
        <div class="column ">
            <p class="label">Dans un rayon de </p>
            {!! Form::checkbox('land_seek[city_range][]', '5', [':disabled' => 'isInputDisabled']) !!}
            5 km
            {!! Form::checkbox('land_seek[city_range][]', '10',[':disabled' => 'isInputDisabled']) !!}
            10km
            {!! Form::checkbox('land_seek[city_range][]', '20',[':disabled' => 'isInputDisabled']) !!}
            15km
            {!! Form::checkbox('land_seek[city_range][]', '50',[':disabled' => 'isInputDisabled']) !!}
            20km
        </div>
        <div class="column">
            <div class="field">
                {!! Form::label('land_seek[regions][]', 'Régions', ['class' => 'label']); !!}
                <div class="select">
                    {!! Form::select('land_seek[regions][]',
                             $regions->pluck('name', 'id'),
                             old('land_seek[regions]'),
                             ['placeholder' => 'Veuillez choisir...',
                              ':disabled' => 'isInputDisabled']); !!}
                </div>
            </div>
        </div>
        <div class="column">
            <div class="field">
                {!! Form::label('land_seek[departments][]', 'Départements', ['class' => 'label']); !!}
                {!! Form::select('land_seek[departments][]',
                     $departments->pluck('name', 'id'),
                     old('land_seek[departments]'),
                    [
                        'multiple' => true,
                        'class' => 'input',
                        ':disabled' => 'isInputDisabled'
                    ])
                !!}
            </div>
        </div>
    </div>
    <div class="field">
        {!! Form::label('land_seek[is_bio]', 'Je souhaite m\'installer en bio', ['class' => 'label']) !!}
        {!! Form::radio('land_seek[is_bio]', 'true',old('land_seek[is_bio]'), [':disabled' => 'isInputDisabled']) !!}
        oui
        {!! Form::radio('land_seek[is_bio]', 'false', old('land_seek[is_bio]'), [':disabled' => 'isInputDisabled']) !!}
        non
    </div>
    <div class="field">
        {!! Form::label('land_seek[surface_range][]', 'Surface recherchée(en ha)', ['class' => 'label']); !!}
        @foreach ($surfaceRanges->pluck('surface', 'id') as $id => $surface)
            {!! Form::checkbox(
                'land_seek[surface_range][]',
                $id,
                in_array($id, old('land_seek[surface_range]', [])),
                [
                    ':disabled' => 'isInputDisabled'
                ]
            ) !!}
            {{$surface}}
        @endforeach
    </div>
    <div class="field">
        {!! Form::label('land_seek[production_genre][]', 'Production(s) envisagée(s)', ['class' => 'label']); !!}
        {!! Form::checkbox('land_seek[production_genre][]', 'production_genre_1', old('land_seek[production_genre[]]'), [':disabled' => 'isInputDisabled']) !!}
        Production 1
        {!! Form::checkbox('land_seek[production_genre][]', 'production_genre_2', old('land_seek[production_genre[]]'), [':disabled' => 'isInputDisabled']) !!}
        Production 2
        {!! Form::checkbox('land_seek[production_genre][]',
        'other',
        old('land_seek[production_genre]'),
        [':disabled' => 'isProductionGenreOther || isInputDisabled']) !!}
        Autre
    </div>
    <div class="field" v-show="isProductionGenreOther">
        {!! Form::label('land_seek[other_production_genre]', 'Veuillez préciser', ['class' => 'label']); !!}
        {!! Form::text('land_seek[other_production_genre]',
                 old('land_seek[other_production_genre]'),
                  ['class' => 'input',
                  ':disabled' => 'isInputDisabled']) !!}
    </div>
    <div class="field">
        {!! Form::label('land_seek[land_seek_building][]', 'Habitation(s) et bâti(s)', ['class' => 'label']); !!}
        {!! Form::checkbox('land_seek[building][]', 'has_houses', old('land_seek[building[]]'), [':disabled' => 'isInputDisabled']) !!}
        Avec une maison d'habitation existante
        {!! Form::checkbox('land_seek[building][]', 'has_farm_building', old('land_seek[building[]]'), [':disabled' => 'isInputDisabled']) !!}
        Avec des bâtis agricoles existants
    </div>
    <div class="field">
        {!! Form::label('land_seek[offer_genre]', 'Accès au foncier souhaité', ['class' => 'label']); !!}
        <div class="select">
            {!! Form::select('land_seek[offer_genre]',
                     $offerGenresLandSeek->pluck('name', 'id'),
                     old('land_seek[offer_genre]'),
                      ['placeholder' => 'Veuillez choisir...',
                       ':disabled' => 'offerGenre']);!!}
        </div>
    </div>
    <div class="field" v-show="offerGenre === '1'">
        {!! Form::label('land_seek[price][]', 'Prix (en €)', ['class' => 'label']); !!}
        @foreach ($priceRanges->pluck('price', "id") as $k => $price)
            {!! Form::checkbox('land_seek[price][]', $price, old('price[]', ["id" => 'price'.$k]), [':disabled' => 'isInputDisabled']) !!}
            {{$price}}
        @endforeach
    </div>
    <div class="columns">
        <div class="column is-half">
            <div class="field" v-show="offerGenre === '2'">
                {!! Form::label('land_seek[rent_min]', 'Loyer minimum (en €)', ['class' => 'label']); !!}
                {!! Form::number('land_seek[land_seek_rent_min]', old('land_seek[rent_min]'), ['min'=>0,'class' => 'input', ':disabled' => 'isInputDisabled'] ) !!}
            </div>
        </div>
        <div class="column">
            <div class="field" v-show="offerGenre === '2'">
                {!! Form::label('land_seek[rent_max]', 'Loyer maximum', ['class' => 'label']); !!}
                {!! Form::number('land_seek[land_seek_rent_max]', old('land_seek[rent_max]'), ['min'=>1,'class' => 'input', ':disabled' => 'isInputDisabled'] ) !!}
            </div>
        </div>
    </div>
    <div class="field">
        {!! Form::label('land_seek[experience_farming]', 'Expérience dans le domaine agricole', ['class' => 'label']); !!}
        {!! Form::textarea('land_seek[experience_farming]',
                     old('land_seek[experience_farming]'),
                      ['class' => 'textarea',
                       ':disabled' => 'isInputDisabled',
                       'maxlength' => 1000,
                       'placeholder' => 'Limite de 1000 caractères']) !!}
    </div>
    <div class="field">
        {!! Form::label('land_seek[about_project]', 'Et si vous nous en disiez un peu plus sur votre projet ?*', ['class' => 'label']); !!}
        {!! Form::textarea('land_seek[about_project]',
                 old('land_seek[about_projet]'),
                  ['class' => 'textarea',
                  'required',
                  ':disabled' => 'isInputDisabled',
                   'maxlength'=>1000,
                   'placeholder'=>'Limite de 1000 caractères']) !!}
    </div>
    <div class="field">
        {!! Form::label('land_seek[about_content]', 'Et si vous nous en disiez un peu plus sur vous ?*', ['class' => 'label']); !!}
        {!! Form::textarea('land_seek[about_content]',
                 old('land_seek[about_content]'),
                 ['class' => 'textarea',
                 'required',
                 ':disabled' => 'isInputDisabled',
                 'maxlength'=>1000,
                 'placeholder'=>'Limite de 1000 caractères']) !!}
    </div>
    <div class="field">
        {!! Form::label('land_seek[title]', 'Titre de votre annonce*', ['class' => 'label']); !!}
        {!! Form::text('land_seek[title]',
                 old('land_seek[title]'),
                 ['class' => 'input',
                  "required",
                  ':disabled' => 'isInputDisabled']) !!}
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
            <input type="checkbox" name="confirm_project_follows_chart" :disabled="isInputDisabled"
                   {{ old('confirm_project_follows_chart') ? 'checked' : '' }} required>
            Je certifie que mon projet correspond à la <a href="/">charte de Terre de Liens</a>
        </label>
    </div>
</div>