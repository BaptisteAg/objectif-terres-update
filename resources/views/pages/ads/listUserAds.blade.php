@extends ('default')

@section ('title', 'Consulter la liste de vos annonces favorites')

@section('main-content')
	<section class="section">
		<div class="container">
			<nav class="level">
				<div class="level-left">
					<div>
						<h1 class="title">Liste de vos annonces</h1>
						@if(count($ads) <=1)
							<h2 class="subtitle"> {{ count($ads) }} annonce publiée.</h2>
						@else
							<h2 class="subtitle"> {{ count($ads) }} annonces publiées.</h2>
						@endif
					</div>
				</div>
			</nav>
			<section class="section">
				@foreach ($ads as $ad)
					<div class="columns ">
						<div class="column is-three-quarters ">
							<div class="columns">
								<div class="column is-one-quarter ">
									<a href="{{route("ads.show", $ad->id)}}">
										<figure class="image is-5by4">
											@if(count($ad->documents) > 0)
												@foreach($ad->documents as $document)
													@if($document->type_document ==="image")
														<img src="{{asset($document->path)}}">
													@endif
												@endforeach
											@else
												<img src="https://picsum.photos/256/256">
											@endif
										</figure>
									</a>
								</div>
								<div class="column">@if($ad->landSeekAd)
										<h1 class="title">
											<a href="{{route('ads.show', $ad->id)}}">{{$ad->landSeekAd->title}}</a>
										</h1>
										<p><span class=" has-text-grey-dark">Type d'annonce  :</span>
											<span class="has-text-black">Recherche de foncier</span></p>
									@elseif($ad->landOfferAd)
										<h1 class="title">
											<a href="{{route("ads.show", $ad->id)}}">{{$ad->landOfferAd->title}}</a>
										</h1>
										<p><span class="has-text-grey-dark">Type d'annonce  :</span>
											<span class="has-text-black">Offre de foncier</span></p>
									@elseif($ad->jobOfferAd)
										<h1 class="title">
											<a href="{{route("ads.show", $ad->id)}}">
												{{$ad->jobAd->title}}
											</a>
										</h1>
										<p><span class="has-text-grey-dark">Type d'annonce :</span>
											<span class="has-text-black">Offre d'emploi</span></p>
									@elseif($ad->jobSeekAd)
										<h1 class="title">
											<a href="{{route("ads.show", $ad->id)}}">
												{{$ad->jobAd->title}}
											</a>
										</h1>
										<p><span class="has-text-grey-dark">Type d'annonces  :</span>
											<span class="has-text-black">Recherche d'emploi</span></p>
									@endif

									<p><span class="has-text-grey-dark">Localisations :</span>
										<span class="has-text-black">{{ $ad->regions->pluck('name')->implode(', ') }}</span>
										<span class="has-text-black">{{ $ad->departments->pluck('name')->implode(', ') }}</span>
										<span class="has-text-black">{{ $ad->cities->pluck('name')->implode(', ') }}</span>
									</p>
									<p><span class="has-text-grey-dark">Annonce créée le :</span> <span
												class="has-text-black">{{ $ad->created_at }}</span>
									</p>


									@isset($ad->adMessages)
										<p><span>Vous n'avez pas reçu de messages concernant cette annonce</span>
										</p>
									@endisset
									@if(count($ad->adMessages) === 1 )

										<p><span>Vous avez reçu <span class="has-text-black has-text-weight-bold"><a
															href="{{route("ads.show", $ad->id).'#reponses'}}"> {{count($ad->adMessages)}} réponse </a></span>concernant cette annonce !</span>
										</p>

									@elseif(count($ad->adMessages) > 1)
										<p><span
													class="has-text-grey-dark">Vous avez reçu <span
														class="has-text-black has-text-weight-bold">	<a
															href="{{route("ads.show", $ad->id).'#reponses'}}"> {{count($ad->adMessages)}} réponses </a></span>
											 concernant cette annonce ! </span>
										</p>

									@endif
								</div>
							</div>
						</div>
						<div class="column ">
							<div class="buttons">
								@if($ad->is_draft === 0)
									<a href="{{route("ads.show", $ad->id)}}">
										<button class="button is-link is-medium ">
											<span class="icon is-small">
											 <i class="fas fa-eye"></i>
											</span>
											<span>Voir l'annonce</span>
										</button>
									</a>
								@else
									<a href="">
										<button class="button is-link is-light is-medium ">
											<span class="icon is-small">
											<i class="fas fa-pen"></i>
											</span>
											<span>Modifier l'annonce</span>
										</button>

									</a>
								@endif
							</div>
						</div>
					</div>
					<div class="columns">
						<div class="column is-three-fifths">
							@if($ad->is_draft === 0)
								<article class="message is-success">
									<div class="message-body">
										Votre annonce est en ligne !
									</div>
								</article>
							@else
								<article class="message is-warning">
									<div class="message-body">
										Votre annonce est en mode brouillon, elle n'est pas encore publiée !
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