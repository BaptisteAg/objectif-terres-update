@extends('default')

@section('title', 'Bienvenue sur Objectif Terres')

@section('head-script')
	<!-- Import Leaflet CSS Style Sheet -->
	<link rel="stylesheet" href="https://npmcdn.com/leaflet@1.0.0-rc.2/dist/leaflet.css"/>
	<!-- Import Leaflet JS Library -->
	<script src="https://npmcdn.com/leaflet@1.0.0-rc.2/dist/leaflet.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma-carousel@4.0.4/dist/css/bulma-carousel.min.css">
@endsection


@section('main-content')
	<div id="my_osm_widget_map"></div>
	<section class="section">
        <div class="container">
            <div class="has-text-centered ">
                <h2 class="title is-1 text_warning_orange">Dernières annonces foncières publiées</h2>
                <p>ASTUCE : <a href="{{url('/')}}">Créez votre compte gratuit</a> pour visualiser directement les annonces
                    de votre région !</p>
            </div>
            <div class="columns">
                @foreach ($ads as $ad)
                    <div class="column is-half tile tile_image">
                        <a href="{{route("ads.show", $ad->id)}}" class="tile__link card">
                                <div class="card-image vignette photo">
                                    <figure class="image vignette__image-wrap vignette__ratio_4-3">
                                        <img class="vignette__image" src="{{url('/images/vignette/photo_02_4-3_600.jpg')}}" alt="Placeholder image">
                                    </figure>

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
                    <button class="button is-link is-medium">Toutes les annonces foncières</button>
                </div>
            </div>
        </div>
	</section>
	<section class="section">
		<div class="has-text-centered">
			<h2 class="title is-1 text_warning_orange">Offres d'emploi les plus consultés</h2>
			<div class="columns is-centered">
				@for ($i = 0; $i < 3; $i++)
					<div class="column is-one-quarter">
						<div class="card">
							<div class="card-image">
								<figure class="image is-3by2">
									<img src="/images/placeholder-ad.png" alt="picsum">
								</figure>
							</div>
							<div class="card-content">
								<p class="title is-4">Titre annonce travail</p>
								<p class="subtitle is-6">Département ou région</p>
							</div>
						</div>
					</div>
				@endfor
			</div>
			<div class="columns is-centered">
				<div class="column is-half has-text-centered">
					<button class="button is-link">Toutes les offres d'emploi</button>
				</div>
			</div>
		</div>
	</section>
	<section class="section">
		<div class="container">
			<div class="columns">
				<div class="column is-one-third">
					<h3 class="title is-3 ">Mon projet agricole</h3>
					<p class="subtitle is-5 ">Donec ullamcorper nulla non metus auctor
						fringilla. Maecenas sed diam eget risus varius
						blandit sit amet non magna.</p>
					<p class="subtitle "><strong>Pour aller plus loin :</strong> Terre de Liens vous met à
						dispostion un Centre de Ressources donec
						ullamcorper nulla non metus auctor fringilla.</p>
				</div>
				@for ($i = 0; $i < 3; $i++)
					<div class="column has-text-centered">
						<div class="card">
							<div class="card-image">
								<figure class="image is-3by2">
									<img src="/images/placeholder-ad.png" alt="picsum">
								</figure>
							</div>
							<div class="card-content">
								<p class="title is-4">Titre de la card</p>
								<p class="subtitle is-6">Département ou région</p>
							</div>
						</div>
					</div>
				@endfor
			</div>
		</div>
	</section>

	@include('components.cardVideo')

	<section class="section">
		<div class="container has-text-centered ">
			<h2 class="title is-2 ">Ils ont réussi avec nous ! </h2>
		</div>
		<div class="container ">
			<div id="post_images" class="carousel">
				@for ($i = 0; $i < 4; $i++)
					<div class="column is-12 ">
						<div class="card">
							<div class="card-content">
								<div class="media">
									<div class="media-left">
										<figure class="image is-48x48">
											<img src="https://bulma.io/images/placeholders/96x96.png"
												 alt="Placeholder image">
										</figure>
									</div>
									<div class="media-content">
										<p class="title is-4">Jean-Pierre Delatoite</p>
										<p class="subtitle is-6">Paysan dans la Drôme</p>
									</div>
								</div>
								<div class="content">
									Avec Objectif Terre j'ai réussi à trouver
									la terre dont j'avais besoin pour aboutir
									ma reconversion dans l'agriculture bio et
									paysanne.
								</div>
							</div>
						</div>
					</div>
				@endfor
			</div>
		</div>
	</section>

	@include('components.faqAccordion')
	@include('components.study')
	@include('components.partnering')
	@include('components.support-terre-liens')

