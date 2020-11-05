<div class="columns is-multiline mb-50">
    @include('pages.ads.partials.show-images')
    <div class="column is-half is-flex-tablet">
        <div class="card is-flex-tablet card-announcement">
            <div class="card-content">
                <div class="content">
                    @if($ad->is_draft)
                        <p><span class="is-size-5">Annonce soumise le : </span><span
                                    class="subtitle">{{ $ad->created_at}}</span>
                        </p>
                    @else
                        @if(isset($ad->is_partner) && $ad->is_partner === 1 )
                            <p class="custom-tags">
                                <span class="custom-tag warning">Annonce certifiée </span>
                            </p>
                        @endif
                        <p><span class="is-size-5">Publié le : </span><span
                                    class="subtitle">{{ $ad->published_on}}</span>
                        </p>
                    @endif
                </div>
                <div class="content">
                    <p><span class="is-size-5">Publié par : </span>
                        @auth()
                            @if(auth()->user()->role >= 1 )
                                <span class="subtitle">
                                    <a href="{{route('user.show', $ad->userPp->id)}}">{{ $ad->pp_display_name }}</a>
                                </span>
                            @elseif(auth()->user()->role < 1)
                                <span class="subtitle">
                                    {{ $ad->pp_display_name}}
                                </span>
                            @endif
                        @endauth
                        @guest()
                            <span class="subtitle">
                                {{ $ad->pp_display_name}}
                            </span>
                        @endguest()
                    </p>
                </div>
                <div class="content">
                    <p>
                        <span class="is-size-5 is-capitalized ad-show-feature-label">Surface recherchée</span>
                        :
                        <span class="subtitle">{{ empty($ad->human_ha) ? 'Non renseigné' :$ad->human_ha }}</span>
                    </p>
                </div>

                <div class="content">
                    @if( $ad->landSeekAd->buildings->count() >0 )
                        <p><span class="is-size-5 ad-show-feature-label">Habitation(s) et bâti(s)
                                recherché(s) : </span><br>
                            @foreach($ad->landSeekAd->buildings as $building)
                                @if($building->requirement->label !== "Indifférent")
                                    <span class="subtitle">{{ $building->buildingType->label }}</span> <i
                                            class="fas fa-arrow-right"></i><span
                                            class="subtitle"> {{ $building->requirement->label }}</span><br>
                                @endif
                            @endforeach
                        </p>
                    @endif
                </div>

                @auth
                    @if(auth()->user()->role >=2)
                        @if(isset($ad->support_request_territory_id))
                            <div class="content">
                                <p>
                                    <span class="is-size-5 is-capitalized ad-show-feature-label">Territoire </span>
                                    :
                                    <span class="subtitle">{{$ad->supportRequestTerritoryId->name}}</span>
                                </p>
                            </div>
                        @endif
                    @endif
                @endauth

                <div class="content">
                    @if(count($ad->cities))
                        <p>
                            <span class="is-size-5 ad-show-feature-label">
                                Commune(s)
                                @if($ad->locationable_radius)
                                    (dans un rayon de {{$ad->locationable_radius}}km)
                                @endif
                                :
                            </span>
                            @foreach($ad->zipCodesByCity as $city => $zipCodes)
                                <span class="subtitle">{{$city}} ({{ $zipCodes->implode(', ') }})@if(!$loop->last)
                                        , @endif</span>
                            @endforeach
                        </p>
                    @endif

                    @if(count($ad->departments))
                        <p>
                            <span class="is-size-5 is-capitalized ad-show-feature-label">Département(s) : </span>
                            <span class="subtitle"> {{ $ad->departmentsList() }}</span>
                        </p>
                    @endif

                    @if(count($ad->regions))
                        <p>
                            <span class="is-size-5 is-capitalized ad-show-feature-label">Région(s) : </span>
                            <span class="subtitle">{{$ad->regionsList() }}</span>
                        </p>
                    @endif
                </div>

                @if($ad->accept_share_contact_infos === 1)
                    <div class="content">
                        <p>
                            <span class="is-size-5 ad-show-feature-label">N° de téléphone : </span>
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
        <div class="">
            @if(isset($ad->landSeekAd->installationType))
                @if($ad->landSeekAd->installationType->name !== "Indifférent")
                    <div class="mb-20 ">
                        <p class="has-text-link is-size-5 "> Installation souhaitée</p>
                        <p class="">
                            @if ($ad->landSeekAd->installationType->name === "Seul·e")
                                Individuelle
                            @else
                                {{ $ad->landSeekAd->installationType->name }}
                            @endif
                        </p>
                    </div>
                @endif
            @endif
            @if($ad->landSeekAd->productionGenres->count() || $ad->landSeekAd->production_type_add)
                <div class="mb-20 ">
                    <p class="has-text-link is-size-5 "> Production(s) envisagée(s)</p>
                    <ul class="">
                        @foreach($ad->landSeekAd->productionGenres as $id => $productionGenre)
                            @if($id !== "other")
                                @if(!$loop->last)
                                    {{$productionGenre->name}} ,
                                @else
                                    {{$productionGenre->name}}
                                @endif
                            @endif
                        @endforeach
                        @if($ad->landSeekAd->production_type_add)
                            @if($ad->landSeekAd->productionGenres->count())
                                ,
                            @endif
                            {{ ucfirst($ad->landSeekAd->production_type_add) }}
                        @endif
                    </ul>
                </div>
            @endif
            @if($ad->landSeekAd->productionGenresPossible->count() >0)
                <div class="mb-20">
                    <p class="has-text-link is-size-5 "> Production(s) possible(s)</p>
                    <ul class="">
                        @foreach($ad->landSeekAd->productionGenresPossible as $productionGenre)
                            <li>{{$productionGenre->name}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-20">
                <p class="has-text-link is-size-5 "> Souhaite s'installer en bio</p>
                @if ($ad->landSeekAd->is_bio === 1)
                    <p class="">Oui</p>
                @elseif ($ad->landSeekAd->is_bio === 0)
                    <p class="">Non</p>
                @elseif($ad->landSeekAd->is_bio === -1)
                    <p class="">Ne sais pas</p>
                @else
                    <p class="">Non précisé</p>
                @endif
            </div>

            @if($ad->landSeekAd->offerGenres->count())
                @foreach ($ad->landSeekAd->offerGenres as $offerGenre)
                    <div class="mb-20">
                        <p class="has-text-link is-size-5 ">Accès au foncier souhaité </p>
                        <p class="">
                            {{$offerGenre->id === $offerGenre::ID_VENTE ? 'Vente' : $offerGenre->name}}

                            @if($isSupportRequest && $offerGenre->id === $offerGenre::ID_VENTE && $ad->landSeekAd->price_max)
                                <br>Budget maximum : {{ $ad->landSeekAd->price_max }} €
                            @endif
                        </p>
                    </div>
                @endforeach
            @endif

            @if($isSupportRequest)
                <div class="mb-20">
                    <p class="has-text-link is-size-5 "> Niveau de formation agricole</p>
                    @if($ad->landSeekAd->educationLevels->count() >0)
                        <p>
                        @foreach($ad->landSeekAd->educationLevels as $educationLevel)
                            @if($loop->last)
                                <span class="">{{$educationLevel->name}}</span>
                            @else
                                <span class="">{{$educationLevel->name}}, </span>
                            @endif
                        @endforeach
                        </p>
                    @else
                        <p class="">Non renseignée</p>
                    @endif
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
            <h4 class="title is-3">Description du terrain recherché</h4>
            <p>  {!! nl2br($ad->landSeekAd->land_description ?? "Non précisée") !!} </p>
        </div>
        <div class="content">
            <h4 class="title is-3">Description du projet</h4>
            <p>  {!! nl2br($ad->about_project_content ?? "") !!} </p>
        </div>
        @if($ad->landSeekAd->experience_farming)
            <div class="content">
                <h4 class="title is-3">Expérience du porteur de projet dans le domaine agricole</h4>
                <p> {!! nl2br($ad->landSeekAd->experience_farming ?? "") !!}</p>
            </div>
        @endif
        @if($ad->about_content)
            <div class="content">
                <h4 class="title is-3">A propos du porteur de projet</h4>
                <p>  {!! nl2br($ad->about_content ?? "") !!}</p>
            </div>
        @endif


    </div>
</div>

{{--<hr class="navbar-divider">--}}
{{--<h4 class="title is-3 has-text-centered">Description générale du bien</h4>--}}
{{--<div class="columns is-multiline is-mobile is-centered">--}}

{{--    @if(isset($ad->landSeekAd->installationType))--}}
{{--        @if($ad->landSeekAd->installationType->name !== "Indifférent")--}}
{{--            <div class="column is-one-quarter ">--}}
{{--                <p class="has-text-link is-size-5 has-text-centered"> Installation souhaitée</p>--}}
{{--                <p class="has-text-centered">--}}
{{--                    @if ($ad->landSeekAd->installationType->name === "Seul·e")--}}
{{--                        Individuelle--}}
{{--                    @else--}}
{{--                        {{ $ad->landSeekAd->installationType->name }}--}}
{{--                    @endif--}}
{{--                </p>--}}
{{--            </div>--}}
{{--        @endif--}}
{{--    @endif--}}

{{--    <div class="column is-one-quarter ">--}}
{{--        <p class="has-text-link is-size-5 has-text-centered"> Production(s) envisagée(s)</p>--}}
{{--        --}}{{--                <p class="has-text-centered">{{$ad->landSeekAd->productionGenresPossible->pluck('name')->implode(', ') }}</p>--}}
{{--        <ul class="has-text-centered">--}}
{{--            @foreach($ad->landSeekAd->productionGenres as $id => $productionGenre)--}}
{{--                @if($id !== "other")--}}
{{--                    <li>{{$productionGenre->name}}</li>--}}
{{--                @endif--}}
{{--            @endforeach--}}
{{--            @if($ad->landSeekAd->production_type_add)--}}
{{--                {{ $ad->landSeekAd->production_type_add }}--}}
{{--            @endif--}}
{{--        </ul>--}}
{{--    </div>--}}

{{--    @if($ad->landSeekAd->productionGenresPossible->count() >0)--}}
{{--        <div class="column is-one-quarter ">--}}
{{--            <p class="has-text-link is-size-5 has-text-centered"> Production(s) envisagée(s)</p>--}}
{{--            <ul class="has-text-centered">--}}
{{--                @foreach($ad->landSeekAd->productionGenresPossible as $productionGenre)--}}
{{--                    <li>{{$productionGenre->name}}</li>--}}
{{--                @endforeach--}}
{{--            </ul>--}}
{{--        </div>--}}
{{--    @endif--}}

{{--    <div class="column is-one-quarter ">--}}
{{--        <p class="has-text-link is-size-5 has-text-centered"> Souhaite s'installer en bio</p>--}}

{{--        @if ($ad->landSeekAd->is_bio === 1)--}}
{{--            <p class="has-text-centered">Oui</p>--}}
{{--        @elseif ($ad->landSeekAd->is_bio === 0)--}}
{{--            <p class="has-text-centered">Non</p>--}}
{{--        @else--}}
{{--            <p class="has-text-centered">Ne sais pas</p>--}}
{{--        @endif--}}
{{--    </div>--}}


{{--    @if($ad->landSeekAd->offerGenres->count())--}}
{{--        @foreach ($ad->landSeekAd->offerGenres as $offerGenre)--}}
{{--            <div class="column is-one-quarter ">--}}
{{--                <p class="has-text-link is-size-5 has-text-centered"> Accès au foncier souhaité </p>--}}
{{--                <p class="has-text-centered">--}}
{{--                    {{$offerGenre->name}}--}}
{{--                    @if($offerGenre->id === $offerGenre::ID_VENTE)--}}
{{--                        <br>Budget maximum : {{ $ad->landSeekAd->price_max }} €--}}
{{--                    @endif--}}
{{--                </p>--}}
{{--            </div>--}}
{{--        @endforeach--}}
{{--    @endif--}}

{{--    <div class="column is-one-quarter ">--}}
{{--        <p class="has-text-link is-size-5 has-text-centered"> Surface(s) recherchée(s)(en hectares)</p>--}}
{{--        <p class="has-text-centered">De {{ $ad->landSeekAd->surface_range_min }}ha--}}
{{--            à {{ $ad->landSeekAd->surface_range_max }}ha</p>--}}
{{--    </div>--}}

{{--    --}}{{--    @if($ad->landSeekAd->productionGenres->count())--}}
{{--    --}}{{--        <div class="column is-one-quarter ">--}}
{{--    --}}{{--            <p class="has-text-link is-size-5 has-text-centered"> Production(s) actuelle(s)</p>--}}
{{--    --}}{{--            @foreach ($ad->landSeekAd->productionGenres as $productionGenresSeek)--}}
{{--    --}}{{--                @if($productionGenresSeek->name !== '')--}}
{{--    --}}{{--                    <p class="has-text-centered">{{$productionGenresSeek->name}}</p>--}}
{{--    --}}{{--                @else--}}
{{--    --}}{{--                    <p class="has-text-centered">-</p>--}}
{{--    --}}{{--                @endif--}}
{{--    --}}{{--            @endforeach--}}
{{--    --}}{{--        </div>--}}
{{--    --}}{{--    @endif--}}


{{--</div>--}}

{{--<hr class="navbar-divider">--}}
{{--@if($isSupportRequest && $ad->support_request_text)--}}
{{--    <div class="content">--}}
{{--        <h4 class="title is-3">Résumé de votre projet</h4>--}}
{{--        <p>  {!! nl2br($ad->support_request_text ?? "") !!} </p>--}}
{{--    </div>--}}
{{--@endif--}}
{{--@if($ad->landSeekAd->land_description)--}}
{{--    <div class="content">--}}
{{--        <h4 class="title is-3">Description du terrain recherché</h4>--}}
{{--        <p>  {!! nl2br($ad->landSeekAd->land_description ?? "") !!} </p>--}}
{{--    </div>--}}
{{--@endif--}}
{{--<div class="content">--}}
{{--    <h4 class="title is-3">Description du projet</h4>--}}
{{--    <p>  {!! nl2br($ad->about_project_content ?? "") !!} </p>--}}
{{--</div>--}}
{{--@if($ad->about_content)--}}
{{--    <div class="content">--}}
{{--        <h4 class="title is-3">A propos du porteur de projet</h4>--}}
{{--        <p>  {!! nl2br($ad->about_content ?? "") !!}</p>--}}
{{--    </div>--}}
{{--@endif--}}

{{--@if($ad->landSeekAd->experience_farming)--}}
{{--    <div class="content">--}}
{{--        <h4 class="title is-3">Expérience du porteur de projet dans le domaine agricole</h4>--}}
{{--        <p> {!! nl2br($ad->landSeekAd->experience_farming ?? "") !!}</p>--}}
{{--    </div>--}}
{{--@endif--}}
@if($isSupportRequest)
    @include('pages.ads.partials.projectDataKeys')
@endif

<div id="map_ad"></div>

<div class="section">
    @include('pages.ads.partials.threadsDisplay')
</div>


