<header id="vue-header">
	<header-page id="header-page" inline-template>
		<div>
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
                            @if(auth()->user()->role >=2)
                                <div class="level-item">
                                    <a href="{{route('moderator.index')}}">
                                        <span class="icon">
                                            <i class="far fa-user"></i>
                                        </span>
                                        <span>Mon esapce modérateur ({{ Auth::user()->name }}, {{Auth::user()->first_name}})</span>
                                    </a>
                                </div>
                                @else

                                <div class="level-item">
                                    <a href="{{route('userAccount.index')}}">
                                        <span class="icon">
                                            <i class="far fa-user"></i>
                                        </span>
                                        <span>Mon compte ({{ Auth::user()->name }}, {{Auth::user()->first_name}})</span>
                                    </a>
                                </div>
                            @endif
							<div class="level-item">
                                <span class="icon">
                                    <a href=""><i class="far fa-bell"></i></a>
                                </span>
							</div>
							<div class="level-item">
								<span class="notification-container">
								 <a href="{{route('threads.index')}}">
										<i class="far fa-envelope"></i>
									</a>

									@if($numberOfUnreadMessages >=0)
										<span class="notification-counter">{{$numberOfUnreadMessages}}</span>
									@endif
								</span>
							</div>
							<div class="level-item">
								<a class="dropdown-item" href="{{ route('logout') }}"
								   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
							<span class="icon">
							<i class="fas fa-sign-out-alt"></i>
							</span>
									<span>Se déconnecter</span>
								</a>
								<span class="icon">
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
							<h3 class="title">Objectif Terres</h3>
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
								<input id="job" type="radio" name="ad_category" value="job"
									   v-model="adCategorySelected">
								d'emploi
							</label>
						</div>
					</div>
					<div class="column is-3">
						<p>Où</p>
						<div>
							<multi-select
									:options="{{ json_encode(array_merge([(object)['id' => '0','name' => 'Toutes les régions']], json_decode($regions))) }}"
									:multiple="true"
									name="regions_location_researches[]"
									v-model="regionsSelected"
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
			<div v-show="isFormOpen" class="has-ba" style="display : none">
				<div class="container-custom" v-show="adCategorySelected === 'job'">
					@include('layouts.partials.headerJobResearch')
				</div>
				<div class="container-custom" v-show="adCategorySelected === 'land'">
					@include('layouts.partials.headerLandResearch')
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
									<a href="{{ route('ads.create') }}" class="button is-bordered">Déposer une
										annonce</a>
								</div>
							</div>
						</div>
					</div>
				</nav>
				@if( Auth::check())
					@if (Route::current()->getName() === 'ads.list' || Route::current()->getName() === 'researches.show' || Route::current()->getName() == 'favoriteAds.show' || Route::current()->getName() == 'messages.index' )
						<div class="tabs is-centered is-medium">
							<ul>
								<li class="{{ Route::current()->getName() === 'ads.list' ? 'is-active' : '' }}"><a
											href="{{route ('ads.list')}}"><span class="icon is-small">
											<i class="far fa-newspaper" aria-hidden="true"></i></span>
										<span>Mes annonces</span>
									</a>
								</li>
								<li class="{{Route::current()->getName() === 'researches.show' ? 'is-active' : '' }}"><a
											href="{{route('researches.show')}}"><span class="icon is-small">
											<i class="fas fa-save" aria-hidden="true"></i></span>
										<span>Mes recherches sauvegardées</span>
									</a>
								</li>
								<li class="{{ Route::current()->getName() == 'favoriteAds.show' ? 'is-active' : '' }}">
									<a
											href="{{route('favoriteAds.show')}}"><span class="icon is-small">
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
					@else
			</div>
			@endif
			@endif
		</div>
	</header-page>
</header>

