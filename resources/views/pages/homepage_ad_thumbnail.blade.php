<div class="column is-one-quarter-desktop is-half-tablet  tile tile_image">
    <a href="{{route("ads.show", $ad->id)}}" class="tile__link card">
        <div class="card-image vignette photo">
            <figure class="image vignette__image-wrap vignette__ratio_4-3 is-square">
                @if($ad->hasImages)
                    @if($ad->images[0]->path !=="0")
                        <img src="{{app('url')->assetFrom('https://objectif-terres.org', $ad->images[0]->path)}}"
                             class=" vignette__image" alt="{{$ad->images[0]->name}}">
                    @endif
                @endif
            </figure>
            <ul class="custom-tags custom-list custom-list_v">
                @if(isset($ad->is_partner) && $ad->is_partner === 1 )
                    <li class="custom-tag warning">Annonce certifiée</li>
                @endif
                <li class="custom-tag success">
                    <i class="fas fa-map-marker-alt"></i>
                    @if (is_null($ad->citiesList) and is_null($ad->departmentsList) and is_null($ad->regionsList) )
                        Non renseignée
                    @else
                        {{$ad->shortLocationsList ?? ""}}
                    @endif
                </li>
                @if($ad->landSeekAd || $ad->landOfferAd)
                    <li class="custom-tag danger">
                        <i class="fas fa-arrows-alt-h"></i>
                        @if(!empty($ad->human_ha))
                            {{$ad->human_ha}}
                        @endif
                    </li>
                @endif
            </ul>
            <ul class="custom-tags custom-list custom-list_v custom-tags-right">
                @if($ad->landOfferAd && $ad->landOfferAd->offerGenres->count())
                    <li class="custom-tag info">
                        @foreach($ad->landOfferAd->offerGenres as $offerGenre)
                            {{$offerGenre->id === $offerGenre::ID_VENTE ? 'Vente' : $offerGenre->name}}
                            @if(!$loop->last)
                                ,
                            @endif
                        @endforeach
                    </li>
                @endif
                @if($ad->landOfferAd)
                    <li class="custom-tag warning">
                        <i class="fas fa-piggy-bank"></i>
                        @if($ad->landOfferAd->price || $ad->landOfferAd->rent_price)
                            @if($ad->landOfferAd->price)
                                {{number_format($ad->landOfferAd->price, 0, ",", " " )}} €
                            @endif
                            @if($ad->landOfferAd->price && $ad->landOfferAd->rent_price)
                                ou
                            @endif
                            @if($ad->landOfferAd->rent_price)
                                {{number_format($ad->landOfferAd->rent_price, 0, ",", " " )}} € / an
                            @endif
                        @else
                            Prix non renseigné
                        @endif
                    </li>
                @endif
                @if($ad->landSeekAd)
                    @if($ad->isSupportRequest)
                        <li class="custom-tag warning">
                            <i class="fas fa-piggy-bank"></i>
                            @if($ad->landSeekAd->price_max)
                                @if($ad->landSeekAd->price_max > 300000)
                                    Plus de 300 000 €
                                @else
                                    Jusqu'à {{number_format($ad->landSeekAd->price_max, 2, ',', ' ')}}
                                    €
                                @endif
                            @elseif(isset($ad->landSeekAd->rent_max))
                                Jusqu'à {{number_format($ad->landSeekAd->rent_max, 2, ',', ' ')}}
                                €/an
                            @else
                                Budget non renseigné
                            @endif
                        </li>
                    @endif
                @endif
            </ul>
        </div>
        <div class="card-content has-text-centered tile__container">
            <div class="content text_danger_orange tile__content">
                <p class="title tile__title">{{ \Illuminate\Support\Str::limit($ad->title, 100, $end='...') }}</p>
                <div class="tile__intro">
                    <p>{{ \Illuminate\Support\Str::limit($ad->about_project_content, 100, $end='...') }}</p>
                </div>
                <p class="button-wrap">
                    <span class="button round small warning read-more">
                        <span class="button__icon">
                            <i class="fas fa-arrow-right" aria-hidden="true"></i>
                        </span>
                    </span>
                </p>
            </div>
        </div>
    </a>
</div>