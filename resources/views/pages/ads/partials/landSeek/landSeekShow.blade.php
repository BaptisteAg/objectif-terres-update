<section class="section">
	<div class="container ">
		<nav class="breadcrumb" aria-label="breadcrumbs">
			<ul>
				<li><a href="#">Annonces</a></li>
				<li><a href="#">Recherches foncières</a></li>
			</ul>
		</nav>
		<h1 class="title has-text-link">{{$ad->title}}</h1>

		@auth
			@if(auth()->user()->role >= 1)
				@include('pages.ads.partials.moderator-options')
			@endif

			@if(auth()->user()->id === $ad->user_pp_id)
				@include('pages.ads.partials.ad-status-message-display')
			@endif
		@endauth
		<div class="columns ">
			@include('pages.ads.partials.show-images')
			<div class="column">
				<div class="card">
					<div class="card-content">
						<div class="content">
							@if(is_null($ad->published_on))
								<p><span class="is-size-5 ">Annonce soumise le : </span><span
											class="subtitle">{{ $ad->created_at}}</span>
								</p>
							@else
								<p><span class="is-size-5  ">Publié le  : </span><span
											class="subtitle">{{ $ad->published_on}}</span>
								</p>
							@endif
						</div>
						<div class="content">
							<p><span class="is-size-5   ">Publié par  : </span>
								@auth()
									@if(auth()->user()->role >= 1 )
										<span class="subtitle">
										<a href="{{route('user.show', $ad->userPp->id)}}">{{ $ad->userPp->first_name}} {{$ad->userPp->name}}</a>
									</span>
									@elseif(auth()->user()->role < 1)
										<span class="subtitle">
										{{ $ad->userPp->first_name}} {{$ad->userPp->name}}
									</span>
									@endif
								@endauth
								@guest()
									<span class="subtitle">
										{{ $ad->userPp->first_name}} {{$ad->userPp->name}}
									</span>
								@endguest()
							</p>
						</div>
						<div class="content">
							<p><span class="is-size-5 is-capitalized ad-show-feature-label">Catégorie : </span><span
										class="subtitle">Recherche de foncier</span></p>

						</div>
						@if($ad->landSeekAd->surface_range_max)
							<div class="content">
								<p>
									<span class="is-size-5  ad-show-feature-label">Surface recherchée : </span>
									<span class="subtitle ad-show-feature-label">
										De {{$ad->landSeekAd->surface_range_min}}<small>ha</small>
										à {{$ad->landSeekAd->surface_range_max}}<small>ha</small>
									</span><br>
								</p>
							</div>
						@endif
						<div class="content">
							@if(count($ad->cities))
								<p>
									<span class="is-size-5 ad-show-feature-label">
										Communes
										@if($ad->locationable_radius)
											(dans un rayon de {{$ad->locationable_radius}}km)
										@endif
										:
									</span><br>
									@foreach($ad->zipCodesByCity as $city => $zipCodes)
										<span class="subtitle">{{$city}} ({{ $zipCodes->implode(', ') }})</span><br>
									@endforeach
								</p>
							@endif

							@if(count($ad->departments))
								<p>
									<span class="is-size-5 is-capitalized ad-show-feature-label">Départements : </span><br>
									<span class="subtitle"> {{$ad->departments->pluck('name')->implode(', ') }}</span>
								</p>
							@endif

							@if(count($ad->regions))
								<p>
									<span class="is-size-5 is-capitalized ad-show-feature-label">Régions : </span><br>
									<span class="subtitle">{{$ad->regions->pluck('name')->implode(', ') }}</span>
								</p>
							@endif
						</div>
						{{--<div class="content">
							@if(count($ad->landSeekAd->priceRanges))
								<p><span class="is-size-4  ad-show-feature-label">Prix recherché : </span>
									@foreach($ad->landSeekAd->priceRanges as $priceRange)
										<span class="subtitle ad-show-feature-label">{{$priceRange->price }}€</span><br>
									@endforeach
								</p>
							@endif
						</div>--}}
						@if($ad->userPp->accept_share_contact_infos === 1)
							<div class="content">
								<p>
									<span class="is-size-5 ad-show-feature-label">N° de téléphone du porteur de projet : </span>
								</p>
								<p><span class="subtitle">{{$ad->userPp->phone}}</span></p>
							</div>
						@endif

						@include('pages.ads.partials.show-documents')
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

			@if($ad->landSeekAd->productionGenres->count())
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
			@endif

			@if($ad->landSeekAd->buildings->count())
				<div class="column is-one-quarter ">
					<p class="has-text-link is-size-5 has-text-centered">Habitation(s) et bâti(s) recherché(s)</p>
					@if($ad->landSeekAd->buildings)
						@foreach($ad->landSeekAd->buildings as $building)
							{{ $building->buildingType->label }} : {{ $building->requirement->label }}<br>
						@endforeach
					@endif
				</div>
			@endif

		</div>

		<hr class="navbar-divider">
		<div class="content">
			<h3 class="title is-3">Description du projet</h3>
			<p> {{nl2br(e($ad->about_project_content))}}</p>
		</div>

		<div class="content">
			<h3 class="title is-3">A propos du porteur de projet</h3>
			<p> {{nl2br(e($ad->about_content))}}</p>
		</div>

		@if($ad->landSeekAd->experience_farming)
			<div class="content">
				<h3 class="title is-3">Expérience du porteur de projet dans le domaine agricole</h3>
				<p> {{nl2br(e($ad->landSeekAd->experience_farming))}}</p>
			</div>
		@endif


		<div class="section">
			@include('pages.ads.partials.threadsDisplay')
		</div>

	</div>
</section>

@include('components.support-terre-liens')

