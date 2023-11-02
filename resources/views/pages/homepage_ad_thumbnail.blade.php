<a class="column is-flex is-flex-direction-column" href="/annonces/{{$ad->id}}">
    <figure class="image is-3by2">
        @if($ad->hasImages && $ad->images[0]?->path)
            <img class="objT-border vignette__image"
                 src="{{app('url')->assetFrom('https://objectif-terres.org', $ad->images[0]->path)}}"
                 alt="{{$ad->images[0]->name}}">
        @else
            <img class="objT-border vignette__image"
                 src="https://images.unsplash.com/photo-1557234195-bd9f290f0e4d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80"
                 alt="placeholder">
        @endif
    </figure>


    <div class="columns is-mobile mt-2 mb-0 mt-4-mobile mb-3-mobile is-justify-content-space-between">
        <div class="column pl-0-mobile">
            <span class="tag is-warning has-text-weight-bold is-uppercase">
                {{ Str::words($ad->formatted_type, 1) }}
            </span>
        </div>

        @if($ad->is_partner)
            <div class="column p-0-mobile is-flex is-justify-content-center is-align-items-center">
                <div class="columns is-mobile is-variable is-1">
                    <div class="column py-0 is-flex is-align-items-center">
                        <figure class="image is-16x16">
                            <img src="{{ asset('images/icons/Certif.png') }}">
                        </figure>
                    </div>
                    <div class="column py-0">
                        <p class="">Certifié</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="column pr-0-mobile" style="color: #A74B2B">
            {{ Str::words($ad->formatted_price, 3) }}
        </div>
    </div>

    <p class="title is-5">{{ $ad->title }}</p>

    @if(!empty($ad->surface))
        <p class="mb-4 mt-auto">
            <span class="has-text-weight-bold">< ></span> {{ $ad->surface }} Ha
        </p>
    @endif

    <p class="@empty($ad->surface)mt-auto @endempty mb-4">{{ $ad->formatted_location }}</p>

    <b-button rounded class="mb-4 width-fit-content is-align-self-flex-start" tag="a" href="/annonces/{{$ad->id}}">
        Voir l'annonce
    </b-button>
</a>
