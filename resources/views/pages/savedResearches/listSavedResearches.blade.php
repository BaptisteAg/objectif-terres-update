@extends ('default')

@section ('title', 'Consulter la liste de vos recherches sauvegarder')

@section('main-content')


	<section class="section">
		<div class="container">
			<nav class="level">
				<div class="level-left">
					<div>
						<h1 class="title">Liste des recherches sauvegardées</h1>
						<h2 class="subtitle"> {{ count($researches) }} recherches sauvegardées.</h2>
					</div>
				</div>
			</nav>
			@if ($message = Session::get('success'))
				<article class="message is-success">
					<div class="message-header">
						<p>Succès</p>
						<button class="delete" aria-label="delete"></button>
					</div>
					<div class="message-body">
						Une alerte a bien été créée. Un email de confirmation vous a été envoyé !
					</div>
				</article>
			@endif
			<section class="section">
				@foreach ($researches as $research)
					<div class="columns ">
						<div class="column is-three-quarters ">
							<h1 class="title">{{$research->name}} </h1>
							<p><span class="has-text-grey-dark">Type d'annonces recherchés :</span>
								@if($research->ad_type === 'jobOfferAd')
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

							@if($research->surface_min)
								<p><span class="has-text-grey-dark">Surface minimum : </span><span
											class="has-text-black">{{ $research->surface_min }}</span></p>
							@endif
							@if($research->surface_max)
								<p><span class="has-text-grey-dark">Surface maximum : </span><span
											class="has-text-black">{{ $research->surface_max }}</span></p>
							@endif
							@if($research->price_min)
								<p><span class="has-text-grey-dark">Prix minimum : </span><span
											class="has-text-black">{{ $research->price_min }}</span></p>
							@endif
							@if($research->price_max)
								<p><span class="has-text-grey-dark">Prix maximum : </span><span
											class="has-text-black">{{ $research->price_max }}</span></p>
							@endif
							@if($research->has_pics === '1')
								<p><span class="has-text-grey-dark">Annonces avec photos </span></p>
							@endif
							@if($research->has_houses === '1')
								<p><span class="has-text-grey-dark">Uniquement des anonces avec habitation </span></p>
							@endif
							@if($research->adStatuses )
								<p><span class="has-text-grey-dark">Statut(s) des annonces : </span><span
											class="has-text-black">{{ $research->adStatuses->pluck('name')->implode(', ') }}</span>
								</p>
							@endif
							@if($research->jobStatuses )
								<p><span class="has-text-grey-dark">Statut(s) des opportunités professionnels  : </span><span
											class="has-text-black">{{ $research->jobStatuses->pluck('name')->implode(', ') }}</span>
								</p>
							@endif
							@if($research->projectStatuses )
								<p><span class="has-text-grey-dark">Statut(s) des projets  : </span><span
											class="has-text-black">{{ $research->jobStatuses->pluck('name')->implode(', ') }}</span>
								</p>
							@endif
							@if($research->offerGenres )
								<p><span class="has-text-grey-dark">Type(s) d'offre(s)  : </span><span
											class="has-text-black">{{ $research->offerGenres->pluck('name')->implode(', ') }}</span>
								</p>
							@endif
							@if($research->bioCertifications )
								<p><span class="has-text-grey-dark">Système(s) de production bio  : </span><span
											class="has-text-black">{{ $research->bioCertifications->pluck('name')->implode(', ') }}</span>
								</p>
							@endif
							@if($research->productionGenres )
								<p><span class="has-text-grey-dark">Type(s) de productions recherché(s)  : </span><span
											class="has-text-black">{{ $research->productionGenres->pluck('name')->implode(', ') }}</span>
								</p>
							@endif
						</div>
						<div class="column ">
							<div class="buttons">
								<a class="">
									{!! Form::open(['route' => 'researches.index', 'method' => 'get']) !!}
									<input type="hidden" name="ad_type" value="{{$research->ad_type}}">
									<input type="hidden" name="surface_min" value="{{$research->surface_min}}">
									<input type="hidden" name="surface_max" value="{{$research->surface_max}}">
									<input type="hidden" name="has_pics" value="{{$research->has_pics}}">
									<input type="hidden" name="has_house" value="{{$research->has_house}}">
									<input type="hidden" name="price_min" value="{{$research->price_min}}">
									<input type="hidden" name="price_max" value="{{$research->price_max}}">

									@foreach ($research->regions->pluck('id') as $region)
										<input type="hidden" name="research_locations[]" value="{{ $region }}">
									@endforeach

									@foreach ($research->departments->pluck('id') as $department)
										<input type="hidden" name="research_locations_departments[]"
											   value="{{ $department }}">
									@endforeach

									@foreach ($research->cities->pluck('id') as $city)
										<input type="hidden" name="research_locations_cities[]" value="{{ $city }}">
									@endforeach

									@foreach ($research->adStatuses->pluck('id') as $adStatus)
										<input type="hidden" name="ad_status[]" value="{{ $adStatus }}">
									@endforeach

									@foreach ($research->jobStatuses->pluck('id') as $jobStatus)
										<input type="hidden" name="job_status[]" value="{{ $jobStatus }}">
									@endforeach

									@foreach ($research->offerGenres->pluck('id') as $offerGenre)
										<input type="hidden" name="project_status[]" value="{{ $offerGenre }}">
									@endforeach
									@foreach ($research->projectStatuses->pluck('id') as $projectStatus)
										<input type="hidden" name="project_status[]" value="{{ $projectStatus }}">
									@endforeach
									@foreach ($research->bioCertifications->pluck('id') as $bioCertification)
										<input type="hidden" name="project_status[]" value="{{ $bioCertification }}">
									@endforeach
									@foreach ($research->productionGenres->pluck('id') as $productionGenre)
										<input type="hidden" name="project_status[]" value="{{ $productionGenre }}">
									@endforeach

									<button type="submit" class="button is-link is-normal ">
											<span class="icon is-small">
											 <i class="fas fa-eye"></i>
											</span>
										<span>Voir les annonces</span>
									</button>
									{{Form::close()}}
								</a>
							</div>
							<div class="buttons">
								{{Form::open(['route' => 'researches.notification', 'method' => 'get'])}}
								<input type="hidden" value="{{$research->id}}" name="research">
								<button type="submit" class="button is-link is-light"><span class="icon is-small"><i
												class="fas fa-bell"></i></span>
									<span>Créer une alerte</span>
								</button>
								{{Form::close()}}
							</div>
							{{Form::open(['route' => 'researches.destroy'])}}
							<div class="buttons">
								<input type="hidden" value="{{$research->id}}" name="research">
								<button type="submit" class="button is-danger is-normal is-light">
												<span class="icon has-text-danger">
												  <i class="fas fa-ban"></i>
												</span>
									<span>Supprimer la recherche</span>
								</button>
							</div>
							{{Form::close()}}
						</div>
					</div>
					<hr class="navbar-divider">
				@endforeach
			</section>

			<section class="section">
				<pagination :per-page="10" :records="500" @paginate="myCallback"></pagination>
			</section>

			@include('components.section_orientation_terre_liens')
			@include('components.partnering')
			@include('components.support_terre_liens')

		</div>
	</section>
@endsection
