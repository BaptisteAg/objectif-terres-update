<?php /** @var \App\Models\Ad $ad */ ?>

<div>
    <p class="pb-3">Référence : {{$ad->id}}</p>
    <h1 class="title">
        {{$ad->title}}
    </h1>
    @if($ad->attributionAd->ad_status_id === \App\Models\AdStatus::APPROVE_ID && $ad->published_on)
        <p>Publié le {{ $ad->published_on}}</p>
    @endif
</div>
