<header>
	<div>
		<div class="container-custom bg-d-primary">
			<nav class="level ">
				<div class="level-left">
					<div class="level-item">
						<a href="/" class="button button basic secondary without-link-styles">
							<span class="button__label">Nous soutenir</span>
						</a>
					</div>
					<div class="bubble-wrap level-item">
						<a class="" href="/qui-sommes-nous">Qui sommes nous ?</a>
						<div class="bubble is-visible fluid bubble_danger">
							<div class="bubble__container bubble__container_danger ">
								<ul class="menu menu-submenu">
									<li>
										<a class="menu__link menu__link_danger without-link-styles"
										   href="">Le mouvement Terre de Liens</a>
									</li>
									<li>
										<a class="menu__link menu__link_danger without-link-styles"
										   href="">A propos d'Objectif Terre</a>
									</li>
								</ul>
							</div>
						</div>
					</div>

				</div>
				<div class="level-right">
					@guest
						<div class="level-item">Bienvenue !</div>
						<div class="level-item">
							<a href="{{ route('login') }}">Connectez-vous</a>
						</div>
						<div class="level-item">ou</div>
						@if (Route::has('register'))
							<div class="level-item">
								<a href="{{ route('register') }}">Créez un compte</a>
							</div>
						@endif
					@else
						<div class="level-item">
							@if(auth()->user()->role === 0 )
								<a class="navbar-item button is-bordered" href="{{route('user.index')}}">
									<span class="icon">
										<i class="far fa-user"></i>
									</span>
									<span>Bonjour, ({{ Auth::user()->name }}, {{Auth::user()->first_name}})</span>
								</a>
							@else
								<div class="dropdown">
									<div class="dropdown-trigger">
										<button class="button  button-dropdown" aria-haspopup="true"
												aria-controls="dropdown-menu">
										<span class="icon">
											<i class="far fa-user"></i>
										</span>
											<span>{{Auth::user()->first_name}} {{ Auth::user()->name }} </span>
											<span class="icon is-small">
											<i class="fas fa-angle-down" aria-hidden="true"></i>
										</span>
										</button>
									</div>
									<div class="dropdown-menu" id="header-dropdown-menu" role="menu">
										<div class="dropdown-content">
											@if(auth()->user()->role >= 3 )
												<a href="{{route('supervisor.index')}}"
												   class="dropdown-item without-link-styles text_charcoal ">
													Espace responsable territorial
												</a>
											@endif
											@if(auth()->user()->role >= 2 )
												<a href="{{route('advisor.index')}}"
												   class="dropdown-item without-link-styles text_charcoal">
													Espace primo-accueillant
												</a>
											@endif

											@if(auth()->user()->role >= 1 )
												<a href="{{route('moderator.index')}}"
												   class="dropdown-item without-link-styles text_charcoal">
													Espace modérateur
												</a>
											@endif
										</div>
									</div>
								</div>
							@endif
						</div>
						<div class="level-item bubble-wrap">
							<p class="button__wrap">
								<a href="#" class="button round small secondary without-link-styles"
								   title="Accéder aux applis Terre de liens">
									<span class="button__icon"><i class="fas fa-th"></i></span>
								</a>
							</p>
							<div class="bubble is-visible left">
								<div class="bubble__container">
									<div class="bubble__scrollable-wrap">
										<div class="bubble__scrollable">
											<ul class="menu menu-submenu tiles">
												<li class="tile_icon-label">
													<a href="#" class="menu__link tile__link"
													   title="Accéder aux applis Terre de liens">
                                                                            <span class="tile__icon"><i
																						class="fad fa-address-card"></i></span>
														<div class="tile__content">
															<p class="tile__title">
																Rhizôme</p>
														</div>
													</a>
												</li>
												<li class="tile_icon-label">
													<a href="#" class="menu__link tile__link"
													   title="Consulter mes notifications">
                                                                            <span class="tile__icon"><img
																						src="/images/icons/picto_app_1.PNG"></span>
														<div class="tile__content">
															<p class="tile__title">
																terredeliens.org</p>
															<p class="tile__intro">Le site national
																de Terre de Liens</p>
														</div>
													</a>
												</li>
												<li class="tile_icon-label">
													<a href="#" class="menu__link tile__link"
													   title="Consulter mes notifications">
                                                                            <span class="tile__icon"><img
																						src="/images/icons/picto_app_4.png"></span>
														<div class="tile__content">
															<p class="tile__title">
																accesstoland.eu</p>
															<p class="tile__intro">
																L'action
																de Terre de
																Liens en
																Europe</p>
														</div>
													</a>
												</li>
												<li class="tile_icon-label">
													<a href="#" class="menu__link tile__link"
													   title="Consulter mes notifications">
                                                                            <span class="tile__icon"><img
																						src="/images/icons/picto_app_2.png"></span>
														<div class="tile__content">
															<p class="tile__title">
																Parcel
															</p>
															<p class="tile__intro">
																Pour une
																alimentation
																Résiliente
																Citoyenne et Locale</p>
														</div>
													</a>
												</li>
												<li class="tile_icon-label">
													<a href="#" class="menu__link tile__link"
													   title="Consulter mes notifications">
                                                                            <span class="tile__icon"><img
																						src="/images/icons/diagnostic-ferme.png"></span>
														<div class="tile__content">
															<p class="tile__title"> Diaganostic
																Ferme</p>
															<p class="tile__intro"> Diagnostiquer,
																collecter et partager des données
																sur les fermes
														</div>
													</a>
												</li>
												<li class="tile_icon-label">
													<a href="#" class="menu__link tile__link"
													   title="Consulter mes notifications">
                                                                            <span class="tile__icon"><img
																						src="/images/icons/phototheque.png"></span>
														<div class="tile__content">
															<p class="tile__title"> Photothèque </p>
															<p class="tile__intro"> Partager les
																photos de Terre de Liens pour une
																agriculture photogénique</p>
														</div>
													</a>
												</li>
												<li class="tile_icon-label">
													<a href="#" class="menu__link tile__link"
													   title="Consulter mes notifications">
                                                                            <span class="tile__icon"><img
																						src="/images/icons/objectif-terre.png"></span>
														<div class="tile__content">
															<p class="tile__title">
																Objectif Terre
															</p>
														</div>
													</a>
												</li>
												<li class="tile_icon-label">
													<a href="#" class="menu__link tile__link"
													   title="Consulter mes messages">
                                                                            <span class="tile__icon"><i
																						class="fad fa-books"></i></span>
														<div class="tile__content">
															<p class="tile__title">
																Centre
																de
																ressources</p>
														</div>
													</a>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="level-item">
							<p class="button__wrap">
								<a href="{{route('notification.index')}}"
								   class="button round small secondary number-sticker-wrap without-link-styles"
								   title="Consulter mes notifications">
									<span class="button__icon"><i class="fas fa-bell"></i></span>
									@unless(auth()->user()->unreadNotifications->isEmpty())
										<span class="number-sticker">{{auth()->user()->unreadNotifications->count()}}</span>
									@endunless
								</a>
							</p>
						</div>
						<div class="level-item ">
							<p class="button__wrap ">
								<a href="{{route('threads.index')}}"
								   class="button round small secondary number-sticker-wrap without-link-styles"
								   title="Consulter mes messages">
									<span class="button__icon"><i class="fas fa-envelope"></i></span>
									@if($numberOfUnreadMessages >=0)
										<span class="number-sticker">{{$numberOfUnreadMessages}}</span>
									@endif
								</a>
							</p>

						</div>
						<div class="level-item">
							<p class="button__wrap">
								<a href="{{route('user.index')}}"
								   class="button round small secondary without-link-styles" title="Gérer mon profil">
									<span class="button__icon"><i class="fas fa-user"></i></span>
								</a>
							</p>
						</div>
						<div class="level-item">
							<a class="dropdown-item " href="{{ route('logout') }}"
							   onclick="event.preventDefault();
												 document.getElementById('logout-form').submit();">
							<span class="icon">
							<i class="fas fa-sign-out-alt"></i>
							</span>
								<span>Se déconnecter</span>
							</a>
							<span class="icon">
								<form id="logout-form" action="{{ route('logout') }}" method="POST"
									  style="display: none;">
									@csrf
								</form>
							</span>
						</div>
					@endguest
				</div>
			</nav>
		</div>

		<a href="#" class="main-nav__logo logo">
			<img src="http://tdlui.semaphore-communication.fr/img/logo/logo_TdL_cartouche_blanc-rouge_500.png"/>
		</a>
		<input type="checkbox" id="main-nav__toggler"/>
		<div id="main-nav__hamburger">
			<div id="main-nav__hamburger__line" class="button__icon"></div>
		</div>

		<div id="main-nav__splash__wrap">
			<div id="main-nav__splash__transform-container" class="bg-trame_champs_dark">
				<div id="main-nav__splash__container">
					<div class="main-nav__content">
						<div class="top-bar">
							<section class="fw-section top-bar__1">
							<div id="vue-header">
									<header-page id="header-page" inline-template
												 :old-search-values="{{json_encode(old())}}">
										{!! Form::open(['route' => 'researches.index', 'method' => 'get']) !!}
										<div class="container-custom bg-trame_champs_dark">
											<div class="columns is-mobile is-vcentered is-multiline">
												<div class="column  is-1-desktop is-one-fifth-tablet is-half-mobile">
													<figure class="image is-square">
														<a class="without-link-styles logo logo_TdL" href="{{route ('home')}}">
															<img class="is-rounded"
																 src="/images/logo/logo_TdL_cartouche_blanc-rouge_500.png"
																 alt="objectif-terres-logo">
														</a>
													</figure>
												</div>
												<div class="column is-4-desktop is-four-fifths-tablet is-half-mobile ">
													<a class="without-link-styles" href="{{route ('home')}}">
														<h1 class="title is-1 m-b-0">Objectif Terres</h1>
													</a>
													<h4 class=" text_green m-t-5">Réalisez votre projet agricole.</h4>
													<p>Une initiative Terre de Liens</p>
												</div>
												<div class="column is-2-desktop is-one-thrid-tablet has-text-centered p-t-40">
													<div style="display:inline-block; padding-top: 7px;">
														<p class="p-r-10">Je</p>
													</div>
													<div class="select form-field">
														<label for="select"></label>
														{{ Form::select('offer_type',
															['OfferAd' => 'Cherche ', 'SeekAd' => 'Propose'],
															null,
															['v-model' => 'offerTypeSelected', "class"=> 'form-field'  ]
														) }}
													</div>

													<div class="select">
														<label for="select form-field"></label>
														{{ Form::select('ad_category',
															['land' => 'une terre ', 'job' => 'un emploi'],
															null,
															['v-model' => 'adCategorySelected',
														   ]
														) }}
													</div>
												</div>
												<div class="column is-2-desktop is-one-third-tablet  p-t-40">
													<div style="display:inline-block; padding-top: 2px;">
														<p>ici : </p>
													</div>
													<div style="display:inline-block">
														<multi-select
																:options="{{ $regionsWithAll }}"
																v-model="selectedRegions"
																:multiple="true"
																name="regions_location_researches_ids[]"
																selected-count-text="région(s) sélectionnée(s)"
																placeholder="Choississez une/des région(s)">
														</multi-select>
													</div>
												</div>
												<div class="column is-3-tablet has-text-centered  p-t-40  " style="padding-top: 38px;">
													{!! Form::submit('Rechercher', ['class' => ' button basic primary']) !!}<br>
													<a class="has-text-left" href="#" @click="more_criteria()">Plus de
														critère</a>
												</div>
											</div>
										</div>
										<div v-show="isFormOpen" class="has-ba" style="display : none">
											<div class="container-custom bg-l-pearl" v-if="adCategorySelected === 'job'">
												@include('layouts.partials.headerJobResearch')
											</div>
											<div class="container-custom bg-l-pearl" v-if="adCategorySelected === 'land'">
												@include('layouts.partials.headerLandResearch')
											</div>
										</div>
										{!! Form::close() !!}
									</header-page>
								</div>
							</section>
							<section class="fw-section top-bar__2">
								<div class="container is-fluid menu-container ">
									<ul class="menu menu-site ">
										<li class="bubble-wrap">
											<a href="#" class="menu__link without-link-styles">
												Je souhaite
											</a>
											<div class="bubble is-visible fluid bubble_danger">
												<div class="bubble__container bubble__container_danger ">
													<ul class="menu menu-submenu">
														<li>
															<a class="menu__link menu__link_danger without-link-styles"
															   href="/louer-vendre-mes-terres">m'installer paysan</a>
														</li>
														<li>
															<a class="menu__link menu__link_danger without-link-styles"
															   href="/ceder-ma-ferme">trouver une terre ou des financements</a>
														</li>
														<li>
															<a class="menu__link menu__link_danger without-link-styles"
															   href="/trouver-un-emploi">transmettre ma ferme</a>
														</li>
														<li>
															<a class="menu__link menu__link_danger without-link-styles"
															   href="/confier-mes-terres">faire une donation ou un leg à Terre
																de Liens</a>
														</li>
													</ul>
												</div>
											</div>
										</li>
										<li class="bubble-wrap">
											<a href="#" class="menu__link without-link-styles">
												Je suis
											</a>
											<div class="bubble is-visible fluid bubble_danger">
												<div class="bubble__container bubble__container_danger ">
													<ul class="menu menu-submenu">
														<li>
															<a class="menu__link menu__link_danger without-link-styles"
															   href="">en reconversion professionnelle avec un projet
																d'installation</a>
														</li>
														<li>
															<a class="menu__link menu__link_danger without-link-styles"
															   href="">un candidat à l'installation en recherche de terres</a>
														</li>
														<li>
															<a class="menu__link menu__link_danger without-link-styles"
															   href="">un paysan (bientôt) à la retraite</a>
														</li>
														<li>
															<a class="menu__link menu__link_danger without-link-styles"
															   href="">un propriétaire de foncier</a>
														</li>
														<li>
															<a class="menu__link menu__link_danger without-link-styles"
															   href="">une collectivité </a>
														</li>
													</ul>
												</div>
											</div>
										</li>
										<li>
											<a class="menu__link without-link-styles" href="#">Questions fréquentes</a>
										</li>
										<li>
											<a class="menu__link without-link-styles" href="#">Première visite ?</a>
										</li>

										<li class="secondary">
											<a href="/accompagnement/demarrer" class="menu__link without-link-styles">Être
												accompagné</a>
										</li>
										<li class="secondary">
											@if(Auth::check())
												@if(auth()->user()->role === 1 )
													<a href="{{ route('moderator.index') }}"
													   class="menu__link without-link-styles">Espace
														modérateur</a>
												@elseif(auth()->user()->role === 2)
													<a href="{{ route('advisor.index') }}"
													   class="menu__link without-link-styles">Espace
														primo-accueillant</a>

												@elseif (auth()->user()->role >= 3)
													<a href="{{ route('supervisor.index') }}"
													   class="menu__link without-link-styles">Espace
														responsable territorial</a>
												@else
													<a href="{{ route('ads.create') }}" class="menu__link without-link-styles">Déposer
														une
														annonce</a>

												@endif
											@else
												<a href="{{ route('ads.create') }}" class="menu__link without-link-styles">Déposer
													une
													annonce</a>
											@endif
										</li>
									</ul>

									@if( Auth::check() and auth()->user()->role <=1)
										@if (Route::current()->getName() === 'ads.list'||
											Route::current()->getName() === 'researches.show' ||
											Route::current()->getName() === 'ads.show' ||
											Route::current()->getName() === 'favoriteAds.show' ||
											Route::current()->getName() === 'messages.index'||
											Route::current()->getName() === 'user.update' ||
											strpos(Route::current()->getName(), 'threads.') === 0 ||
											Route::current()->getName() === 'support-request.show')
											@include('layouts.partials.users-tabs')
										@endif
									@endif
									<br>
								</div>
							</section>
						</div>




					</div>
				</div>
			</div>

		</div>
		@if( Auth::check() and auth()->user()->role >=1)
			@if(auth()->user()->role ==1)
				@include('components.moderator-tabs')
			@elseif(auth()->user()->role ==2)
				@include('components.advisor-tabs')
			@elseif(auth()->user()->role >=3)
				@include('components.supervisor-tabs')
			@endif
		@endif

	</div>
</header>

