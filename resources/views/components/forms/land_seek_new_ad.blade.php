<div id="land_seek_form">
    <div class="field">
        {!! Form::label('installation_type', 'Type d\'installation', ['class' => 'label']); !!}
        <div class="select">
            {!! Form::select('installation_type', ['solo' => 'Individuelle','couple' => 'En couple','collective' => 'Collective','undefined' => 'Ne sait pas encore', ], null, ['placeholder' => 'Choisir un type d\'installation...','required', ':disabled'=>'land_seek_ads.is_input_disabled']); !!}
        </div>
    </div>
    <div class="columns">
        <div class=" column is-one-quarter">
            <div class="field">
                {!! Form::label('city', 'Commune ou Code postal', ['class' => 'label']); !!}
                {!! Form::text('city', null, ['class' => 'input', 'required', ':disabled'=>'land_seek_ads.is_input_disabled'] ) !!}
            </div>
        </div>
        <div class="column">
            <p class="label">Dans un rayon de </p>
            {!! Form::checkbox('city_range', '5 km', null, [':disabled'=>'land_seek_ads.is_input_disabled']) !!}
            5 km
            {!! Form::checkbox('city_range', '10 km', null,[':disabled'=>'land_seek_ads.is_input_disabled']) !!}
            10km
            {!! Form::checkbox('city_range', '20 km', null,[':disabled'=>'land_seek_ads.is_input_disabled']) !!}
            15km
            {!! Form::checkbox('city_range', '50 km', null,[':disabled'=>'land_seek_ads.is_input_disabled']) !!}
            20km
        </div>
        <div class="column">
            <div class="field">
                {!! Form::label('region', 'Région', ['class' => 'label']); !!}
                <div class="select">
                    {!! Form::select('region', ['rhones-alpes' => 'Rhônes-Alpes', 'bretagne'=>'Bretagne'], null, ['placeholder' => 'Veuillez choisir...', ':disabled'=>'land_seek_ads.is_input_disabled']); !!}
                </div>
            </div>
        </div>
        <div class="column">
            <div class="field">
                {!! Form::label('departments', 'Départements', ['class' => 'label']); !!}
                {!! Form::text('departments', null, ['class' => 'input', ':disabled'=>'land_seek_ads.is_input_disabled'] ) !!}
            </div>
        </div>
    </div>
    <div class="field">
        {!! Form::label('is_bio', 'Je souhaite m\'installer en bio', ['class' => 'label']); !!}
        {!! Form::radio('is_bio', 'true',null, [':disabled'=>'land_seek_ads.is_input_disabled']) !!}
        oui
        {!! Form::radio('is_bio', 'false', null, [':disabled'=>'land_seek_ads.is_input_disabled']) !!}
        non
    </div>
    <div class="field">
        {!! Form::label('surface_range', 'Surface recherchée(en ha)', ['class' => 'label']); !!}
        {!! Form::checkbox('surface_range', '0-5', false, [':disabled'=>'land_seek_ads.is_input_disabled']) !!}
        0-5
        {!! Form::checkbox('surface_range', '5-10', false, [':disabled'=>'land_seek_ads.is_input_disabled']) !!}
        5-10
        {!! Form::checkbox('surface_range', '10-20', false, [':disabled'=>'land_seek_ads.is_input_disabled']) !!}
        10-20
        {!! Form::checkbox('surface_range', '20-50', false, [':disabled'=>'land_seek_ads.is_input_disabled']) !!}
        20-50
        {!! Form::checkbox('surface_range', '50-100', false, [':disabled'=>'land_seek_ads.is_input_disabled']) !!}
        50-100
        {!! Form::checkbox('surface_range', '>100', false, [':disabled'=>'land_seek_ads.is_input_disabled']) !!}
        >100
    </div>
    <div class="field">
        {!! Form::label('production_type', 'Production(s) envisagée(s)', ['class' => 'label']); !!}
        {!! Form::checkbox('production_type', 'production_type_1', false, [':disabled'=>'land_seek_ads.is_input_disabled']) !!}
        Production 1
        {!! Form::checkbox('production_type', 'production_type_2', false, [':disabled'=>'land_seek_ads.is_input_disabled']) !!}
        Production 2
        {!! Form::checkbox('production_type', 'other', false, ['v-model'=>'land_seek_ads.is_production_type_other',':disabled'=>'land_seek_ads.is_input_disabled' ]) !!}
        Autre
    </div>
    <div class="field" v-show = "land_seek_ads.is_production_type_other">
        {!! Form::label('other_production_type', 'Veuillez préciser', ['class' => 'label']); !!}
        {!! Form::text('other_production_type', null, ['class' => 'input', ':disabled'=>'land_seek_ads.is_input_disabled'] ) !!}
    </div>
    <div class="field">
        {!! Form::label('building', 'Habitation(s) et bâti(s)', ['class' => 'label']); !!}
        {!! Form::checkbox('building', 'has_houses', false, [':disabled'=>'land_seek_ads.is_input_disabled']) !!}
        Avec une maison d'habitation existante
        {!! Form::checkbox('building', 'has_farm_building', false, [':disabled'=>'land_seek_ads.is_input_disabled']) !!}
        Avec des bâtis agricoles existants
    </div>
    <div class="field">
        {!! Form::label('offer_genre', 'Accès au foncier souhaité', ['class' => 'label']); !!}
        <div class="select">
            {!! Form::select('offer_genre', ['location' => 'Location','acquisition' => 'Acquisition','undefined' => 'Indifférent'], null, ['placeholder' => 'Veuillez choisir...', 'v-model'=>'land_seek_ads.offer_genre']); !!}
        </div>
    </div>
    <div class="field" v-show ="land_seek_ads.offer_genre === 'acquisition'">
        {!! Form::label('price', 'Prix (en €)', ['class' => 'label']); !!}
        {!! Form::checkbox('price', '< 500000', false, [':disabled'=>'land_seek_ads.is_input_disabled']) !!}
        Moins de 50 000
        {!! Form::checkbox('price', '50-10000', false, [':disabled'=>'land_seek_ads.is_input_disabled']) !!}
        De 50 à 100 000
        {!! Form::checkbox('price', '100-200000', false, [':disabled'=>'land_seek_ads.is_input_disabled']) !!}
        De 100 à 200 000
        {!! Form::checkbox('price', '200-300000', false, [':disabled'=>'land_seek_ads.is_input_disabled']) !!}
        De 200 à 300 000
        {!! Form::checkbox('price', '>300000', false, [':disabled'=>'land_seek_ads.is_input_disabled']) !!}
        Plus de 300 000
    </div>
    <div class="columns">
        <div class="column is-half">
            <div class="field" v-show ="land_seek_ads.offer_genre === 'location'">
                {!! Form::label('rent_min', 'Loyer minimum (en €)', ['class' => 'label']); !!}
                {!! Form::number('rent_min', null, ['min'=>0,'class' => 'input', ':disabled'=>'land_seek_ads.is_input_disabled'] ) !!}
            </div>
        </div>
        <div class="column">
            <div class="field" v-show ="land_seek_ads.offer_genre === 'location'">
                {!! Form::label('rent_max', 'Loyer maximum', ['class' => 'label']); !!}
                {!! Form::number('rent_max', null, ['min'=>1,'class' => 'input', ':disabled'=>'land_seek_ads.is_input_disabled'] ) !!}
            </div>
        </div>
    </div>
    <div class="field">
        {!! Form::label('experience_farming', 'Expérience dans le domaine agricole', ['class' => 'label']); !!}
        {!! Form::textarea('experience_farming', null, ['class' => 'textarea', ':disabled'=>'land_seek_ads.is_input_disabled', 'maxlength'=>1000, 'placeholder'=>'Limite de 1000 caractères'] ) !!}
    </div>
    <div class="field">
        {!! Form::label('about_project', 'Et si vous nous en disiez un peu plus sur votre projet ?', ['class' => 'label']); !!}
        {!! Form::textarea('about_project', null, ['class' => 'textarea','required', ':disabled'=>'land_seek_ads.is_input_disabled', 'maxlength'=>1000, 'placeholder'=>'Limite de 1000 caractères'] ) !!}
    </div>
    <div class="field">
        {!! Form::label('about_content', 'Et si vous nous en disiez un peu plus sur vous ?', ['class' => 'label']); !!}
        {!! Form::textarea('about_content', null, ['class' => 'textarea','required', ':disabled'=>'land_seek_ads.is_input_disabled', 'maxlength'=>1000, 'placeholder'=>'Limite de 1000 caractères'] ) !!}
    </div>
    <div class="field">
        {!! Form::label('title', 'Titre de votre annonce', ['class' => 'label']); !!}
        {!! Form::text('title', null, ['class' => 'input', "required", ':disabled'=>'land_seek_ads.is_input_disabled'] ) !!}
    </div>
    <div class="field">
        <span>Une photo de vous ? Une synthèse de votre projet ? Les photos sont importantes pour donner envie de consulter votre annonce.</span>
        <div class="file">
            <label class="file-label">
                {!! Form::file('image', ['class' => 'file-input', ':disabled'=>'land_seek_ads.is_input_disabled'] ) !!}
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
            <input type="checkbox" required>
            Je certifie que mon projet correspond à la <a href="/">charte de Terre de Liens</a>
        </label>
    </div>
    <div class="field is-grouped">
        <div class="control">
            {!! Form::submit('Envoyer',['class'=>'button is-link', ':disabled'=>'land_seek_ads.is_input_disabled']) !!}
        </div>
        <div class="control">
            <button class="button is-link is-light">Annuler</button>
        </div>
    </div>
</div>