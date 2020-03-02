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
        <div class="columns">
            @include('pages.ads.partials.show-images')
            <div class="column">
                <div class="card">
                    <div class="card-content">
                        <div class="content">
                            <p><span class="is-size-5 is-capitalized has-text-black ">Publié le  : </span><span
                                        class="subtitle">{{ $ad->created_at}}</span>
                            </p>
                        </div>
                        <div class="content">
                            <p><span class="is-size-5  has-text-black ">Publié par  : </span>
                                @if(auth()->user()->role >=1)
                                    <span class="subtitle"><a href="{{route('user.show', $ad->userPp->id)}}">{{ $ad->userPp->first_name}} {{$ad->userPp->name}}</a></span>
                                @else
                                    <span class="subtitle">{{ $ad->userPp->first_name}} {{$ad->userPp->name}}</span>
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
                            <p><span class="is-size-5 is-capitalized has-text-black">Code postal : </span><span
                                        class="subtitle">{{$ad->cities[0]->zip_code }} ({{$ad->cities[0]->name }})</span>
                            </p>
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


                    @include('pages.ads.partials.buttonsFavoriteAndMessage')
                </div>
            </div>
        </div>

        @include('pages.ads.partials.adMessageModal')

        <hr class="navbar-divider">
        <h3 class="title is-3 has-text-centered">Caractéristiques de l'offre</h3>
        <div class="columns is-multiline is-mobile is-centered">
            @if($ad->jobOfferAd->educationLevels)
                <div class="column is-one-third ">
                    <p class="has-text-link is-size-5 has-text-centered"> Niveaux de formation acceptés</p>
                    <p class="has-text-centered">{{$ad->jobOfferAd->educationLevels->pluck('name')->implode(', ') }}</p>
                </div>
            @endif

            @if($ad->jobOfferAd->experience_farming)
                <div class="column is-one-third ">
                    <p class="has-text-link is-size-5 has-text-centered"> Expérience dans le monde agricole</p>
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
                <h3 class="title is-3">Description de l'offre d'emploi</h3>
                <p> {{$ad->jobOfferAd->job_description}}</p>
            </div>
        @endif

        <div class="content">
            <h3 class="title is-3">Description de la ferme</h3>
            <p> {{$ad->about_project_content}}</p>
        </div>

        <div class="content">
            <h3 class="title is-3">A propos du porteur de projet</h3>
            <p> {{$ad->about_content}}</p>
        </div>

        <div class="section">
            @include('pages.ads.partials.threadsDisplay')
        </div>
    </div>

</section>
@include('components.partnering')
@include('components.supportTerreLiens')


