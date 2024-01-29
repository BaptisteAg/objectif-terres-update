@if(!isset($isPreview) || !$isPreview)
    @auth
        @if(count($threads))
            <b-button tag="a" rounded href="#messages-display" type="is-danger">
                Voir les fils de discussion
            </b-button>
        @else
            @include('pages.ads.partials.modal-new-ad-message')
        @endif

        @if($ad->user_pp_id !== auth()->user()->id)
            @if($favoriteAdAlreadyExist)
                <b-button tag="a" class="ml-3" type="is-warning" rounded icon-left="star-outline"
                          href="{{route ('favoriteAds.destroy', $favoriteAdAlreadyExist->id)}}"
                          style="padding-left: 1em; padding-right: 1em;">
                </b-button>
            @else
                {!! Form::open(['route'=>'favoriteAds.create', 'method'=>'get']) !!}
                <input name="ad_id" value="{{$ad->id}}" type="hidden">
                <b-button rounded class="ml-3" icon-left="star-outline" style="padding-left: 1em; padding-right: 1em;"
                          onclick="this.form.submit()">
                </b-button>
                {!! Form::close() !!}
            @endif
        @endif
    @else
        {!! Form::open(['route'=>'login', 'method'=>'get']) !!}
        <b-button type="is-danger" rounded onclick="this.form.submit()">
            Répondre à l’annonce
        </b-button>
        {!! Form::close() !!}
        {!! Form::open(['route'=>'favoriteAds.create', 'method'=>'get']) !!}
        <input name="ad_id" value="{{$ad->id}}" type="hidden">
        <b-button rounded class="ml-3" icon-left="star-outline" style="padding-left: 1em; padding-right: 1em;"
                  onclick="this.form.submit()">
        </b-button>
        {!! Form::close() !!}
    @endauth
@endif
