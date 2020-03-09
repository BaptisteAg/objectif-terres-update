@extends ('default')

@section ('title', 'Mon compte')

@section('main-content')


	<div class="section">
		<div class="container">
			<div class="columns is-mobile is-centered">
				<div class="column is-two-thirds">
					<h1 class="title is-2 has-text-centered has-text-link">Bienvenue sur votre espace <span
								class="is-italic">{{ Auth::user()->first_name }} {{ Auth::user()->name }}</span></h1>
					<h2 class="subtitle has-text-centered">Retrouvez tous les services d'Objectif Terres dans votre
						espace personnel </h2>
					<br>
					<br>
				</div>
			</div>
		</div>
		<div class="content">
			<div class="tabs is-centered is-medium">
				<ul>
					<li><a href="{{route ('ads.list')}}"><span class="icon is-small">
											<i class="far fa-newspaper" aria-hidden="true"></i></span>
							<span>Mes annonces</span>
						</a>
					</li>
					<li><a href="{{route('researches.show')}}" ><span class="icon is-small">
											<i class="fas fa-save" aria-hidden="true"></i></span>
							<span>Mes recherches sauvegardées</span>
						</a>
					</li>
					<li><a href="{{route('favoriteAds.show')}}"><span class="icon is-small">
											<i class="fas fa-star" aria-hidden="true"></i></span>
							<span>Mes annonces favorites</span>
						</a>
					</li>
					<li class="{{ Route::current()->getName() == 'threads.index' ? 'is-active' : '' }}">
						<a
								href="{{route('threads.index')}}"><span class="icon is-small">
											<i class="fas fa-comments"></i></span>
							<span>Ma messagerie</span>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>

	@include('components.partnering')
	@include('components.supportTerreLiens')
@endsection
