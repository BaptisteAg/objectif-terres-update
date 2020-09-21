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
                                        Tableau de bord
                                    </a>
                                @endif
                                @if(auth()->user()->role >= 2 )
                                    @if(auth()->user()->role >=3 )
                                        <a href="{{route('advisor.index')}}"
                                           class="dropdown-item  text_charcoal">
                                            espace gestion des accompagnements
                                        </a>
                                    @else
                                        <a href="{{route('advisor.index')}}"
                                           class="dropdown-item  text_charcoal">
                                            espace primo-accueillant
                                        </a>
                                    @endif
                                @endif

                                @if(auth()->user()->role >= 1 )
                                    @if(auth()->user()->role >=3)
                                        <a href="{{route('moderator.index')}}"
                                           class="dropdown-item  text_charcoal">
                                            Gestion des annonces
                                        </a>
                                    @else
                                        <a href="{{route('moderator.index')}}"
                                           class="dropdown-item  text_charcoal">
                                            Espace modérateur
                                        </a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            @include('layouts.header.lanceur-applications-mobile')

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
            <a target="_blank" href="{{url('https://soutenir.terredeliens.org/objectifterre/~mon-don')}}" class="button basic success ">
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