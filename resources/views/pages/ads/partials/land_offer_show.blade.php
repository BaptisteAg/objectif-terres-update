<h1 class="title has-text-link">Offre foncière</h1>
<section class="section is-medium ">
	<div class="container ">
		<nav class="breadcrumb" aria-label="breadcrumbs">
			<ul>
				<li><a href="#">Annonces</a></li>
				<li><a href="#">Offre foncières</a></li>
			</ul>
		</nav>
		<h1 class="title has-text-link">{{$landOfferAd->landOfferAd->title}}</h1>
		<div class="columns">
			<div class=" column is-two-thirds ">
				<div class="card">
					<div class="card-image">
						<figure class="image is-2by1">
							<img src="https://picsum.photos/480/320" alt="Placeholder image">
						</figure>
					</div>
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
							<p><span class="is-size-5 is-capitalized has-text-black">Région(s) : </span>
								@foreach ($landOfferAd->regions as $adRegion)
									<span class="subtitle">
										{{$adRegion->name}}
									</span>
								@endforeach
							</p>
						</div>
						<div class="content">
							{{dd($landOfferAd->landOfferAd->building->price)}}


							@if($landOfferAd->landOfferAd->land->price)
								<p><span class="is-size-4 is-capitalized has-text-black">Prix ou loyer mensuel du foncier : </span>
									<span class="subtitle has-text-black">{{$landOfferAd->landOfferAd->land->price}} €</span>
								</p>
							@elseif($landOfferAd->landOfferAd->building->price)
								<p>
									<span class="is-size-4 is-capitalized has-text-black">Prix ou loyer mensuel du bâti : </span>
									<span class="subtitle has-text-black">{{$landOfferAd->landOfferAd->building->price}}</span>
								</p>
							@elseif($landOfferAd->landOfferAd->house->price)
								<p><span class="is-size-4 is-capitalized has-text-black">Prix ou loyer mensuel de l'habitation : </span>
									<span class="subtitle has-text-black">{{$landOfferAd->landOfferAd->house->price}}</span>
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
				<p class="has-text-link is-size-5 has-text-centered"> Type d'installation souhaité</p>
				<p class="has-text-centered">{{$landOfferAd->landOfferAd->installationType->name}}</p>
			</div>

			<div class="column is-one-quarter ">
				<p class="has-text-link is-size-5 has-text-centered"> Accès au foncier souhaité </p>
				<p class="has-text-centered">{{$landOfferAd->landOfferAd->offerGenre->name}}</p>
			</div>

			<div class="column is-one-quarter ">
				<p class="has-text-link is-size-5 has-text-centered"> Souhaite s'installer en bio</p>

				@if ($landOfferAd->landOfferAd->is_bio === 1)
					<p class="has-text-centered">Oui</p>
				@elseif ($landOfferAd->landOfferAd->is_bio === 0)
					<p class="has-text-centered">Non</p>
				@else
					<p class="has-text-centered">Ne sais pas</p>
				@endif
			</div>

			<div class="column is-one-quarter ">
				<p class="has-text-link is-size-5 has-text-centered"> Surface(s) recherchée(s)(en ha)</p>
				@foreach ($landOfferAd->landOfferAd->surfaceRanges as $surfaceRangeSeek)
					@if($surfaceRangeSeek->surface !== '')
						<p class="has-text-centered">{{$surfaceRangeSeek->surface}}</p>
					@else
						<p class="has-text-centered">Non renseigné</p>
					@endif
				@endforeach
			</div>
			<div class="column is-one-quarter ">
				<p class="has-text-link is-size-5 has-text-centered"> Production(s) envisagée(s)</p>
				@foreach ($landOfferAd->landOfferAd->productionGenres as $productionGenresSeek)
					@if($productionGenresSeek->name !== '')
						<p class="has-text-centered">{{$productionGenresSeek->name}}</p>
					@else
						<p class="has-text-centered">-</p>
					@endif
				@endforeach
			</div>

			<div class="column is-one-quarter ">
				<p class="has-text-link is-size-5 has-text-centered">Habitation(s) et bâti(s) recherché(s)</p>

				@if($landOfferAd->landOfferAd->has_farm_buildings === 1)
					<p class="has-text-centered">Avec des bâtis agricoles existants</p>
				@else
					<p class="has-text-centered">Sans bâtis agricoles existants</p>
				@endif
				@if($landOfferAd->landOfferAd->has_houses === 1)
					<p class="has-text-centered">Avec une maison d’habitation existante</p>
				@else
					<p class="has-text-centered">Sans maison d’habitation existante</p>
				@endif
			</div>

		</div>

		<hr class="navbar-divider">
		<div class="content">
			<h3 class="title is-3">Description du projet</h3>
			<p> {{$landOfferAd->about_project_content}}</p>
		</div>

		<div class="content">
			<h3 class="title is-3">A propos du porteur de projet</h3>
			<p> {{$landOfferAd->about_content}}</p>
		</div>

		@if($landOfferAd->landOfferAd->experience_farming)
			<div class="content">
				<h3 class="title is-3">Expérience du porteur de projet dans le domaine agricole</h3>
				<p> {{$landOfferAd->landOfferAd->experience_farming}}</p>
			</div>
		@endif
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


	@include('components.partnering')
	@include('components.support_terre_liens')

</section>