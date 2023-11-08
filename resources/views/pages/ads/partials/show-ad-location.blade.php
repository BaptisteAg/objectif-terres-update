<div class="w-50">
    <strong>Département :</strong>
    {{ $ad->mainDepartment->name }} ({{ $ad->mainDepartment->code }})
    @if($ad->secondaryDepartmentsList->count())
        <br><small>
            {{ $ad->secondaryDepartmentsList->join(', ') }}
        </small>
    @endif
</div>

<?php if(!isset($showCities)) $showCities = false; ?>

@if($showCities || auth()->user()->id === $ad->user_pp_id || auth()->user()->role >= 1)
    <div class="w-50">
        <strong>Commune{{$ad->citiesList->count() > 1 ? 's' : ''}} :</strong>
        {{ $ad->citiesList->join(', ') }}
        @if(!$showCities)
            <br><small>(non visible pour les autres utilisateurs)</small>
        @endif
    </div>
@endif
