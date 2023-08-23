<div class="column is-one-quarter">
    <figure class="image is-3by2">
        @if($ad->hasImages && $ad->images[0]->path !=="0")
            <img class="objT-border"
                 src="{{app('url')->assetFrom('https://objectif-terres.org', $ad->images[0]->path)}}"
                 alt="{{$ad->images[0]->name}}">
        @else
            <img class="objT-border"
                 src="https://images.unsplash.com/photo-1557234195-bd9f290f0e4d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80"
                 alt="placeholder">
        @endif
    </figure>
    <div class="columns">
        <div class="column">
            @if($ad->landOfferAd && $ad->landOfferAd->offerGenres->count())
                <span class="tag is-warning">
            @foreach($ad->landOfferAd->offerGenres as $offerGenre)
                        {{$offerGenre->id === $offerGenre::ID_VENTE ? 'Vente' : $offerGenre->name}}
                        @if(!$loop->last)
                            ,
                        @endif
                    @endforeach
                </span>
            @endif
        </div>
        <div class="column">
            <img src="{{ asset('images/icons/Certif.png') }}" alt="Description de l'image">
        </div>
        <div class="column">

        </div>
    </div>

</div>