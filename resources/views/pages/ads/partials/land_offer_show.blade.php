@section('title', $landOfferAd->landOfferAd->title)
<section class="section is-medium ">
	<div class="container ">
		<nav class="breadcrumb" aria-label="breadcrumbs">
			<ul>
				<li><a href="#">Annonces</a></li>
				<li><a href="#">Offres foncières</a></li>
			</ul>
		</nav>
		<h1 class="title has-text-link">{{$landOfferAd->landOfferAd->title}}</h1>
		<div class="columns">
			<div class=" column is-two-thirds ">
				<div id="ad_images" class="carousel">
					@foreach($landOfferAd->documents as $document)
						<div class="card">
							<div class="card-image">
								<figure class="image is-2by1">
									@if($document->path === "0")
										<img src="https://picsum.photos/480/320" alt="picsum">
									@else
										<img src="{{URL::asset($document->path)}}" alt="Placeholder image">
									@endif
								</figure>
							</div>
						</div>
					@endforeach
				</div>
			</div>
			<div class="column">
				<div class="card">
					<div class="card-content">
						<div class="content">
							<p><span class="is-size-5 is-capitalized has-text-black ">Publié le  : </span><span
										class="subtitle">{{ \Carbon\Carbon::parse($landOfferAd->created_at)->format('d/m/Y')}}</span>
							</p>
						</div>
						<div class="content">
							<p><span class="is-size-5 is-capitalized has-text-black">Catégorie : </span><span
										class="subtitle">Offre de foncier</span></p>
						</div>
						<div class="content">
							<span class="is-size-5 is-capitalized has-text-black">Localisation : </span>
							<p><span class="subtitle">{{$landOfferAd->cities->pluck('name')->implode(', ') }}</span></p>
							<p><span class="subtitle">{{$landOfferAd->departments->pluck('name')->implode(', ') }}</span></p>
							<p><span class="subtitle">{{$landOfferAd->regions->pluck('name')->implode(', ') }}</span></p>
						</div>
						<div class="content">
							@if($landOfferAd->landOfferAd->land->price)
								<p><span class="is-size-5  has-text-black">Prix ou loyer mensuel du foncier : </span>
									<span class="subtitle has-text-black">{{ number_format($landOfferAd->landOfferAd->land->price, 0, ",", " " )}} €</span>
								</p>
							@elseif($landOfferAd->landOfferAd->building->price)
								<p>
									<span class="is-size-5  has-text-black">Prix ou loyer mensuel du bâti : </span>
									<span class="subtitle has-text-black">{{number_format($landOfferAd->landOfferAd->building->price, 0, ",", " " )}}</span>
								</p>
							@elseif($landOfferAd->landOfferAd->house->price)
								<p><span class="is-size-5  has-text-black">Prix ou loyer mensuel de l'habitation : </span>
									<span class="subtitle has-text-black">{{number_format($landOfferAd->landOfferAd->house->price, 0, ",", " " )}}</span>
								</p>
							@endif
						</div>
					</div>
					<footer class="card-footer">
						<button class="card-footer-item button is-link">
								 <span class="icon is-small">
								<i class="fas fa-reply"></i>
								</span>
							<span> Répondre à l'annonce</span>
						</button>
						<button class="card-footer-item button is-link is-light">
							 <span class="icon is-small">
									<i class="fas fa-save"></i>
								</span>
							<span> Sauvegarder l'annonce</span>
						</button>
					</footer>
				</div>
			</div>
		</div>
		<hr class="navbar-divider">
		<h3 class="title is-3 has-text-centered">Caractéristiques du projet</h3>
		<div class="columns is-multiline is-mobile is-centered">

			<div class="column is-one-quarter ">
				<p class="has-text-link is-size-5 has-text-centered"> Transmission d’activité (ferme
					toujours en fonctionnement)</p>
				@if($landOfferAd->landOfferAd->is_activity_transfer === 1)
					<p class="has-text-centered">Oui</p>
				@else
					<p class="has-text-centered">Non</p>
				@endif
			</div>


			<div class="column is-one-quarter ">
				@if($landOfferAd->landOfferAd->is_activity_transfer === 1)
					<p class="has-text-link is-size-5 has-text-centered"> Système(s) de production en place </p>
					<p class="has-text-centered">
						<span>{{$landOfferAd->landOfferAd->productionGenres->pluck('name')->implode(', ') }}</span>
					</p>
				@else
					<p class="has-text-link is-size-5 has-text-centered"> Production(s) envisageable(s) </p>
					<p class="has-text-centered">
							<span>{{$landOfferAd->landOfferAd->productionGenres->pluck('name')->implode(', ') }}</span>
					</p>
				@endif
			</div>

			<div class="column is-one-quarter ">
				<p class="has-text-link is-size-5 has-text-centered"> Certification bio des terres</p>
				<p class="has-text-centered">
						<span>{{$landOfferAd->landOfferAd->bioCertifications->pluck('name')->implode(', ') }}</span>
				</p>
			</div>

			<div class="column is-one-quarter ">
				<p class="has-text-link is-size-5 has-text-centered"> Type d'appel à candidature(s)</p>
				<p class="has-text-centered">
					@if($landOfferAd->landOfferAd->is_call_for_application_community === 1)
						<span>Projet
						soutenu par une collectivité</span>
					@elseif($landOfferAd->landOfferAd->is_call_for_application_terre_de_liens === 1)
						<span>Projet
						pour une ferme Terre de Liens</span>
					@elseif($landOfferAd->landOfferAd->is_call_for_application_test_area === 1)
						<span>Projet Espace test agricole</span>
					@else
						<span>Le projet ne répond pas à un apple de candidature</span>
					@endif
				</p>
			</div>
			<div class="column is-one-quarter ">
				<p class="has-text-link is-size-5 has-text-centered"> Altitude (en m)</p>
				<p class="has-text-centered">{{$landOfferAd->landOfferAd->altitude}}</p>
			</div>
			<div class="column is-one-quarter ">
				<p class="has-text-link is-size-5 has-text-centered"> Accès à l'eau</p>
				<p class="has-text-centered">{{$landOfferAd->landOfferAd->water_access}}</p>
			</div>
		</div>

		<hr class="navbar-divider">
		<div class="content">
			<h3 class="title is-3 has-text-centered">Caractéristique du foncier</h3>
			<div class="columns is-multiline is-mobile is-centered">
				@if($landOfferAd->landOfferAd->building)
					<div class=" column is-one-thirds ">
						<h3 class="title is-5 has-text-centered">Bâti agricole</h3>
						@if($landOfferAd->landOfferAd->building->number)
							<p class="has-text-black">Nombre :
								<span>{{$landOfferAd->landOfferAd->building->number}}</span>
							</p>
						@endif
						@if($landOfferAd->landOfferAd->building->surface)
							<p class="has-text-black">Surface (en m²) :
								<span>{{$landOfferAd->landOfferAd->building->surface}}</span>
							</p>
						@endif
						@if($landOfferAd->landOfferAd->building->buildings)
							<p class="has-text-black">Type de cession :
								<span>{{$landOfferAd->landOfferAd->building->buildings->pluck('name')->implode(', ') }}</span>
							</p>
						@endif
						@if($landOfferAd->landOfferAd->building->price)
							<p class="has-text-black">Prix :
								<span class="has-text-weight-bold">{{number_format($landOfferAd->landOfferAd->building->price , 0, ",", " " )}} €</span>
							</p>
						@endif
					</div>
				@endif
				@if($landOfferAd->landOfferAd->house)
					<div class=" column is-one-thirds ">
						<h3 class="title is-5 has-text-centered">Habitation</h3>
						@if($landOfferAd->landOfferAd->house->number)
							<p class="has-text-black">Nombre :
								<span>{{$landOfferAd->landOfferAd->house->number}}</span>
							</p>
						@endif
						@if($landOfferAd->landOfferAd->house->surface)
							<p class="has-text-black">Surface (en m²) :
								<span>{{$landOfferAd->landOfferAd->house->surface}}</span>
							</p>
						@endif
						@if($landOfferAd->landOfferAd->house->houses)
							<p class="has-text-black">Type de cession :
								<span>{{$landOfferAd->landOfferAd->house->houses->pluck('name')->implode(', ') }}</span>
							</p>
						@endif
						@if($landOfferAd->landOfferAd->house->price)
							<p class="has-text-black">Prix :
								<span class="has-text-weight-bold">{{number_format($landOfferAd->landOfferAd->house->price, 0, ",", " " )}} €</span>
							</p>
						@endif
					</div>
				@endif
				@if($landOfferAd->landOfferAd->land)
					<div class=" column is-one-thirds ">
						<h3 class="title is-5 has-text-centered">Foncier agricole</h3>
						@if($landOfferAd->landOfferAd->land->area)
							<p class="has-text-black">Surface (en ha) :
								<span>{{$landOfferAd->landOfferAd->land->area}}</span>
							</p>
						@endif
						@if($landOfferAd->landOfferAd->land->lands)
							<p class="has-text-black">Type de cession :
								<span>{{$landOfferAd->landOfferAd->land->lands->pluck('name')->implode(', ') }}</span>
							</p>
						@endif
						@if($landOfferAd->landOfferAd->is_activity_transfer === 1 and  $landOfferAd->landOfferAd->land->land_availability)
							<p class="has-text-black">Disponibilité des terres à partir du :
								<span>{{ \Carbon\Carbon::parse($landOfferAd->landOfferAd->land->land_availibility)->format('d/m/Y')}}</span>
							</p>
						@elseif ($landOfferAd->landOfferAd->is_activity_transfer === 0 and  $landOfferAd->landOfferAd->land->land_transfer_deadline)
							<p class="has-text-black">Disponibilité des terres à partir du :
								<span>{{ \Carbon\Carbon::parse($landOfferAd->landOfferAd->land->land_availibility)->format('d/m/Y')}}</span>
							</p>
						@endif
						@if($landOfferAd->landOfferAd->land->price)
							<p class="has-text-black">Prix :
								<span class="has-text-weight-bold">{{number_format($landOfferAd->landOfferAd->land->price, 0, ",", " " )}} €</span>
							</p>
						@endif
					</div>
				@endif
			</div>
		</div>
		<div class="content">
			<h3 class="title is-3">Description du projet</h3>
			<p> {{$landOfferAd->about_project_content}}</p>
		</div>

		<div class="content">
			<h3 class="title is-3">A propos du porteur de projet</h3>
			<p> {{$landOfferAd->about_content}}</p>
		</div>

		<div class="content">
			<div class="columns is-mobile is-centered">
				<div class="column is-half">
					<div class="box has-background-white-ter ">
						<article class="media">
							<div class="media-content">
								<div class="content has-text-centered ">
									<p class="has-text-centered is-size-4">Vous souhaitez répondre à cette annonce
										?</p>
									<button class="button is-link  is-large">Répondre à l'annonce</button>
								</div>

							</div>
						</article>
					</div>
				</div>
			</div>
		</div>
	</div>

</section>
	@include('components.partnering')
	@include('components.support_terre_liens')

