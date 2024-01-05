<?php /** @var \App\Models\Ad $ad */ ?>
@php
    $adsMoreButton = [
        'mainDepartment' => [
               'name' => $ad->main_department->name,
               'code' => $ad->main_department->code,
           ],
        'secondaryDepartmentsList' => $ad->secondaryDepartmentsList->all(),
        'citiesList' => $ad->citiesArray,
        'showCities' => $showCities,
    ];
   dump($adsMoreButton);
@endphp

<show-more-button :ad='{{ json_encode($adsMoreButton) }}'>
</show-more-button>
