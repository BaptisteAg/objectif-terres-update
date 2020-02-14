@extends ('default')

@section ('title', 'Consulter la liste de vos annonces favorites')

@section('main-content')


	<section class="section">
		<div class="container">
			<nav class="level">
				<div class="level-left">
					<div>
						<h1 class="title">Liste des annonces favorites</h1>
						@if(count($favoriteAds) <=1)
							<h2 class="subtitle"> {{ count($favoriteAds) }} annonce favorite.</h2>
						@else
							<h2 class="subtitle"> {{ count($favoriteAds) }} annonces favorites.</h2>
						@endif
					</div>
				</div>
			</nav>
			<section class="section">
				@foreach ($favoriteAds as $favoriteAd)
					<div class="columns ">
						<div class="column is-three-quarters ">
							<div class="columns">
								<div class="column is-one-quarter ">
									<a href="{{route("ads.show", $favoriteAd->ad->id)}}">
										<figure class="image is-5by4">
											@if(count ($favoriteAd->ad->documents) > 0)
												@foreach($favoriteAd->ad->documents as $document)
													@if(strpos($document->type, "image") !== false)
														<img src="{{asset($document->path)}}">
													@endif
												@endforeach
											@else
												<img src="https://picsum.photos/256/256">
											@endif
										</figure>
									</a>
								</div>
								<div class="column">@if($favoriteAd->ad->landSeekAd)
										<a href="{{route("ads.show", $favoriteAd->ad->id)}}">
											<h1 class="title">{{$favoriteAd->ad->landSeekAd->title}} </h1>
										</a>
										<p><span class="has-text-grey-dark">Type d'annonces recherchés :</span>
											<span class="has-text-black">Recherche de foncier</span></p>
									@elseif($favoriteAd->ad->landOfferAd)
										<a href="{{route("ads.show", $favoriteAd->ad->id)}}"><h1
													class="title">{{$favoriteAd->ad->landOfferAd->title}} </h1></a>
										<p><span class="has-text-grey-dark">Type d'annonces recherchés :</span>
											<span class="has-text-black">Offre de foncier</span></p>
									@elseif($favoriteAd->ad->jobOfferAd)
										<a href="{{route("ads.show", $favoriteAd->ad->id)}}"><h1
													class="title">{{$favoriteAd->ad->jobAd->title}} </h1></a>
										<p><span class="has-text-grey-dark">Type d'annonces recherchés :</span>
											<span class="has-text-black">Offre d'emploi</span></p>
									@elseif($favoriteAd->ad->jobSeekAd)
										<a href="{{route("ads.show", $favoriteAd->ad->id)}}"><h1
													class="title">{{$favoriteAd->ad->jobAd->title}} </h1></a>
										<p><span class="has-text-grey-dark">Type d'annonces recherchés :</span>
											<span class="has-text-black">Recherche d'emploi</span></p>
									@endif

									<p><span class="has-text-grey-dark">Localisations :</span>
										<span class="has-text-black">{{ $favoriteAd->ad->regions->pluck('name')->implode(', ') }}</span>
										<span class="has-text-black">{{ $favoriteAd->ad->departments->pluck('name')->implode(', ') }}</span>
										<span class="has-text-black">{{ $favoriteAd->ad->cities->pluck('name')->implode(', ') }}</span>
									</p>
									<p><span class="has-text-grey-dark">Annonce sauvegardée le :</span> <span
												class="has-text-black">{{ \Carbon\Carbon::parse($favoriteAd->created_at)->format('d/m/Y')}}</span>
									</p></div>
							</div>


						</div>
						<div class="column ">
							<div class="buttons">
								<a href="{{route("ads.show", $favoriteAd->ad->id)}}">
									<button class="button is-link is-medium ">
											<span class="icon is-small">
											 <i class="fas fa-eye"></i>
											</span>
										<span>Voir l'annonce</span>
									</button>
								</a>
							</div>
							{{Form::open(['route' => 'favoriteAds.destroy'])}}
							<div class="buttons ">
								<input type="hidden" type="number" value="{{(int)$favoriteAd->id}}"
									   name="favoriteAdId">
								<button type="submit" class="button is-danger is-medium is-light">
												<span class="icon has-text-danger">
												  <i class="fas fa-ban"></i>
												</span>
									<span>Retirer l'annonce des favoris</span>
								</button>
							</div>
							{{Form::close()}}
						</div>
					</div>
					<div class="columns">
						<div class="column ">
							@if(count ($favoriteAd->ad->adMessages()->whereUserId(auth()->user()->id)->get()) > 0)
								<article class="message is-success">
									<div class="message-body">
										<a href="">Vous avez déjà envoyé un message au porteur de projet. Consulter votre messagerie !</a>
									</div>
								</article>
							@else
								<article class="message is-warning">
									<div class="message-body">
										Vous n'avez pas encore répondu à cette annonce !
									</div>
								</article>
							@endif
						</div>
						<div></div>
					</div>
					<hr class="navbar-divider">
				@endforeach
			</section>

			<section class="section">
				<pagination :per-page="10" :records="500" @paginate="myCallback"></pagination>
			</section>

			@include('components.sectionOrientationTerreLiens')
			@include('components.partnering')
			@include('components.supportTerreLiens')

		</div>
	</section>
@endsection

@section('script')

	<script>
        let deleteButton = document.querySelector('#close-notification');
        deleteButton.addEventListener('click', function (e) {
            let notification = document.querySelector('.message');
            notification.style.display = 'none';
        })

	</script>

@endsection