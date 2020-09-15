@extends ('default')

@section ('title', 'Mon compte')

@section('main-content')
	<div class="section pt-0">
		<div class="container">
			<div class="columns is-mobile is-centered">
				<div class="column is-two-thirds">
					<h1 class="page__title">Bienvenue sur votre espace <span
								class="is-italic">{{ Auth::user()->first_name }} {{ Auth::user()->name }}</span></h1>
					<h2 class="page__subtitle">Retrouvez tous les services d'Objectif Terres dans votre
						espace personnel </h2>
					<br>
					<br>
				</div>
			</div>
		</div>
		<section class="section">
			<div class="columns is-mobile is-centered ">
				@if(auth()->user()->ads()->count() )
					<div class="column is-3 ">
						<a class="" href="{{route("ads.list")}}">
							<div class="card custom-card ">
								<div class="card-content">
									<div class="media">
										<div class="media-left">
											<figure class="image is-48x48 custom-card custom-card-image">
										<span class="icon is-large">
										  <i class="fas fa-3x fa-newspaper"></i>
										</span>
											</figure>
										</div>
										<div class="media-content">
											<p class="custom-card custom-card-text-title">Mes annonces</p>
										</div>
									</div>
									<div class="content">
										Consulter la liste de vos annonces publiées sur Objectif Terres.
									</div>
								</div>
							</div>
						</a>
					</div>
				@endif

				@if(auth()->user()->supportRequest)
					<div class="column is-3 ">
						<a class="" href="{{route("support-request.show")}}">
							<div class="card custom-card ">
								<div class="card-content">
									<div class="media">
										<div class="media-left">
											<figure class="image is-48x48 custom-card custom-card-image">
												<span class="icon is-large">
												  <i class="fas fa-3x fa-hands-helping"></i>
												</span>
											</figure>
										</div>
										<div class="media-content">
											<p class="custom-card custom-card-text-title">Mon accompagnement</p>
										</div>
									</div>
									<div class="content">
										Consulter et suivre votre demande d'accompagnement
									</div>
								</div>
							</div>
						</a>
					</div>
				@endif

				<div class="column is-3">
					<a class="" href="{{route("researches.show")}}">
						<div class="card custom-card">
							<div class="card-content">
								<div class="media">
									<div class="media-left">
										<figure class="image is-48x48 custom-card custom-card-image">
									<span class="icon is-large">
									  <i class="fas fa-3x fas fa-save"></i>
									</span>
										</figure>
									</div>
									<div class="media-content">
										<p class="custom-card custom-card-text-title">Mes recherches sauvegardées</p>
									</div>
								</div>
								<div class="content">
									Retrouver l'ensemble de vos recherches d'annonces sauvegardées.
								</div>
							</div>
						</div>
					</a>

				</div>
				<div class="column is-3">
					<a class="" href="{{route("favoriteAds.show")}}">
						<div class="card custom-card">
							<div class="card-content">
								<div class="media">
									<div class="media-left">
										<figure class="image is-48x48 custom-card custom-card-image">
									<span class="icon is-large">
									  <i class="fas fa-3x fas fa-star"></i>
									</span>
										</figure>
									</div>
									<div class="media-content">
										<p class="custom-card custom-card-text-title">Mes annonces favorites</p>
									</div>
								</div>
								<div class="content">
									Consulter et gérer l'ensemble de vos annonces favorites.
								</div>
							</div>
						</div>
					</a>
				</div>
			</div>
			<div class="columns is-mobile is-centered mt-10">
				<div class="column is-3">
					<a class="" href="{{route('threads.index')}}">
						<div class="card custom-card">
							<div class="card-content">
								<div class="media">
									<div class="media-left">
										<figure class="image is-48x48 custom-card custom-card-image">
									<span class="icon is-large">
									  <i class="fas fa-3x fas fa-envelope"></i>
									</span>
										</figure>
									</div>
									<div class="media-content">
										<p class="custom-card custom-card-text-title">Ma messagerie</p>
									</div>
								</div>
								<div class="content">
									Consulter vos messages et entrer en contact avec les autres membres d'Objectif Terres.
								</div>
							</div>
						</div>
					</a>
				</div>

				@if(!auth()->user()->is_sf_user)
					<div class="column is-3">
						<a class="" href="{{route('user.edit')}}">
							<div class="card custom-card">
								<div class="card-content">
									<div class="media">
										<div class="media-left">
											<figure class="image is-48x48 custom-card custom-card-image">
												<span class="icon is-large">
												  <i class="fas fa-3x fas fa-user"></i>
												</span>
											</figure>
										</div>
										<div class="media-content">
											<p class="custom-card custom-card-text-title">Mes informations</p>
										</div>
									</div>
									<div class="content">
										Consulter et modifier les informations de mon profil.
									</div>
								</div>
							</div>
						</a>
					</div>
				@endif

				<div class="column is-3">
					<a class="" href="{{route('notification.index')}}">
						<div class="card custom-card">
							<div class="card-content">
								<div class="media">
									<div class="media-left">
										<figure class="image is-48x48 custom-card custom-card-image">
									<span class="icon is-large">
									  <i class="fas fa-3x fas fa-bell"></i>
									</span>
										</figure>
									</div>
									<div class="media-content">
										<p class="custom-card custom-card-text-title">Mes notifications</p>
									</div>
								</div>
								<div class="content">
									Consulter l'ensemble de vos notifications.
								</div>
							</div>
						</div>
					</a>

				</div>
			</div>
		</section>
	</div>


	@include('components.partnering')
	@include('components.support-terre-liens')
@endsection
