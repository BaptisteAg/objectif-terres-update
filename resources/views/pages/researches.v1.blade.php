@extends ('default')

@section ('title', 'Rechercher parmi les annonces postées sur Objectif Terres')
@section('head-script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma-carousel@4.0.4/dist/css/bulma-carousel.min.css">
    @if($hasDepartmentPolygons)
        <!-- Import Leaflet CSS Style Sheet -->
        <link rel="stylesheet" href="https://npmcdn.com/leaflet@1.0.0-rc.2/dist/leaflet.css"/>
    @endif
@endsection

@section('main-content')
    @if($hasDepartmentPolygons)
        <div id="global-map"></div>
    @endif
    <section class="section pt-0">
        <div class="container">
            <nav class="level">
                <div class="level-left">
                    <div class="level-item">
                        @include('components.breadcrumb')
                    </div>
                </div>
                <div class="level-right">
                    <div class="level-item">
                        <a id="open-modal" href="" class="button" style="margin-top:10px;">
                            <span class="icon"><i class="far fa-heart"></i></span>
                            <span>Sauvegarder cette recherche</span>
                        </a>
                        @guest
                            <div class="modal">
                                <div class="modal-background"></div>
                                <div class="modal-content">
                                    <div class="card">
                                        <div class="card-content">
                                            <div class="content">
                                                <p class="title is-3 has-text-centered has-text-link">Pas encore
                                                    connecté·e ?</p>
                                                <p class="subtitle is-6">Pour sauvegarder cette recherche, vous devez
                                                    vous connecter ou créer un compte sur Objectif Terres</p>
                                            </div>
                                        </div>
                                        <footer class="card-footer">
                                            <div class="buttons card-footer-item">
                                                <a href="{{route('login')}}">
                                                    <button class="button basic primary">
                                                        <span>Se connecter</span></button>
                                                </a>
                                                <a href="{{route('register')}}">
                                                    <button class="button basic secondary">
                                                        <span>S'inscrire</span></button>
                                                </a>
                                            </div>
                                            <button id="close-modal" class="modal-close is-large"
                                                    aria-label="close"></button>
                                        </footer>
                                    </div>
                                </div>
                            </div>
                        @else
                            <form method="POST" action="{{ route('researches.store', request()->input())}}">
                                @csrf
                                <div class="modal">
                                    <div class="modal-background"></div>
                                    <div class="modal-content">
                                        <div class="card">
                                            <div class="card-content">
                                                <div class="field">
                                                    <label class="label">Donner un titre à votre recherche :</label>
                                                    <div class="control">
                                                        <input class="input" type="text" name="name" id="title"
                                                               placeholder="Votre titre...">
                                                    </div>
                                                </div>
                                            </div>
                                            <footer class="card-footer">
                                                <div class="buttons card-footer-item">
                                                    <button type="submit" class="button basic primary form-button">
                                                        Valider
                                                    </button>
                                                </div>
                                                <button id="close-modal" class="modal-close is-large"
                                                        aria-label="close"></button>
                                            </footer>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endguest
                    </div>
                </div>
            </nav>
            <nav class="level">
                <div class="level-left">
                    <div class="">
                        @if(isset($adsType))
                            @if ($adsType === 'landOfferAd')
                                <h1 class="title">Offres foncières</h1>
                            @elseif($adsType === 'landSeekAd')
                                <h1 class="title">Recherche de fonciers</h1>
                            @elseif($adsType === 'jobOfferAd')
                                <h1 class="title">Offres d'emploi</h1>
                            @elseif($adsType === 'jobSeekAd')
                                <h1 class="title">Recherche d'emploi</h1>
                            @else
                                <h1 class="title">Toutes les annonces</h1>
                            @endif
                        @endif
                        @if($ads->total() <= 1 )
                            <h2 class="subtitle text_success">{{ ($ads->total()) }} annonce trouvée</h2>
                        @else
                            <h2 class="subtitle text_success">{{ ($ads->total()) }} annonces trouvées</h2>
                        @endif
                    </div>
                </div>
                <div class="level-right">
                    <div class="level-item ">
                        <br>
                        <div class="select">
                            <select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                <option disabled  value="">Trier par</option>
                                <option {{request()->input('order') === 'desc' && request()->input('sort') === 'date' ? 'selected' : '' }} value="{{ route('researches.index', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'date', 'page'=> 0])) }}">
                                    Date: du plus récent au plus ancien
                                </option>
                                <option {{request()->input('order') === 'asc' && request()->input('sort') === 'date' ? 'selected' : '' }} value="{{ route('researches.index', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'date', 'page'=> 0])) }}">
                                    Date: du plus ancien au plus récent
                                </option>

                                @if($adsType =='landSeekAd' or $adsType== 'landOfferAd')
                                    @if($adsType == 'landOfferAd')
                                        <option {{request()->input('order') === 'asc' && request()->input('sort') === 'price' ? 'selected' : '' }} value="{{ route('researches.index', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'price', 'page'=> 0])) }}">
                                            Prix : du moins au plus élevé
                                        </option>
                                        <option {{request()->input('order') === 'desc' && request()->input('sort') === 'price' ? 'selected' : '' }} value="{{ route('researches.index', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'price', 'page'=> 0])) }}">
                                            Prix : du plus au moins élevé
                                        </option>
                                    @endif
                                    @if($adsType == 'landSeekAd')
                                        <option {{request()->input('order') === 'asc' && request()->input('sort') === 'surface_range_max' ? 'selected' : '' }} value="{{ route('researches.index', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'surface_range_max', 'page'=> 0])) }}">
                                            Surface : du plus petit au plus grand
                                        </option>
                                        <option {{request()->input('order') === 'desc' && request()->input('sort') === 'surface_range_max' ? 'selected' : '' }} value="{{ route('researches.index', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'surface_range_max', 'page'=> 0])) }}">
                                            Surface : du plus grand au plus petit
                                        </option>
                                    @elseif($adsType == 'landOfferAd')
                                        <option {{request()->input('order') === 'asc' && request()->input('sort') === 'surface' ? 'selected' : '' }} value="{{ route('researches.index', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'surface', 'page'=> 0])) }}">
                                            Surface : du plus petit au plus grand
                                        </option>
                                        <option {{request()->input('order') === 'desc' && request()->input('sort') === 'surface' ? 'selected' : '' }} value="{{ route('researches.index', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'surface', 'page'=> 0])) }}">
                                            Surface : du plus grand au plus petit
                                        </option>
                                    @endif
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
            </nav>
            <section class="section">
                @foreach($ads as $ad)
                    <ul class="list list_v tiles">
                        <li class="tile tile_text-image_h">
                            <a class="tile__link" href="{{route('ads.show',  $ad->id)}}">
                                <div class="vignette photo is-flex">
                                    @include('pages.ads.partials.thumbnail_left')
                                </div>
                                <div class="tile__content large">
                                    @include("pages.ads.partials.thumbnail_right")

                                    <p class="button__wrap">
                                        <span class="button round small warning read-more">
                                            <span class="button__icon"><i class="fas fa-arrow-right"></i></span>
                                        </span>
                                    </p>
                                </div>
                            </a>
                        </li>
                    </ul>
                @endforeach
            </section>
            <section class="section">
                <div class="columns is-mobile is-centered">
                    <div class="column is-half ">
                        {{ $ads->appends(Request::all())->links() }}
                    </div>
                </div>

            </section>
            {{--            @if($adsType === 'landOfferAd' || $adsType === 'landSeekAd')--}}
            {{--                <section class="section">--}}
            {{--                    <div class="columns">--}}
            {{--                        <div class="column">--}}
            {{--                            <h1 class="title is-1">Avez-vous un projet agricole ?</h1>--}}
            {{--                            <div><p>Objectif Terre est là pour vous aider à le réaliser ! Avec un suivi sur mesure et--}}
            {{--                                    notre expérience du secteur, nous sommes en mesure de vous apporter une vraie plus--}}
            {{--                                    value, de l'idée initiale au projet déjà défini. <u>Rencontrons-nous !</u></p></div>--}}
            {{--                            <div>--}}
            {{--                                <p><i class="far fa-check-circle"></i> Un suivi sur mesure</p>--}}
            {{--                                <p><i class="far fa-check-circle"></i> Des experts du secteur foncier</p>--}}
            {{--                                <p><i class="far fa-check-circle"></i> Des ressources</p>--}}
            {{--                                <p><i class="far fa-check-circle"></i> Des formations adaptées</p>--}}
            {{--                            </div>--}}
            {{--                            <a href="/" class="button is-dark is-uppercase is-medium">Contactez-nous</a>--}}
            {{--                        </div>--}}
            {{--                        <div class="column">--}}
            {{--                            <figure><img src="https://picsum.photos/600/350" alt="Placeholder image"></figure>--}}
            {{--                            <div><p>En 2018, plus de xx fermiers ont pu s'installer ou céder leurs terres avec succès,--}}
            {{--                                    grâce à la platerforme Objectif Terre et au travail mené sur le terrain par--}}
            {{--                                    l'association Terre de Liens</p></div>--}}
            {{--                        </div>--}}
            {{--                    </div>--}}
            {{--                </section>--}}
            {{--            @else--}}
            {{--                @include('components.section-orientation-terre-liens')--}}
            {{--            @endif--}}


        </div>
    </section>
    {{--    @include('components.partnering')--}}
    {{-- @include('components.support-terre-liens') --}}
@endsection

@section('script')
    <script>
        document.querySelector('a#open-modal').addEventListener('click', function (event) {
            event.preventDefault();
            let modal = document.querySelector('.modal');
            let html = document.querySelector('html');
            modal.classList.add('is-active');
            html.classList.add('is-clipped');

            modal.querySelector('.modal-background').addEventListener('click', function (e) {
                e.preventDefault();
                modal.classList.remove('is-active');
                html.classList.remove('is-clipped');
            });
            modal.querySelector('#close-modal').addEventListener('click', function (e) {
                e.preventDefault();
                modal.classList.remove('is-active');
                html.classList.remove('is-clipped');
            });
        });
    </script>

    @if($hasDepartmentPolygons)
        <script defer>
            regionMapInit('global-map', {
                region_id: "{{$request->get("regions_location_researches_ids")[0]}}",
                offer_type: "{{$request->get("offer_type")}}",
                ad_category: "{{$request->get("ad_category")}}"
            });
        </script>
    @endif

@endsection