@endsection


@section('script')
	<script src="{{ asset('js/bulma-accordion.js') }}"></script>
	<script>let accordions = bulmaAccordion.attach();</script>

	<script src="{{ asset('js/bulma-carousel.js') }}"></script>
	<script>
        bulmaCarousel.attach('#post_images',
			{
            slidesToScroll: 1,
            slidesToShow: 2,
            loop: true,
            navigation: true,

        });
	</script>

	<script>
		var map = L.map('my_osm_widget_map', { /* use the same name as your <div id=""> */
			center: [46.290552, 2.771017], /* set GPS Coordinates */
			zoom: 5, /* define the zoom level */
			zoomControl: true, /* false = no zoom control buttons displayed */
			scrollWheelZoom: false /* false = scrolling zoom on the map is locked */
		});

		function setupLocationPolygon(polygonData, options, callback) {
			var polygon = L.geoJSON(polygonData.geojson, {
				smoothFactor: options.smoothFactor || 0,
				style: {
					color: '#b34818'
				}
			});

			polygon.addTo(map);

			polygon.bindTooltip(polygonData.ads_count.toString(),
					{permanent: true, direction: "center", className: 'leaflet-tooltip '+options.className}
			).openTooltip();

			polygon.addEventListener('mouseover', _ => {
				polygon._tooltip._contentNode.classList.add('leaflet-tooltip-mouseover')
			});
			polygon.addEventListener('mouseout', _ => {
				polygon._tooltip._contentNode.classList.remove('leaflet-tooltip-mouseover')
			});

			if(_.isFunction(callback)) {
				callback(polygon);
			}

			return polygon
		}

		function enableRegions(form, callback) {
			var formData = new FormData(form);
			formData.append('_token', "{{ csrf_token() }}");

			fetch('/locations/polygon/regions', {
				headers: headers,
				method: 'POST',
				body: formData
			})
			.then(response => response.json())
			.then(regionsPolygonData => {
				callback(regionsPolygonData);

				regionsPolygonData.forEach(polygonData => {
					setupLocationPolygon(polygonData, {
						smoothFactor : 2
					}, function (polygon) {
						polygon.addEventListener('click', _ => {
							location.href = "/recherche?offer_type="+
									formData.get('offer_type')+
									"&ad_category="+
									formData.get('ad_category')+
									'&regions_location_researches_ids[]='+polygonData.region_id;
						});

					})
				})
			})
		}

        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWlja2l3YXkiLCJhIjoiY2s0YmE0NHZqMDZrejNrcGlxeWJmNHRtdCJ9.In4xuZz8wYnXmDX5jrrhCg', { /* set your personal MapBox Access Token */
            maxZoom: 18, /* zoom limit of the map */
            id: 'mapbox.satellite' /* mapbox.light / dark / streets / outdoors / satellite */
        }).addTo(map);

		var headers = new Headers();
		headers.append('pragma', 'no-cache');
		headers.append('cache-control', 'no-cache');

		fetch('/locations/polygon/france', {
			headers: headers,
			method: 'GET',
		})
		.then(response => response.json())
		.then(francePolygonData => {
			var francePolygon = setupLocationPolygon(francePolygonData, {
				className: "leaflet-tooltip-big",
				smoothFactor : 2
			});

			var popup = L.popup({
				closeOnClick: false,
				autoClose: false,
				direction: top,
				maxWidth : 560
			}).setContent(`
				<form id="leaflet-preform" action="/recherche">
					<div class="select form-field">
						<select name="offer_type">
							<option value="OfferAd">Je cherche</option>
							<option value="SeekAd">Je propose</option>
						</select>
					</div>
					<div class="select form-field">
						<select name="ad_category">
							<option value="land">une terre</option>
							<option value="job">un emploi</option>
						</select>
					</div>
					<button class="button is-normal basic primary">ok</button>
				</form>
			`);
			francePolygon.bindPopup(popup).openPopup();

			var form = document.getElementById("leaflet-preform");

			form.addEventListener('submit', function (event) {
				event.preventDefault();

				form.querySelector('button').innerHTML = '<i class="fa fa-spinner fa-spin" style="font-size:25px;margin-top:8px;"></i>';

				enableRegions(form, function (regionsPolygonData) {
					if(!regionsPolygonData.length) {
						alert("Désolé, il n'y a pas d'annonce de ce type pour l'instant.");
						form.querySelector('button').innerHTML = "ok";
						return;
					}

					map.removeLayer(francePolygon);
				})
			})
		});


	</script>

@endsection
