@extends('default')

@section('title', 'Profil de '. $user->first_name.' '.$user->name )

@section('main-content')
	<div class="section">

		<div class="section">
			<div class="columns is-mobile is-centered">
				<div class="column is-half ">
					<div class="card ">
						<div class="card-content">
							<div class="media">
								<div class="media-left">
										<span class="icon is-large">
										   <i class="fas fas fa-3x fa-user"></i>
										</span>
								</div>
								<div class="media-content">
									<div class="columns">
										<div class="column">
											<p class="title is-4">{{$user->first_name}} {{$user->name}}</p>
										</div>
										<div class="column is-offset-4">
											@if(auth()->user()->id == $user->id or auth()->user()->role >= 2)
												<a href="{{route('user.edit', $user->id)}}">
													<button class="button is-link "
															type="button">
														 <span class="icon is-small">
															<i class="fa fa-user-edit" aria-hidden="true"></i>
														</span>
														<span>Modifier le profil</span>
													</button>
												</a>
											@else
												<div id="vue-contact-user-modal">
													<vue-threads inline-template>
														<div>
															<button class="open-modal-new-message button is-link "
																	type="button">
														 <span class="icon is-small">
															<i class="fa fa-paper-plane" aria-hidden="true"></i>
														</span>
																<span> Envoyer un message au porteur de projet</span>
															</button>
															@include('pages.users.partials.newMessageModal')
														</div>
													</vue-threads>
												</div>
											@endif
										</div>
									</div>
								</div>
							</div>

							<div class="content">
								<div class="columns">
									<div class="column has-text-centered">
										<p>
											<span class="icon">
										   <i class="fas fa-envelope"></i>
										</span>
											{{$user->email ?? "Adresse mail non renseignée"}}
										</p>
									</div>
									<div class="column has-text-centered">
											<span class="icon">
										   <i class="fas fa-map-marker-alt"></i>
										</span>
										{{$user->street ?? "Adresse non renseignée "}}
										<p>{{$user->city ?? "Ville non renseignée"}}</p>

									</div>
									<div class="column has-text-centered">
										<p>
											<span class="icon">
										   <i class="fas fa-phone"></i>
										</span>
											{{$user->phone ?? "Numéro de téléphone non renseigné"}}
										</p>
									</div>
								</div>
							</div>
							<div class="card-footer is-marginless">
								<p class="card-footer-item ">Membre depuis le {{$user->created_at}}</p>
							</div>
						</div>
					</div>
				</div>


			</div>
		</div>

		<div class="container ">
			<nav class="level">
				<div class="level-left">
					<div>
						@if(count($ads) <=1)
							<h1 class="title"> {{ count($ads) }} annonce ou demande d'accompagnement soumise</h1>
						@else
							<h2 class="title"> {{ count($ads) }} annonces ou demandes d'accompagnement soumises</h2>
						@endif
					</div>
				</div>
			</nav>
			<section class="section ">
				@foreach ($ads as $ad)
					<div class="columns ">
						<div class="column is-three-quarters ">
							<div class="columns is-vcentered">
								<div class="column is-two-quarter ">
									<div id="slider-container">
										<div id="ads-user-images" class="carousel">
											@if($ad->hasImages)
												@foreach($ad->images as $document)
													<div class="card">
														<div class="card-image">
															<a href="{{route('ads.show', $ad->id)}}">
																<figure class="image is-16by9">
																	@if($document->path === "0")
																		<img src="https://picsum.photos/480/320"
																			 alt="picsum">
																	@else
																		<img src="{{URL::asset($document->path)}}"
																			 alt="Placeholder image">
																	@endif
																</figure>
															</a>
														</div>
													</div>
												@endforeach
											@else
												<div class="card carousel-item  ad-carousel">
													<div class="card-image">
														<a href="{{route('ads.show', $ad->id)}}">
															<figure class="image is-16by9">
																<img src="/images/placeholder-ad.png">
															</figure>
														</a>
													</div>
												</div>
											@endif
										</div>
									</div>
								</div>
								<div class="column">
									<h1 class="title">
										<a href="{{route('ads.show', $ad->id)}}">{{$ad->title}}</a>
									</h1>
									<p>
										@if(isset($ad->project))
											<span class="tag is-link">Demande d'accompagnement</span>
										@else
											<span class="tag is-primary">Annonce</span>
										@endif
									</p>
									<br>

									<p>
										<span class=" has-text-grey-dark">Type  :</span>
										<span class="has-text-black">{{$ad->ad_type_full_name}}</span>
									</p>
									<p>
										<span class="has-text-grey-dark">Localisations :</span>
										<span class="has-text-black">{{ $ad->regions->pluck('name')->implode(', ') }}</span>
										<span class="has-text-black">{{ $ad->departments->pluck('name')->implode(', ') }}</span>
										<span class="has-text-black">{{ $ad->cities->pluck('name')->implode(', ') }}</span>
									</p>
									<p>
										@if(isset($ad->project))
											<span class="has-text-grey-dark">Projet soumis le :</span>
											<span class="has-text-black">{{ $ad->submitDate?? 'Non définis' }}</span>
										@else
											@if(! is_null($ad->attributionAd->published_on ))
												<span class="has-text-grey-dark">Annonce publié le :</span>
												<span class="has-text-black">{{ $ad->published_on }}</span>
											@else
												<span class="has-text-grey-dark">Annonce soumise le :</span>
												<span class="has-text-black">{{ $ad->submitDate }}</span>
											@endif
										@endif
									</p>
									<p>
									@if(isset($ad->project))
										<p>
											<span class="has-text-grey-dark">Stade de l'accompagnement :</span>
											<span class="has-text-black">{{$ad->project->supportStage->name ?? 'Non définis' }}</span>
											<span class="has-tooltip-right"
												  data-tooltip="{{\App\Models\SupportStage::TOOLTIPS[$ad->project->supportStage->id]}}">
											<i class="fas fa-info-circle has-text-info "></i>
											</span>
										</p>
										<p>
											<span class="has-text-grey-dark">Etat de la demande :</span>
											<span class="has-text-black">{{ $ad->project->supportState->name ?? 'Non définis' }}</span>
											<span class="has-tooltip-right"
												  data-tooltip="{{\App\Models\SupportState::TOOLTIPS[$ad->project->supportState->id]}}">
											<i class="fas fa-info-circle has-text-info "></i>
											</span>
										</p>
										<p>
											<span class="has-text-grey-dark">Statut du projet :</span>
											<span class="has-text-black">{{ $ad->project->projectStatus->name ?? 'Non définis' }}</span>
											<span class="has-tooltip-right"
												  data-tooltip="{{\App\Models\ProjectStatus::TOOLTIPS[$ad->project->projectStatus->id]}}">
											<i class="fas fa-info-circle has-text-info "></i>
											</span>
										</p>
									@else
										<span class="has-text-grey-dark">Statut de l'annonce :</span>
										<span class="has-text-black">{{ $ad->attributionAd->adStatus->name?? 'Non définis' }}</span>
									@endif

								</div>
							</div>
						</div>
						<div class="column ">
							<div class="buttons">
								@if(isset($ad->project))
									<a href="{{route("advisor.showSupport", $ad->id)}}">
										<button class="button is-link is-medium ">
									<span class="icon is-small">
											<i class="fas fa-hands-helping"></i>
											</span>
											<span>Espace de suivi</span>
										</button>
									</a>
								@else
									<a href="{{route("ads.show", $ad->id)}}">
										<button class="button is-link is-medium ">
											<span class="icon is-small">
											 <i class="fas fa-eye"></i>
											</span>
											<span>Voir l'annonce</span>
										</button>
									</a>
								@endif
							</div>
						</div>
					</div>
					<div class="columns">
						<div class="column is-three-fifths">
							@if($ad->is_draft === 1)
								<article class="message is-warning">
									<div class="message-body">
										L'annonce est en mode brouillon, elle n'a pas été encore soumise à modération !
									</div>
								</article>
							@endif
							@if($ad->attributionAd->user_moderator_id === auth()->user()->id)
								<article class="message is-link">
									<div class="message-body">
										Vous êtes le modérateur de cette annonce !
									</div>
								</article>
							@elseif($ad->attributionAd->user_advisor_id === auth()->user()->id)
								<article class="message is-link">
									<div class="message-body">
										Vous êtes le primo-accueilant pour ce projet !
									</div>
								</article>
							@endif
						</div>
						<div></div>
					</div>
					<hr class="navbar-divider">
				@endforeach

			</section>
		</div>

	</div>
