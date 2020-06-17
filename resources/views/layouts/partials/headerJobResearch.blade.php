<div class="columns is-mobile is-multiline">
   @include('layouts.partials.headerResearchLocation')
    <div class="column is-full-mobile is-half-tablet is-one-third-desktop">
        {{ Form::label('jobOfferType', 'Choisissez un statut', ['class' => 'label']) }}
        <div class="select">
            {{ Form::select('jobOfferType', $jobOfferTypes->pluck('name'), null, ['placeholder' => 'statut de job']) }}
        </div>
    </div>
</div>
