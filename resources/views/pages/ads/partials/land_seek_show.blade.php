@section('title', $landSeekAd->landSeekAd->title)

<section class="section is-medium ">
	<div class="container ">
		<nav class="breadcrumb" aria-label="breadcrumbs">
			<ul>
				<li><a href="#">Annonces</a></li>
				<li><a href="#">Recherches foncières</a></li>
			</ul>
		</nav>
		<h1 class="title has-text-link">{{$landSeekAd->landSeekAd->title}}</h1>
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
										<img src="{{$document->path}}" alt="Placeholder image">
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
										class="subtitle">{{ \Carbon\Carbon::parse($landSeekAd->created_at)->format('d/m/Y')}}</span>
							</p>
						</div>
						<div class="content">
							<p><span class="is-size-5 is-capitalized has-text-black">Catégorie : </span><span
										class="subtitle">Recherche de foncier</span></p>

						</div>
						<div class="content">
							<span class="is-size-5 is-capitalized has-text-black">Localisation(s) : </span>
							<p><span class="subtitle">{{$landSeekAd->cities->pluck('name')->implode(', ') }}</span></p>
							<p><span class="subtitle">{{$landSeekAd->departments->pluck('name')->implode(', ') }}</span></p>
							<p><span class="subtitle">{{$landSeekAd->regions->pluck('name')->implode(', ') }}</span></p>

						</div>
						<div class="content">
							<p><span class="is-size-4  has-text-black">Prix recherché : </span>
								<span class="subtitle has-text-black">{{$landSeekAd->landSeekAd->priceRanges->pluck('price')->implode(', ') }}</span>
							</p>
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
				<p class="has-text-centered">{{$landSeekAd->landSeekAd->installationType->name}}</p>
			</div>

			<div class="column is-one-quarter ">
				<p class="has-text-link is-size-5 has-text-centered"> Accès au foncier souhaité </p>
				<p class="has-text-centered">{{$landSeekAd->landSeekAd->offerGenre->name}}</p>
			</div>

			<div class="column is-one-quarter ">
				<p class="has-text-link is-size-5 has-text-centered"> Souhaite s'installer en bio</p>

				@if ($landSeekAd->landSeekAd->is_bio === 1)
					<p class="has-text-centered">Oui</p>
				@elseif ($landSeekAd->landSeekAd->is_bio === 0)
					<p class="has-text-centered">Non</p>
				@else
					<p class="has-text-centered">Ne sais pas</p>
				@endif
			</div>

			<div class="column is-one-quarter ">
				<p class="has-text-link is-size-5 has-text-centered"> Surface(s) recherchée(s)(en ha)</p>

				@foreach($landSeekAd->landSeekAd->surfaceRanges as $surfaceRangeSeek)
					@if($surfaceRangeSeek->surface !== '')
						<p class="has-text-centered">{{$landSeekAd->landSeekAd->surfaceRanges->pluck('surface')->implode(', ') }}</p>
					@else
						<p class="has-text-centered">Non renseigné</p>
					@endif
				@endforeach
			</div>
			<div class="column is-one-quarter ">
				<p class="has-text-link is-size-5 has-text-centered"> Production(s) envisagée(s)</p>
				@foreach ($landSeekAd->landSeekAd->productionGenres as $productionGenresSeek)
					@if($productionGenresSeek->name !== '')
						<p class="has-text-centered">{{$productionGenresSeek->name}}</p>
					@else
						<p class="has-text-centered">-</p>
					@endif
				@endforeach
			</div>

			<div class="column is-one-quarter ">
				<p class="has-text-link is-size-5 has-text-centered">Habitation(s) et bâti(s) recherché(s)</p>

				@if($landSeekAd->landSeekAd->has_farm_buildings === 1)
					<p class="has-text-centered">Avec des bâtis agricoles existants</p>
				@else
					<p class="has-text-centered">Sans bâtis agricoles existants</p>
				@endif
				@if($landSeekAd->landSeekAd->has_houses === 1)
					<p class="has-text-centered">Avec une maison d’habitation existante</p>
				@else
					<p class="has-text-centered">Sans maison d’habitation existante</p>
				@endif
			</div>

		</div>

		<hr class="navbar-divider">
		<div class="content">
			<h3 class="title is-3">Description du projet</h3>
			<p> {{$landSeekAd->about_project_content}}</p>
		</div>

		<div class="content">
			<h3 class="title is-3">A propos du porteur de projet</h3>
			<p> {{$landSeekAd->about_content}}</p>
		</div>

		@if($landSeekAd->landSeekAd->experience_farming)
			<div class="content">
				<h3 class="title is-3">Expérience du porteur de projet dans le domaine agricole</h3>
				<p> {{$landSeekAd->landSeekAd->experience_farming}}</p>
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
									<button class="button is-link  is-large">
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
	</div>
</section>

	@include('components.partnering')
	@include('components.support_terre_liens')

