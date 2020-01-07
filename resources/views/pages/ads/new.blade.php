@extends('default')

@section('title', 'Bienvenue sur Objectif Terres')

@section('main-content')
    <section class="section is-medium">
        <div class="columns">
            <div class="column"></div>
            <div class="column is-half">
                <div>
                    <h2 class="title is-1">Publiez votre annonce</h2>
                    <p>Vous avez un projet agricole ? Vous avez besoin d’aide ou d’un suivi sur mesure ?
                        Vous avez une idée de projet mais il n’est pas encore finalisé ? Eget risus varius
                        blandit sit amet non magna. Sed posuere consectetur est at lobortis.</p>
                </div>
                <br>
                <div>
                    <p class="has-text-grey">Pour nous permettre de vous valider votre annonce, veuillez nous en dire en
                        peu plus…</p>
                </div>
                {!! Form::open(['files' => true]) !!}
                <div class="field">
                    {!! Form::label('ad_type', 'Type d\'annonce', ['class' => 'label']); !!}
                    <div class="select">
                        {!! Form::select('ad_type', ['land_seek' => 'Recherche de foncier'], null, ['placeholder' => 'Choisir un type d\'annonce...']); !!}
                    </div>
                </div>
                <div class="field">
                    {!! Form::label('installation_type', 'Type d\'installation', ['class' => 'label']); !!}
                    <div class="select">
                        {!! Form::select('installation_type', ['solo' => 'Individuelle','couple' => 'En couple','collective' => 'Collective','undefined' => 'Ne sait pas encore', ], null, ['placeholder' => 'Choisir un type d\'installation...']); !!}
                    </div>
                </div>
                <div class="columns">
                    <div class=" column is-one-quarter">
                        <div class="field">
                            {!! Form::label('city', 'Commune', ['class' => 'label']); !!}
                            {!! Form::text('city', null, ['class' => 'input'] ) !!}
                        </div>
                    </div>
                    <div class="column">
                        <p class="label">Dans un rayon de </p>
                        {!! Form::checkbox('city_range', '5 km', null) !!}
                        5 km
                        {!! Form::checkbox('city_range', '10 km', null) !!}
                        10km
                        {!! Form::checkbox('city_range', '20 km', null) !!}
                        15km
                        {!! Form::checkbox('city_range', '50 km', null) !!}
                        20km
                    </div>
                    <div class="column">
                        <div class="field">
                            {!! Form::label('region', 'Région', ['class' => 'label']); !!}
                            <div class="select">
                                {!! Form::select('region', ['rhones-alpes' => 'Rhônes-Alpes', 'bretagne'=>'Bretagne'], null, ['placeholder' => 'Veuillez choisir...']); !!}
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="field">
                            {!! Form::label('departments', 'Départements', ['class' => 'label']); !!}
                            {!! Form::text('departments', null, ['class' => 'input'] ) !!}
                        </div>
                    </div>
                </div>
                <div class="field">
                    {!! Form::label('offer_genre', 'Accès au foncier souhaité', ['class' => 'label']); !!}
                    <div class="select">
                        {!! Form::select('offer_genre', ['location' => 'Location','acquisition' => 'Acquisition','undefined' => 'Indifférent'], null, ['placeholder' => 'Veuillez choisir...']); !!}
                    </div>
                </div>
                <div class="field">
                    <p class="label">Je souhaite m'installer en bio </p>
                    {!! Form::radio('is_bio', 'true') !!}
                    oui
                    {!! Form::radio('is_bio', 'false', null) !!}
                    non
                </div>
                <div class="field">
                    <p class="label">Surface recherchée(en ha) </p>
                    {!! Form::checkbox('surface_range', '0-5', null) !!}
                    0-5 km
                    {!! Form::checkbox('surface_range', '5-10', null) !!}
                    5-10 km
                    {!! Form::checkbox('surface_range', '10-20', null) !!}
                    10-20 km
                    {!! Form::checkbox('surface_range', '20-50', null) !!}
                    20-50 km
                    {!! Form::checkbox('surface_range', '50-100', null) !!}
                    50-100 km
                    {!! Form::checkbox('surface_range', '>100', null) !!}
                    >100 km
                </div>
                <div class="field">
                    <p class="label">Productions envisagée(s) </p>
                    {!! Form::checkbox('building', 'has_building', null) !!}
                    Avec une maison dd'habitation existante
                    {!! Form::checkbox('production_type', 'choice 2', null) !!}
                    Avec des bâtis agricoles existants
                </div>
                <div class="field">
                    <p class="label">Prix si recherche d'acquisition </p>
                    {!! Form::checkbox('price', '< 500000', null) !!}
                    Moins de 50 000
                    {!! Form::checkbox('price', '50-10000', null) !!}
                    De 50 à 100 000
                    {!! Form::checkbox('price', '100-200000', null) !!}
                    De 100 à 200 000
                    {!! Form::checkbox('price', '200-300000', null) !!}
                    De 200 à 300 000
                    {!! Form::checkbox('price', '>300000', null) !!}
                    Plus de 300 000
                </div>
                <div class="columns">
                    <div class="column is-half">
                        <div class="field">
                            <p class="label">Si recherche de location, loyer minimum</p>
                            {!! Form::text('rent_min', null, ['class' => 'input'] ) !!}
                        </div>
                    </div>
                    <div class="column">
                        <div class="field">
                            <p class="label">Si recherche de location, loyer maximum</p>
                            {!! Form::text('rent_max', null, ['class' => 'input'] ) !!}
                        </div>
                    </div>
                </div>
                <div class="field">
                    {!! Form::label('experience_farming', 'Expérience dans le domaine agricole', ['class' => 'label']); !!}
                    {!! Form::text('experience_farming', null, ['class' => 'textarea'] ) !!}
                </div>
                <div class="field">
                    {!! Form::label('about_project', 'Et si vous nous en disiez un peu plus sur votre projet ?', ['class' => 'label']); !!}
                    {!! Form::text('about_project', null, ['class' => 'textarea'] ) !!}
                </div>
                <div class="field">
                    {!! Form::label('about_content', 'Et si vous nous en disiez un peu plus sur vous ?', ['class' => 'label']); !!}
                    {!! Form::text('about_content', null, ['class' => 'textarea'] ) !!}
                </div>
                <div class="field">
                    <span>Une photo de vous ? Une synthèse de votre projet ? Les photos sont importantes pour donner envie de consulter votre annonce.</span>
                    <div class="file">
                        <label class="file-label">
                            {!! Form::file('image', ['class' => 'file-input'] ) !!}
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
                        <input type="checkbox">
                        Je certifie que mon projet correspond à la <a href="/">charte de Terre de Liens</a>
                    </label>
                </div>
                <div class="field is-grouped">
                    <div class="control">
                        {!! Form::submit('Envoyer',['class'=>'button is-link']) !!}
                    </div>
                    <div class="control">
                        <button class="button is-link is-light">Annuler</button>
                    </div>
                </div>
                <div class="column"></div>
                {!! Form::close() !!}
            </div>
            <div class="column"></div>
        </div>

        @include('components.partnering')
        @include('components.support_terre_liens')
    </section>
@endsection