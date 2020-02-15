<section class="section">
	<div class="container ">
		<nav class="breadcrumb" aria-label="breadcrumbs">
			<ul>
				<li><a href="#">Annonces</a></li>
				<li><a href="#">Recherches foncières</a></li>
			</ul>
		</nav>
		<h1 class="title has-text-link">{{$ad->landSeekAd->title}}</h1>
		<div class="columns ">
			<div id="slider-container" class="column is-two-thirds ">
				<div id="ad-images" class="carousel ">
					@if(count($ad->documents) <= 0)
						<div class="card carousel-item ad-carousel ">
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
							@if(strpos($document->type, 'image') !== false)
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
							@endif
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
										class="subtitle">Recherche de foncier</span></p>

						</div>
						<div class="content">
							<span class="is-size-5 has-text-black">Localisation(s) : </span>
							@if(count($ad->cities))
								<p>
									<span class="subtitle">Villes : {{ ucwords($ad->cities->pluck('name')->implode(', ')) }}</span>
								</p>
							@endif

							@if(count($ad->departments))
								<p>
									<span class="subtitle">Départements : {{$ad->departments->pluck('name')->implode(', ') }}</span>
								</p>
							@endif

							@if(count($ad->regions))
								<p>
									<span class="subtitle">Régions : {{$ad->regions->pluck('name')->implode(', ') }}</span>
								</p>
							@endif
						</div>
						<div class="content">
							{{--@if(count($ad->landSeekAd->priceRanges))
								<p><span class="is-size-4  has-text-black">Prix recherché : </span>
									@foreach($ad->landSeekAd->priceRanges as $priceRange)
										<span class="subtitle has-text-black">{{$priceRange->price }}€</span><br>
									@endforeach
								</p>
							@endif--}}
						</div>
						@if($ad->userPp->accept_share_contact_infos === 1)
							<div class="content">
								<p><span class="is-size-5 has-text-black">N° de téléphone du porteur de projet : </span>
								</p>
								<p><span class="subtitle">{{$ad->userPp->phone}}</span></p>
							</div>
						@endif

						@if($ad->documents->hasImages)
							@foreach($ad->documents as $document)
								@if(strpos($document->type, 'image') !== false)
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
								@endif
							@endforeach
						@endif
					</div>
					@include('pages.ads.partials.buttonsFavoriteAndMessage')
				</div>
			</div>
		</div>
		@include('pages.ads.partials.adMessageModal')

		<hr class="navbar-divider">
		<h3 class="title is-3 has-text-centered">Caractéristiques du projet</h3>
		<div class="columns is-multiline is-mobile is-centered">

			<div class="column is-one-quarter ">
				<p class="has-text-link is-size-5 has-text-centered"> Type d'installation souhaité</p>
				<p class="has-text-centered">{{$ad->landSeekAd->installationType->name}}</p>
			</div>

			<div class="column is-one-quarter ">
				<p class="has-text-link is-size-5 has-text-centered"> Souhaite s'installer en bio</p>

				@if ($ad->landSeekAd->is_bio === 1)
					<p class="has-text-centered">Oui</p>
				@elseif ($ad->landSeekAd->is_bio === 0)
					<p class="has-text-centered">Non</p>
				@else
					<p class="has-text-centered">Ne sais pas</p>
				@endif
			</div>

			{{--
			@if($ad->landSeekAd->offerGenre)
				<div class="column is-one-quarter ">
					<p class="has-text-link is-size-5 has-text-centered"> Accès au foncier souhaité </p>
					<p class="has-text-centered">{{$ad->landSeekAd->offerGenre->name}}</p>
				</div>
			@endif

			<div class="column is-one-quarter ">
				<p class="has-text-link is-size-5 has-text-centered"> Surface(s) recherchée(s)(en ha)</p>
				@foreach ($ad->landSeekAd->surfaceRanges as $surfaceRangeSeek)
					@if($surfaceRangeSeek->surface !== '')
						<p class="has-text-centered">{{$ad->landSeekAd->surfaceRanges->pluck('surface')->implode(', ') }}</p>
					@else
						<p class="has-text-centered">Non renseigné</p>
					@endif
				@endforeach
			</div>--}}

			<div class="column is-one-quarter ">
				<p class="has-text-link is-size-5 has-text-centered"> Production(s) envisagée(s)</p>
				@foreach ($ad->landSeekAd->productionGenres as $productionGenresSeek)
					@if($productionGenresSeek->name !== '')
						<p class="has-text-centered">{{$productionGenresSeek->name}}</p>
					@else
						<p class="has-text-centered">-</p>
					@endif
				@endforeach
			</div>

			<div class="column is-one-quarter ">
				<p class="has-text-link is-size-5 has-text-centered">Habitation(s) et bâti(s) recherché(s)</p>
				@if($ad->landSeekAd->buildings && count($ad->landSeekAd->buildings))
					@foreach($ad->landSeekAd->buildings as $building)
						{{ $building->buildingType->label }} : {{ $building->requirement->label }}
					@endforeach
				@endif

			</div>

		</div>

		<hr class="navbar-divider">
		<div class="content">
			<h3 class="title is-3">Description du projet</h3>
			<p> {{$ad->about_project_content}}</p>
		</div>

		<div class="content">
			<h3 class="title is-3">A propos du porteur de projet</h3>
			<p> {{$ad->about_content}}</p>
		</div>

		@if($ad->landSeekAd->experience_farming)
			<div class="content">
				<h3 class="title is-3">Expérience du porteur de projet dans le domaine agricole</h3>
				<p> {{$ad->landSeekAd->experience_farming}}</p>
			</div>
		@endif

@include('pages.ads.partials.callToActionMessage')

	</div>
</section>


@include('components.partnering')
@include('components.supportTerreLiens')

