<div class="columns">
    @include('pages.ads.partials.show-images')
    <div class="column is-half is-flex-tablet">
        <div class="card is-flex-tablet card-announcement">
            <div class="card-content">
                @foreach($ad->landOfferAd->offerGenres as $offerGenre)
                    <span class="custom-tag info">{{$offerGenre->name}}</span>
                @endforeach
                <div class="content">
                    @if($ad->is_draft)
                        <p><span class="is-size-5  has-text-black ">Annonce soumise le : </span><span
                                    class="subtitle">{{ $ad->created_at}}</span>
                        </p>
                    @else
                        @if(isset($ad->is_partner) && $ad->is_partner === 1 )
                            <p class="custom-tags">
                                <span class="custom-tag warning">Annonce certifiée </span>
                            </p>
                        @endif
                        <p><span class="is-size-5  has-text-black ">Publié le : </span><span
                                    class="subtitle">{{ $ad->published_on}}</span>
                        </p>
                    @endif
                </div>
                <div class="content">
                    <p><span class="is-size-5 has-text-black">Publié par : </span>
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
                            <p><span class="is-size-5 is-capitalized has-text-black">Code postal : </span><span
                                        class="subtitle">{{$ad->cities[0]->zip_code }} ({{$ad->cities[0]->name }}
                                    )</span>
                            </p>
                        </div>
                    @else
                        <div class="content">
                            @if( auth()->user()->id === $ad->user_pp_id)
                                <p><span class="is-size-5 has-text-black">Code Postal (non visible pour les autres
                                        utilisateurs): </span><span
                                            class="subtitle">{{$ad->cities[0]->zip_code }} ({{$ad->cities[0]->name }}
                                        )</span>
                                </p>
                            @endif
                            <p><span class="is-size-5 is-capitalized has-text-black">Département : </span><span
                                        class="subtitle">{{$ad->cities[0]->department->code }}
                                    ({{$ad->cities[0]->department->name }})</span>
                            </p>
                        </div>
                    @endif
                @elseif($ad->departments->count())
                    <div class="content">
                        <p><span class="is-size-5 is-capitalized has-text-black">Département : </span><span
                                    class="subtitle">{{$ad->departments[0]->code }} ({{$ad->departments[0]->name }}
                                )</span>
                        </p>
                    </div>
                @endif

                @if(! is_null($ad->landOfferAd->surface))
                    <div class="content">
                        <p><span class="is-size-5 is-capitalized has-text-black">Surface : </span><span
                                    class="subtitle">{{$ad->landOfferAd->surface}} hectares</span></p>
                    </div>
                @endif
                <div class="content">
                    @if ($ad->landOfferAd->offerGenres->count() >=1)
                        <p>
                            <span class="is-size-5  has-text-black">Mode de cession : </span>
                            <span class="subtitle">
                                {{$ad->landOfferAd->offerGenres->pluck('name')->implode(', ') }}
                            </span>
                        </p>
                    @endif
                    @if($ad->landOfferAd->price)
                        <p><span class="is-size-5  has-text-black">Prix : </span>
                            <span class="subtitle ">{{ number_format($ad->landOfferAd->price, 0, ",", " " )}} €</span>
                        </p>
                    @endif
                    @if($ad->landOfferAd->rent_price)
                        <p>
                            <span class="is-size-5  has-text-black">Loyer mensuel : </span>
                            <span class="subtitle ">{{number_format($ad->landOfferAd->rent_price, 0, ",", " " )}}
                                €</span>
                        </p>
                    @endif
                </div>
                @if($ad->is_activity_transfer)
                    <div class="content">
                        <p>
                            <span class="is-size-5  has-text-black">Transfert d'activité : </span>
                            <span class="subtitle"> {{ $ad->is_activity_transfer ? "Oui" : "Non" }} </span>
                        </p>
                    </div>
                @endif
                {{--				<div class="content">--}}
                {{--					<p><span class="is-size-5 is-capitalized has-text-black">Altitude : </span>--}}
                {{--						@if($ad->landOfferAd->altitude)--}}
                {{--							<span class="subtitle">{{$ad->landOfferAd->altitude }}m</span>--}}
                {{--						@else--}}
                {{--							<span class="subtitle">Non renseignée</span>--}}
                {{--						@endif--}}
                {{--					</p>--}}
                {{--				</div>--}}
                {{--				@if($ad->landOfferAd )--}}
                {{--					<div class="content">--}}
                {{--						<p>--}}
                {{--							<span class="is-size-5 is-capitalized has-text-black">Accès à l'eau : </span><span--}}
                {{--									class="subtitle">{{$ad->waterAccess}}</span>--}}
                {{--						</p>--}}
                {{--					</div>--}}
                {{--				@endif--}}

                @if($ad->userPp->accept_share_contact_infos === 1)
                    <div class="content">
                        <p>
                            <span class="is-size-5 has-text-black">N° de téléphone du porteur de projet : </span>
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

    @if($ad->landOfferAd->productionGenres->count())
        <div class="column is-one-third ">
            <p class="has-text-link is-size-5 has-text-centered">Système de production en place</p>
            <p class="has-text-centered">
                <span>{{$ad->landOfferAd->productionGenres->pluck('name')->implode(', ') }}</span>
            </p>
        </div>
    @endif

    @if($ad->landOfferAd->productionGenresPossible->count())
        <div class="column is-one-third ">
            <p class="has-text-link is-size-5 has-text-centered">Productions possibles</p>
            <p class="has-text-centered">
                <span>{{$ad->landOfferAd->productionGenresPossible->pluck('name')->implode(', ') }}</span>
            </p>
        </div>
    @endif

    <div class="column is-one-third ">
        <p class="has-text-link is-size-5 has-text-centered"> Certification des terres</p>

        <p class="has-text-centered">
            @foreach($ad->landOfferAd->bioCertifications as $bioCertification)
                @if($bioCertification->icon == "")
                    <span>{{$bioCertification->name }}</span>
                @endif
                <img src="{{ $bioCertification->icon }}">
            @endforeach
        </p>
    </div>

    <div class="column is-one-third ">
        <p class="has-text-link is-size-5 has-text-centered">Altitude</p>

        <p class="has-text-centered">
            @if($ad->landOfferAd->altitude)
                {{$ad->landOfferAd->altitude }}m
            @else
                Non renseignée
            @endif
        </p>
    </div>

    <div class="column is-one-third ">
        <p class="has-text-link is-size-5 has-text-centered">Accès à l'eau</p>

        <p class="has-text-centered">
            {{$ad->waterAccess}}
        </p>
    </div>
</div>

<hr class="navbar-divider">

@if($isSupportRequest && $ad->support_request_text)
    <div class="content">
        <h3 class="title is-3">Résumé de votre projet</h3>
        <p>  {!! nl2br($ad->support_request_text ?? "") !!} </p>
    </div>
@endif


@if($ad->landOfferAd->buildings_description || $ad->landOfferAd->houses_description)
    <div class="content">
        <h3 class="title is-3">Descriptions</h3>
        <div class="columns is-multiline is-mobile is-centered">
            @if($ad->landOfferAd->has_buildings)
                <div class=" column is-one-thirds ">
                    <h3 class="title is-5">Bâtiment(s) agricole(s)</h3>
                    @if($ad->landOfferAd->buildings_description)
                        <p class="has-text-black">
                            <span>{{$ad->landOfferAd->buildings_description}}</span>
                        </p>
                    @endif
                </div>
            @endif
            @if($ad->landOfferAd->has_houses)
                <div class=" column is-one-thirds ">
                    <h3 class="title is-5">Habitation(s)</h3>
                    @if($ad->landOfferAd->houses_description)
                        <p class="has-text-black">
                            <span>{{$ad->landOfferAd->houses_description}}</span>
                        </p>
                    @endif
                </div>
            @endif
        </div>
    </div>
@endif
@if($ad->landOfferAd->sau_description)
    <div class="content">
        <h3 class="title is-3">Description SAU</h3>
        <p>  {!! nl2br($ad->landOfferAd->sau_description ?? "") !!}</p>
    </div>
@endif
@if($ad->landOfferAd->water_access_description)
    <div class="content">
        <h3 class="title is-3">Description de l'accès à l'eau</h3>
        <p> {!! nl2br($ad->landOfferAd->water_access_description ??"") !!}</p>
    </div>
@endif
@if($ad->landOfferAd->test_description)
    <div class="content">
        <h3 class="title is-3">Description du test agricole</h3>
        <p>  {!! nl2br($ad->landOfferAd->test_description ?? "") !!}</p>
    </div>
@endif

<div class="content">
    <h3 class="title is-3">Description du projet</h3>
    <p>  {!! nl2br($ad->about_project_content ??"") !!}</p>
</div>
@if($ad->about_content)
    <div class="content">
        <h3 class="title is-3">A propos de l'annonceur</h3>
        <p> {!! nl2br($ad->about_content ?? "") !!}</p>
    </div>
@endif


@if($isSupportRequest)
    @include('pages.ads.partials.projectDataKeys')
@endif


<div id="map_ad"></div>

<div class="section">
    @include('pages.ads.partials.threadsDisplay')
</div>
