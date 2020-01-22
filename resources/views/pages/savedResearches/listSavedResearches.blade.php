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
						</div>
						<div class="column ">
							<div class="buttons">
								<a class="">
									{!! Form::open(['route' => 'researches.index', 'method' => 'get']) !!}
									<input type="hidden" name="ad_type" value="{{$research->ad_type}}">
									@foreach ($research->regions->pluck('id') as $region)
										<input type="hidden" name="research_locations[]" value="{{ $region }}">
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
							{{Form::open(['route' => 'researches.destroy'])}}
							<div class="buttons">
								<input type="hidden" value="{{$research->id}}" name="research">
								<a>
									<button type="submit" class="button is-danger is-normal is-light">
												<span class="icon has-text-danger">
												  <i class="fas fa-ban"></i>
												</span>
										<span>Supprimer la recherche</span>
									</button>
								</a>
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
