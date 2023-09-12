<div id="top-bar-user-menu" class="level-right pt-0 pb-15">
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
                            @if((Auth::user()->first_name == null) && (Auth::user()->name == null))
                                <span>{{Auth::user()->email}} </span>

                            @else
                                <span>{{Auth::user()->first_name != null ? Auth::user()->first_name : ""}} {{ Auth::user()->name != null ? Auth::user()->name : "" }} </span>
                            @endif
                            <span class="icon is-small">
                                        <i class="fas fa-angle-down" aria-hidden="true"></i>
                                    </span>
                        </button>
                    </div>
                    <div class="dropdown-menu" id="header-dropdown-menu" role="menu">
                        <div class="dropdown-content" onclick="">
                            @if(auth()->user()->role >= 4 )
                                <a href="{{\Laravel\Nova\Nova::path()}}"
                                   class="dropdown-item  text_charcoal ">
                                    Administration
                                </a>
                            @endif
                            @if(auth()->user()->role >= 3 )
                                <a href="{{route('supervisor.index')}}"
                                   class="dropdown-item  text_charcoal ">
                                    Tableau de bord
                                </a>
                            @endif
                            @if(auth()->user()->role >= 2 )
                                @if(auth()->user()->role >=3)
                                    <a href="{{route('advisor.index')}}"
                                       class="dropdown-item  text_charcoal">
                                        Gestion des accompagnements
                                    </a>
                                @else
                                    <a href="{{route('advisor.index')}}"
                                       class="dropdown-item  text_charcoal">
                                        Espace primo-accueillant
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

        {{--                <div class="level-item">--}}
        {{--                    <p class="button__wrap">--}}
        {{--                        <a href="{{route('favoriteAds.show')}}"--}}
        {{--                           class="button round small secondary " title="Annonces favorites">--}}
        {{--                            <span class="button__icon"><i class="fas fa-star" aria-hidden="true"></i></span>--}}
        {{--                        </a>--}}
        {{--                    </p>--}}
        {{--                </div>--}}
        {{--                <div class="level-item">--}}
        {{--                    <p class="button__wrap">--}}
        {{--                        <a href="{{route('researches.show')}}"--}}
        {{--                           class="button round small secondary " title="Mes recherches">--}}
        {{--                            <span class="button__icon"><i class="fas fa-save" aria-hidden="true"></i></span>--}}
        {{--                        </a>--}}
        {{--                    </p>--}}
        {{--                </div>--}}
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
                   class="button round small secondary " title="Accéder à mon compte">
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
<vue-header
        :unread_messages="{{$numberOfUnreadMessages}}"
        :unread_notifications="{{auth()->user()->unreadNotifications->count()}}"
        :routes="{
  home: '{{ route('home') }}',
  login: '{{ route('login') }}',
  logout: '{{ route('logout') }}',
  account: '{{route('user.index')}}',
  messages: '{{route('threads.index')}}',
  notifications: '{{route('notification.index')}}',
  @if(auth()->user()->role >= 4 )
  role_4: '{{ \Laravel\Nova\Nova::path() }}',
  @endif
  @if(auth()->user()->role >= 3 )
  role_3: '{{ route('supervisor.index') }}',
  @endif
  @if(auth()->user()->role >= 2 )
  role_2: '{{ route('advisor.index') }}',
  @endif
  @if(auth()->user()->role >= 1 )
  role_1: '{{ route('moderator.index') }}',
  @endif
  about_us: '{{ route('qui-sommes-nous') }}',
  create_ads: '{{ route('ads.create') }}',
  all_ads: '{{route('researches.index', ['ad_category' => 'all'])}}',
}"></vue-header>
