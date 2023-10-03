<div class="columns">
@include('pages.ads.partials.show-images')
    <div class="column is-half is-flex-tablet">
        <div class="card is-flex-tablet card-announcement">
            <div class="card-content">
                @foreach($ad->jobSeekAd->jobOfferTypes as $offerType)
                    <span class="tag is-primary is-medium">{{$offerType->name}}</span>
                @endforeach
                <div class="content">
                    @if($ad->is_draft)
                        <p><span class="is-size-5   ">Annonce soumise le : </span><span
                                    class="subtitle">{{ $ad->created_at}}</span>
                        </p>
                    @else
                        @if(isset($ad->is_partner) && $ad->is_partner === 1 )
                            <p class="custom-tags">
                                <span class="custom-tag warning">Annonce certifiée </span>
                            </p>
                        @endif
                        <p><span class="is-size-5   ">Publié le : </span><span
                                    class="subtitle">{{ $ad->published_on}}</span>
                        </p>
                    @endif
                </div>
                @if($ad->accept_share_contact_infos === 1)
                    <div class="content">
                        <p><span class="is-size-5   ">Publié par : </span>
                            @auth()
                                @if(auth()->user()->role >= 1 )
                                    <span class="subtitle">
                                        <a href="{{route('user.show', $ad->userPp->id)}}">{{ $ad->pp_display_name}}</a>
                                    </span>
                                @elseif(auth()->user()->role < 1)
                                    <span class="subtitle">
                                        {{ $ad->pp_display_name}}
                                    </span>
                                @endif
                            @endauth
                            @guest()
                                <span class="subtitle">
                                    {{ $ad->pp_display_name}}
                                </span>
                            @endguest
                        </p>
                    </div>
                @endif
                <div class="content">
                    <p>
                        <span class="is-size-5 is-capitalized ">Catégorie : </span>
                        <span class="subtitle">{{$ad->ad_type_full_name}}</span>
                    </p>
                </div>
                @if($ad->jobSeekAd->jobOfferTypes->count())
                    <div class="content">
                        <p><span class="is-size-5  ">Type d’opportunité professionnelle recherché :</span>
                            <span class="subtitle ">{{$ad->jobSeekAd->jobOfferTypes->pluck('name')->implode(', ') }}</span>
                        </p>
                    </div>
                @endif
                <div class="content">
                    <p><span class="is-size-5  ">Zone de recherche :</span></p>
                    @if(count($ad->cities))
                        <p>
                            <span class="is-size-6 ad-show-feature-label">
                                Communes
                                @if($ad->locationable_radius)
                                    (dans un rayon de {{$ad->locationable_radius}}km)
                                @endif
                                :
                            </span><br>
                            @foreach($ad->zipCodesByCity as $city => $zipCodes)
                                <span class="subtitle">{{$city}} ({{ $zipCodes->implode(', ') }})</span><br>
                            @endforeach
                        </p>
                    @endif

                    @if(! is_null($ad->departmentsList()))
                        <p>
                            <span class="is-size-6 is-capitalized ad-show-feature-label">Départements : </span>
                            <span class="subtitle"> {{$ad->departmentsList() }}</span>
                        </p>
                    @endif

                    @if(! is_null($ad->regionsList()))
                        <p>
                            <span class="is-size-6 is-capitalized ad-show-feature-label">Régions : </span>
                            <span class="subtitle"> {{$ad->regionsList() }}</span>
                        </p>
                    @endif
                </div>
                @if($ad->accept_share_contact_infos === 1 && $ad->userPp->phone)
                    <div class="content">
                        <p>
                            <span class="is-size-5 ">N° de téléphone : </span>
                            <span class="subtitle">{{$ad->userPp->phone}}</span>
                        </p>
                    </div>
                @endif

                @include('pages.ads.partials.show-documents')
            </div>
            @include('pages.ads.partials.buttons-favorite-and-message')
        </div>
    </div>
</div>

@include('pages.ads.partials.adMessageModal')

<hr class="navbar-divider">
<h4 class="title is-3 has-text-centered">Profil</h4>
<div class="columns is-multiline is-mobile is-centered">
    @if( isset ($ad->jobSeekAd->educationLevels))
        @if ($ad->jobSeekAd->educationLevels->count() >=1)
            <div class="column is-one-third ">
                <p class="has-text-link is-size-5 has-text-centered">Niveau de formation</p>
                <p class="has-text-centered">{{$ad->jobSeekAd->educationLevels->pluck('name')->implode(', ') }}</p>
            </div>
        @endif
    @endif

    @if($ad->jobSeekAd->experience_farming)
        <div class="column is-one-third ">
            <p class="has-text-link is-size-5 has-text-centered"> Expérience dans le monde agricole</p>
            <p class="has-text-centered">{{$ad->jobSeekAd->experience_farming}}</p>
        </div>
    @endif
</div>

<hr class="navbar-divider">

@if($ad->about_project_content)
    <div class="content">
        <h4 class="title is-3">Description</h4>
        <p> {!! nl2br($ad->about_project_content ?? "") !!}</p>
    </div>
@endif
@if($ad->about_content)
    <div class="content">
        <h4 class="title is-3">Informations sur l’annonceur</h4>
        <p>  {!! nl2br($ad->about_content ?? "") !!}</p>
    </div>
@endif



