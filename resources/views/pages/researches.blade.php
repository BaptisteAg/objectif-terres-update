@extends ('default')

@section ('title', 'Rechercher parmis les annonces postées sur Objectif Terres')
@section('head-script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma-carousel@4.0.4/dist/css/bulma-carousel.min.css">
@endsection

@section('main-content')
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
                        @guest
                            <a id="open-modal" href="">
                                <span class="icon"><i class="far fa-heart"></i></span>
                                <span>Sauvegarder cette recherche</span>
                            </a>
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
                            <a id="open-modal" href="">
                                <span class="icon"><i class="far fa-heart"></i></span>
                                <span>Sauvegarder cette recherche</span>
                            </a>
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
                                @@elseif($adsType === 'jobSeekAd')
                                <h1 class="title">Recherche d'emploi</h1>
                            @else
                                <h1 class="title">Toutes les annonces</h1>
                            @endif
                        @endif
                        <h2 class="subtitle text_success">{{ ($ads->total()) }} annonces trouvées</h2>
                    </div>
                </div>
                <div class="level-right">
                    <div class="level-item ">
                        <label class="label">Trier par : </label>
                        <br>
                        <div class="select">
                            <select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                <option value="">Choisissez un filter</option>
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
                                    <div class="vignette__image-wrap is-flex">
                                        @if($ad->hasImages)
                                            @if($ad->images[0]->path ==="0")
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
                                        @if(isset($ad->is_partner) && $ad->is_partner === 1 )
                                            <li class="custom-tag warning">Partenaire Terre de Liens</li>
                                        @endif
                                        <li class="custom-tag success">
                                            <i class="fas fa-map-marker-alt"></i>
                                            @if (is_null($ad->citiesList) and is_null($ad->departmentsList) and is_null($ad->regionsList))
                                                Non renseignée
                                            @elseif ($ad->landOfferAd && !$ad->landOfferAd->accept_use_zip_code)
                                                @if( !is_null($ad->citiesList) )
                                                    {{ $ad->cities[0]->department->name }}
                                                @elseif( !is_null($ad->departmentsList))
                                                    {{ $ad->departmentsList ?? ""}}
                                                @endif
                                            @else
                                                {{ $ad->citiesList ?? "" }}
                                                {{ $ad->departmentsList ?? "" }}
                                                {{ $ad->regionsList ?? "" }}
                                            @endif
                                        </li>
                                        @if($ad->landOfferAd)
                                            <li class="custom-tag warning">
                                                <i class="fas fa-piggy-bank"></i>
                                                @if(! is_null($ad->landOfferAd->price))
                                                    {{number_format($ad->landOfferAd->price, 0, ",", " " )}} €
                                                @else
                                                    Prix non renseigné
                                                @endif
                                                @if(! is_null($ad->landOfferAd->rent_price))
                                                    {{number_format($ad->landOfferAd->rent_price, 0, ",", " " )}} €/mois
                                                @else
                                                @endif
                                            </li>
                                            <li class="custom-tag danger">
                                                <i class="fas fa-arrows-alt-h"></i>
                                                @if(isset($ad->landOfferAd->surface))
                                                    {{$ad->landOfferAd->surface}} ha
                                                @else
                                                    Surface non renseignée
                                                @endif

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
                                                @if(isset($ad->landSeekAd->surface_range_min) and isset($ad->landSeekAd->surface_range_max))
                                                    Entre {{$ad->landSeekAd->surface_range_min}}
                                                    et {{$ad->landSeekAd->surface_range_max}} ha
                                                @elseif(isset($ad->landSeekAd->surface_range_min))
                                                    {{$ad->landSeekAd->surface_range_min}} ha
                                                @elseif(isset($ad->landSeekAd->surface_range_max))
                                                    {{$ad->landSeekAd->surface_range_max}} ha
                                                @else
                                                    Surface non renseignée
                                                @endif
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                                <div class="tile__content large">
                                    <div class="tile__pre-title">
                                        <span class="tile__date">Publié {{$ad->created_at_diff}}</span>
                                        @if(isset($ad->is_partner) && $ad->is_partner === 1 )
                                            <ul class="custom-tags">
                                                <li class="custom-tag warning">Partenaire Terre de Liens</li>
                                            </ul>
                                        @endif
                                    </div>
                                    <p class="tile__title">{{$ad->title ?? "Titre de l'annonce non renseigné"}}
                                    </p>
                                    <div class="tile__intro">
                                        @if(isset($ad->about_project_content))
                                            <p>{{ Illuminate\Support\Str::limit($ad->about_project_content, 200)}}</p>
                                        @else
                                            Pas de description renseignée pour cette annonce
                                        @endif
                                    </div>
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
    @include('components.partnering')
    @include('components.support-terre-liens')
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
@endsection
