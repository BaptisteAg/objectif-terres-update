<div class="columns is-multiline mb-50">
    @include('pages.ads.partials.show-images')
    <div class="column is-half is-flex-tablet">
        <div class="card is-flex-tablet card-announcement">
            <div class="card-content">
                <div class="content">
                    @if($ad->is_draft)
                        <p><span class="is-size-5  has-text-black ">Annonce soumise le : </span><span
                                    class="subtitle">{{ $ad->created_at}}</span>
                        </p>
                    @else
                        @if(isset($ad->is_partner) && $ad->is_partner === 1 )
                            <p class="custom-tags">
                                <span class="custom-tag warning">Partenaire Terre de Liens</span>
                            </p>
                        @endif
                        <p><span class="is-size-5  has-text-black ">Publié le : </span><span
                                    class="subtitle">{{ $ad->published_on}}</span>
                        </p>
                    @endif
                </div>
                <div class="content">
                    <p><span class="is-size-5   ">Publié par : </span>
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
                <div class="content">
                    <p>
                        <span class="is-size-5 is-capitalized ad-show-feature-label">Surface recherchée (en ha)</span>
                        :
                        <span class="subtitle">{{ $ad->human_ha }}</span>
                    </p>
                </div>

                <div class="content">
                    @if( !empty($ad->landSeekAd->buildings) )
                        <p><span class="is-size-5 is-capitalized ad-show-feature-label">Habitation(s) et bâti(s)
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

                @if($ad->userPp->accept_share_contact_infos === 1)
                    <div class="content">
                        <p>
                            <span class="is-size-5 ad-show-feature-label">N° de téléphone du porteur de projet : </span>
                        </p>
                        <p><span class="subtitle">{{$ad->userPp->phone}}</span></p>
                    </div>
                @endif

                @include('pages.ads.partials.show-documents')
            </div>
            @include('pages.ads.partials.buttons-favorite-and-message')
        </div>
    </div>
</div>
@include('pages.ads.partials.adMessageModal')

<hr class="navbar-divider">
<h3 class="title is-3 has-text-centered">Caractéristiques du projet</h3>
<div class="columns is-multiline is-mobile is-centered">

    <div class="column is-one-quarter ">
        <p class="has-text-link is-size-5 has-text-centered"> Installation souhaité</p>
        <p class="has-text-centered">
            @if ($ad->landSeekAd->installationType->name === "Seul·e")
                Individuelle
            @else
                {{ $ad->landSeekAd->installationType->name }}
            @endif
        </p>
    </div>

    <div class="column is-one-quarter ">
        <p class="has-text-link is-size-5 has-text-centered"> Production(s) envisagée(s)</p>
        {{--                <p class="has-text-centered">{{$ad->landSeekAd->productionGenresPossible->pluck('name')->implode(', ') }}</p>--}}
        <ul class="has-text-centered">
            @foreach($ad->landSeekAd->productionGenresPossible as $productionGenre)
                <li>{{$productionGenre->name}}</li>
            @endforeach
        </ul>
    </div>

    <div class="column is-one-quarter ">
        <p class="has-text-link is-size-5 has-text-centered"> Souhaite s'installer en bio</p>

        @if ($ad->landSeekAd->is_bio === 1)
            <p class="has-text-centered">Oui</p>
        @elseif ($ad->landSeekAd->is_bio === 0)
            <p class="has-text-centered">Non</p>
        @else
            <p class="has-text-centered">Ne sais pas</p>
        @endif
    </div>

    {{--
    @if($ad->landSeekAd->offerGenre)
        <div class="column is-one-quarter ">
            <p class="has-text-link is-size-5 has-text-centered"> Accès au foncier souhaité </p>
            <p class="has-text-centered">{{$ad->landSeekAd->offerGenre->name}}</p>
        </div>
    @endif

    <div class="column is-one-quarter ">
        <p class="has-text-link is-size-5 has-text-centered"> Surface(s) recherchée(s)(en ha)</p>
        @foreach ($ad->landSeekAd->surfaceRanges as $surfaceRangeSeek)
            @if($surfaceRangeSeek->surface !== '')
                <p class="has-text-centered">{{$ad->landSeekAd->surfaceRanges->pluck('surface')->implode(', ') }}</p>
            @else
                <p class="has-text-centered">Non renseigné</p>
            @endif
        @endforeach
    </div>--}}

    {{--    @if($ad->landSeekAd->productionGenres->count())--}}
    {{--        <div class="column is-one-quarter ">--}}
    {{--            <p class="has-text-link is-size-5 has-text-centered"> Production(s) actuelle(s)</p>--}}
    {{--            @foreach ($ad->landSeekAd->productionGenres as $productionGenresSeek)--}}
    {{--                @if($productionGenresSeek->name !== '')--}}
    {{--                    <p class="has-text-centered">{{$productionGenresSeek->name}}</p>--}}
    {{--                @else--}}
    {{--                    <p class="has-text-centered">-</p>--}}
    {{--                @endif--}}
    {{--            @endforeach--}}
    {{--        </div>--}}
    {{--    @endif--}}


</div>

<hr class="navbar-divider">
<div class="content">
    <h3 class="title is-3">Description du terrain recherché</h3>
    <p>  {!! nl2br($ad->landSeekAd->land_description ?? "") !!} </p>
</div>
<div class="content">
    <h3 class="title is-3">Description du projet</h3>
    <p>  {!! nl2br($ad->about_project_content ?? "") !!} </p>
</div>
<div class="content">
    <h3 class="title is-3">A propos du porteur de projet</h3>
    <p>  {!! nl2br($ad->about_content ?? "") !!}</p>
</div>

@if($ad->landSeekAd->experience_farming)
    <div class="content">
        <h3 class="title is-3">Expérience du porteur de projet dans le domaine agricole</h3>
        <p> {!! nl2br($ad->landSeekAd->experience_farming ?? "") !!}</p>
    </div>
@endif

<div id="map_ad"></div>

<div class="section">
    @include('pages.ads.partials.threadsDisplay')
</div>


