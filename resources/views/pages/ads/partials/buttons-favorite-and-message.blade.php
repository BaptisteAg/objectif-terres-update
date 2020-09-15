
@auth
    @if(auth()->user()->role >= 1)
        @if($moderatorInChargeOfModeration)
            @if(count($threads))
                <button onclick="window.location.href='#messages-display'" type="button"
                        class="ad-action-button card-footer-item button is-link is-fullwidth">
                    <span class="icon is-small">
                        <i class="fas fa-reply"></i>
                    </span>
                    <span> Voir les fils de discussion </span>
                </button>
            @else
                <button id="open-modal-message" type="button"
                        class="ad-action-button card-footer-item button is-link is-fullwidth">
                    <span class="icon is-small">
                        <i class="fas fa-reply"></i>
                    </span>
                    <span> Envoyer un message au porteur de projet</span>
                </button>
            @endif
        @else
            @if(count($threads))
                <button onclick="window.location.href='#messages-display'" type="button"
                        class="ad-action-button card-footer-item button is-link is-fullwidth">
                    <span class="icon is-small">
                        <i class="fas fa-reply"></i>
                    </span>
                    <span> Voir votre fil de discussion </span>
                </button>
            @else
                <button id="open-modal-message" type="button"
                        class="ad-action-button card-footer-item button is-link is-fullwidth">
                    <span class="icon is-small">
                        <i class="fas fa-reply"></i>
                    </span>
                    <span> Répondre à l'annonce</span>
                </button>
            @endif
        @endif
    @elseif($ad->user_pp_id !== auth()->user()->id)
        <footer class="card-footer">
            @if(count($threads))
                <a href="#messages-display" class="ad-action-button card-footer-item button is-link is-fullwidth">
                    <span class="icon is-small">
                        <i class="fas fa-reply"></i>
                    </span>
                    <span> Voir votre fil de discussion </span>
                </a>
            @else
                <button id="open-modal-message" type="button"
                        class="ad-action-button card-footer-item button is-link is-fullwidth">
                    <span class="icon is-small">
                        <i class="fas fa-reply"></i>
                    </span>
                    <span> Répondre à l'annonce</span>
                </button>
            @endif
            @if($favoriteAdAlreadyExist)
                <a href="{{route ('favoriteAds.destroy', $favoriteAdAlreadyExist->id)}}"
                   class="ad-action-button card-footer-item button is-link btn-favorite-ads">
                    <span class="icon is-small">
                        <i class="fas fa-heart"></i>
                    </span>
                </a>
            @else
                {!! Form::open(['route'=>'favoriteAds.create', 'method'=>'get']) !!}
                <input name="ad_id" value="{{$ad->id}}" type="hidden">
                <button class="ad-action-button card-footer-item button is-link is-outlined btn-favorite-ads">
                    <span class="icon">
                        <i class="far fa-heart"></i>
                    </span>
                </button>
                {!! Form::close() !!}
            @endif
        </footer>
    @elseif($ad->user_pp_id === auth()->user()->id)
        <footer class="card-footer">
            @if(count($threads))
                <a href="#messages-display" class="ad-action-button card-footer-item button is-link is-fullwidth">
                    <span class="icon is-small">
                        <i class="fas fa-reply"></i>
                    </span>
                    <span> Voir vos fil de discussion </span>
                </a>
            @endif
        </footer>
    @endif
@else
    <footer class="card-footer ">
            <button id="open-modal-message" type="button" class="ad-action-button card-footer-item button is-link">
                <span class="icon is-small">
                    <i class="fas fa-reply"></i>
                </span>
                <span> Répondre à l'annonce</span>
            </button>
        {!! Form::open(['route'=>'favoriteAds.create', 'method'=>'get']) !!}
        <input name="ad_id" value="{{$ad->id}}" type="hidden">
        <button class="ad-action-button card-footer-item button is-link is-outlined btn-favorite-ads">
            <span class="icon is-small">
                <i class="far fa-heart"></i>
            </span>
        </button>
        {!! Form::close() !!}
    </footer>
@endauth