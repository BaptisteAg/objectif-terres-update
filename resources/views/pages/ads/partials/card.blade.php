<a class="unset-color columns is-flex fd-c-mobile" href="/annonces/{{$ad->id}}">
    <div class="column is-two-fifths">
        <figure class="image is-3by2">
            @if($ad->hasImages && $ad->images[0]?->path)
                <img class="objT-border vignette__image"
                     src="{{app('url')->assetFrom('https://objectif-terres.org', $ad->images[0]->path)}}"
                     alt="{{$ad->images[0]->name}}">
            @else
                <img class="objT-border vignette__image"
                     src="https://images.unsplash.com/photo-1557234195-bd9f290f0e4d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80"
                     alt="placeholder">
                <b-button tag="a" href="" class="mr-2 fav-button is-hidden-desktop" rounded size="is-medium"
                          icon-right="star-outline"></b-button>
            @endif
        </figure>

        {{--        @if($ad->hasImages && $ad->images[0]?->path)
                    <figure class="image is-3by2 objT-border"
                            style="background-image: url({{app('url')->assetFrom('https://objectif-terres.org', str_replace(' ', '%20', $ad->images[0]->path))}});
                       background-repeat: no-repeat;
                       background-position: center;
                       background-size: cover;">
                        <b-button tag="a" href="" class="mr-2 fav-button is-hidden-desktop" rounded size="is-medium"
                                  icon-right="star-outline"></b-button>
                    </figure>
                @else
                    <figure class="image is-3by2 objT-border"
                            style="background: url('https://images.unsplash.com/photo-1557234195-bd9f290f0e4d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80') no-repeat center / cover;">
                        <b-button tag="a" href="" class="mr-2 fav-button is-hidden-desktop" rounded size="is-medium"
                                  icon-right="star-outline"></b-button>
                    </figure>
                @endif--}}
    </div>
    <div class="column is-flex is-flex-direction-column">
        <div class="columns is-mobile mt-2 mb-0 mt-4-mobile mb-3-mobile is-justify-content-space-between">
            <div class="column pl-0-mobile">
                 <span class="tag is-warning has-text-weight-bold is-uppercase">
                     {{ $ad->formatted_type }}
                 </span>
            </div>

            <div class="column pr-0-mobile title is-6 has-text-right" style="color: #A74B2B">
                {{ $ad->formatted_price }}
            </div>
        </div>

        <p class="title is-5">{{ $ad->title }}</p>

        @if(isset($ad->about_project_content))
            <p>{{ Illuminate\Support\Str::limit($ad->about_project_content, 300)}}</p>
        @else
            Pas de description renseignée pour cette annonce
        @endif

        @if(config('app.env') !== 'production')
            <p class="title is-1 has-background-black has-text-white">Type : {{$ad->type}}</p>
        @endif

        <div class="is-flex mt-auto mb-4 is-justify-content-space-between">
            <div class="is-flex is-flex-direction-column fd-r-mobile jc-sb-mobile pt-3-mobile" style="width: 100%">
                <p class="pb-3 pb-0-mobile">
                    @if(!empty($ad->surface))
                        <span class="has-text-weight-bold">< ></span> {{ $ad->surface }} Ha
                    @endif
                </p>
                <p>{{ $ad->formatted_location }}</p>
            </div>
            <div class="mt-auto is-hidden-touch is-flex">
                @if($ad->currentUserFavoriteAd)
                    <b-button tag="a" type="is-warning" rounded icon-left="star-outline" size="is-medium" class="mr-2"
                              href="{{route ('favoriteAds.destroy', $ad->currentUserFavoriteAd->id)}}"
                              style="padding-left: 1em; padding-right: 1em;">
                    </b-button>
                @else
                    {!! Form::open(['route'=>'favoriteAds.create', 'method'=>'get']) !!}
                    <input name="ad_id" value="{{$ad->id}}" type="hidden">
                    <b-button native-type="submit" rounded icon-left="star-outline" size="is-medium" class="mr-2"
                              style="padding-left: 1em; padding-right: 1em;">
                    </b-button>
                    {!! Form::close() !!}
                @endif
                <b-button rounded size="is-medium" tag="a"
                          href="/annonces/{{$ad->id}}">
                    Voir l'annonce
                </b-button>
            </div>
        </div>
    </div>
</a>
