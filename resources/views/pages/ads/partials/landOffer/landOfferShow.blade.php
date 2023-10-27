<?php /** @var \App\Models\Ad $ad */ ?>

<div class="columns">
    <div class="column is-flex is-flex-direction-column is-justify-content-space-between">

        <div class="buttons is-justify-content-space-between">
            @include('pages.ads.partials.share-button')
            @include('pages.ads.partials.modal-documents')
        </div>


        {{--Affichage ref/title/date--}}
        <div>
            <p class="pb-3">Référence : {{$ad->id}}</p>
            <h1 class="title">
                {{$ad->title}}
            </h1>
            <p>Publié le {{ $ad->published_on}}</p>
        </div>

        <div class="mt-3">

            {{--Affichage des tags et du prix--}}
            <div class="is-flex is-justify-content-space-between pb-4">
                <b-taglist>
                    @foreach($ad->landOfferAd->offerGenres as $offerGenre)
                        <b-tag type="is-warning" size="is-medium"
                               class="has-text-weight-bold is-uppercase">{{$offerGenre->id === $offerGenre::ID_VENTE ? 'Vente' : $offerGenre->name}}
                        </b-tag>
                    @endforeach
                </b-taglist>
                <div class="title is-5" style="color: #A74B2B">
                    {{ !empty($ad->formatted_price) ? $ad->formatted_price : 'Prix non renseigné' }}
                </div>
            </div>

            {{--Affichage des informations détaillées de l'annonce--}}
            <div class="is-flex is-flex-wrap-wrap gap-3 is-justify-content-space-between">

                @if(!empty($ad->landOfferAd->surface))
                    <div class="w-50">
                        <strong>Surface : </strong>
                        {{$ad->landOfferAd->surface}} hectares
                    </div>
                @endif

                @auth
                    @if(auth()->user()->role >= 2 && isset($ad->support_request_id_region))
                        <div class="w-50">
                            <strong>Région : </strong>
                            {{$ad->supportRequestIdRegion->name}}
                        </div>
                    @endif
                @endauth

                @if($ad->accept_share_contact_infos === 1)
                    <div class="w-50">
                        <strong>Publié par : </strong>
                        @if(!empty($ad->userPp))
                            @auth()
                                @if(auth()->user()->role >= 1 )
                                    <a href="{{route('user.show', $ad->userPp->id)}}">{{ $ad->pp_display_name}}</a>
                                @elseif(auth()->user()->role < 1)
                                    {{ $ad->pp_display_name}}
                                @endif
                            @endauth
                            @guest()
                                {{ $ad->pp_display_name}}
                            @endguest()
                        @else
                            [Utilisateur supprimé]
                        @endif
                    </div>
                @endif

                <div class="w-50">
                    <strong>Altitude : </strong>
                    @if($ad->landOfferAd->altitude)
                        {{$ad->landOfferAd->altitude }} mètres
                    @else
                        Non renseignée
                    @endif
                </div>

                @if($ad->landOfferAd->accept_use_zip_code || auth()->user()->id === $ad->user_pp_id || auth()->user()->role >= 1)
                    <div class="w-50">
                        <strong>Département :</strong>
                        {{ $ad->mainDepartment->name }} ({{ $ad->mainDepartment->code }})
                        @if($ad->secondaryDepartmentsList->count())
                            <small>
                                {{ $ad->secondaryDepartmentsList->join(', ') }}
                            </small>
                        @endif
                        @if(!$ad->landOfferAd->accept_use_zip_code)
                            <br><small>(non visible pour les autres utilisateurs)</small>
                        @endif
                    </div>


                    <div class="w-50">
                        <strong>Commune{{$ad->citiesList->count() > 1 ? 's' : ''}} :</strong>
                        {{ $ad->citiesList->join(', ') }}
                        @if(!$ad->landOfferAd->accept_use_zip_code)
                            <br><small>(non visible pour les autres utilisateurs)</small>
                        @endif
                    </div>
                @endif

                @if($ad->landOfferAd->is_activity_transfer)
                    <div class="w-50">
                        <strong>Ferme en activité : </strong>
                        {{ $ad->landOfferAd->is_activity_transfer ? "Oui" : "Non" }}
                    </div>
                @endif

                @if($ad->accept_share_contact_infos === 1 && !empty($ad->userPp) && $ad->userPp->phone)
                    <div class="w-50">
                        <strong>N° de téléphone : </strong>
                        {{$ad->userPp->phone}}
                    </div>
                @endif

                @if ($ad->landOfferAd->offerGenres->count() >=1)
                    <div class="w-50">
                        <strong>Mode de cession : </strong>
                        @foreach($ad->landOfferAd->offerGenres as $offerGenre)
                            {{$offerGenre->id === $offerGenre::ID_VENTE ? 'Vente' : $offerGenre->name}}
                            @if(!$loop->last)
                                ,
                            @endif
                        @endforeach
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
            @if($ad->landOfferAd->productionGenresSecondary->count() || $ad->landOfferAd->secondary_production_type_add)
                @foreach($ad->landOfferAd->productionGenresSecondary->pluck('name') as $productionGenresSecondary)
                    <b-tag type="is-primary" rounded size="is-medium">
                        {{$productionGenresSecondary}}
                    </b-tag>
                @endforeach
                @if($ad->landOfferAd->secondary_production_type_add)
                    <b-tag type="is-primary" rounded size="is-medium">
                        {{ ucfirst($ad->landOfferAd->secondary_production_type_add) }}
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
            @include('pages.ads.partials.new-buttons-favorite-and-message')
        </div>
        <a href="https://portail-terredeliens.force.com/rhizome/s/signaler-un-abus" target="_blank"
           class="is-underlined is-hidden-touch">Signaler un abus</a>
    </div>
</div>
