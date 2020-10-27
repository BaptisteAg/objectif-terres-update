@extends ('default')

@section ('title', 'Consulter la liste de vos annonces')

@section('main-content')
    <section class="section">
        <div class="container">
            <h1 class="page__title">Liste de mes annonces</h1>
            @if(count($ads) <=1)
                <h2 class="page__subtitle"> {{ count($ads) }} annonce créée</h2>
            @else
                <h2 class="page__subtitle"> {{ count($ads) }} annonces créées</h2>
            @endif
            <section class="section">
                @foreach ($ads as $ad)
                    <ul class="list list_v tiles">
                        <li class="tile tile_text-image_h">
                            <div class="tile__link">
                                <div class="vignette photo is-flex">
                                    <div class="vignette__image-wrap is-flex">
                                        @if($ad->hasImages)
                                            @if($ad->images->first()->path ==="0")
                                                @if($ad->ad_type == "landSeek" or $ad->ad_type == "landOffer")
                                                    <img src="{{URL::asset('images/illustrations/ferme01.jpg')}}"
                                                         class="vignette__image" alt="image generic ferme"/>
                                                @else
                                                    <img src="{{URL::asset("images/illustrations/photo_08_bandeau-maous_1920.jpg")}}"
                                                         class=" vignette__image" alt="image generic emploi ferme"/>
                                                @endif
                                            @else
                                                <img src="{{URL::asset($ad->images[0]->path)}}"
                                                     alt="{{$ad->images[0]->name}}">
                                            @endif
                                        @else
                                            @if($ad->ad_type == "landSeek" or $ad->ad_type == "landOffer")
                                                <img src="{{URL::asset('images/illustrations/ferme01.jpg')}}"
                                                     class="vignette__image" alt="image generic ferme"/>
                                            @else
                                                <img src="{{URL::asset("images/illustrations/photo_08_bandeau-maous_1920.jpg")}}"
                                                     class=" vignette__image" alt="image generic emploi ferme"/>
                                            @endif
                                        @endif
                                    </div>
                                    <ul class="custom-tags custom-list custom-list_v x-large">
                                        @foreach(array_filter([$ad->regionsList, $ad->departmentsList, $ad->citiesList]) as $locations)
                                            <li class="custom-tag success">
                                                <i class="fas fa-map-marker-alt"></i>
                                                {{ $locations }}
                                            </li>
                                        @endforeach
                                        @if($ad->landOfferAd)
                                            <li class="custom-tag warning">
                                                <i class="fas fa-piggy-bank"></i>
                                                @if(! is_null($ad->landOfferAd->price))
                                                    {{number_format($ad->landOfferAd->price, 0, ",", " " )}}
                                                    €
                                                @else
                                                    Prix non renseigné
                                                @endif
                                                @if(! is_null($ad->landOfferAd->rent_price))
                                                    {{number_format($ad->landOfferAd->rent_price, 0, ",", " " )}}
                                                    €/mois
                                                @else
                                                @endif
                                            </li>
                                            <li class="custom-tag danger">
                                                <i class="fas fa-arrows-alt-h"></i>
                                                {{ $ad->human_ha }}

                                            </li>
                                        @endif
                                        @if($ad->landSeekAd)
                                            <li class="custom-tag warning">
                                                <i class="fas fa-piggy-bank"></i>
                                                @if(isset($ad->landSeekAd->price_max))
                                                    @if($ad->landSeekAd->price_max > 300000)
                                                        Plus de 300 000 €
                                                    @else
                                                        Jusqu'à {{number_format($ad->landSeekAd->price_max, 2, ',', ' ')}}
                                                        €
                                                    @endif
                                                @elseif(isset($ad->landSeekAd->rent_max))
                                                    Jusqu'à {{number_format($ad->landSeekAd->rent_max, 2, ',', ' ')}}
                                                    €/mois
                                                @else
                                                    Budget non renseigné
                                                @endif
                                            </li>
                                            <li class="custom-tag danger">
                                                <i class="fas fa-arrows-alt-h"></i>
                                                {{ $ad->human_ha }}
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                                <div class="tile__content large">
                                    <div class="tile__pre-title">
                                        <span class="tile__date">Annonce créée le {{ $ad->created_at}}</span>
                                        <ul class="custom-tags">
                                            <li class="custom-tag warning">{{$ad->ad_type_full_name}}</li>
                                        </ul>
                                    </div>
                                    <p class="tile__title">{{$ad->title ?? "Titre de l'annonce non renseigné"}}
                                    </p>
                                    <div class="tile__intro">
                                        @if(isset($ad->about_project_content))
                                            <p>{{ Illuminate\Support\Str::limit($ad->about_project_content, 200)}}</p>
                                        @else
                                            <p>Pas de description renseignée pour cette annonce.</p>
                                        @endif
                                        <p class="mt-10 mb-10">
                                            @if(count($ad->threads) === 0)
                                                <span class="text_charcoal">Vous n'avez pas reçu de messages concernant
                                                    cette annonce</span>
                                            @endif
                                            @if(count($ad->threads) === 1 )
                                                <span>Vous avez <span class="text_charcoal has-text-weight-bold">
                                                        <a
                                                                href="{{route("threads.index")}}"> {{count($ad->threads)}}
                                                            fil de discussion
                                                        </a>
                                                    </span>concernant cette annonce !</span>

                                            @elseif(count($ad->threads) > 1)
                                                <span class="text_charcoal">Vous avez <span
                                                            class="has-text-weight-bold">
                                                        <a
                                                                href="{{route("threads.index")}}"> {{count($ad->threads)}}
                                                            fils de discussion
                                                        </a>
                                                    </span>
                                                    concernant cette annonce ! </span>
                                            @endif
                                        </p>
                                    </div>
                                    @if(!$ad->attributionAd || $ad->is_draft === 1)
                                        <article class="message is-warning">
                                            <div class="message-body">
                                                Votre annonce est en mode brouillon, elle n'as pas été encore soumise à
                                                modération !
                                            </div>
                                        </article>
                                    @else
                                        @if(isset($ad->attributionAd->adStatus))
                                            @if($ad->attributionAd->adStatus->id === \App\Models\AdStatus::APPROVE_ID)
                                                <article class="message is-success">
                                                    <div class="message-body">
                                                        Votre annonce a été validée et est en ligne depuis
                                                        le {{$ad->published_on}} !
                                                    </div>
                                                </article>
                                            @elseif($ad->attributionAd->adStatus->id === \App\Models\AdStatus::PENDING_ID)
                                                <article class="message is-warning">
                                                    <div class="message-body">
                                                        Votre annonce nécessite quelques modifications,
                                                        <a
                                                                href="{{route('threads.index')}}">consulter votre
                                                            messagerie
                                                        </a>
                                                        pour
                                                        plus d'informations !
                                                    </div>
                                                </article>
                                            @elseif($ad->attributionAd->adStatus->id === \App\Models\AdStatus::REFUSE_ID)
                                                <article class="message is-danger">
                                                    <div class="message-body">
                                                        Votre annonce a été réfusée,
                                                        <a href="{{route('threads.index')}}">consulter
                                                            votre
                                                            messagerie
                                                        </a>
                                                        pour plus d'informations !
                                                    </div>
                                                </article>
                                            @elseif($ad->attributionAd->adStatus->id === \App\Models\AdStatus::ARCHIVED_ID)
                                                <article class="message is-message ">
                                                    <div class="message-body">
                                                        Votre annonce a été archivée !
                                                    </div>
                                                </article>
                                            @else
                                                <article class="message is-message message is-dark">
                                                    <div class="message-body">
                                                        Votre annonce n'as pas été encore approuvée et publiée !
                                                    </div>
                                                </article>
                                            @endif
                                        @else

                                        @endif
                                    @endif

                                    <p class="ad-admin button__wrap button__wrap_right">

                                        <a href="{{route("ads.show", $ad->id)}}">
                                            <button class="button basic  small success mr-20">
                                                <span class="icon is-small">
                                                    <i class="fas fa-eye text_white"></i>
                                                </span>
                                                <span>Voir</span>
                                            </button>
                                        </a>

                                        <a href="{{route("ads.edit", $ad->id)}}">
                                            <button class="button basic  small warning mr-20">
                                                <span class="icon is-small">
                                                    <i class="fas fa-pencil-alt text_white"></i>
                                                </span>
                                                <span>Modifier</span>
                                            </button>
                                        </a>

                                        <a href="{{ route('ads.delete', ["ad" => $ad->id]) }}"
                                           onclick="return confirm('Êtes vous sûr·e ? Cette opération est irréversible.')">
                                            <button class="button basic small danger">
                                                <span class="icon text_white">
                                                    <i class="fas fa-trash"></i>
                                                </span>
                                                <span>Supprimer</span>
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
{{--            @include('components.section-orientation-terre-liens')--}}
        </div>
    </section>
@endsection

