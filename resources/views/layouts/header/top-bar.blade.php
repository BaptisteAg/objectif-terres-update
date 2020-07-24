<div class="container-custom bg-d-primary is-hidden-mobile">
    <nav class="level ">
        <div class="level-left">
            <div class="level-item">
                <a href="/" class="button basic secondary ">
                    <span class="button__label">Nous soutenir</span>
                </a>
            </div>
            <div class="bubble-wrap level-item">
                <a class="button basic primary" href="/qui-sommes-nous">
                    <span class="button__label">Qui sommes nous ?</span>
                </a>
                <div class="bubble is-visible fluid bubble_primary">
                    <div class="bubble__container bubble__container_primary ">
                        <ul class="custom-menu menu-submenu">
                            <li>
                                <a class="menu__link menu__link_primary "
                                   href="">Le mouvement Terre de Liens</a>
                            </li>
                            <li>
                                <a class="menu__link menu__link_primary "
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
                    <a class="link-header" href="{{ route('login') }}">Connectez-vous</a>
                </div>
                <div class="level-item">ou</div>
                @if (Route::has('register'))
                    <div class="level-item">
                        <a class="link-header" href="{{ route('register') }}">Créez un compte</a>
                    </div>
                @endif
            @else
                <div class="level-item">
                    @if(auth()->user()->role === 0 )
                        <span class="icon">
										<i class="far fa-user"></i>
									</span>
                        <span>Bonjour, {{Auth::user()->first_name}} {{ Auth::user()->name }}</span>
                    @else
                        <div class="dropdown">
                            <div class="dropdown-trigger">
                                <button class="button button-dropdown front-office-button" aria-haspopup="true"
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
                                <div class="dropdown-content" onclick="">
                                    @if(auth()->user()->role >= 3 )
                                        <a href="{{route('supervisor.index')}}"
                                           class="dropdown-item  text_charcoal ">
                                            Espace responsable territorial
                                        </a>
                                    @endif
                                    @if(auth()->user()->role >= 2 )
                                        <a href="{{route('advisor.index')}}"
                                           class="dropdown-item  text_charcoal">
                                            Espace primo-accueillant
                                        </a>
                                    @endif

                                    @if(auth()->user()->role >= 1 )
                                        <a href="{{route('moderator.index')}}"
                                           class="dropdown-item  text_charcoal">
                                            Espace modérateur
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                @include('layouts.header.lanceur-applications')

                <div class="level-item">
                    <p class="button__wrap">
                        <a href="{{route('favoriteAds.show')}}"
                           class="button round small secondary " title="Annonces favorites">
                            <span class="button__icon"><i class="fas fa-star" aria-hidden="true"></i></span>
                        </a>
                    </p>
                </div>
                <div class="level-item">
                    <p class="button__wrap">
                        <a href="{{route('researches.show')}}"
                           class="button round small secondary " title="Mes recherches">
                            <span class="button__icon"><i class="fas fa-save" aria-hidden="true"></i></span>
                        </a>
                    </p>
                </div>
                <div class="level-item">
                    <p class="button__wrap">
                        <a href="{{route('notification.index')}}"
                           class="button round small secondary number-sticker-wrap "
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
                           class="button round small secondary number-sticker-wrap "
                           title="Consulter mes messages">
                            <span class="button__icon"><i class="fas fa-envelope"></i></span>
                            @if($numberOfUnreadMessages >0)
                                <span class="number-sticker">{{$numberOfUnreadMessages}}</span>
                            @endif
                        </a>
                    </p>

                </div>
                <div class="level-item">
                    <p class="button__wrap">
                        <a href="{{route('user.index')}}"
                           class="button round small secondary " title="Gérer mon profil">
                            <span class="button__icon"><i class="fas fa-user"></i></span>
                        </a>
                    </p>
                </div>
                <div class="level-item logout">
                    <a class="link-header" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
												 document.getElementById('logout-form').submit();">
							<span class="icon">
							<i class="fas fa-sign-out-alt"></i>
							</span>
                        <span>Se déconnecter</span>
                    </a>
{{--                    <span class="icon">--}}
{{--								<form id="logout-form" action="{{ route('logout') }}" method="POST"--}}
{{--                                      style="display: none;">--}}
{{--									@csrf--}}
{{--								</form>--}}
{{--							</span>--}}
                </div>
            @endguest
        </div>
    </nav>
</div>