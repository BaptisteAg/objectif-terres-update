@section('title', $ad->title)
<section class="section">
	<div class="container ">
		<nav class="breadcrumb" aria-label="breadcrumbs">
			<ul>
				<li><a href="#">Annonces</a></li>
				<li><a href="#">Offres foncières</a></li>
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
		<div class="columns">
			@include('pages.ads.partials.show-images')
			<div class="column">
				<div class="card">
					<div class="card-content">
						@foreach($ad->landOfferAd->offerGenres as $offerGenre)
							<span class="tag is-primary is-medium">{{$offerGenre->name}}</span>
						@endforeach
						<div class="content">
							@if(is_null($ad->published_on))
								<p><span class="is-size-5  ">Annonce soumise le : </span><span
											class="subtitle">{{ $ad->created_at}}</span>
								</p>
							@else
								<p><span class="is-size-5 ">Publié le  : </span><span
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
							<p><span class="is-size-5 is-capitalized has-text-black">Catégorie : </span><span
										class="subtitle">Offre de foncier</span></p>
						</div>
						@if($ad->landOfferAd->accept_use_zip_code)
							@if($ad->cities->count())
								<div class="content">
									<p><span class="is-size-5 is-capitalized has-text-black">Code postal : </span><span
												class="subtitle">{{$ad->cities[0]->zip_code }} ({{$ad->cities[0]->name }})</span>
									</p>
								</div>
							@endif
						@else
							@if($ad->departments->count())
								<div class="content">
									<p><span class="is-size-5 is-capitalized has-text-black">Département : </span><span
												class="subtitle">{{$ad->departments[0]->code }} ({{$ad->departments[0]->name }})</span>
									</p>
								</div>
							@endif
						@endif
						<div class="content">
							<p><span class="is-size-5 is-capitalized has-text-black">Surface : </span><span
										class="subtitle">{{$ad->landOfferAd->surface}} hectares</span></p>
						</div>

						<div class="content">
							@if ($ad->landOfferAd->offerGenres->count() >=1)
								<p>
									<span class="is-size-5  has-text-black">Type d'offre : </span>
									<span class="subtitle">
									{{$ad->landOfferAd->offerGenres->pluck('name')->implode(', ') }}
								</span>
								</p>
							@endif
							@if($ad->landOfferAd->price)
								<p><span class="is-size-5  has-text-black">Prix : </span>
									<span class="subtitle ">{{ number_format($ad->landOfferAd->price, 0, ",", " " )}} €</span>
								</p>
							@endif
							@if($ad->landOfferAd->rent_price)
								<p>
									<span class="is-size-5  has-text-black">Loyer mensuel : </span>
									<span
											class="subtitle ">{{number_format($ad->landOfferAd->rent_price, 0, ",", " " )}} €</span>
								</p>
							@endif
						</div>

						<div class="content">
							<p><span class="is-size-5 is-capitalized has-text-black">Altitude : </span><span
										class="subtitle">{{$ad->landOfferAd->altitude}}m</span></p>
						</div>


						@if($ad->landOfferAd->water_access !== "" && $ad->landOfferAd->water_access !== null)
							<div class="content">
								<p>
									<span class="is-size-5 is-capitalized has-text-black">Accès à l'eau : </span><span
											class="subtitle">{{$ad->landOfferAd->water_access ? "Oui" : "Non"}}</span>
								</p>
							</div>
						@endif

						@if($ad->userPp->accept_share_contact_infos === 1)
							<div class="content">
								<p>
									<span class="is-size-5 has-text-black">N° de téléphone du porteur de projet : </span>
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

			@if($ad->landOfferAd->productionGenres->count())
				<div class="column is-one-third ">
					<p class="has-text-link is-size-5 has-text-centered">Système de production en place</p>
					<p class="has-text-centered">
						<span>{{$ad->landOfferAd->productionGenres->pluck('name')->implode(', ') }}</span>
					</p>
				</div>
			@endif

			@if($ad->landOfferAd->productionGenresPossible->count())
				<div class="column is-one-third ">
					<p class="has-text-link is-size-5 has-text-centered">Productions possibles</p>
					<p class="has-text-centered">
						<span>{{$ad->landOfferAd->productionGenresPossible->pluck('name')->implode(', ') }}</span>
					</p>
				</div>
			@endif

			<div class="column is-one-third ">
				<p class="has-text-link is-size-5 has-text-centered"> Certification bio des terres</p>

				<p class="has-text-centered">
					<span>{{$ad->landOfferAd->bioCertifications->pluck('name')->implode(', ') }}</span><br>
					@foreach($ad->landOfferAd->bioCertifications as $bioCertification)
						<img src="{{ $bioCertification->icon }}">
					@endforeach
				</p>
			</div>
		</div>

		<hr class="navbar-divider">
		<div class="content">
			<h3 class="title is-3 has-text-centered">Description</h3>
			<div class="columns is-multiline is-mobile is-centered">
				@if($ad->landOfferAd->has_buildings)
					<div class=" column is-one-thirds ">
						<h3 class="title is-5 has-text-centered">Bâtiment(s) agricole(s)</h3>
						@if($ad->landOfferAd->buildings_description)
							<p class="has-text-black">
								<span>{{$ad->landOfferAd->buildings_description}}</span>
							</p>
						@endif
					</div>
				@endif
				@if($ad->landOfferAd->has_houses)
					<div class=" column is-one-thirds ">
						<h3 class="title is-5 has-text-centered">Habitation(s)</h3>
						@if($ad->landOfferAd->houses_description)
							<p class="has-text-black">
								<span>{{$ad->landOfferAd->houses_description}}</span>
							</p>
						@endif
					</div>
				@endif
			</div>
		</div>
		<div class="content">
			<h3 class="title is-3">Description du projet</h3>
			<p> {!! nl2br(e($ad->about_project_content))!!}</p>
		</div>
		<div class="content">
			<h3 class="title is-3">A propos du porteur de projet</h3>
			<p> {!! nl2br(e($ad->about_content))!!}</p>
		</div>
		@if($ad->landOfferAd->sau_description)
			<div class="content">
				<h3 class="title is-3">Description SAU</h3>
				<p> {!! nl2br(e($ad->landOfferAd->sau_description))!!}</p>
			</div>
		@endif
		@if($ad->landOfferAd->water_access_description)
			<div class="content">
				<h3 class="title is-3">Description de l'accès à l'eau</h3>
				<p> {!! nl2br(e($ad->landOfferAd->water_access_description))!!}</p>
			</div>
		@endif
		@if($ad->landOfferAd->test_description)
			<div class="content">
				<h3 class="title is-3">Description du test agricole</h3>
				<p> {!! nl2br(e($ad->landOfferAd->test_description))!!}</p>
			</div>
		@endif

		<div class="section">
			@include('pages.ads.partials.threadsDisplay')
		</div>
	</div>

</section>

@include('components.support-terre-liens')
