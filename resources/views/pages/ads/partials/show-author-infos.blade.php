@if($ad->accept_share_contact_infos === 1)
    <div class="w-50">
        <strong>Publié par : </strong>
        @if(!empty($ad->userPp))
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

    @if($ad->userPp?->phone)
        <div class="w-50">
            <strong>N° de téléphone : </strong>
            {{$ad->userPp->phone}}
        </div>
    @endif

    @if($ad->userPp?->phone)
        <div class="w-50">
            <strong>N° de téléphone : </strong>
            {{$ad->userPp->phone}}
        </div>
    @endif

@endif
