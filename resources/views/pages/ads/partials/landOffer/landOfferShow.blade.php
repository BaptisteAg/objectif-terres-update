<div class="columns">
    @include('pages.ads.partials.show-images')
    <div class="column is-half is-flex-tablet">
        <div class="card is-flex-tablet card-announcement">
            <div class="card-content">
                @foreach($ad->landOfferAd->offerGenres as $offerGenre)
                    <span class="custom-tag info">
                        {{$offerGenre->id === $offerGenre::ID_VENTE ? 'Achat' : $offerGenre->name}}
                    </span>
                @endforeach
                <div class="content">
                    @if($ad->is_draft)
                        <p><span class="is-size-5   ">Annonce soumise le : </span><span
                                    class="subtitle">{{ $ad->created_at}}</span>
                        </p>
                    @else
                        @if(isset($ad->is_partner) && $ad->is_partner === 1 )
                            <p class="custom-tags">
                                <span class="custom-tag warning">Annonce certifiée </span>
                            </p>
                        @endif
                        <p><span class="is-size-5   ">Publié le : </span><span
                                    class="subtitle">{{ $ad->published_on}}</span>
                        </p>
                    @endif
                </div>
                <div class="content">
                    <p><span class="is-size-5 ">Publié par : </span>
                        @auth()
                            @if(auth()->user()->role >= 1 )
                                <span class="subtitle">
                                    <a href="{{route('user.show', $ad->userPp->id)}}">{{ $ad->userPp->first_name}} {{$ad->userPp->name}}</a>
                                </span>
                            @elseif(auth()->user()->role < 1)
                                <span class="subtitle">
                                    {{ $ad->userPp->first_name}} {{$ad->userPp->name}}
                                </span>
                            @endif
                        @endauth
                        @guest()
                            <span class="subtitle">
                                {{ $ad->userPp->first_name}} {{$ad->userPp->name}}
                            </span>
                        @endguest()
                    </p>
                </div>
                {{--				<div class="content">--}}
                {{--					<p><span class="is-size-5 is-capitalized has-text-black">Catégorie : </span><span--}}
                {{--								class="subtitle">{{$ad->ad_type_full_name}}</span></p>--}}
                {{--				</div>--}}
                @auth
                    @if(auth()->user()->role >=2)
                        @if(isset($ad->support_request_id_region))
                            <div class="content">
                                <p>
                                    <span class="is-size-5 is-capitalized ad-show-feature-label">Territoire </span>
                                    :
                                    <span class="subtitle">{{$ad->supportRequestIdRegion->name}}</span>
                                </p>
                            </div>
                        @endif
                    @endif
                @endauth
                @if($ad->cities->count())
                    @if($ad->landOfferAd->accept_use_zip_code)
                        <div class="content">
                            <p><span class="is-size-5 is-capitalized ">Code postal : </span><span
                                        class="subtitle">{{$ad->cities[0]->zip_code }} ({{$ad->cities[0]->name }}
                                    )</span>
                            </p>
                        </div>
                    @else
                        <div class="content">
                            @auth
                                @if( auth()->user()->id === $ad->user_pp_id || auth()->user()->role >=3)
                                    <p>
                                        @if(auth()->user()->id === $ad->user_pp_id)
                                            <span class="is-size-5 ">Code Postal (non visible pour les autres
                                                utilisateurs): </span>
                                        @else
                                            <span class="is-size-5 ">Code Postal: </span>
                                        @endif
                                        <span
                                                class="subtitle">{{$ad->cities[0]->zip_code }}
                                            ({{$ad->cities[0]->name }}
                                            )</span>
                                    </p>
                                @else
                                    <p><span class="is-size-5 is-capitalized ">Département : </span><span
                                                class="subtitle">{{$ad->cities[0]->department->code }}
                                            ({{$ad->cities[0]->department->name }})</span>
                                    </p>
                                @endif
                            @else
                                <p><span class="is-size-5 is-capitalized ">Département : </span><span
                                            class="subtitle">{{$ad->cities[0]->department->code }}
                                        ({{$ad->cities[0]->department->name }})</span>
                                </p>
                            @endauth
                        </div>
                    @endif
                @elseif($ad->departments->count())
                    <div class="content">
                        <p><span class="is-size-5 is-capitalized ">Département : </span><span
                                    class="subtitle">{{$ad->departments[0]->code }} ({{$ad->departments[0]->name }}
                                )</span>
                        </p>
                    </div>
                @elseif($ad->regions->count())
                    <div class="content">
                        <p><span class="is-size-5 is-capitalized has-text-black">Région : </span>
                            <span class="subtitle">
                                {{$ad->regions[0]->name }}
                            </span>
                        </p>
                    </div>
                @endif

                @if(!empty($ad->landOfferAd->surface))
                    <div class="content">
                        <p><span class="is-size-5 is-capitalized ">Surface : </span><span
                                    class="subtitle">{{$ad->landOfferAd->surface}} hectares</span></p>
                    </div>
                @endif
                <div class="content">
                    @if ($ad->landOfferAd->offerGenres->count() >=1)
                        <p>
                            <span class="is-size-5  ">Mode de cession : </span>
                            <span class="subtitle">
                                @foreach($ad->landOfferAd->offerGenres as $offerGenre)
                                    {{$offerGenre->id === $offerGenre::ID_VENTE ? 'Achat' : $offerGenre->name}}
                                    @if(!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            </span>
                        </p>
                    @endif
                    <p>
                        @if($ad->landOfferAd->price || $ad->landOfferAd->rent_price)
                            @if($ad->landOfferAd->price)
                                <span class="is-size-5  ">Prix : </span>
                                <span class="subtitle ">
                                    {{number_format($ad->landOfferAd->price, 0, ",", " " )}} €
                                </span>
                            @endif
                            @if($ad->landOfferAd->rent_price)
                                <span class="is-size-5  ">Loyer mensuel : </span>
                                <span class="subtitle ">
                                    {{number_format($ad->landOfferAd->rent_price, 0, ",", " " )}} € / mois
                                </span>
                            @endif
                        @else
                            <span class="is-size-5  ">Prix : </span>
                            <span class="subtitle ">
                                Non renseigné
                            </span>
                        @endif
                    </p>
                </div>
                @if($ad->landOfferAd->is_activity_transfer)
                    <div class="content">
                        <p>
                            <span class="is-size-5  ">Ferme en activité : </span>
                            <span class="subtitle"> {{ $ad->landOfferAd->is_activity_transfer ? "Oui" : "Non" }} </span>
                        </p>
                    </div>
                @endif
                @if($ad->accept_share_contact_infos === 1 && $ad->userPp->phone)
                    <div class="content">
                        <p>
                            <span class="is-size-5 ">N° de téléphone : </span>
                            <span class="subtitle">{{$ad->userPp->phone}}</span>
                        </p>
                    </div>
                @endif

                @include('pages.ads.partials.show-documents')
            </div>

            @include('pages.ads.partials.buttons-favorite-and-message')

        </div>
    </div>
</div>
@include('pages.ads.partials.adMessageModal')

<div class="columns is-multiline">
    <div class="column is-half-desktop is-full-tablet">
        <h4 class="title is-3 has-text-centered">Description générale du bien</h4>
        <div class=" ">
            @if($ad->landOfferAd->productionGenres->count())
                <div class="mb-20">
                    <p class="has-text-link is-size-5 ">Système de production en place</p>
                    <p class="">
                        <span>{{$ad->landOfferAd->productionGenres->pluck('name')->implode(', ') }}</span>
                    </p>
                </div>
            @endif

            @if($ad->landOfferAd->productionGenresPossible->count())
                <div class="mb-20">
                    <p class="has-text-link is-size-5 ">Productions possibles</p>
                    <p class="">
                        <span>{{$ad->landOfferAd->productionGenresPossible->pluck('name')->implode(', ') }}</span>
                    </p>
                </div>
            @endif

            @if($ad->landOfferAd->bioCertifications->count())
                <div class=" ">
                    <p class="has-text-link is-size-5"> Certification des terres</p>

                    <p class="">
                        @foreach($ad->landOfferAd->bioCertifications as $bioCertification)
                            @if($bioCertification->icon == "")
                                <span>{{$bioCertification->name }}</span>
                            @endif
                            <img src="{{ $bioCertification->icon }}">
                        @endforeach
                    </p>
                </div>
            @endif

            <div class="mb-20">
                <p class="has-text-link is-size-5 ">Altitude</p>
                <p class="">
                    @if($ad->landOfferAd->altitude)
                        {{$ad->landOfferAd->altitude }}m
                    @else
                        Non renseignée
                    @endif
                </p>
            </div>

            @if($ad->water_access === 1)
            <div class="mb-20">
                <p class="has-text-link is-size-5 ">Accès à l'eau</p>

                <p class="">
                    {{$ad->water_access_description}}
                </p>
            </div>
            @endif


        </div>
    </div>
    <div class="column is-half-desktop is-full-tablet">
        @if($isSupportRequest && $ad->support_request_text)
            <div class="content">
                <h4 class="title is-3">Résumé de votre projet</h4>
                <p>  {!! nl2br($ad->support_request_text ?? "") !!} </p>
            </div>
        @endif
        <div class="content">
            @if($ad->landOfferAd->sau_description || $ad->landOfferAd->has_houses || $ad->landOfferAd->has_buildings)
            <h4 class="title is-3"> Description du bâti</h4>

                @if($ad->landOfferAd->sau_description)
                <p>  {!! nl2br($ad->landOfferAd->sau_description ?? "") !!}</p>
                @endif

                @if($ad->landOfferAd->has_houses || $ad->landOfferAd->has_buildings)
                    <div class="content">
                        <div class="">
                            @if($ad->landOfferAd->has_buildings)
                                <div class="mb-20">
                                    <p class="has-text-link is-size-5">Bâtiment(s) agricole(s)</p>
                                    <p class="">
                                        <span>
                                            {{$ad->landOfferAd->building->description ?? "Non renseignée"}}</span>
                                    </p>
                                    @if($isSupportRequest)
                                        <p class="">
                                            <span>
                                                {{$ad->landOfferAd->building->surface ?? "Non renseignée"}}</span>
                                        </p>
                                        <p class="">
                                            <span>Type de cession :
                                                @if($ad->landOfferAd->building->offerGenres->count() > 0 )

                                                    @foreach($ad->landOfferAd->building->offerGenres as $offerGenre)
                                                        {{$offerGenre->id === $offerGenre::ID_VENTE ? 'Achat' : $offerGenre->name}}
                                                        @if(!$loop->last)
                                                            ,
                                                        @endif
                                                    @endforeach

                                                @else
                                                    non précisé
                                                @endif
                                            </span>
                                        </p>
                                    @endif
                                </div>
                            @else
                                <div class="mb-20">
                                    <p class="has-text-link is-size-5">Bâtiment(s) agricole(s)</p>
                                    <p class="">Sans bâtiment agricole</p>
                                </div>
                            @endif
                            @if($ad->landOfferAd->has_houses)
                                <div class=" mb-20 ">
                                    <p class="has-text-link is-size-5">Habitation(s)</p>
                                    <p class="">
                                        <span>{{$ad->landOfferAd->house->description ?? "Non renseignée"}}</span>
                                    </p>
                                    @if($isSupportRequest)
                                        <p class="">
                                            <span>Surface totale
                                                : {{$ad->landOfferAd->house->surface ?? "Non renseignée"}}</span>
                                        </p>
                                        <p class="">
                                            <span>Type de cession :
                                                @if($ad->landOfferAd->house->offerGenres->count() > 0 )
                                                    @foreach($ad->landOfferAd->house->offerGenres as $offerGenre)
                                                        {{$offerGenre->id === $offerGenre::ID_VENTE ? 'Achat' : $offerGenre->name}}
                                                        @if(!$loop->last)
                                                            ,
                                                        @endif
                                                    @endforeach
                                                @else
                                                    non précisé
                                                @endif
                                            </span>
                                        </p>
                                    @endif
                                </div>
                            @else
                                <div class="mb-20">
                                    <p class="has-text-link is-size-5">Habitation</p>
                                    <p class="">Sans habitation</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            @endif
        </div>
        @if($ad->landOfferAd->test_description)
            <div class="content">
                <h4 class="title is-3">Description du test agricole</h4>
                <p>  {!! nl2br($ad->landOfferAd->test_description ?? "") !!}</p>
            </div>
        @endif

        <div class="content">
            <h4 class="title is-3">Description du projet</h4>
            <p>  {!! nl2br($ad->about_project_content ??"") !!}</p>
        </div>
        @if($ad->about_content)
            <div class="content">
                <h4 class="title is-3">A propos de l'annonceur</h4>
                <p> {!! nl2br($ad->about_content ?? "") !!}</p>
            </div>
        @endif
    </div>
</div>


{{--<hr class="navbar-divider">--}}
{{--<h4 class="title is-3 has-text-centered">Description générale du bien</h4>--}}
{{--<div class="columns is-multiline is-mobile is-centered">--}}
{{--    @if($ad->landOfferAd->productionGenres->count())--}}
{{--        <div class="column is-one-third ">--}}
{{--            <p class="has-text-link is-size-5 has-text-centered">Système de production en place</p>--}}
{{--            <p class="has-text-centered">--}}
{{--                <span>{{$ad->landOfferAd->productionGenres->pluck('name')->implode(', ') }}</span>--}}
{{--            </p>--}}
{{--        </div>--}}
{{--    @endif--}}

{{--    @if($ad->landOfferAd->productionGenresPossible->count())--}}
{{--        <div class="column is-one-third ">--}}
{{--            <p class="has-text-link is-size-5 has-text-centered">Productions possibles</p>--}}
{{--            <p class="has-text-centered">--}}
{{--                <span>{{$ad->landOfferAd->productionGenresPossible->pluck('name')->implode(', ') }}</span>--}}
{{--            </p>--}}
{{--        </div>--}}
{{--    @endif--}}

{{--    <div class="column is-one-third ">--}}
{{--        <p class="has-text-link is-size-5 has-text-centered"> Certification des terres</p>--}}

{{--        <p class="has-text-centered">--}}
{{--            @foreach($ad->landOfferAd->bioCertifications as $bioCertification)--}}
{{--                @if($bioCertification->icon == "")--}}
{{--                    <span>{{$bioCertification->name }}</span>--}}
{{--                @endif--}}
{{--                <img src="{{ $bioCertification->icon }}">--}}
{{--            @endforeach--}}
{{--        </p>--}}
{{--    </div>--}}

{{--    <div class="column is-one-third ">--}}
{{--        <p class="has-text-link is-size-5 has-text-centered">Altitude</p>--}}

{{--        <p class="has-text-centered">--}}
{{--            @if($ad->landOfferAd->altitude)--}}
{{--                {{$ad->landOfferAd->altitude }}m--}}
{{--            @else--}}
{{--                Non renseignée--}}
{{--            @endif--}}
{{--        </p>--}}
{{--    </div>--}}

{{--    <div class="column is-one-third ">--}}
{{--        <p class="has-text-link is-size-5 has-text-centered">Accès à l'eau</p>--}}

{{--        <p class="has-text-centered">--}}
{{--            {{$ad->waterAccess}}--}}
{{--        </p>--}}
{{--    </div>--}}
{{--</div>--}}

{{--<hr class="navbar-divider">--}}


{{--@if($isSupportRequest && $ad->support_request_text)--}}
{{--    <div class="content">--}}
{{--        <h4 class="title is-3">Résumé de votre projet</h4>--}}
{{--        <p>  {!! nl2br($ad->support_request_text ?? "") !!} </p>--}}
{{--    </div>--}}
{{--@endif--}}


{{--@if($ad->landOfferAd->buildings_description || $ad->landOfferAd->houses_description)--}}
{{--    <div class="content">--}}
{{--        <h4 class="title is-3">Descriptions</h4>--}}
{{--        <div class="columns is-multiline is-mobile is-centered">--}}
{{--            @if($ad->landOfferAd->has_buildings)--}}
{{--                <div class=" column is-one-thirds ">--}}
{{--                    <h4 class="title is-5">Bâtiment(s) agricole(s)</h4>--}}
{{--                    @if($ad->landOfferAd->buildings_description)--}}
{{--                        <p class="has-text-black">--}}
{{--                            <span>{{$ad->landOfferAd->buildings_description}}</span>--}}
{{--                        </p>--}}
{{--                    @endif--}}
{{--                </div>--}}
{{--            @endif--}}
{{--            @if($ad->landOfferAd->has_houses)--}}
{{--                <div class=" column is-one-thirds ">--}}
{{--                    <h4 class="title is-5">Habitation(s)</h4>--}}
{{--                    @if($ad->landOfferAd->houses_description)--}}
{{--                        <p class="has-text-black">--}}
{{--                            <span>{{$ad->landOfferAd->houses_description}}</span>--}}
{{--                        </p>--}}
{{--                    @endif--}}
{{--                </div>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endif--}}
{{--@if($ad->landOfferAd->sau_description)--}}
{{--    <div class="content">--}}
{{--        <h4 class="title is-3">Description SAU</h4>--}}
{{--        <p>  {!! nl2br($ad->landOfferAd->sau_description ?? "") !!}</p>--}}
{{--    </div>--}}
{{--@endif--}}
{{--@if($ad->landOfferAd->water_access_description)--}}
{{--    <div class="content">--}}
{{--        <h4 class="title is-3">Description de l'accès à l'eau</h4>--}}
{{--        <p> {!! nl2br($ad->landOfferAd->water_access_description ??"") !!}</p>--}}
{{--    </div>--}}
{{--@endif--}}
{{--@if($ad->landOfferAd->test_description)--}}
{{--    <div class="content">--}}
{{--        <h4 class="title is-3">Description du test agricole</h4>--}}
{{--        <p>  {!! nl2br($ad->landOfferAd->test_description ?? "") !!}</p>--}}
{{--    </div>--}}
{{--@endif--}}

{{--<div class="content">--}}
{{--    <h4 class="title is-3">Description du projet</h4>--}}
{{--    <p>  {!! nl2br($ad->about_project_content ??"") !!}</p>--}}
{{--</div>--}}
{{--@if($ad->about_content)--}}
{{--    <div class="content">--}}
{{--        <h4 class="title is-3">A propos de l'annonceur</h4>--}}
{{--        <p> {!! nl2br($ad->about_content ?? "") !!}</p>--}}
{{--    </div>--}}
{{--@endif--}}





@if($isSupportRequest)
    @include('pages.ads.partials.projectDataKeys')
@endif


<div id="map_ad"></div>

<div class="section">
    @include('pages.ads.partials.threadsDisplay')
</div>
