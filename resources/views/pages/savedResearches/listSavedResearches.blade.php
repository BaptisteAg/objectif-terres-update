Zones de recherche@extends ('default')

@section ('title', 'Consulter la liste de vos recherches sauvegarder')

@section('main-content')
	<section class="section">
		<div class="container">
			<nav class="level">
				<div class="level-left">
					<div>
						<h1 class="title">Liste des recherches sauvegardées</h1>
						<br>
						@if(count($researches) <= 1)
							<h2 class="subtitle"> {{ count($researches) }} recherche sauvegardée.</h2>
						@else
							<h2 class="subtitle"> {{ count($researches) }} recherches sauvegardées.</h2>
						@endif

						@if($numberAlertActives <= 1)
							<h2 class="subtitle"> {{ $numberAlertActives}} alerte active.</h2>
						@else
							<h2 class="subtitle"> {{ $numberAlertActives}} alertes actives.</h2>
						@endif
					</div>
				</div>
			</nav>
			<section class="section">
				@foreach ($researches as $research)
					<div class="columns ">
						<div class="column is-three-quarters ">
							<a href="{{route ('researches.index', $research->url)}}"><h1
										class="title">{{$research->name}} </h1></a>
							<p><span class="has-text-grey-dark">Type d'annonces recherchés :</span>
								@if($research->ad_type === 'jobOffer')
									<span class="has-text-black">Offres d'emplois</span>
								@elseif($research->ad_type === 'jobSeekAd')
									<span class="has-text-black">Recherche d'emplois</span>
								@elseif($research->ad_type === 'landOfferAd')
									<span class="has-text-black">Offres de foncier</span>
								@elseif($research->ad_type === 'landSeekAd')
									<span class="has-text-black">Recherche de foncier</span>
								@endif
							</p>
							<p><span class="has-text-grey-dark">Localisations :</span>
								<span class="has-text-black">{{ $research->regions->pluck('name')->implode(', ') }}</span>
								<span class="has-text-black">{{ $research->departments->pluck('name')->implode(', ') }}</span>
								<span class="has-text-black">{{ $research->cities->pluck('name')->implode(', ') }}</span>
							</p>
							<p><span class="has-text-grey-dark">Recherche crée le :</span> <span
										class="has-text-black">{{ \Carbon\Carbon::parse($research->created_at)->format('d/m/Y')}}</span>
							</p>

							@isset($research->surface_min)
								<p><span class="has-text-grey-dark">Surface minimum : </span><span
											class="has-text-black">{{ $research->surface_min }}</span></p>
							@endisset
							@isset($research->surface_max)
								<p><span class="has-text-grey-dark">Surface maximum : </span><span
											class="has-text-black">{{ $research->surface_max }}</span></p>
							@endisset
							@isset($research->price_min)
								<p><span class="has-text-grey-dark">Prix minimum : </span><span
											class="has-text-black">{{ $research->price_min }}</span></p>
							@endisset
							@isset($research->price_max)
								<p><span class="has-text-grey-dark">Prix maximum : </span><span
											class="has-text-black">{{ $research->price_max }}</span></p>
							@endisset
							@if($research->has_pics === '1')
								<p><span class="has-text-grey-dark">Annonces avec photos </span></p>
							@endif
							@if($research->has_houses === '1')
								<p><span class="has-text-grey-dark">Uniquement des anonces avec habitation </span></p>
							@endif
							@empty($research->adStatuses )
								<p><span class="has-text-grey-dark">Statut(s) des annonces : </span><span
											class="has-text-black">{{ $research->adStatuses->pluck('name')->implode(', ') }}</span>
								</p>
							@endempty
							@empty($research->jobOfferTypes )
								<p><span class="has-text-grey-dark">Statut(s) des opportunités professionnels  : </span><span
											class="has-text-black">{{ $research->jobOfferTypes->pluck('name')->implode(', ') }}</span>
								</p>
							@endempty
							@empty($research->projectStatuses )
								<p><span class="has-text-grey-dark">Statut(s) des projets  : </span><span
											class="has-text-black">{{ $research->jobOfferTypes->pluck('name')->implode(', ') }}</span>
								</p>
							@endempty
							@empty($research->offerGenres )
								<p><span class="has-text-grey-dark">Type(s) d'offre(s)  : </span><span
											class="has-text-black">{{ $research->offerGenres->pluck('name')->implode(', ') }}</span>
								</p>
							@endempty
							@empty($research->bioCertifications )
								<p><span class="has-text-grey-dark">Système(s) de production bio  : </span><span
											class="has-text-black">{{ $research->bioCertifications->pluck('name')->implode(', ') }}</span>
								</p>
							@endempty

							@empty($research->productionGenres )
								<p><span class="has-text-grey-dark">Type(s) de productions recherché(s)  : </span><span
											class="has-text-black">{{ $research->productionGenres->pluck('name')->implode(', ') }}</span>
								</p>
							@endempty
						</div>
						<div class="column ">
							<div class="buttons">
								<a href="{{route ('researches.index', $research->url)}}">
									<button class="button is-link is-normal ">
											<span class="icon is-small">
											 <i class="fas fa-eye"></i>
											</span>
										<span>Voir les annonces</span>
									</button>
								</a>
							</div>
							<div class="buttons">

								@if($research->has_alert === 0)
									{{Form::open(['route' => 'researches.notification', 'method' => 'get'])}}
									<input type="hidden" value="{{$research->id}}" name="research">
									<button type="submit" class="button is-link is-light"><span class="icon is-small"><i
													class="fas fa-bell"></i></span>
										<span>Créer une alerte</span>
									</button>
									{{Form::close()}}
								@else
									<a href="{{route ('researches.deleteAlert', $research->id)}}">
									<button class="button is-danger is-light">
										<span class="icon is-small">
											<i class="fas fa-bell-slash"></i>
										</span>
										<span>Supprimer l'alerte</span>
									</button>
									</a>
								@endif
							</div>
							<a href="{{route ('researches.destroy', $research->id)}}">
							<div class="buttons">
								<button class="button is-danger is-normal">
												<span class="icon has-text-danger">
												 <i class="fas fa-ban has-text-white"></i>
												</span>
									<span>Supprimer la recherche</span>
								</button>
							</div>
							</a>
						</div>
					</div>
					<hr class="navbar-divider">
				@endforeach
			</section>

			<section class="section">
				<pagination :per-page="10" :records="500" @paginate="myCallback"></pagination>
			</section>
			@include('components.sectionOrientationTerreLiens')
		</div>

	</section>

	@include('components.partnering')
	@include('components.supportTerreLiens')
@endsection
