@extends ('default')

@section ('title', 'Consulter la liste de vos annonces favorites')

@section('main-content')
    <section class="section pt-0">
        <div class="container">
            <h1 class="page__title">Liste des annonces favorites</h1>
            @if(count($favoriteAds) <=1)
                <h2 class="page__subtitle"> {{ count($favoriteAds) }} annonce favorite.</h2>
            @else
                <h2 class="page__subtitle"> {{ count($favoriteAds) }} annonces favorites.</h2>
            @endif
            <section class="section">
                @foreach ($favoriteAds as $favoriteAd)
                    <ul class="list list_v tiles">
                        <li class="tile tile_text-image_h">
                            <div class="tile__link">
                                <div class="vignette photo is-flex">
                                        <div class="vignette__image-wrap is-flex">
                                            @if($favoriteAd->ad->hasImages)
                                                @if($favoriteAd->ad->images[0]->path ==="0")
                                                    @if($favoriteAd->ad->ad_type == "landSeek" or $favoriteAd->ad->ad_type == "landOffer")
                                                        <img src="{{URL::asset('images/illustrations/ferme01.jpg')}}"
                                                             class="vignette__image" alt="image generic ferme"/>
                                                    @else
                                                        <img src="{{URL::asset("images/illustrations/photo_08_bandeau-maous_1920.jpg")}}"
                                                             class=" vignette__image" alt="image generic emploi ferme"/>
                                                    @endif
                                                @else
                                                    <img src="{{URL::asset($favoriteAd->ad->images[0]->path)}}"
                                                         alt="{{$favoriteAd->ad->images[0]->name}}">
                                                @endif
                                            @else
                                                @if($favoriteAd->ad->ad_type == "landSeek" or $favoriteAd->ad->ad_type == "landOffer")
                                                    <img src="{{URL::asset('images/illustrations/ferme01.jpg')}}"
                                                         class="vignette__image" alt="image generic ferme"/>
                                                @else
                                                    <img src="{{URL::asset("images/illustrations/photo_08_bandeau-maous_1920.jpg")}}"
                                                         class=" vignette__image" alt="image generic emploi ferme"/>
                                                @endif
                                            @endif
                                        </div>
                                    <ul class="custom-tags custom-list custom-list_v x-large">
                                        <li class="custom-tag success">
                                            <i class="fas fa-map-marker-alt"></i>
                                            @if (is_null($favoriteAd->ad->citiesList) and is_null($favoriteAd->ad->departmentsList) and is_null($favoriteAd->ad->regionsList)   )
                                                Non renseignée
                                            @else
                                                {{$favoriteAd->ad->citiesList ?? ""}}
                                                {{$favoriteAd->ad->departmentsList ?? ""}}
                                                {{$favoriteAd->ad->regionsList ?? ""}}
                                            @endif
                                        </li>
                                        @if($favoriteAd->ad->landOfferAd)
                                            <li class="custom-tag warning">
                                                <i class="fas fa-piggy-bank"></i>
                                                @if(! is_null($favoriteAd->ad->landOfferAd->price))
                                                    {{number_format($favoriteAd->ad->landOfferAd->price, 0, ",", " " )}}
                                                    €
                                                @else
                                                    Prix non renseigné
                                                @endif
                                                @if(! is_null($favoriteAd->ad->landOfferAd->rent_price))
                                                    {{number_format($favoriteAd->ad->landOfferAd->rent_price, 0, ",", " " )}}
                                                    €/mois
                                                @else
                                                @endif
                                            </li>
                                            <li class="custom-tag danger">
                                                <i class="fas fa-arrows-alt-h"></i>
                                                @if(isset($favoriteAd->ad->landOfferAd->surface))
                                                    {{$favoriteAd->ad->landOfferAd->surface}} ha
                                                @else
                                                    Surface non renseignée
                                                @endif

                                            </li>
                                        @endif
                                        @if($favoriteAd->ad->landSeekAd)
                                            <li class="custom-tag warning">
                                                <i class="fas fa-piggy-bank"></i>
                                                @if(isset($favoriteAd->ad->landSeekAd->price_max))
                                                    @if($favoriteAd->ad->landSeekAd->price_max > 300000)
                                                        Plus de 300 000 €
                                                    @else
                                                        Jusqu'à {{number_format($favoriteAd->ad->landSeekAd->price_max, 2, ',', ' ')}}
                                                        €
                                                    @endif
                                                @elseif(isset($favoriteAd->ad->landSeekAd->rent_max))
                                                    Jusqu'à {{number_format($favoriteAd->ad->landSeekAd->rent_max, 2, ',', ' ')}}
                                                    €/mois
                                                @else
                                                    Budget non renseigné
                                                @endif
                                            </li>
                                            <li class="custom-tag danger">
                                                <i class="fas fa-arrows-alt-h"></i>
                                                @if(isset($favoriteAd->ad->landSeekAd->surface_range_min) and isset($favoriteAd->ad->landSeekAd->surface_range_max))
                                                    Entre {{$favoriteAd->ad->landSeekAd->surface_range_min}}
                                                    et {{$favoriteAd->ad->landSeekAd->surface_range_max}} ha
                                                @elseif(isset($favoriteAd->ad->landSeekAd->surface_range_min))
                                                    {{$favoriteAd->ad->landSeekAd->surface_range_min}} ha
                                                @elseif(isset($favoriteAd->ad->landSeekAd->surface_range_max))
                                                    {{$favoriteAd->ad->landSeekAd->surface_range_max}} ha
                                                @else
                                                    Surface non renseignée
                                                @endif
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                                <div class="tile__content large">
                                    <div class="tile__pre-title">
                                        <span class="tile__date">Annonce sauvegardée le {{ \Carbon\Carbon::parse($favoriteAd->created_at)->format('d/m/Y')}}</span>
                                    </div>
                                    <p class="tile__title">{{$favoriteAd->ad->title ?? "Titre de l'annonce non renseigné"}}
                                    </p>
                                    <div class="tile__intro">
                                        @if(isset($favoriteAd->ad->about_project_content))
                                            <p>{{ Illuminate\Support\Str::limit($favoriteAd->ad->about_project_content, 200)}}</p>
                                        @else
                                            <p>Pas de description renseignée pour cette annonce</p>
                                        @endif
                                    </div>

                                    @if($favoriteAd->ad->threadAlreadyExist)
                                        <article class="message is-success mb-0">
                                            <div class="message-body pt-15 pr-15 pb-15 pl-15">
                                                <a href="{{route('threads.index')}}">Vous avez déjà envoyé un message au porteur
                                                    de projet. Consulter votre messagerie !</a>
                                            </div>
                                        </article>
                                    @else
                                        <article class="message is-warning mb-0">
                                            <div class="message-body pt-15 pr-15 pb-15 pl-15">
                                                Vous n'avez pas encore répondu à cette annonce !
                                            </div>
                                        </article>
                                    @endif

                                    <p class="button__wrap button__wrap_right">
                                        <a href="{{route("ads.show", $favoriteAd->ad->id)}}">
                                            <button class="button basic  small warning mr-20">
											<span class="icon is-small">
											<i class="fas fa-eye text_white"></i>
											</span>
                                                <span>Voir l'annonce</span>
                                            </button>
                                        </a>
                                        <a href="{{route ('favoriteAds.destroy', $favoriteAd->id)}}">
                                            <button class="button basic small danger">
												<span class="icon text_white">
												  <i class="fas fa-trash"></i>
												</span>
                                                <span>Retirer l'annonce des favoris</span>
                                            </button>
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </li>
                    </ul>
                @endforeach
            </section>
            <section class="section">
                <pagination :per-page="10" :records="500" @paginate="myCallback"></pagination>
            </section>

            @include('components.section-orientation-terre-liens')
            @include('components.partnering')
            @include('components.support-terre-liens')

        </div>
    </section>
@endsection

