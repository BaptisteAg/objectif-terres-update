<div class="columns is-mobile is-multiline">
   @include('layouts.partials.headerResearchLocation')
    <div class="column is-full-mobile is-half-tablet is-one-third-desktop">
        {{ Form::label('jobOfferType', 'Choisissez un statut', ['class' => 'label']) }}
        <div class="select form-field">
            {{ Form::select('jobOfferType', $jobOfferTypes->pluck('name'), null, ['placeholder' => 'Statut de job', 'class' => "form-field"]) }}
        </div>
        <div class="field mt-20">
            {!! Form::label('keywords', 'Recherche par mot clé', ['class' => 'label']); !!}
            <input name="keywords" class="input" type="text" placeholder="Votre recherche..."
                   value="{{old('keywords')}}">
        </div>
    </div>
</div>
