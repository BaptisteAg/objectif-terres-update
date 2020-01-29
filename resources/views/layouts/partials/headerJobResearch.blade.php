<div class="columns">
   @include('layouts.partials.headerResearchLocation')
    <div class="column">
        {{ Form::label('jobStatus', 'Choisissez un statut', ['class' => 'label']) }}
        <div class="select">
            {{ Form::select('jobStatus', $jobStatuses->pluck('name'), null, ['placeholder' => 'statut de job']) }}
        </div>
    </div>
</div>
