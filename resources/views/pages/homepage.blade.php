@extends('default')

@section('title', 'Bienvenue sur Objectif Terres')

@section('head-script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma-carousel@4.0.4/dist/css/bulma-carousel.min.css">
    <!-- Import Leaflet CSS Style Sheet -->
    <link rel="stylesheet" href="https://npmcdn.com/leaflet@1.0.0-rc.2/dist/leaflet.css"/>
@endsection


@section('main-content')
    <div id="global-map"></div>
    <section class="section">
        <div class="container">
            <div class="has-text-centered ">
                <h2 class="title is-1 text_warning_orange">Dernières annonces publiées</h2>
                <p>ASTUCE :
                    <a href="{{url('/')}}">Créez votre compte gratuit</a>
                    pour visualiser directement les annonces
                    de votre région !
                </p>
            </div>
            <div class="columns">
                @foreach ($ads as $ad)
                    <div class="column is-half tile tile_image">
                        <a href="{{route("ads.show", $ad->id)}}" class="tile__link card">
                            <div class="card-image vignette photo">
                                <figure class="image vignette__image-wrap vignette__ratio_4-3">
                                    <img class="vignette__image" src="{{url('/images/vignette/photo_02_4-3_600.jpg')}}"
                                         alt="Placeholder image">
                                </figure>
                                <ul class="custom-tags custom-list custom-list_v">
                                    <li class="custom-tag success">
                                        <i class="fas fa-map-marker-alt"></i>
                                        @if (is_null($ad->citiesList) and is_null($ad->departmentsList) and is_null($ad->regionsList)   )
                                            Non renseignée
                                        @else
                                            {{$ad->citiesList ?? ""}}
                                            {{$ad->departmentsList ?? ""}}
                                            {{$ad->regionsList ?? ""}}
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
                            <div class="card-content has-text-centered tile__container">
                                <div class="content text_danger_orange tile__content">
                                    <h4 class="title is-4 tile__title">{{$ad->title}}</h4>
                                    <div class="tile__intro">
                                        <p>{{ \Illuminate\Support\Str::limit($ad->about_project_content, 200, $end='...') }}</p>
                                    </div>
                                    <p class="button-wrap">
                                        <span class="button round small warning read-more">
                                            <span class="button__icon">
                                                <i class="fas fa-arrow-right" aria-hidden="true"></i>
                                            </span>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="columns is-centered">
                <div class="column is-half has-text-centered">
                    <button class="button is-link is-medium basic secondary">
                        <span class="button__icon"><i class="fas fa-plus" aria-hidden="true"></i></span>

                        <span class="button__label">Toutes les annonces</span>
                    </button>
                </div>
            </div>
        </div>
    </section>
    <section class="section bg-l-pearl bg-trame_champs_light">
        <div class="container">
            <div class="has-text-centered ">
                <h2 class="title is-1 text_warning_orange">Annonce à la Une</h2>
                <p>ASTUCE :
                    <a href="{{url('/')}}">Créez votre compte gratuit</a>
                    pour visualiser directement les annonces
                    de votre région !
                </p>
            </div>
            <div class="columns">
                @foreach ($ads as $ad)
                    <div class="column is-half tile tile_image">
                        <a href="{{route("ads.show", $ad->id)}}" class="tile__link card">
                            <div class="card-image vignette photo">
                                <figure class="image vignette__image-wrap vignette__ratio_4-3">
                                    <img class="vignette__image" src="{{url('/images/vignette/photo_02_4-3_600.jpg')}}"
                                         alt="Placeholder image">
                                </figure>
                                <ul class="custom-tags custom-list custom-list_v">
                                    <li class="custom-tag success">
                                        <i class="fas fa-map-marker-alt"></i>
                                        @if (is_null($ad->citiesList) and is_null($ad->departmentsList) and is_null($ad->regionsList)   )
                                            Non renseignée
                                        @else
                                            {{$ad->citiesList ?? ""}}
                                            {{$ad->departmentsList ?? ""}}
                                            {{$ad->regionsList ?? ""}}
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
                            <div class="card-content has-text-centered tile__container">
                                <div class="content text_danger_orange tile__content">
                                    <h4 class="title is-4 tile__title">{{$ad->title}}</h4>
                                    <div class="tile__intro">
                                        <p>{{ \Illuminate\Support\Str::limit($ad->about_project_content, 200, $end='...') }}</p>
                                    </div>
                                    <p class="button-wrap">
                                        <span class="button round small warning read-more">
                                            <span class="button__icon">
                                                <i class="fas fa-arrow-right" aria-hidden="true"></i>
                                            </span>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="columns is-centered">
                <div class="column is-half has-text-centered">
                    <button class="button is-link is-medium basic secondary">
                        <span class="button__icon"><i class="fas fa-plus" aria-hidden="true"></i></span>

                        <span class="button__label">Toutes les annonces</span>
                    </button>
                </div>
            </div>
        </div>
    </section>
    {{--	<section class="section">--}}
    {{--		<div class="has-text-centered">--}}
    {{--			<h2 class="title is-1 text_warning_orange">Offres d'emploi les plus consultés</h2>--}}
    {{--			<div class="columns is-centered">--}}
    {{--				@for ($i = 0; $i < 3; $i++)--}}
    {{--					<div class="column is-one-quarter">--}}
    {{--						<div class="card">--}}
    {{--							<div class="card-image">--}}
    {{--								<figure class="image is-3by2">--}}
    {{--									<img src="/images/placeholder-ad.png" alt="picsum">--}}
    {{--								</figure>--}}
    {{--							</div>--}}
    {{--							<div class="card-content">--}}
    {{--								<p class="title is-4">Titre annonce travail</p>--}}
    {{--								<p class="subtitle is-6">Département ou région</p>--}}
    {{--							</div>--}}
    {{--						</div>--}}
    {{--					</div>--}}
    {{--				@endfor--}}
    {{--			</div>--}}
    {{--			<div class="columns is-centered">--}}
    {{--				<div class="column is-half has-text-centered">--}}
    {{--					<button class="button is-link">Toutes les offres d'emploi</button>--}}
    {{--				</div>--}}
    {{--			</div>--}}
    {{--		</div>--}}
    {{--	</section>--}}
    {{--	<section class="section">--}}
    {{--		<div class="container">--}}
    {{--			<div class="columns">--}}
    {{--				<div class="column is-one-third">--}}
    {{--					<h3 class="title is-3 ">Mon projet agricole</h3>--}}
    {{--					<p class="subtitle is-5 ">Donec ullamcorper nulla non metus auctor--}}
    {{--						fringilla. Maecenas sed diam eget risus varius--}}
    {{--						blandit sit amet non magna.</p>--}}
    {{--					<p class="subtitle "><strong>Pour aller plus loin :</strong> Terre de Liens vous met à--}}
    {{--						dispostion un Centre de Ressources donec--}}
    {{--						ullamcorper nulla non metus auctor fringilla.</p>--}}
    {{--				</div>--}}
    {{--				@for ($i = 0; $i < 3; $i++)--}}
    {{--					<div class="column has-text-centered">--}}
    {{--						<div class="card">--}}
    {{--							<div class="card-image">--}}
    {{--								<figure class="image is-3by2">--}}
    {{--									<img src="/images/placeholder-ad.png" alt="picsum">--}}
    {{--								</figure>--}}
    {{--							</div>--}}
    {{--							<div class="card-content">--}}
    {{--								<p class="title is-4">Titre de la card</p>--}}
    {{--								<p class="subtitle is-6">Département ou région</p>--}}
    {{--							</div>--}}
    {{--						</div>--}}
    {{--					</div>--}}
    {{--				@endfor--}}
    {{--			</div>--}}
    {{--		</div>--}}
    {{--	</section>--}}

    {{--	@include('components.cardVideo')--}}

    {{--    <section class="hero has_margin">--}}
    {{--        <div class="hero-body block-video">--}}
    {{--            @include('components.video')--}}
    {{--        </div>--}}
    {{--    </section>--}}

    {{--	<section class="section">--}}
    {{--		<div class="container has-text-centered ">--}}
    {{--			<h2 class="title is-2 ">Ils ont réussi avec nous ! </h2>--}}
    {{--		</div>--}}
    {{--		<div class="container ">--}}
    {{--			<div id="post_images" class="carousel">--}}
    {{--				@for ($i = 0; $i < 4; $i++)--}}
    {{--					<div class="column is-12 ">--}}
    {{--						<div class="card">--}}
    {{--							<div class="card-content">--}}
    {{--								<div class="media">--}}
    {{--									<div class="media-left">--}}
    {{--										<figure class="image is-48x48">--}}
    {{--											<img src="https://bulma.io/images/placeholders/96x96.png"--}}
    {{--												 alt="Placeholder image">--}}
    {{--										</figure>--}}
    {{--									</div>--}}
    {{--									<div class="media-content">--}}
    {{--										<p class="title is-4">Jean-Pierre Delatoite</p>--}}
    {{--										<p class="subtitle is-6">Paysan dans la Drôme</p>--}}
    {{--									</div>--}}
    {{--								</div>--}}
    {{--								<div class="content">--}}
    {{--									Avec Objectif Terre j'ai réussi à trouver--}}
    {{--									la terre dont j'avais besoin pour aboutir--}}
    {{--									ma reconversion dans l'agriculture bio et--}}
    {{--									paysanne.--}}
    {{--								</div>--}}
    {{--							</div>--}}
    {{--						</div>--}}
    {{--					</div>--}}
    {{--				@endfor--}}
    {{--			</div>--}}
    {{--		</div>--}}
    {{--	</section>--}}

    @include('components.faqAccordion')

    <div id="vue-rss">
        @include('components.rssNews')
    </div>

    @include('components.partnering')
    @include('components.support-terre-liens')

@endsection

@section('script')
    <script src="{{ asset('js/bulma-accordion.js') }}"></script>
    <script>let accordions = bulmaAccordion.attach();</script>

    <script src="{{ asset('js/bulma-carousel.js') }}"></script>
    <script>
        bulmaCarousel.attach('#post_images', {
            slidesToScroll: 1,
            slidesToShow: 2,
            loop: true,
            navigation: true,
        });

        new Vue({
            el: '#vue-rss',
            data: {
                ready: true
            }
        });

    </script>

    <script defer>
        homepageMapInit('global-map');
    </script>

@endsection
