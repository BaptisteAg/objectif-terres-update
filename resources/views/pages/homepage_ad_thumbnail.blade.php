<div class="column is-one-quarter is-flex is-flex-direction-column">
    <figure class="image is-3by2">
        @if($ad->hasImages && $ad->images[0]?->path)
            <img class="objT-border"
                 src="{{app('url')->assetFrom('https://objectif-terres.org', $ad->images[0]->path)}}"
                 alt="{{$ad->images[0]->name}}">
        @else
            <img class="objT-border"
                 src="https://images.unsplash.com/photo-1557234195-bd9f290f0e4d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80"
                 alt="placeholder">
        @endif
    </figure>


    <div class="columns mt-2 mb-0">
        <div class="column is-flex is-justify-content-left">
            <span class="tag is-warning has-text-weight-bold is-uppercase">
                {{ $ad->formatted_type }}
            </span>
        </div>

        @if($ad->is_partner)
            <div class="column is-flex is-justify-content-center">
                <div class="columns is-variable is-1">
                    <div class="column is-flex is-align-items-center">
                        <figure class="image is-16x16">
                            <img src="{{ asset('images/icons/Certif.png') }}">
                        </figure>
                    </div>
                    <div class="column">
                        <p class="">Certifié</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="column is-flex is-justify-content-right">
            {{ $ad->formatted_price }}
        </div>
    </div>

    <p class="title is-5">{{ $ad->title }}</p>

    <p class="mb-4 mt-auto"><span class="has-text-weight-bold">< ></span> {{ $ad->surface }} Ha @empty($ad->surface)non renseigné@endempty</p>

    <p class="mb-4">{{ $ad->formatted_location }}</p>

    <a class="button is-rounded mb-4 width-fit-content is-align-self-flex-start" href="/annonces/{{$ad->id}}">Voir l'annonce</a>

</div>