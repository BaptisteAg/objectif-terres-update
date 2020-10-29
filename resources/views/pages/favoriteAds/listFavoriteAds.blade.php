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
                                    @include('pages.ads.partials.thumbnail_left', ["ad" => $favoriteAd->ad])
                                </div>
                                <div class="tile__content large">

                                    @include('pages.ads.partials.thumbnail_right', ["ad" => $favoriteAd->ad])

                                    @if($ad->ad->threadAlreadyExist)
                                        <article class="message is-success mb-0">
                                            <div class="message-body pt-15 pr-15 pb-15 pl-15">
                                                <a href="{{route('threads.index')}}">Vous avez déjà envoyé un message au
                                                    porteur
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

