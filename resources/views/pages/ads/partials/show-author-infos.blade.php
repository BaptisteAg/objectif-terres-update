@auth()
    @if($ad->third_party_ad_user_id && auth()->user()->role >= 1)
        <div class="w-50">
            <strong>Publié par : </strong>
            <a href="{{route('user.show', $ad->userPp->id)}}">{{ $ad->pp_display_name}}</a>
        </div>
    @endif
@endauth

<div class="w-50">
    <strong>Publié @if($ad->third_party_ad_user_id)
            pour
        @else
            par
        @endif : </strong>
    @if($ad->third_party_ad_user_id)
        {{$ad->thirdPartyAdUser->first_name}} {{$ad->thirdPartyAdUser->last_name}}
    @elseif(!empty($ad->userPp))
        @auth()
            @if(auth()->user()->role >= 1 )
                <a href="{{route('user.show', $ad->userPp->id)}}">{{ $ad->pp_display_name}}</a>
            @elseif(auth()->user()->role < 1)
                {{ $ad->pp_display_name}}
            @endif
        @endauth
        @guest()
            {{ $ad->pp_display_name}}
        @endguest()
    @else
        [Utilisateur supprimé]
    @endif
</div>

@if(!$ad->third_party_ad_user_id)
    @if($ad->accept_share_contact_infos === 1)
        @if($ad->userPp?->phone)
            <div class="w-50">
                <strong>N° de téléphone : </strong>
                {{$ad->userPp->phone}}
            </div>
        @endif
    @endif

    @if($ad->userPp?->email)
        <div class="w-50">
            <strong>Email : </strong>
            {{$ad->userPp->email}}
        </div>
    @endif
@endif

