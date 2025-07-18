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
                    <strong>Niveau de formation : </strong>
                    @if( isset ($ad->associateSeekAd->educationLevels))
                        @if ($ad->associateSeekAd->educationLevels->count() >=1)
                            {{$ad->associateSeekAd->educationLevels->pluck('name')->implode(', ') }}
                        @endif
                    @endif
                </div>

                <div class="w-50">
                    <strong>Lieu et terres agricoles déjà trouvées : </strong>
                    {{ $ad->associateSeekAd->is_land_already_found ? "Oui" : "Non" }}
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
        'subAd' => $ad->associateSeekAd,
        'mainProductionLabel' => 'Production principale',
        'secondaryProductionLabel' => 'Production secondaires et envisageables',
    ])
    @if($ad->associateSeekAd->land_description)
        <div>
            <h3 class="title is-4">Description des terres</h3>
            <p>{!! nl2br($ad->associateSeekAd->land_description ?? "Non précisée") !!}</p>
        </div>
    @endif
    <div>
        <h3 class="title is-4">Description du projet</h3>
        <p>{!! nl2br($ad->about_project_content ??"") !!}</p>
    </div>
    @if($ad->associateSeekAd->experience_farming)
        <div>
            <h3 class="title is-4">Expérience souhaitée dans le milieu agricole</h3>
            <p>{!! nl2br($ad->associateSeekAd->experience_farming ?? "") !!}</p>
        </div>
    @endif

    {{--    TODO : formation ??--}}
    {{--    @if($ad->associateSeekAd->educationLevels->count())--}}
    {{--        <div class="w-50">--}}
    {{--            <h3 class="title is-4">Niveau de formation souhaité</h3>--}}
    {{--            @foreach($ad->associateSeekAd->educationLevels as $educationLevel)--}}
    {{--                @if($educationLevel->name == "")--}}
    {{--                    <p>{{$educationLevel->name }}</p>--}}
    {{--                @endif--}}
    {{--                <img src="{{ $educationLevel->icon }}">--}}
    {{--            @endforeach--}}
    {{--        </div>--}}
    {{--    @endif--}}

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
        <a href="https://terredeliens.my.site.com/rhizome/s/signaler-un-abus" target="_blank"
           class="is-underlined is-hidden-touch">Signaler un abus</a>
    </div>
</div>
