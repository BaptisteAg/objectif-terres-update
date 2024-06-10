<?php /** @var \App\Models\LandSeekAd|\App\Models\LandOfferAd|\App\Models\AssociateOfferAd $subAd */ ?>

<div>
    <h3 class="title is-4">{{ $mainProductionLabel }}</h3>
    <b-taglist>
        @if($subAd->productionGenres->count() || $subAd->production_type_add)
            @foreach($subAd->productionGenres->pluck('name') as $productionGenre)
                <b-tag type="is-primary" rounded size="is-medium">
                    {{$productionGenre}}
                </b-tag>
            @endforeach
            @if($subAd->production_type_add)
                <b-tag type="is-primary" rounded size="is-medium">
                    {{ ucfirst($subAd->production_type_add) }}
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
    <h3 class="title is-4">{{ $secondaryProductionLabel }}</h3>
    <b-taglist>
        @if($subAd->productionGenresSecondary->count())
            @foreach($subAd->productionGenresSecondary->pluck('name') as $secondaryProductionGenre)
                <b-tag type="is-primary" rounded size="is-medium">
                    {{$secondaryProductionGenre}}
                </b-tag>
            @endforeach
        @else
            <b-tag type="is-primary" rounded size="is-medium">
                Non renseigné
            </b-tag>
        @endif
    </b-taglist>
</div>
