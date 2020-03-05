@section('title', $ad->title)
<section class="section">
    <div class="container ">
        <nav class="breadcrumb" aria-label="breadcrumbs">
            <ul>
                <li><a href="#">Annonces</a></li>
                <li><a href="#">Opportunités professionnelles</a></li>
            </ul>
        </nav>
        <h1 class="title has-text-link">{{$ad->title}}</h1>
        @auth
            @if(auth()->user()->role >= 2)
                @include('pages.ads.partials.moderator-options')
            @endif
        @endauth
        <div class="columns">
            @include('pages.ads.partials.show-images')

            <div class="column">
                <div class="card">
                    <div class="card-content">
                        <div class="content">
                            @if(is_null($ad->published_on))
                                <p><span class="is-size-5  has-text-black ">Annonce soumise le : </span><span
                                            class="subtitle">{{ $ad->created_at}}</span>
                                </p>
                            @else
                                <p><span class="is-size-5  has-text-black ">Publié le  : </span><span
                                            class="subtitle">{{ $ad->published_on}}</span>
                                </p>
                            @endif
                        </div>
                        <div class="content">
                            <p><span class="is-size-5  has-text-black ">Publié par  : </span>
                                @if(auth()->user()->role >= 1 )
                                    <span class="subtitle">
										<a href="{{route('user.show', $ad->userPp->id)}}">{{ $ad->userPp->first_name}} {{$ad->userPp->name}}</a>
									</span>
                                @else
                                    <span class="subtitle">
										{{ $ad->userPp->first_name}} {{$ad->userPp->name}}
									</span>
                                @endif
                            </p>
                        </div>
                        <div class="content">
                            <p>
                                <span class="is-size-5 is-capitalized has-text-black">Catégorie : </span>
                                <span class="subtitle">Proposition opportunité professionnelle</span>
                            </p>
                        </div>
                        <div class="content">
                            @if(count($ad->cities))
                                <p>
									<span class="is-size-5 ad-show-feature-label">
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

                            @if(count($ad->departments))
                                <p>
                                    <span class="is-size-5 is-capitalized ad-show-feature-label">Départements : </span><br>
                                    <span class="subtitle"> {{$ad->departments->pluck('name')->implode(', ') }}</span>
                                </p>
                            @endif

                            @if(count($ad->regions))
                                <p>
                                    <span class="is-size-5 is-capitalized ad-show-feature-label">Régions : </span><br>
                                    <span class="subtitle">{{$ad->regions->pluck('name')->implode(', ') }}</span>
                                </p>
                            @endif
                        </div>
                        @if($ad->jobSeekAd->jobOfferTypes->count())
                            <div class="content">
                                <p><span class="is-size-5  has-text-black">Intéressé par :</span>
                                    <span class="subtitle ">{{$ad->jobSeekAd->jobOfferTypes->pluck('name')->implode(', ') }}</span>
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


                    @include('pages.ads.partials.buttonsFavoriteAndMessage')
                </div>
            </div>
        </div>

        @include('pages.ads.partials.adMessageModal')

        <hr class="navbar-divider">
        <h3 class="title is-3 has-text-centered">Profil</h3>
        <div class="columns is-multiline is-mobile is-centered">
            @if($ad->jobSeekAd->educationLevels)
                <div class="column is-one-third ">
                    <p class="has-text-link is-size-5 has-text-centered">Niveau de formation</p>
                    <p class="has-text-centered">{{$ad->jobSeekAd->educationLevels->pluck('name')->implode(', ') }}</p>
                </div>
            @endif

            @if($ad->jobSeekAd->experience_farming)
                <div class="column is-one-third ">
                    <p class="has-text-link is-size-5 has-text-centered"> Expérience dans le monde agricole</p>
                    <p class="has-text-centered">{{$ad->jobSeekAd->experience_farming}}</p>
                </div>
            @endif
        </div>

        <hr class="navbar-divider">

        <div class="content">
            <h3 class="title is-3">Description du projet</h3>
            <p> {{$ad->about_project_content}}</p>
        </div>

        <div class="content">
            <h3 class="title is-3">A propos</h3>
            <p> {{$ad->about_content}}</p>
        </div>

        <div class="section">
            @include('pages.ads.partials.threadsDisplay')
        </div>
    </div>

</section>
@include('components.partnering')
@include('components.supportTerreLiens')


