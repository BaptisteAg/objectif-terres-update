<header id="vue-header">
	<div class="container-custom">
		<nav class="level">
			<div class="level-left">
				<div class="level-item">
					<a href="/" class="button">Nous soutenir</a>
				</div>
				<div class="level-item">
					<a href="/" class="">Qui sommes nous ?</a>
				</div>
				<div class="level-item">
					<a href="/" class="">Contactez-nous</a>
				</div>
			</div>
			<div class="level-right">
				@guest
					<div class="level-item">Bienvenue !</div>
					<div class="level-item">
						<a href="{{ route('signIn') }}">Connectez-vous</a>
					</div>
					<div class="level-item">ou</div>
					@if (Route::has('register'))
						<div class="level-item">
							<a href="{{ route('register') }}">Créez un compte</a>
						</div>
					@endif
				@else
					<div class="level-item">
						<span class="icon">
							<a href=""><i class="far fa-user"></i><span>Bienvenue, {{ Auth::user()->name }}</span></a>
						</span>
					</div>
					<div class="level-item">
                <span class="icon">
                    <a href=""><i class="far fa-bell"></i></a>
                </span>
					</div>
					<div class="level-item">
                <span class="icon">
                    <a href=""><i class="far fa-envelope"></i></a>
                </span>
					</div>
					<div class="level-item">
						<span class="icon">
						<a class="dropdown-item" href="{{ route('logout') }}"
						   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
							Se déconnecter
						<i class="fas fa-sign-out-alt"></i></a>
						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							@csrf
						</form>
						</span>
					</div>
			</div>
			@endguest
		</nav>
	</div>
	{!! Form::open(['route' => 'researches.index', 'method' => 'get']) !!}
	<div class="container-custom has-background-grey-lighter">
		<div class="columns">
			<div class="column is-1">
				<a href="{{url ('/')}}">
					<figure class="image is-128x128">
						<img class="is-rounded" src="http://placehold.it/200x200" alt="">
					</figure>
				</a>
			</div>
			<div class="column is-2">
				<a href="{{url ('/')}}">
					<h3 class="title">Objectif Terre</h3>
				</a>
				<h4 class="subtitle">Réalisez votre projet agricole.</h4>
				<p>Une initiative Terre de Liens</p>
			</div>
			<div class="column is-2">
				<p>Je cherche</p>
				<div class="select">
					<label for="select"></label>
					{{ Form::select('ad_type',
									['offer_ads' => 'Des offres', 'seek_ads' => 'Des demandes'],
									null,
									['v-model' => 'adTypeSelected']) }}
				</div>
			</div>
			<div class="column is-2">
				<div class="control">
					<label class="radio is-block" for="land">
						<input id="land" type="radio" name="ad_category" value="land" checked
							   v-model="adCategorySelected">
						de terres/ferme
					</label>
					<label class="radio is-block is-marginless" for="job">
						<input id="job" type="radio" name="ad_category" value="job" v-model="adCategorySelected">
						d'emploi
					</label>
				</div>
			</div>
			<div class="column is-3">
				<p>Où</p>
				<div>
					<multi-select
							:data="{{ json_encode(array_merge([(object)['id' => '0','name' => 'Toutes les régions']], json_decode($regions))) }}"
							:multiple="true"
							name="regions_location_researches[]"
							selected-count-text="région(s) sélectionnée(s)"
							placeholder="Choississez une/des région(s)">
					</multi-select>
				</div>
				{!! Form::submit('Rechercher', ['class' => 'button']) !!}
			</div>
			<div class="column is-2">
				<a href="#" @click="more_criteria()">Plus de critère</a>
			</div>

		</div>
	</div>
	<div v-if="isFormOpen" class="has-ba">
		<div class="container-custom" v-show="adCategorySelected === 'job'">
			@include('layouts.partials.header_job_research')
		</div>
		<div class="container-custom" v-show="adCategorySelected === 'land'">
			@include('layouts.partials.header_land_research')
		</div>
	</div>
	{!! Form::close() !!}
	<div class="container is-fluid">
		<nav class="navbar is-boxed">
			<div class="navbar-brand">
				<a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false"
				   data-target="navbarMenu">
					<span aria-hidden="true"></span>
					<span aria-hidden="true"></span>
					<span aria-hidden="true"></span>
				</a>
			</div>
			<div class="navbar-menu" id="navbarMenu">
				<div class="navbar-start">
					<a class="navbar-item">Accueil</a>
					<div class="navbar-item has-dropdown is-hoverable">
						<a class="navbar-link">Je souhaite</a>
						<div class="navbar-dropdown">
							<a class="navbar-item">About</a>
							<a class="navbar-item">Jobs</a>
							<a class="navbar-item">Contact</a>
						</div>
					</div>
					<div class="navbar-item has-dropdown is-hoverable">
						<a class="navbar-link">Je suis</a>
						<div class="navbar-dropdown">
							<a class="navbar-item">About</a>
							<a class="navbar-item">Jobs</a>
							<a class="navbar-item">Contact</a>
						</div>
					</div>
					<a class="navbar-item">Orientation & accompagnement</a>
				</div>
				<div class="navbar-end">
					<div class="navbar-item">
						<div class="buttons">
							<a class="navbar-item">Ressources utiles</a>
							<a class="navbar-item">Témoignages & chiffres clés</a>
							<a href="{{ route('ads.create') }}" class="button is-bordered">Déposer une annonce</a>
						</div>
					</div>
				</div>
			</div>
		</nav>
	</div>
</header>

