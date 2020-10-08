<div class="columns">
    @include('pages.ads.partials.show-images')
    <div class="column is-half is-flex-tablet">
        <div class="card is-flex-tablet card-announcement">
            <div class="card-content">
                @foreach($ad->jobOfferAd->jobOfferTypes as $offerType)
                    <span class="tag is-primary is-medium">{{$offerType->name}}</span>
                @endforeach
                <div class="content">
                    @if($ad->is_draft)
                        <p><span class="is-size-5  has-text-black ">Annonce soumise le : </span><span
                                    class="subtitle">{{ $ad->created_at}}</span>
                        </p>
                    @else
                        @if(isset($ad->is_partner) && $ad->is_partner === 1 )
                            <p class="custom-tags">
                                <span class="custom-tag warning">Annonce certifiée </span>
                            </p>
                        @endif
                        <p><span class="is-size-5  has-text-black ">Publié le : </span><span
                                    class="subtitle">{{ $ad->published_on}}</span>
                        </p>
                    @endif
                </div>
                <div class="content">
                    <p><span class="is-size-5  has-text-black ">Publié par : </span>
                        @auth()
                            @if(auth()->user()->role >= 1 )
                                <span class="subtitle">
                                    <a href="{{route('user.show', $ad->userPp->id)}}">{{ $ad->userPp->first_name}} {{$ad->userPp->name}}</a>
                                </span>
                            @elseif(auth()->user()->role < 1)
                                <span class="subtitle">
                                    {{ $ad->userPp->first_name}} {{$ad->userPp->name}}
                                </span>
                            @endif
                        @endauth
                        @guest()
                            <span class="subtitle">
                                {{ $ad->userPp->first_name}} {{$ad->userPp->name}}
                            </span>
                        @endguest()
                    </p>
                </div>
                <div class="content">
                    <p>
                        <span class="is-size-5 is-capitalized has-text-black">Catégorie : </span>
                        <span class="subtitle">{{$ad->ad_type_full_name}}</span>
                    </p>
                </div>

                <div class="content">
                    @if(count($ad->cities))
                        <p><span class="is-size-5 is-capitalized has-text-black">Code postal : </span><span
                                    class="subtitle">{{$ad->cities[0]->zip_code }} ({{$ad->cities[0]->name }})</span>
                        </p>
                    @endif
                    @if(!is_null($ad->departmentsList()))
                        <p>
                            <span class="is-size-5 is-capitalized ad-show-feature-label">Départements : </span>
                            <span class="subtitle">{{$ad->departmentsList()}}</span>
                        </p>
                    @endif
                    @if(!is_null($ad->regionsList()))
                        <p>
                            <span class="is-size-5 is-capitalized ad-show-feature-label">Régions : </span>
                            <span class="subtitle">{{$ad->regionsList()}}</span>
                        </p>
                    @endif
                </div>
                @if($ad->jobOfferAd->jobOfferTypes->count())
                    <div class="content">
                        <p><span class="is-size-5  has-text-black">Offres possibles :</span>
                            <span class="subtitle ">{{$ad->jobOfferAd->jobOfferTypes->pluck('name')->implode(', ') }}</span>
                        </p>
                    </div>
                @endif
                @if($ad->userPp->accept_share_contact_infos === 1)
                    <div class="content">
                        <p><span class="is-size-5 has-text-black">N° de téléphone du porteur de projet : </span>
                        </p>
                        <p><span class="subtitle">{{$ad->userPp->phone}}</span></p>
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
<h3 class="title is-3 has-text-centered">Description de l'offre</h3>
<div class="columns is-multiline is-mobile is-centered">
    @if($ad->jobOfferAd->educationLevels)
        <div class="column is-one-third ">
            <p class="has-text-link is-size-5 has-text-centered"> Niveau de formation souhaité</p>
            <p class="has-text-centered">{{$ad->jobOfferAd->educationLevels->pluck('name')->implode(', ') }}</p>
        </div>
    @endif

    @if($ad->jobOfferAd->experience_farming)
        <div class="column is-one-third ">
            <p class="has-text-link is-size-5 has-text-centered"> Expérience souhaitée</p>
            <p class="has-text-centered">{{$ad->jobOfferAd->experience_farming}}</p>
        </div>
    @endif


    <div class="column is-one-third ">
        <p class="has-text-link is-size-5 has-text-centered">Transmission d'activité envisagée</p>
        <p class="has-text-centered">{{$ad->jobOfferAd->is_activity_transmission ? 'Oui' : 'Non'}}</p>
    </div>

</div>

<hr class="navbar-divider">

@if($ad->jobOfferAd->job_description)
    <div class="content">
        <h3 class="title is-3">Description du poste</h3>
        <p>  {!! nl2br($ad->jobOfferAd->job_description ?? "") !!}</p>
    </div>
@endif

@if($ad->about_project_content)
    <div class="content">
        <h3 class="title is-3">Description de la ferme</h3>
        <p> {!! nl2br($ad->about_project_content ?? "") !!} </p>
    </div>
@endif
@if($ad->about_content)
    <div class="content">
        <h3 class="title is-3">Information(s) sur l’annonceur</h3>
        <p> {!! nl2br($ad->about_content ?? "") !!}</p>
    </div>
@endif

<div id="map_ad"></div>

<div class="section">
    @include('pages.ads.partials.threadsDisplay')
</div>


