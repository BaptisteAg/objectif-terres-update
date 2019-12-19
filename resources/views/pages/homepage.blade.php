@extends('default')


@section('title', 'Bienvenue sur Objectif Terres')
@section('head-script')
	<!-- Import Leaflet CSS Style Sheet -->
	<link rel="stylesheet" href="https://npmcdn.com/leaflet@1.0.0-rc.2/dist/leaflet.css" />
	<!-- Import Leaflet JS Library -->
	<script src="https://npmcdn.com/leaflet@1.0.0-rc.2/dist/leaflet.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma-carousel@4.0.4/dist/css/bulma-carousel.min.css">
@endsection


@section('main-content')
	<div id="my_osm_widget_map"></div>
	<section class="section is-medium">
		<div class="has-text-centered">
			<h2 class="title is-1">Dernières annonces foncières publiées</h2>
			<p>ASTUCE : Créez votre compte gratuit pour visualiser directement les annonces de votre région !</p>
		</div>
		<div class="columns">
			@for ($i = 0; $i < 2; $i++)
				<div class="column is-half ">
					<div class="card">
						<div class="card-image">
							<figure class="image is-4by3">
								<img src="https://picsum.photos/900/660" alt="Placeholder image">
							</figure>
						</div>
						<div class="card-content has-text-centered">
							<div class="media">
								<div class="media-content has-text-centered">
									<p class="title is-4">Titre annonce #{{$i+1}}</p>
								</div>
							</div>
							<div class="content">
								Lorem ipsum dolor sit amet, consectetur adipiscing elit.
								Phasellus nec iaculis mauris.
							</div>
							<button class="button is-link">Voir l'annonce</button>
						</div>
					</div>
				</div>
			@endfor
		</div>
			<div class="columns is-centered">
				<div class="column is-half has-text-centered">
					<button class="button is-link">Toutes les annonces foncières</button>
				</div>
			</div>
	</section>
	<section class="section">
		<div class="has-text-centered">
			<h2 class="title is-1">Offres d'emploi les plus consultés</h2>
			<div class="columns is-centered">
				@for ($i = 0; $i < 3; $i++)
				<div class="column is-one-quarter">
					<div class="card">
						<div class="card-image">
							<figure class="image is-4by3">
								<img src="https://picsum.photos/200/300" alt="Placeholder image">
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
					<h3 class="title is-3 is-spaced">Mon projet agricole</h3>
					<p class="subtitle is-5 is-spaced">Donec ullamcorper nulla non metus auctor
						fringilla. Maecenas sed diam eget risus varius
						blandit sit amet non magna.</p>
					<p class="subtitle is-spaced"><strong>Pour aller plus loin :</strong> Terre de Liens vous met à
						dispostion un Centre de Ressources donec
						ullamcorper nulla non metus auctor fringilla.</p>
				</div>
					@for ($i = 0; $i < 3; $i++)
						<div class="column has-text-centered">
							<div class="card">
								<div class="card-image">
									<figure class="image is-4by3">
										<img src="https://picsum.photos/200/300" alt="Placeholder image">
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
	@include('components.support_terre_liens')
@endsection


@section('script')

	<script>
		let mymap = L.map('my_osm_widget_map', { /* use the same name as your <div id=""> */
			center: [46.290552, 2.771017], /* set GPS Coordinates */
            zoom: 5, /* define the zoom level */
            zoomControl: false, /* false = no zoom control buttons displayed */
            scrollWheelZoom: false /* false = scrolling zoom on the map is locked */
        });

        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWlja2l3YXkiLCJhIjoiY2s0YmE0NHZqMDZrejNrcGlxeWJmNHRtdCJ9.In4xuZz8wYnXmDX5jrrhCg', { /* set your personal MapBox Access Token */
            maxZoom: 20, /* zoom limit of the map */
            id: 'mapbox.light' /* mapbox.light / dark / streets / outdoors / satellite */
        }).addTo(mymap);

        L.marker([46.290552, 2.771017]).addTo(mymap); /* set your location's GPS Coordinates : [LAT,LON] */


	</script>
@endsection