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
                                    @include('pages.ads.partials.thumbnail_left')
                                </div>
                                <div class="tile__content large">
                                    @include('pages.ads.partials.thumbnail_right')

                                    <div class="tile__intro">
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
                                                Votre annonce est en mode brouillon, elle n'a pas été encore soumise à
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
                <pagination :per-page="10" :records="500"></pagination>
            </section>
{{--            @include('components.section-orientation-terre-liens')--}}
        </div>
    </section>
@endsection

