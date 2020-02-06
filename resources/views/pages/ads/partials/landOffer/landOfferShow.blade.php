@section('title', $ad->landOfferAd->title)
<section class="section is-medium ">
	<div class="container ">
		<nav class="breadcrumb" aria-label="breadcrumbs">
			<ul>
				<li><a href="#">Annonces</a></li>
				<li><a href="#">Offres foncières</a></li>
			</ul>
		</nav>
		<h1 class="title has-text-link">{{$ad->landOfferAd->title}}</h1>
		<div class="columns">
			<div id="slider-container" class="column is-two-thirds ">
				<div id="ad-images" class="carousel ">
					@if(count($ad->documents) <= 0)
						<div id="test" class="card carousel-item ad-carousel ">
							<div class="card-image">
								<figure class="image is-2by1">
									<img src="https://picsum.photos/480/320" alt="picsum">
								</figure>
							</div>
						</div>
						<div class="card carousel-item  ad-carousel">
							<div class="card-image">
								<figure class="image is-2by1">
									<img src="https://picsum.photos/480/320" alt="picsum">
								</figure>
							</div>
						</div>
					@else
						@foreach($ad->documents as $document)
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
					@endif
				</div>
			</div>
			<div class="column">
				<div class="card">
					<div class="card-content">
						<div class="content">
							<p><span class="is-size-5 is-capitalized has-text-black ">Publié le  : </span><span
										class="subtitle">{{ $ad->created_at}}</span>
							</p>
						</div>
						<div class="content">
							<p><span class="is-size-5 is-capitalized has-text-black">Catégorie : </span><span
										class="subtitle">Offre de foncier</span></p>
						</div>
						<div class="content">
							<span class="is-size-5 is-capitalized has-text-black">Localisation(s) : </span>
							<p><span class="is-size-6 is-italic">Commune(s) :</span><span
										class="subtitle">{{$ad->cities->pluck('name')->implode(', ') }}</span></p>
							<p><span class="is-size-6 is-italic">Département(s) :</span><span
										class="subtitle">{{$ad->departments->pluck('name')->implode(', ') }}</span></p>
							<p><span class="is-size-6 is-italic">Région(s) :</span><span
										class="subtitle">{{$ad->regions->pluck('name')->implode(', ') }}</span></p>
						</div>
						<div class="content">
							@if($ad->landOfferAd->land->price)
								<p><span class="is-size-5  has-text-black">Prix ou loyer mensuel du foncier : </span>
									<span class="subtitle has-text-black">{{ number_format($ad->landOfferAd->land->price, 0, ",", " " )}} €</span>
								</p>
							@elseif($ad->landOfferAd->building->price)
								<p>
									<span class="is-size-5  has-text-black">Prix ou loyer mensuel du bâti : </span>
									<span
											class="subtitle has-text-black">{{number_format($ad->landOfferAd->building->price, 0, ",", " " )}}</span>
								</p>
							@elseif($ad->landOfferAd->house->price)
								<p><span
											class="is-size-5  has-text-black">Prix ou loyer mensuel de l'habitation : </span>
									<span
											class="subtitle has-text-black">{{number_format($ad->landOfferAd->house->price, 0, ",", " " )}}</span>
								</p>
							@endif
						</div>
					</div>
					@if( $ad->user_pp_id !== auth()->user()->id)
						<footer class="card-footer">
							<button id="open-modal-message" type="button" class="card-footer-item button is-link">
								 <span class="icon is-small">
								<i class="fas fa-reply"></i>
								</span>
								<span> Répondre à l'annonce</span>
							</button>
							{!! Form::open(['route'=>'favoriteAds.create', 'method'=>'get']) !!}
							<input name="ad_id" value="{{$ad->id}}" type="hidden">
							<button class="card-footer-item button is-link is-light">
							 <span class="icon is-small">
								<i class="fas fa-star"></i>
								</span>
								<span> Mettre cette annonce en favoris</span>
							</button>
							{!! Form::close() !!}
						</footer>
					@endif
				</div>
			</div>
		</div>


		@include('pages.ads.partials.adMessageModal')

		<hr class="navbar-divider">
		<h3 class="title is-3 has-text-centered">Caractéristiques du projet</h3>
		<div class="columns is-multiline is-mobile is-centered">

			<div class="column is-one-quarter ">
				<p class="has-text-link is-size-5 has-text-centered"> Transmission d’activité (ferme
					toujours en fonctionnement)</p>
				@if($ad->landOfferAd->is_activity_transfer === 1)
					<p class="has-text-centered">Oui</p>
				@else
					<p class="has-text-centered">Non</p>
				@endif
			</div>


			<div class="column is-one-quarter ">
				@if($ad->landOfferAd->is_activity_transfer === 1)
					<p class="has-text-link is-size-5 has-text-centered"> Système(s) de production en place </p>
					<p class="has-text-centered">
						<span>{{$ad->landOfferAd->productionGenres->pluck('name')->implode(', ') }}</span>
					</p>
				@else
					<p class="has-text-link is-size-5 has-text-centered"> Production(s) envisageable(s) </p>
					<p class="has-text-centered">
						<span>{{$ad->landOfferAd->productionGenres->pluck('name')->implode(', ') }}</span>
					</p>
				@endif
			</div>

			<div class="column is-one-quarter ">
				<p class="has-text-link is-size-5 has-text-centered"> Certification bio des terres</p>
				<p class="has-text-centered">
					<span>{{$ad->landOfferAd->bioCertifications->pluck('name')->implode(', ') }}</span>
				</p>
			</div>

			<div class="column is-one-quarter ">
				<p class="has-text-link is-size-5 has-text-centered"> Type d'appel à candidature(s)</p>
				<p class="has-text-centered">
					@if($ad->landOfferAd->is_call_for_application_community === 1)
						<span>Projet
						soutenu par une collectivité</span>
					@elseif($ad->landOfferAd->is_call_for_application_terre_de_liens === 1)
						<span>Projet
						pour une ferme Terre de Liens</span>
					@elseif($ad->landOfferAd->is_call_for_application_test_area === 1)
						<span>Projet Espace test agricole</span>
					@else
						<span>Le projet ne répond pas à un apple de candidature</span>
					@endif
				</p>
			</div>
			<div class="column is-one-quarter ">
				<p class="has-text-link is-size-5 has-text-centered"> Altitude (en m)</p>
				<p class="has-text-centered">{{$ad->landOfferAd->altitude}}</p>
			</div>
			<div class="column is-one-quarter ">
				<p class="has-text-link is-size-5 has-text-centered"> Accès à l'eau</p>
				<p class="has-text-centered">{{$ad->landOfferAd->water_access}}</p>
			</div>
		</div>

		<hr class="navbar-divider">
		<div class="content">
			<h3 class="title is-3 has-text-centered">Caractéristique du foncier</h3>
			<div class="columns is-multiline is-mobile is-centered">
				@if($ad->landOfferAd->building)
					<div class=" column is-one-thirds ">
						<h3 class="title is-5 has-text-centered">Bâti agricole</h3>
						@if($ad->landOfferAd->building->number)
							<p class="has-text-black">Nombre :
								<span>{{$ad->landOfferAd->building->number}}</span>
							</p>
						@endif
						@if($ad->landOfferAd->building->surface)
							<p class="has-text-black">Surface (en m²) :
								<span>{{$ad->landOfferAd->building->surface}}</span>
							</p>
						@endif
						@if($ad->landOfferAd->building->buildings)
							<p class="has-text-black">Type de cession :
								<span>{{$ad->landOfferAd->building->buildings->pluck('name')->implode(', ') }}</span>
							</p>
						@endif
						@if($ad->landOfferAd->building->price)
							<p class="has-text-black">Prix :
								<span class="has-text-weight-bold">{{number_format($ad->landOfferAd->building->price , 0, ",", " " )}} €</span>
							</p>
						@endif
					</div>
				@endif
				@if($ad->landOfferAd->house)
					<div class=" column is-one-thirds ">
						<h3 class="title is-5 has-text-centered">Habitation</h3>
						@if($ad->landOfferAd->house->number)
							<p class="has-text-black">Nombre :
								<span>{{$ad->landOfferAd->house->number}}</span>
							</p>
						@endif
						@if($ad->landOfferAd->house->surface)
							<p class="has-text-black">Surface (en m²) :
								<span>{{$ad->landOfferAd->house->surface}}</span>
							</p>
						@endif
						@if($ad->landOfferAd->house->houses)
							<p class="has-text-black">Type de cession :
								<span>{{$ad->landOfferAd->house->houses->pluck('name')->implode(', ') }}</span>
							</p>
						@endif
						@if($ad->landOfferAd->house->price)
							<p class="has-text-black">Prix :
								<span class="has-text-weight-bold">{{number_format($ad->landOfferAd->house->price, 0, ",", " " )}} €</span>
							</p>
						@endif
					</div>
				@endif
				@if($ad->landOfferAd->land)
					<div class=" column is-one-thirds ">
						<h3 class="title is-5 has-text-centered">Foncier agricole</h3>
						@if($ad->landOfferAd->land->area)
							<p class="has-text-black">Surface (en ha) :
								<span>{{$ad->landOfferAd->land->area}}</span>
							</p>
						@endif
						@if($ad->landOfferAd->land->lands)
							<p class="has-text-black">Type de cession :
								<span>{{$ad->landOfferAd->land->lands->pluck('name')->implode(', ') }}</span>
							</p>
						@endif
						@if($ad->landOfferAd->is_activity_transfer === 1 and  $ad->landOfferAd->land->land_availability)
							<p class="has-text-black">Disponibilité des terres à partir du :
								<span>{{ \Carbon\Carbon::parse($ad->landOfferAd->land->land_availibility)->format('d/m/Y')}}</span>
							</p>
						@elseif ($ad->landOfferAd->is_activity_transfer === 0 and  $ad->landOfferAd->land->land_transfer_deadline)
							<p class="has-text-black">Disponibilité des terres à partir du :
								<span>{{ \Carbon\Carbon::parse($ad->landOfferAd->land->land_availibility)->format('d/m/Y')}}</span>
							</p>
						@endif
						@if($ad->landOfferAd->land->price)
							<p class="has-text-black">Prix :
								<span class="has-text-weight-bold">{{number_format($ad->landOfferAd->land->price, 0, ",", " " )}} €</span>
							</p>
						@endif
					</div>
				@endif
			</div>
		</div>
		<div class="content">
			<h3 class="title is-3">Description du projet</h3>
			<p> {{$ad->about_project_content}}</p>
		</div>
		<div class="content">
			<h3 class="title is-3">A propos du porteur de projet</h3>
			<p> {{$ad->about_content}}</p>
		</div>
		@if( $ad->user_pp_id !== auth()->user()->id)
			<div class="content">
				<div class="columns is-mobile is-centered">
					<div class="column is-half">
						<div class="box has-background-white-ter ">
							<article class="media">
								<div class="media-content">
									<div class="content has-text-centered ">
										<p class="has-text-centered is-size-4">Vous souhaitez répondre à cette annonce
											?</p>
										<button id="open-modal-message" class="button is-link  is-large">
									 	<span class="icon is-small">
										<i class="fas fa-reply"></i>
										</span>
											<span> Répondre à l'annonce</span>
										</button>
									</div>

								</div>
							</article>
						</div>
					</div>
				</div>
			</div>
		@endif
	</div>

</section>

@include('components.partnering')
@include('components.supportTerreLiens')
