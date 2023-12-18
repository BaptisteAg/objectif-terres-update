<?php /** @var \App\Models\Ad $ad */ ?>
<div class="w-50">
    <strong>Département :</strong>
    {{ $ad->main_department->name }} ({{ $ad->main_department->code }})
    @if($ad->secondaryDepartmentsList->count())
        <br><small>
            {{ $ad->secondaryDepartmentsList->take(3)->join(', ') }}
            @if($ad->secondaryDepartmentsList->count() > 3)
                , ... ({{ $ad->secondaryDepartmentsList->count() - 3 }} autres)
            @endif
        </small>
    @endif
</div>

<?php if (!isset($showCities)) $showCities = false; ?>

@if($showCities || auth()->user()->id === $ad->user_pp_id || auth()->user()->role >= 1)
    <div class="w-50">
        <strong>Commune{{$ad->citiesCount > 1 ? 's' : ''}} :</strong>
        {{ $ad->citiesList }}
        @if(!$showCities)
            <br><small>(non visible pour les autres utilisateurs)</small>
        @endif
    </div>
@endif
