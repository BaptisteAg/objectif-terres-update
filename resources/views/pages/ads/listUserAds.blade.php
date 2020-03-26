@extends ('default')

@section ('title', 'Consulter la liste de vos annonces favorites')

@section('main-content')
	<section class="section">
		<div class="container">
			<nav class="level">
				<div class="level-left">
					<div>
						<h1 class="title">Liste de mes annonces</h1>

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
								<div class="column">@if($ad->landSeekAd)
										<h1 class="title">
											<a href="{{route('ads.show', $ad->id)}}">{{$ad->title}}</a>
										</h1>
										<p><span class=" has-text-grey-dark">Type d'annonce  :</span>
											<span class="has-text-black">Recherche de foncier</span></p>
									@elseif($ad->landOfferAd)
										<h1 class="title">
											<a href="{{route("ads.show", $ad->id)}}">{{$ad->title}}</a>
										</h1>
										<p><span class="has-text-grey-dark">Type d'annonce  :</span>
											<span class="has-text-black">Offre de foncier</span></p>
									@elseif($ad->jobOfferAd)
										<h1 class="title">
											<a href="{{route("ads.show", $ad->id)}}">
												{{$ad->title}}
											</a>
										</h1>
										<p><span class="has-text-grey-dark">Type d'annonce :</span>
											<span class="has-text-black">Offre d'emploi</span></p>
									@elseif($ad->jobSeekAd)
										<h1 class="title">
											<a href="{{route("ads.show", $ad->id)}}">
												{{$ad->title}}
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

									@if(count($ad->threads) === 0)
										<p><span>Vous n'avez pas reçu de messages concernant cette annonce</span>
										</p>
									@endif
									@if(count($ad->threads) === 1 )

										<p><span>Vous avez  <span class="has-text-black has-text-weight-bold"><a
															href="{{route("threads.index")}}"> {{count($ad->threads)}} fil de discussion </a></span>concernant cette annonce !</span>
										</p>

									@elseif(count($ad->threads) > 1)
										<p><span
													class="has-text-grey-dark">Vous avez <span
														class="has-text-black has-text-weight-bold">	<a
															href="{{route("threads.index")}}"> {{count($ad->threads)}} fils de discussion </a></span>
											 concernant cette annonce ! </span>
										</p>

									@endif
								</div>
							</div>
						</div>

						<div class="column ">
							<div class="buttons">
								@if($ad->attributionAd and $ad->attributionAd->adStatus->id === 1 )
									<a href="{{route("ads.show", $ad->id)}}">
										<button class="button is-link is-light is-medium ">
											<span class="icon is-small">
											<i class="fas fa-eye"></i>
											</span>
											<span>Voir l'annonce</span>
										</button>

									</a>
								@elseif($ad->is_draft === 0)
									<a href="{{route("ads.show", $ad->id)}}">
										<button class="button is-link is-light is-medium ">
											<span class="icon is-small">
											 <i class="fas fa-eye"></i>
											</span>
											<span>Apercu de  l'annonce</span>
										</button>
									</a>
								@else
									<a href="{{route("ads.show", $ad->id)}}">
										<button class="button is-link is-light is-medium ">
											<span class="icon is-small">
											<i class="fas fa-eye"></i>
											</span>
											<span>Voir l'annonce</span>
										</button>

									</a>
								@endif
							</div>
							@if($ad->attributionAd and $ad->attributionAd->adStatus->id === 3 )
							@else
								<div class="buttons">
									<a href="{{route("ads.delete", $ad->id)}}">
										<button class="button is-danger is-light is-medium ">
											<span class="icon is-small">
											<i class="fas fa-trash"></i>
											</span>
											<span>Supprimer l'annonce</span>
										</button>

									</a>
								</div>
							@endif
						</div>
					</div>
					<div class="columns">
						<div class="column is-three-fifths">
							@if(! $ad->attributionAd and $ad->is_draft === 0)
								<article class="message is-success">
									<div class="message-body">
										Votre annonce n'as pas encore été soumise, finaliser la création de votre annonce !
									</div>
								</article>

							@elseif($ad->attributionAd->adStatus->id === 1)
								<article class="message is-success">
									<div class="message-body">
										Votre annonce  a été validée et est en ligne depuis le {{$ad->published_on}} !
									</div>
								</article>
							@elseif($ad->attributionAd->adStatus->id === 2)
								<article class="message is-warning">
									<div class="message-body">
										Votre annonce nécessite quelques modifications, <a
												href="{{route('threads.index')}}">consulter votre messagerie</a> pour
										plus d'informations !
									</div>
								</article>

							@elseif($ad->attributionAd->adStatus->id === 3)
								<article class="message is-danger">
									<div class="message-body">
										Votre annonce a été réfusé, <a href="{{route('threads.index')}}">consulter votre
											messagerie</a> pour plus d'informations !
									</div>
								</article>
							@elseif($ad->attributionAd->adStatus->id === 6)
								<article class="message is-message">
									<div class="message-body">
										Votre annonce a été archivée !
									</div>
								</article>
							@else
								<article class="message is-message">
									<div class="message-body">
										Votre annonce n'as pas été encore approuvée et publiée !
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

			@include('components.section-orientation-terre-liens')
			@include('components.partnering')
			@include('components.support-terre-liens')

		</div>
	</section>
@endsection

@section('script')

	<script>
        let deleteButton = document.querySelector('.close-notification');
        deleteButton.addEventListener('click', function (e) {
            let notification = document.querySelector('.message');
            notification.style.display = 'none';
        })

	</script>

@endsection