<header>
    <div>
        <div class="container-custom bg-d-primary">
            <nav class="level">
                <div class="level-left">
                    <div class="level-item">
                        <a href="/" class="button button basic secondary without-styles">
                            <span class="button__label">Nous soutenir</span>
                        </a>
                    </div>
                    <div class="level-item">
                        <a href="/qui-sommes-nous">Qui sommes nous ?</a>
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
                                    <span>Mon compte ({{ Auth::user()->name }}, {{Auth::user()->first_name}})</span>
                                </a>
                            @else
                                <div class="dropdown">
                                    <div class="dropdown-trigger">
                                        <button class="button" aria-haspopup="true" aria-controls="dropdown-menu">
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
                                                <a href="{{route('supervisor.index')}}" class="dropdown-item">
                                                    Espace responsable territorial
                                                </a>
                                            @endif

                                            @if(auth()->user()->role >= 2 )
                                                <a href="{{route('advisor.index')}}" class="dropdown-item">
                                                    Espace primo-accueillant
                                                </a>
                                            @endif

                                            @if(auth()->user()->role >= 1 )
                                                <a href="{{route('moderator.index')}}" class="dropdown-item">
                                                    Espace modérateur
                                                </a>
                                            @endif
                                            {{--											<hr class="dropdown-divider">--}}
                                            {{--											<a href="#" class="dropdown-item">--}}
                                            {{--												Autre lien séparé--}}
                                            {{--											</a>--}}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="level-item">
							<span class="notification-container">
								<a href="{{route('notification.index')}}"><i class="far fa-bell"></i></a>
							@unless(auth()->user()->unreadNotifications->isEmpty())
                                    <span
                                            class="notification-counter">{{auth()->user()->unreadNotifications->count()}}</span>
                                @endunless
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

        <div class="main-nav__content">
            <div id="vue-header">
                <header-page id="header-page" inline-template
                             :old-search-values="{{json_encode(old())}}">
                    {!! Form::open(['route' => 'researches.index', 'method' => 'get']) !!}
                    <div class="container-custom bg-trame_champs_dark">
                        <div class="columns is-desktop is-vcentered">
                            <div class="column is-1">
                                <figure class="image is-128x128">
                                    <a class="without-styles" href="{{route ('home')}}">
                                        <img class="is-rounded" src="/images/logo/logo_TdL_cartouche_blanc-rouge_500.png"
                                             alt="objectif-terres-logo">
                                    </a>
                                </figure>
                            </div>
                            <div class="column is-4 ">
                                <a class="without-styles" href="{{route ('home')}}">
                                    <h1 class="title is-1 m-b-0" >Objectif Terres</h1>
                                </a>
                                <h4 class=" text_green m-t-5">Réalisez votre projet agricole.</h4>
                                <p>Une initiative Terre de Liens</p>
                            </div>
                            <div class="column is-2 has-text-centered p-t-40">
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
                            <div class="column is-2  p-t-40" >
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
                            <div class="column has-text-centered  p-t-40 " style="padding-top: 38px;">
                                {!! Form::submit('Rechercher', ['class' => ' button basic primary']) !!}<br>
                                <a class="has-text-left" href="#" @click="more_criteria()">Plus de critère</a>
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

            
            <div class="container is-fluid menu-container ">
                <ul class="menu menu-site ">
                    <li>
                        <a href="#" class="menu__link">
                            <i class="fas fa-home"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="menu__link">A propos</a>
                    </li>
                    <li>
                        <a href="#" class="menu__link">Ressources</a>
                    </li>
                    <li>
                        <a href="#" class="menu__link">Initiatives</a>
                    </li>
                    <li>
                        <a href="#" class="menu__link">Dossiers thématiques</a>
                    </li>
                    <li class="separator">
                        <a href="#" class="menu__link">Guides et formations</a>
                    </li>
                    <li class="secondary">
                        <a href="#" class="menu__link">Porteurs de projets</a>
                    </li>
                    <li class="secondary">
                        <a href="#" class="menu__link">Territoires et collectivités</a>
                    </li>
                </ul>
{{--                <nav class="navbar is-boxed">--}}
{{--                    <div class="navbar-menu" id="navbarMenu">--}}
{{--                        <div class="navbar-start">--}}
{{--                            <a class="navbar-item">Accueil</a>--}}
{{--                            <div class="navbar-item has-dropdown is-hoverable">--}}
{{--                                <a class="navbar-link">Je souhaite</a>--}}
{{--                                <div class="navbar-dropdown">--}}
{{--                                    <a class="navbar-item" href="/minstaller-comme-paysan">M'installer comme paysan</a>--}}
{{--                                    <a class="navbar-item" href="/louer-vendre-mes-terres">Louer ou vendre mes terres</a>--}}
{{--                                    <a class="navbar-item" href="/ceder-ma-ferme">Céder ma ferme</a>--}}
{{--                                    <a class="navbar-item" href="/trouver-un-emploi">Trouver un emploi</a>--}}
{{--                                    <a class="navbar-item" href="/confier-mes-terres">Confier mes terres</a>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="navbar-item has-dropdown is-hoverable">--}}
{{--                                <a class="navbar-link">Je suis</a>--}}
{{--                                <div class="navbar-dropdown">--}}
{{--                                    <a class="navbar-item">About</a>--}}
{{--                                    <a class="navbar-item">Jobs</a>--}}
{{--                                    <a class="navbar-item">Contact</a>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <a class="menu__link">Témoignages & chiffres clés</a>--}}
{{--                        </div>--}}
{{--                        <div class="navbar-end">--}}
{{--                            <div class="navbar-item">--}}
{{--                                <div class="buttons">--}}
{{--                                    <a class="navbar-item">Ressources utiles</a>--}}
{{--                                    <a class="navbar-item button is-bordered" href="/accompagnement/demarrer">Être--}}
{{--                                        accompagné</a>--}}

{{--                                    @if(false)--}}
{{--                                        @if(auth()->user()->role === 1 )--}}
{{--                                            <a href="{{ route('moderator.index') }}" class="button is-bordered">Espace--}}
{{--                                                modérateur</a>--}}
{{--                                        @elseif(auth()->user()->role === 2)--}}
{{--                                            <a href="{{ route('advisor.index') }}" class="button is-bordered">Espace--}}
{{--                                                primo-accueillant</a>--}}
{{--                                        @elseif (auth()->user()->role >= 3)--}}
{{--                                            <a href="{{ route('supervisor.index') }}" class="button is-bordered">Espace--}}
{{--                                                responsable territorial</a>--}}
{{--                                        @else--}}
{{--                                            <a href="{{ route('ads.create') }}" class="button is-bordered">Déposer une--}}
{{--                                                annonce</a>--}}
{{--                                        @endif--}}
{{--                                    @else--}}
{{--                                        <a href="{{ route('ads.create') }}" class="navbar-item button is-bordered">Déposer--}}
{{--                                            une--}}
{{--                                            annonce</a>--}}
{{--                                    @endauth--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </nav>--}}
                @if( Auth::check() and auth()->user()->role <1)
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
        </div>


    </div>
</header>

