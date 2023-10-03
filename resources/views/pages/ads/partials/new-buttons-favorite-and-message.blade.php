@auth
    @if(auth()->user()->role >= 1)
        @if($moderatorInChargeOfModeration)
            @if(count($threads))
                <b-button rounded @click="window.location.href='#messages-display'" type="is-danger">
                    Voir les fils de discussion
                </b-button>
            @else
                <b-button rounded id="open-modal-message" type="is-danger">
                    Envoyer un message à l'annonceur
                </b-button>
            @endif
        @else
            @if(count($threads))
                <b-button rounded @click="window.location.href='#messages-display'" type="is-danger">
                    Voir votre fil de discussion
                </b-button>
            @else
                <b-button rounded id="open-modal-message" type="is-danger">
                    Répondre à l'annonce
                </b-button>
            @endif
        @endif
    @elseif($ad->user_pp_id !== auth()->user()->id)
        @if(count($threads))
            <b-button rounded href="#messages-display" type="is-danger">
                Voir votre fil de discussion
            </b-button>
        @else
            <b-button rounded id="open-modal-message" type="is-danger">
                Répondre à l'annonce
            </b-button>
        @endif
        @if($favoriteAdAlreadyExist)
            <b-button tag="a" type="is-warning" rounded icon-left="star-outline" href="{{route ('favoriteAds.destroy', $favoriteAdAlreadyExist->id)}}" style="padding-left: 1em; padding-right: 1em;">
            </b-button>
        @else
            {!! Form::open(['route'=>'favoriteAds.create', 'method'=>'get']) !!}
            <input name="ad_id" value="{{$ad->id}}" type="hidden">
            <b-button rounded icon-left="star-outline" style="padding-left: 1em; padding-right: 1em;" onclick="this.form.submit()">
            </b-button>
            {!! Form::close() !!}
        @endif
    @elseif($ad->user_pp_id === auth()->user()->id)
        @if(count($threads))
            <b-button rounded href="#messages-display" type="is-danger">
                Voir vos fil de discussion
            </b-button>
        @endif
    @endif
@else
    <b-button rounded id="open-modal-message" type="is-danger">
        Répondre à l’annonce
    </b-button>
    {!! Form::open(['route'=>'favoriteAds.create', 'method'=>'get']) !!}
    <input name="ad_id" value="{{$ad->id}}" type="hidden">
    <b-button rounded icon-left="star-outline" style="padding-left: 1em; padding-right: 1em;" onclick="this.form.submit()">
    </b-button>
    {!! Form::close() !!}
@endauth
