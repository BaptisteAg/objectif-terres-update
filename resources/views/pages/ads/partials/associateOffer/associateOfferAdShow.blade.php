<?php /** @var \App\Models\Ad $ad */ ?>

<div class="columns">
    <div class="column is-flex is-flex-direction-column is-justify-content-space-between">

        <div class="buttons is-justify-content-space-between">
            @include('pages.ads.partials.share-button')
            @include('pages.ads.partials.is-certified')
            @include('pages.ads.partials.modal-documents')
        </div>

        @include('pages.ads.partials.show-ref-title-date')

        {{--Affichage de la description--}}

        <div class="mt-3">

            {{--Affichage des informations détaillées de l'annonce--}}
            <div class="is-flex is-flex-wrap-wrap gap-3 is-justify-content-space-between">

                @if(!empty($ad->associateOfferAd->surface))
                    <div class="w-50">
                        <strong>Surface : </strong>
                        {{$ad->associateOfferAd->surface}} hectares
                    </div>
                @endif

                @include('pages.ads.partials.show-author-infos')

                <div class="w-50">
                    <strong>Altitude : </strong>
                    @if($ad->associateOfferAd->altitude)
                        {{$ad->associateOfferAd->altitude }} mètres
                    @else
                        Non renseignée
                    @endif
                </div>

                @include('pages.ads.partials.show-ad-location', ['showCities' => $ad->associateOfferAd->accept_use_zip_code])

                @if($ad->associateOfferAd->is_activity_transmission)
                    <div class="w-50">
                        <strong>Transmission d'activité : </strong>
                        {{ $ad->associateOfferAd->is_activity_transmission ? "Oui" : "Non" }}
                    </div>
                @endif

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
        'subAd' => $ad->associateOfferAd,
        'mainProductionLabel' => 'Production principale',
        'secondaryProductionLabel' => 'Production secondaires et envisageables',
    ])

    <div class="is-flex is-flex-wrap-wrap gap-6-mobile is-justify-content-space-between">
        <div class="w-50">
            <h3 class="title is-4">Certification des terres</h3>
            @if($ad->associateOfferAd->bioCertifications->count() || $ad->associateOfferAd->production_type_add)
                @foreach($ad->associateOfferAd->bioCertifications as $bioCertification)
                    @if($bioCertification->icon == "")
                        <p>{{$bioCertification->name }}</p>
                    @endif
                    <img src="{{ $bioCertification->icon }}">
                @endforeach
            @else
                <p>Aucune</p>
            @endif
        </div>
        <div class="w-50">
            <h3 class="title is-4">Accès à l’eau</h3>
            {{ $ad->associateOfferAd->water_access ? "Oui" : "Non" }}
        </div>
    </div>
    <div class="is-flex is-flex-wrap-wrap gap-6-mobile is-justify-content-space-between">
        <div class="w-50">
            <h3 class="title is-4">Présence d’habitations</h3>
            {{ $ad->associateOfferAd->has_houses ? "Oui" : "Non" }}
        </div>
        <div class="w-50">
            <h3 class="title is-4">Présence de bâtiments agricoles</h3>
            {{ $ad->associateOfferAd->has_buildings ? "Oui" : "Non" }}
        </div>
    </div>
    <div>
        <h3 class="title is-4">Description d'associé</h3>
        <p>{{ $ad->associateOfferAd->associate_description }}</p>
    </div>
    <div>
        <h3 class="title is-4">Description de la transmission agricole</h3>
        <p>{!! nl2br($ad->about_project_content ??"") !!}</p>
    </div>
    <div>
        <h3 class="title is-4">A propos de l'annonceur</h3>
        <p>{!! nl2br($ad->about_content ?? "") !!}</p>
    </div>
    <div class="is-flex is-justify-content-space-between is-align-items-center pt-3">
        <div class="buttons mb-0">
            @include('pages.ads.partials.new-buttons-favorite-and-message')
        </div>
        <a href="https://portail-terredeliens.force.com/rhizome/s/signaler-un-abus" target="_blank"
           class="is-underlined is-hidden-touch">Signaler un abus</a>
    </div>
</div>
