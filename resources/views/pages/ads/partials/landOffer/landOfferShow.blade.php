<div class="columns">
    <div class="column is-flex is-flex-direction-column is-justify-content-space-between">
        <div class="buttons is-justify-content-space-between is-hidden-touch">
            <b-button rounded icon-left="share-variant-outline">
                Partager
            </b-button>
            <b-button rounded icon-left="download">
                Télécharger en PDF
            </b-button>
        </div>
        <div class="buttons is-hidden-desktop">
            <b-button rounded icon-left="share-variant-outline" style="padding-left: 1em; padding-right: 1em;">
            </b-button>
            <b-button rounded icon-left="download" style="padding-left: 1em; padding-right: 1em;">
            </b-button>
        </div>
        <div>
            <p class="pb-3">Référence : 1695-V</p>
            <h1 class="title">
                {{$ad->title}}
            </h1>
            <p>Publié le 1er juillet 2023</p>
        </div>
        <div>
            <div class="is-flex is-justify-content-space-between pb-4">
                <b-tag type="is-warning" size="is-medium"
                       class="has-text-weight-bold is-uppercase">{{ $ad->formatted_type }}
                </b-tag>
                <div class="title is-5" style="color: #A74B2B">
                    {{ $ad->formatted_price }}
                </div>
            </div>
            <div class="is-flex is-flex-wrap-wrap gap-3 is-justify-content-space-between">
                @if(!empty($ad->landOfferAd->surface))
                    <div class="w-50">
                        <strong>Surface : </strong>
                        {{$ad->landOfferAd->surface}} hectares
                    </div>
                @endif
                <div class="w-50">
                    <strong>Région : </strong>
                    Auvergne-Rhône-Alpes
                </div>
                <div class="w-50">
                    <strong>Altitude : </strong>
                    @if($ad->landOfferAd->altitude)
                        {{$ad->landOfferAd->altitude }} mètres
                    @else
                        Non renseignée
                    @endif
                </div>
                <div class="w-50">
                    <strong>Département : </strong>
                    Rhône
                </div>
            </div>
        </div>

        <div class="buttons mt-3-mobile">
            @include('pages.ads.partials.new-buttons-favorite-and-message')
        </div>
    </div>
    <div class="column">
        <ads-carousel :images="{{ json_encode($ad->images ?? []) }}"></ads-carousel>
    </div>
</div>
<div class="is-flex is-flex-direction-column gap-6 bg-beige py-7 px-8 objT-border p-6-mobile mx-3-mobile px-1-mobile">
    <div>
        <h3 class="title is-4">Production principale</h3>
        <b-taglist>
            @if($ad->landOfferAd->productionGenres->count() || $ad->landOfferAd->production_type_add)
                @foreach($ad->landOfferAd->productionGenres->pluck('name') as $productionGenre)
                    <b-tag type="is-primary" rounded size="is-medium">
                        {{$productionGenre}}
                    </b-tag>
                @endforeach
                @if($ad->landOfferAd->production_type_add)
                    <b-tag type="is-primary" rounded size="is-medium">
                        {{ ucfirst($ad->landOfferAd->production_type_add) }}
                    </b-tag>
                @endif
            @else
                <b-tag type="is-primary" rounded size="is-medium">
                    Non renseigné
                </b-tag>
            @endif
        </b-taglist>
    </div>
    <div>
        <h3 class="title is-4">Production secondaires et envisageables</h3>
        <b-taglist>
            @if($ad->landOfferAd->productionGenresPossible->count() || $ad->landOfferAd->production_type_wanted_add)
                @foreach($ad->landOfferAd->productionGenresPossible->pluck('name') as $productionGenresPossible)
                    <b-tag type="is-primary" rounded size="is-medium">
                        {{$productionGenresPossible}}
                    </b-tag>
                @endforeach
                @if($ad->landOfferAd->production_type_wanted_add)
                    <b-tag type="is-primary" rounded size="is-medium">
                        {{ ucfirst($ad->landOfferAd->production_type_wanted_add) }}
                    </b-tag>
                @endif
            @else
                <b-tag type="is-primary" rounded size="is-medium">
                    Non renseigné
                </b-tag>
            @endif
        </b-taglist>

    </div>
    <div class="is-flex is-flex-wrap-wrap gap-6-mobile is-justify-content-space-between">
        <div class="w-50">
            <h3 class="title is-4">Certification des terres</h3>
            @if($ad->landOfferAd->bioCertifications->count() || $ad->landOfferAd->production_type_add)
                @foreach($ad->landOfferAd->bioCertifications as $bioCertification)
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
            @if($ad->landOfferAd->water_access === 1)
                <p>{{ucfirst($ad->waterAccess)}}</p>
            @else
                <p>Non renseigné</p>
            @endif
        </div>
    </div>
    <div class="is-flex is-flex-wrap-wrap gap-6-mobile is-justify-content-space-between">
        <div class="w-50">
            <h3 class="title is-4">Présence d’habitations</h3>
            @if($ad->landOfferAd->has_houses)
                <p>
                    {{$ad->landOfferAd->house->description ?? "Non renseignée"}}
                    @if($isSupportRequest)
                        , surface totale
                        : {{empty($ad->landOfferAd->house->surface) ? "Non renseignée" : $ad->landOfferAd->house->surface.'m²'}}
                    @endif
                </p>
                <p>Type de cession :
                    @if($ad->landOfferAd->house->offerGenres->count() > 0 )
                        @foreach($ad->landOfferAd->house->offerGenres as $offerGenre)
                            {{$offerGenre->id === $offerGenre::ID_VENTE ? 'Vente' : $offerGenre->name}}
                            @if(!$loop->last)
                                ,
                            @endif
                        @endforeach
                    @else
                        non précisé
                    @endif
                </p>
            @else
                <p>Sans habitation</p>
            @endif
            <p>Oui</p>
        </div>
        <div class="w-50">
            <h3 class="title is-4">Présence de bâtiments agricoles</h3>
            @if($ad->landOfferAd->has_buildings)
                <p>{{$ad->landOfferAd->building->description ?? "Non renseignée"}}</p>
                @if($isSupportRequest)
                    , surface totale
                    : {{empty($ad->landOfferAd->building->surface) ? "Non renseignée" : $ad->landOfferAd->building->surface.'m²'}}
                @endif
            @else
                <p>Sans bâtiment agricole</p>
            @endif
            <p>Oui</p>
        </div>
    </div>
    <div>
        <h3 class="title is-4">Description de la terre</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
            et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
            aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
            cillum dolore eu fugiat nulla pariatur.</p>
    </div>
    <div>
        <h3 class="title is-4">Description de la transmission agricole</h3>
        <p>{!! nl2br($ad->about_project_content ??"") !!}</p>
    </div>
    <div>
        <h3 class="title is-4">Description du porteur de projet</h3>
        <p>{!! nl2br($ad->about_content ?? "") !!}</p>
    </div>
    <div class="is-flex is-justify-content-space-between is-align-items-center pt-3">
        <div class="buttons mb-0">
            <b-button rounded type="is-danger">
                Répondre à l’annonce
            </b-button>
            <b-button rounded icon-left="star-outline" style="padding-left: 1em; padding-right: 1em;">
            </b-button>
        </div>
        <a href="https://portail-terredeliens.force.com/rhizome/s/signaler-un-abus" target="_blank" class="is-underlined is-hidden-touch">Signaler un abus</a>
    </div>
</div>