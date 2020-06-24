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