<header>
    <div>
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
                                <span>Bonjour, {{ Auth::user()->name }}, {{Auth::user()->first_name}}</span>
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
                        <div class="level-item bubble-wrap">
                            <p class="button__wrap">
                                <a href="#" class="button round small secondary "
                                   title="Accéder aux applis Terre de liens">
                                    <span class="button__icon"><i class="fas fa-th"></i></span>
                                </a>
                            </p>
                            <div class="bubble is-visible left">
                                <div class="bubble__container">
                                    <div class="bubble__scrollable-wrap">
                                        <div class="bubble__scrollable">
                                            <ul class="custom-menu menu-submenu tiles">
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
                                                       title="Centre
                                                                de
                                                                ressources">
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
                                    @if($numberOfUnreadMessages >=0)
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

        <a href="{{route('home')}}" class="main-nav__logo logo">
            <img src="/images/logo/logo_TdL_cartouche_blanc-rouge_500.png" alt="logo-terre-de-liens"/>
        </a>
        <input type="checkbox" id="main-nav__toggler"/>
        <div id="main-nav__hamburger">
            <div id="main-nav__hamburger__line" class="button__icon"></div>
        </div>
        <div id="main-nav__splash__wrap">
            <div id="main-nav__splash__transform-container" class="bg-trame_champs_dark">
                <div id="main-nav__splash__container">
                    <div class="main-nav__content">
                        <div id="vue-header">
                            <section id="above-top-bar-mobile">
                                <div class="columns is-mobile is-centered mt-10 mt-sm-30">
                                    <div class="column is-half">
                                        <p class="menu-search__title has-text-centered">Recherche</p>
                                    </div>
                                </div>
                                <header-page id="header-page" inline-template
                                             :old-search-values="{{json_encode(old())}}">
                                    {!! Form::open(['route' => 'researches.index', 'method' => 'get']) !!}
                                    <div class="columns is-mobile is-centred is-multiline">
                                        <div class="column is-full-mobile has-text-centered pt-40">
                                            <div style="display:inline-block; padding-top: 7px;">
                                                <p class="pr-10 text_white">Je</p>
                                            </div>
                                            <div class="select form-field">
                                                <label for="select"></label>
                                                {{ Form::select('offer_type',
                                                    ['OfferAd' => 'Cherche ', 'SeekAd' => 'Propose'],
                                                    null,
                                                    ['v-model' => 'offerTypeSelected', "class"=> 'form-field'  ]
                                                ) }}
                                            </div>

                                            <div class="select form-field">
                                                <label for="select form-field"></label>
                                                {{ Form::select('ad_category',
                                                    ['land' => 'une terre ', 'job' => 'un emploi'],
                                                    null,
                                                    ['v-model' => 'adCategorySelected',
                                                    "class"=> 'form-field'
                                                   ]
                                                ) }}
                                            </div>
                                        </div>
                                        <div class="column is-full-mobile  has-text-centered">
                                            <div style="display:inline-block; padding-top: 2px;">
                                                <p class="text_white">ici : </p>
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
                                        <div class="column is-half is-offset-3-mobile">
                                            <div class="has-text-centered">
                                                {!! Form::submit('Rechercher', ['class' => ' button basic primary']) !!}
                                                <br>
                                                <a class="is-block mt-5" href="#" @click="more_criteria()"
                                                   onclick="extendHeaderMobileContainer()">Plus de critères</a>
                                            </div>

                                        </div>
                                    </div>
                                    <div v-show="isFormOpen" class="has-ba mb-15" style="display : none">
                                        <div class="container-custom bg-l-pearl"
                                             v-if="adCategorySelected === 'job'">
                                            @include('layouts.partials.headerJobResearch')
                                        </div>
                                        <div class="container-custom bg-l-pearl"
                                             v-if="adCategorySelected === 'land'">
                                            @include('layouts.partials.headerLandResearch')
                                        </div>
                                    </div>
                                    {!! Form::close() !!}
                                </header-page>
                            </section>
                            <div class="top-bar">
                                <section class="fw-section top-bar__1">
                                    <div id="top-bar__1__desktop">
                                        <header-page id="header-page" inline-template
                                                     :old-search-values="{{json_encode(old())}}">
                                            {!! Form::open(['route' => 'researches.index', 'method' => 'get']) !!}
                                            <div class="container-custom bg-trame_champs_dark mb-5">
                                                <div class="columns is-mobile is-vcentered is-multiline">
                                                    <div class="column is-full-tablet is-paddingless is-5-widescreen">
                                                        <div class="columns is-vcentered is-centered">
                                                            <div class="column is-2-desktop is-3-widescreen is-one-fifth-tablet">
                                                                <figure class="image is-square">
                                                                    <a class=" logo logo_TdL"
                                                                       href="{{route ('home')}}">
                                                                        <img class="is-rounded"
                                                                             src="/images/logo/logo_TdL_cartouche_blanc-rouge_500.png"
                                                                             alt="objectif-terres-logo">
                                                                    </a>
                                                                </figure>
                                                            </div>
                                                            <div class="column is-narrow-tablet is-narrow-widescreen">
                                                                <h1 class="title is-1 mb-0">
                                                                    <a class="text_charcoal" href="{{route ('home')}}">
                                                                        Objectif Terres
                                                                    </a>
                                                                </h1>

                                                                <h4 class=" text_success mt-5">Réalisez votre projet
                                                                    agricole.</h4>
                                                                <p>Une initiative Terre de Liens</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="column is-7-widescreen">
                                                        <div class="columns is-vcentered">
                                                            <div class="column has-text-centered">
                                                                <div style="display:inline-block; padding-top: 7px;">
                                                                    <p class="pr-10">Je</p>
                                                                </div>
                                                                <div class="select form-field">
                                                                    <label for="select"></label>
                                                                    {{ Form::select('offer_type',
                                                                        ['OfferAd' => 'Cherche ', 'SeekAd' => 'Propose'],
                                                                        null,
                                                                        ['v-model' => 'offerTypeSelected', "class"=> 'form-field'  ]
                                                                    ) }}
                                                                </div>

                                                                <div class="select form-field">
                                                                    <label for="select form-field"></label>
                                                                    {{ Form::select('ad_category',
                                                                        ['land' => 'une terre ', 'job' => 'un emploi'],
                                                                        null,
                                                                        ['v-model' => 'adCategorySelected',
                                                                        "class"=> 'form-field'
                                                                       ]
                                                                    ) }}
                                                                </div>
                                                            </div>
                                                            <div class="column ">
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
                                                            <div class="column is-narrow-tablet has-text-centered"
                                                                 style="padding-top: 38px;">
                                                                {!! Form::submit('Rechercher', ['class' => ' button basic primary']) !!}
                                                                <br>
                                                                <a class="has-text-left" href="#" @click="more_criteria()">Plus de critères</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{--<div class="column is-3-desktop is-one-third-tablet has-text-centered pt-40">
                                                        <div style="display:inline-block; padding-top: 7px;">
                                                            <p class="pr-10">Je</p>
                                                        </div>
                                                        <div class="select form-field">
                                                            <label for="select"></label>
                                                            {{ Form::select('offer_type',
                                                                ['OfferAd' => 'Cherche ', 'SeekAd' => 'Propose'],
                                                                null,
                                                                ['v-model' => 'offerTypeSelected', "class"=> 'form-field'  ]
                                                            ) }}
                                                        </div>

                                                        <div class="select form-field">
                                                            <label for="select form-field"></label>
                                                            {{ Form::select('ad_category',
                                                                ['land' => 'une terre ', 'job' => 'un emploi'],
                                                                null,
                                                                ['v-model' => 'adCategorySelected',
                                                                "class"=> 'form-field'
                                                               ]
                                                            ) }}
                                                        </div>
                                                    </div>
                                                    <div class="column is-2-desktop is-one-third-tablet pt-40">
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
                                                    <div class="column is-2-desktop is-one-third-tablet has-text-centered pt-40"
                                                         style="padding-top: 38px;">
                                                        {!! Form::submit('Rechercher', ['class' => ' button basic primary']) !!}
                                                        <br>
                                                        <a class="has-text-left" href="#" @click="more_criteria()">Plus de critères</a>
                                                    </div>--}}

                                                </div>
                                            </div>
                                            <div v-show="isFormOpen" class="has-ba">
                                                <div class="container-custom bg-l-pearl"
                                                     v-if="adCategorySelected === 'job'">
                                                    @include('layouts.partials.headerJobResearch')
                                                </div>
                                                <div class="container-custom bg-l-pearl"
                                                     v-if="adCategorySelected === 'land'">
                                                    @include('layouts.partials.headerLandResearch')
                                                </div>
                                            </div>
                                            {!! Form::close() !!}
                                        </header-page>
                                    </div>
                                    <div id="top-bar__1__mobile">
                                        @guest
                                            <div class="text_white mb-20 has-text-weight-bold">
                                                <div class="level-item">Bienvenue !</div>
                                                <div class="level-item">
                                                    <a class="link-header"
                                                       href="{{ route('login') }}">Connectez-vous </a>
                                                    @if(Route::has('register'))
                                                        <span class="mr-5 ml-5">ou</span>
                                                        <a href="{{ route('register') }}"> Créez un compte</a>
                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            <div class="level">
                                                <div class="level-item">
                                                    @if(auth()->user()->role === 0 )
                                                        <a class="navbar-item button is-bordered"
                                                           href="{{route('user.index')}}">
														<span class="icon">
															<i class="far fa-user"></i>
														</span>
                                                            <span>Bonjour, ({{ Auth::user()->first_name }} {{Auth::user()->name}})</span>
                                                        </a>
                                                    @else
                                                        <div class="dropdown">
                                                            <div class="dropdown-trigger">
                                                                <button class="button  button-dropdown"
                                                                        aria-haspopup="true"
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
                                                            <div class="dropdown-menu"
                                                                 role="menu">
                                                                <div class="dropdown-content">
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
                                                <div class="level-item">
                                                    <div class="bubble-wrap">
                                                        <a href="#"
                                                           class="button round small danger "
                                                           title="Accéder aux applis Terre de liens">
																<span class="button__icon"><i
                                                                            class="fas fa-th"></i></span>
                                                        </a>
                                                        <div class="bubble is-visible right">
                                                            <div class="bubble__container">
                                                                <div class="bubble__scrollable-wrap">
                                                                    <div class="bubble__scrollable">
                                                                        <ul class="custom-menu menu-submenu ">
                                                                            <li class="tile_icon-label">
                                                                                <a href="#"
                                                                                   class="menu__link tile__link"
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
                                                                                <a href="#"
                                                                                   class="menu__link tile__link"
                                                                                   title="Consulter mes notifications">
                                                                            <span class="tile__icon"><img
                                                                                        src="/images/icons/picto_app_1.PNG"></span>
                                                                                    <div class="tile__content">
                                                                                        <p class="tile__title">
                                                                                            terredeliens.org</p>
                                                                                        <p class="tile__intro">Le site
                                                                                            national
                                                                                            de Terre de Liens</p>
                                                                                    </div>
                                                                                </a>
                                                                            </li>
                                                                            <li class="tile_icon-label">
                                                                                <a href="#"
                                                                                   class="menu__link tile__link"
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
                                                                                <a href="#"
                                                                                   class="menu__link tile__link"
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
                                                                                <a href="#"
                                                                                   class="menu__link tile__link"
                                                                                   title="Consulter mes notifications">
                                                                            <span class="tile__icon"><img
                                                                                        src="/images/icons/diagnostic-ferme.png"></span>
                                                                                    <div class="tile__content">
                                                                                        <p class="tile__title">
                                                                                            Diaganostic
                                                                                            Ferme</p>
                                                                                        <p class="tile__intro">
                                                                                            Diagnostiquer,
                                                                                            collecter et partager des
                                                                                            données
                                                                                            sur les fermes
                                                                                    </div>
                                                                                </a>
                                                                            </li>
                                                                            <li class="tile_icon-label">
                                                                                <a href="#"
                                                                                   class="menu__link tile__link"
                                                                                   title="Consulter mes notifications">
                                                                            <span class="tile__icon"><img
                                                                                        src="/images/icons/phototheque.png"></span>
                                                                                    <div class="tile__content">
                                                                                        <p class="tile__title">
                                                                                            Photothèque </p>
                                                                                        <p class="tile__intro"> Partager
                                                                                            les
                                                                                            photos de Terre de Liens
                                                                                            pour
                                                                                            une
                                                                                            agriculture photogénique</p>
                                                                                    </div>
                                                                                </a>
                                                                            </li>
                                                                            <li class="tile_icon-label">
                                                                                <a href="#"
                                                                                   class="menu__link tile__link"
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
                                                                                <a href="#"
                                                                                   class="menu__link tile__link"
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
                                                    <div>
                                                        <p class="button__wrap">
                                                            <a href="{{route('notification.index')}}"
                                                               class="button round small danger number-sticker-wrap "
                                                               title="Consulter mes notifications">
															<span class="button__icon"><i
                                                                        class="fas fa-bell"></i></span>
                                                                @unless(auth()->user()->unreadNotifications->isEmpty())
                                                                    <span class="number-sticker number-sticker-alternative">{{auth()->user()->unreadNotifications->count()}}</span>
                                                                @endunless
                                                            </a>
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <p class="button__wrap ">
                                                            <a href="{{route('threads.index')}}"
                                                               class="button round small danger number-sticker-wrap "
                                                               title="Consulter mes messages">
														<span class="button__icon"><i
                                                                    class="fas fa-envelope"></i></span>
                                                                @if($numberOfUnreadMessages >=0)
                                                                    <span class="number-sticker number-sticker-alternative">{{$numberOfUnreadMessages}}</span>
                                                                @endif
                                                            </a>
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <p class="button__wrap">
                                                            <a href="{{route('user.index')}}"
                                                               class="button round small danger "
                                                               title="Gérer mon profil">
															<span class="button__icon"><i
                                                                        class="fas fa-user"></i></span>
                                                            </a>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="level-item">
                                                    <div class="has-text-centered">

                                                        <a class="dropdown-item link-header"
                                                           href="{{ route('logout') }}"
                                                           onclick="event.preventDefault();
												 document.getElementById('logout-form').submit();">
												<span class="icon">
												<i class="fas fa-sign-out-alt"></i>
												</span>
                                                            <span>Se déconnecter</span>
                                                        </a>
                                                        <span class="icon">
														<form id="logout-form" action="{{ route('logout') }}"
                                                              method="POST"
                                                              style="display: none;">
															@csrf
														</form>
													</span>

                                                    </div>
                                                </div>
                                            </div>

                                        @endguest
                                        <div class="top-bar__1__CTA has-text-centered">
                                            <div class="mb-10">
                                                <a href="#" class="button basic success ">
                                                    <span class="button__icon"></span><i
                                                            class="fas fa-hand-holding-heart"></i>
                                                    <span class="button__label">Nous soutenir</span>
                                                </a>
                                            </div>
                                            <div class="">
                                                <a class="button basic secondary "
                                                   href="/qui-sommes-nous"><span
                                                            class="button__label">Qui sommes-nous ?</span></a>
                                            </div>
                                        </div>

                                    </div>

                                </section>
                                <section class="fw-section top-bar__2">
                                    <div class="container is-fluid custom-menu-container ">
                                        <ul class="custom-menu menu-site ">
                                            <li>
                                                <a href="{{route('home')}}" class="menu__link">
                                                    <i class="fas fa-home"></i>
                                                </a>
                                            </li>
                                            <li class="bubble-wrap">
                                                <a href="#" class="menu__link ">
                                                    Je souhaite
                                                </a>
                                                <div class="bubble is-visible fluid bubble_danger">
                                                    <div class="bubble__container bubble__container_danger ">
                                                        <ul class="custom-menu menu-submenu">
                                                            <li>
                                                                <a class="menu__link menu__link_danger "
                                                                   href="/louer-vendre-mes-terres">m'installer
                                                                    paysan</a>
                                                            </li>
                                                            <li>
                                                                <a class="menu__link menu__link_danger "
                                                                   href="/ceder-ma-ferme">trouver une terre ou des
                                                                    financements</a>
                                                            </li>
                                                            <li>
                                                                <a class="menu__link menu__link_danger "
                                                                   href="/trouver-un-emploi">transmettre ma ferme</a>
                                                            </li>
                                                            <li>
                                                                <a class="menu__link menu__link_danger "
                                                                   href="/confier-mes-terres">faire une donation ou un
                                                                    leg à Terre
                                                                    de Liens</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="bubble-wrap">
                                                <a href="#" class="menu__link ">
                                                    Je suis
                                                </a>
                                                <div class="bubble is-visible fluid bubble_danger">
                                                    <div class="bubble__container bubble__container_danger ">
                                                        <ul class="custom-menu menu-submenu">
                                                            <li>
                                                                <a class="menu__link menu__link_danger "
                                                                   href="">en reconversion professionnelle avec un
                                                                    projet
                                                                    d'installation</a>
                                                            </li>
                                                            <li>
                                                                <a class="menu__link menu__link_danger "
                                                                   href="">un candidat à l'installation en recherche de
                                                                    terres</a>
                                                            </li>
                                                            <li>
                                                                <a class="menu__link menu__link_danger "
                                                                   href="">un paysan (bientôt) à la retraite</a>
                                                            </li>
                                                            <li>
                                                                <a class="menu__link menu__link_danger "
                                                                   href="">un propriétaire de foncier</a>
                                                            </li>
                                                            <li>
                                                                <a class="menu__link menu__link_danger "
                                                                   href="">une collectivité </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <a class="menu__link " href="#">Questions
                                                    fréquentes</a>
                                            </li>
                                            <li>
                                                <a class="menu__link " href="#">Première visite ?</a>
                                            </li>
                                            <li class="secondary">
                                                <a href="/accompagnement/demarrer"
                                                   class="menu__link ">Être
                                                    accompagné</a>
                                            </li>
                                            <li class="secondary">
{{--                                                @if(Auth::check())
                                                    @if(auth()->user()->role === 1 )
                                                        <a href="{{ route('moderator.index') }}"
                                                           class="menu__link ">Espace
                                                            modérateur</a>
                                                    @elseif(auth()->user()->role === 2)
                                                        <a href="{{ route('advisor.index') }}"
                                                           class="menu__link ">Espace
                                                            primo-accueillant</a>

                                                    @elseif (auth()->user()->role >= 3)
                                                        <a href="{{ route('supervisor.index') }}"
                                                           class="menu__link ">Espace
                                                            responsable territorial</a>
                                                    @else
                                                        <a href="{{ route('ads.create') }}"
                                                           class="menu__link ">Déposer
                                                            une
                                                            annonce</a>

                                                    @endif
                                                @else--}}
                                                    <a href="{{ route('ads.create') }}"
                                                       class="menu__link ">Déposer
                                                        une
                                                        annonce</a>
{{--                                            @endif--}}
                                            </li>
                                        </ul>
                                        <br>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if( Auth::check() and auth()->user()->role >=1)
            <div class="mt-25">
                @if(auth()->user()->role ==1)
                    @include('components.moderator-tabs')
                @elseif(auth()->user()->role ==2)
                    @include('components.advisor-tabs')
                @elseif(auth()->user()->role >=3)
                    @include('components.supervisor-tabs')
                @endif
            </div>
        @endif
    </div>
</header>

