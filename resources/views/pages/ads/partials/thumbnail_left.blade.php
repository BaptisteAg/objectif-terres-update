<div class="vignette__image-wrap is-flex">
    @if($ad->hasImages)
        @if($ad->images[0]->path ==="0")
            {{--
            @if($ad->ad_type == "landSeek" or $ad->ad_type == "landOffer")
                <img src="{{URL::asset('images/new-placeholder-ad.png')}}"
                     class="vignette__image" alt="image generic ferme"/>
            @else
                <img src="{{URL::asset("images/illustrations/photo_08_bandeau-maous_1920.jpg")}}"
                     class=" vignette__image" alt="image generic emploi ferme"/>
            @endif
            --}}

            <img src="{{URL::asset("images/illustrations/photo_08_bandeau-maous_1920.jpg")}}"
                 class=" vignette__image" alt="image generic emploi ferme"/>
        @else
            <img src="{{app('url')->assetFrom('https://objectif-terres.org', $ad->images[0]->path)}}"
                 class=" vignette__image" alt="{{$ad->images[0]->name}}">
        @endif
    @else
        <img src="{{URL::asset("images/job-offer-placeholder-ad.png")}}"
             class=" vignette__image" alt="image générique emploi ferme"/>
        {{--
        @if($ad->ad_type == "landSeek" or $ad->ad_type == "landOffer")
            <img src="{{URL::asset('images/new-placeholder-ad.png')}}"
                 class="vignette__image" alt="image générique foncier ferme"/>
        @else
            <img src="{{URL::asset("images/job-offer-placeholder-ad.png")}}"
                 class=" vignette__image" alt="image générique emploi ferme"/>
        @endif
        --}}
    @endif
</div>
<ul class="custom-tags custom-list custom-list_v x-large">
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
    @if(isset($ad->is_partner) && $ad->is_partner === 1 )
        <li class="custom-tag warning">Annonce certifiée</li>
    @endif
    <li class="custom-tag success">
        <i class="fas fa-map-marker-alt"></i>
        @if (is_null($ad->citiesList) and is_null($ad->departmentsList) and is_null($ad->regionsList))
            Non renseignée
        @elseif ($ad->landOfferAd && !$ad->landOfferAd->accept_use_zip_code)
            @if( !is_null($ad->citiesList) )
                {{ $ad->cities[0]->department->name }}
            @elseif( !is_null($ad->departmentsList))
                {{ $ad->departmentsList ?? ""}}
            @endif
        @else
            {{ $ad->citiesList ?? "" }}
            {{ $ad->departmentsList ?? "" }}
            {{ $ad->regionsList ?? "" }}
        @endif
    </li>
    @if($ad->landOfferAd)
        <li class="custom-tag warning">
            <i class="fas fa-piggy-bank"></i>
            @if($ad->landOfferAd->price || $ad->landOfferAd->rent_price)
                @if($ad->landOfferAd->price)
                    {{number_format($ad->landOfferAd->price, 0, ",", " " )}} €
                @endif
                @if($ad->landOfferAd->rent_price)
                    {{number_format($ad->landOfferAd->rent_price, 0, ",", " " )}} €/an
                @endif
            @else
                Prix non renseigné
            @endif
        </li>
        <li class="custom-tag danger">
            <i class="fas fa-arrows-alt-h"></i>
            @if(!empty($ad->human_ha))
                {{$ad->human_ha}}
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
        <li class="custom-tag danger">
            <i class="fas fa-arrows-alt-h"></i>
            @if($ad->human_ha)
                {{$ad->human_ha}}
            @endif
        </li>
    @endif
</ul>
