<?php /** @var \App\Models\Ad $ad */ ?>

<div class="columns">
    <div class="column is-flex is-flex-direction-column is-justify-content-space-between">

        <div class="buttons is-justify-content-space-between">
            @include('pages.ads.partials.share-button')
            @include('pages.ads.partials.is-certified')
            @include('pages.ads.partials.modal-documents')
        </div>


        @include('pages.ads.partials.show-ref-title-date')

        <div class="mt-3">

            {{--Affichage des informations détaillées de l'annonce--}}
            <div class="is-flex is-flex-wrap-wrap gap-3 is-justify-content-space-between">

                @include('pages.ads.partials.show-author-infos')

                @include('pages.ads.partials.show-ad-location', ['showCities' => true])

                <div class="w-50">
                    <strong>Surface recherchée : </strong>
                    {{ empty($ad->human_ha) ? 'Non renseigné' :$ad->human_ha }}
                </div>

                @if(isset($ad->landSeekAd->installationType))
                    @if($ad->landSeekAd->installationType->name !== "Indifférent")
                        <div class="w-50">
                            <strong>Installation souhaitée : </strong>
                            @if ($ad->landSeekAd->installationType->name === "Seul·e")
                                Individuelle
                            @else
                                {{ $ad->landSeekAd->installationType->name }}
                            @endif
                        </div>
                    @endif
                @endif

                @foreach($ad->landSeekAd->buildings as $building)
                    <div class="w-50">
                        <strong>{{ $building->buildingType->label }} : </strong>
                        {{ $building->requirement->label }}
                    </div>
                @endforeach

                @php
                    $bioStatuses = [
                        -1 => 'Ne sais pas',
                        0 => 'Non',
                        1 => 'Oui',
                    ];
                @endphp

                <div class="w-50">
                    <strong>Souhaite s'installer en bio : </strong>
                    {{ $bioStatuses[$ad->landSeekAd->is_bio] ?? 'Non précisé' }}
                </div>

            </div>
        </div>

        <div class="buttons mt-3">
            @include('pages.ads.partials.new-buttons-favorite-and-message')
        </div>
    </div>
    <div class="column">
        <ads-carousel :images="{{ json_encode($ad->images ?? []) }}"></ads-carousel>
    </div>
</div>


<div class="is-flex is-flex-direction-column gap-6 bg-beige py-7 px-8 objT-border py-6-mobile mx-3-mobile px-5-mobile">
    @include('pages.ads.partials.show-productions', [
        'subAd' => $ad->landSeekAd,
        'mainProductionLabel' => 'Production principale',
        'secondaryProductionLabel' => 'Production secondaires et envisageables',
    ])

    <div>
        <h3 class="title is-4">Description du terrain recherché</h3>
        <p>{!! nl2br($ad->landSeekAd->land_description ?? "Non précisée") !!}</p>
    </div>
    <div>
        <h3 class="title is-4">Description du projet</h3>
        <p>{!! nl2br($ad->about_project_content ??"") !!}</p>
    </div>
    @if($ad->landSeekAd->experience_farming)
        <div>
            <h3 class="title is-4">Expérience du porteur de projet</h3>
            <p>{!! nl2br($ad->landSeekAd->experience_farming ?? "") !!}</p>
        </div>
    @endif
    @if($ad->about_content)
        <div>
            <h3 class="title is-4">A propos du porteur de projet</h3>
            <p>{!! nl2br($ad->about_content ?? "") !!}</p>
        </div>
    @endif
    <div class="is-flex is-justify-content-space-between is-align-items-center pt-3">
        <div class="buttons mb-0">
            @include('pages.ads.partials.new-buttons-favorite-and-message')
        </div>
        <a href="https://portail-terredeliens.force.com/rhizome/s/signaler-un-abus" target="_blank"
           class="is-underlined is-hidden-touch">Signaler un abus</a>
    </div>
</div>