@endsection

@section('script')
	<script>
				@if(auth()->user()->id != $user->id and auth()->user()->role < 2)
        const vueThreads = new Vue({
                el: '#vue-contact-user-modal',
                name: 'content'
            });

        let buttons = document.querySelectorAll('.open-modal-new-message');
        buttons.forEach((button) => {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                let modal = document.querySelector('.modal');
                let html = document.querySelector('html');
                modal.classList.add('is-active');
                html.classList.add('is-clipped');
            });
        });
        let modal = document.querySelector('.modal');
        let html = document.querySelector('html');
        modal.querySelector('.modal-background').addEventListener('click', function (e) {
            e.preventDefault();
            modal.classList.remove('is-active');
            html.classList.remove('is-clipped');
        });
        modal.querySelector('#close-modal').addEventListener('click', function (e) {
            e.preventDefault();
            modal.classList.remove('is-active');
            html.classList.remove('is-clipped');
        });

        let deleteButton = document.querySelector('.close-notification');
        deleteButton.addEventListener('click', function (e) {
            let notification = document.querySelector('.message');
            notification.style.display = 'none';

        })
		@endif

	</script>
@endsection
@section('js')
	@if(count($ad->images) > 1)
		<script src="{{asset('/js/bulma-carousel.js')}}"></script>
		<script>
            const carouselUserShow = bulmaCarousel.attach('#ads-user-images', {
                slidesToScroll: 1,
                slidesToShow: 1,
                loop: true,
                navigation: true,
            });
		</script>

	@endif

@endsection
