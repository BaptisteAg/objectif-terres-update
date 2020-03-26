@extends('default')

@section('title', 'Profil de '. $user->first_name.' '.$user->name )

@section('main-content')
	<div class="section">
		@include('components.moderatorTabs')
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
										<div class="column is-offset-3">
											@if(auth()->user()->id !== $user->id)
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
											{{$user->email}}
										</p>
									</div>
									<div class="column has-text-centered">
											<span class="icon">
										   <i class="fas fa-map-marker-alt"></i>
										</span>
										{{$user->address}}
										@if(is_null($user->country))
											<p>Pays non renseigné</p>
										@else
											<p>{{$user->country->name_fr_fr}}</p>
										@endif

									</div>
									<div class="column has-text-centered">
										<p>
											<span class="icon">
										   <i class="fas fa-phone"></i>
										</span>
											@if(is_null($user->phone))
												Numéro de téléphone non renseigné
											@else
												{{$user->phone}}
											@endif
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
							<h1 class="title"> {{ count($ads) }} annonce soumise</h1>
						@else
							<h2 class="title"> {{ count($ads) }} annonces soumises</h2>
						@endif
					</div>
				</div>
			</nav>
			<section class="section ">
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

									<p><span class="has-text-grey-dark">Status de l'annonce : </span> <span
												class="has-text-black">{{ $ad->attributionAd->adStatus->name }}</span>
									</p>

									@if(! is_null($ad->project))
										<p><span class="has-text-grey-dark">Status du projet : </span> <span
													class="has-text-black">{{ $ad->project->projectStatus->name }}</span>
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
	</script>
@endsection