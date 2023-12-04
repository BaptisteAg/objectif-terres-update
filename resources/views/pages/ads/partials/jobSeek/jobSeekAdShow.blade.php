<?php /** @var \App\Models\Ad $ad */ ?>

<div class="columns">
    <div class="column is-flex is-flex-direction-column is-justify-content-space-between">

        <div class="buttons is-justify-content-space-between">
            @include('pages.ads.partials.share-button')
            @include('pages.ads.partials.modal-documents')
        </div>

        @include('pages.ads.partials.show-ref-title-date')

        <div class="mt-3">

            {{--Affichage des informations détaillées de l'annonce--}}
            <div class="is-flex is-flex-wrap-wrap gap-3 is-justify-content-space-between">

                @include('pages.ads.partials.show-author-infos')

                @include('pages.ads.partials.show-ad-location', ['showCities' => true])

                <div class="w-50">
                    <strong>Expérience(s) recherchée(s) : </strong>
                    {{$ad->jobSeekAd->jobOfferTypes->pluck('name')->implode(', ') }}
                </div>

                <div class="w-50">
                    <strong>Niveau de formation : </strong>
                    @if( isset ($ad->jobSeekAd->educationLevels))
                        @if ($ad->jobSeekAd->educationLevels->count() >=1)
                            {{$ad->jobSeekAd->educationLevels->pluck('name')->implode(', ') }}
                        @endif
                    @endif
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
        'subAd' => $ad->jobSeekAd,
        'mainProductionLabel' => 'Production principale',
        'secondaryProductionLabel' => 'Production secondaires et envisageables',
    ])

    @if($ad->jobSeekAd->experience_farming)
        <div>
            <h3 class="title is-4">Expérience dans le monde agricole</h3>
            <p>{!! nl2br($ad->jobSeekAd->experience_farming ?? "") !!}</p>
        </div>
    @endif

    @include('pages.ads.partials.inputs.show_about_content')

    <div class="is-flex is-justify-content-space-between is-align-items-center pt-3">
        <div class="buttons mb-0">
            @include('pages.ads.partials.new-buttons-favorite-and-message')
        </div>
        <a href="https://portail-terredeliens.force.com/rhizome/s/signaler-un-abus" target="_blank"
           class="is-underlined is-hidden-touch">Signaler un abus</a>
    </div>
</div>
