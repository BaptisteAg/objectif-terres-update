<footer>
    <section class="bg-d-danger bg-trame_champs_dark">
        <div class="container is-full-width pt-50 pb-80">
            <div class="columns has-text-centered is-multiline is-marginless">
                <div class="column is-2-desktop is-half-tablet">
                    <h6 class="title is-6 text_white footer-site__title">TERRE DE LIENS</h6>
                    <p><a class="" target="_blank" href="{{ url('https://terredeliens.org/-un-mouvement-trois-piliers-.html') }}">Qui sommes nous ?</a>
                    </p>
                    <p><a class="" target="_blank" href="{{ url('https://terredeliens.org/-un-mouvement-trois-piliers-.html') }}">Notre mission</a></p>
                    <p><a class="" target="_blank" href="{{ url('https://terredeliens.org/-proteger-les-terres-.html') }}">Nos actions</a></p>
                    <p><a class="" target="_blank"
                          href="{{ url('https://terredeliens.org/-les-chiffres-clefs-.html') }}">Chiffres clés</a>
                    </p>
                    <p><a class="" target="_blank" href="#">Une question ? </a>
                    </p>
                </div>
                <div class="column is-2-desktop is-half-tablet">
                    <h6 class="title is-6 text_white footer-site__title">NOS AUTRES SITES</h6>
                    <p><a class="" target="_blank" href="{{ url('https://terredeliens.org/') }}">Terre de Liens</a></p>
                    <p><a class="" target="_blank" href="{{ url('https://ressources.terredeliens.org/') }}">Centre de
                            Ressources</a></p>
                    <p><a class="" target="_blank" href="{{ url('https://parcel-app.org/') }}">PARCEL</a></p>
                    <p><a class="" target="_blank" href="{{ url('https://www.accesstoland.eu/') }}">Access to land</a>
                    </p>
                </div>
                <div class="column is-2-desktop is-half-tablet">
                    <h6 class="title is-6 text_white footer-site__title">SUIVEZ-NOUS</h6>
                    <div class="level-item">
                        <a target="_blank" href="{{ url('https://www.facebook.com/terredeliens/') }}"
                           class="button round small secondary mr-10">
                            <span class="button__icon"><i class="fab fa-facebook-f" aria-hidden="true"></i></span>
                        </a>
                        <a target="_blank" href="{{ url('https://www.youtube.com/channel/UCFDSg22G3RXJ4th9imzaG1Q') }}"
                           class="button round small secondary mr-10"><span
                                    class="button__icon"><i class="fab fa-youtube" aria-hidden="true"></i></span>
                        </a>
                        <a target="_blank" href="{{ url('https://www.instagram.com/terredeliens/') }}"
                           class="button round small secondary mr-10"><span
                                    class="button__icon"><i class="fab fa-instagram" aria-hidden="true"></i></span>
                        </a>
                        <a target="_blank"
                           href="{{ url('https://twitter.com/Terredeliens?ref_src=twsrc%5Egoogle%7Ctwcamp%5Eserp%7Ctwgr%5Eauthor') }}"
                           class="button round small secondary"><span
                                    class="button__icon"><i
                                        class="fab fa-twitter" aria-hidden="true"></i></span>
                        </a>
                    </div>
                </div>
                <div class="column is-6-desktop pl-xl-50 pr-xl-50">
                    <form method="post" action="/newsletter">
                        {{ csrf_field() }}
                        <h6 class="title is-6 text_white footer-site__title">NEWSLETTER TERRE DE LIENS</h6>
                        <p>Suivez notre mouvement en vous abonnant.</p>
                        <div class="columns is-gapless is-mobile">
                            <div class="column">
                                <div class="field">
                                    <p class="control has-icons-left has-icons-right is-marginless">
                                        <input class="input" type="email" placeholder="email" name="email">
                                        <span class="icon is-small is-left">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="column is-narrow">
                                <button class="button is-normal is-link form-button basic primary">S'abonner</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <section class="bottom-bar_2">
        <div class="container">
            <div class="columns menu menu-intersites">
                <div class="column is-narrow menu__item is-paddingless"><a class="menu__link " href="/mentions-legales">Mentions
                        légales</a></div>
{{--                <div class="column is-narrow is-paddingless"><a class="menu__link " href="{{url('/')}}">Politique de--}}
{{--                        cookie</a></div>--}}
                <div class="column is-narrow is-paddingless"><a class="menu__link " href="{{route('conditions-utilisation')}}">Conditions
                        d'utilisation</a></div>
                <div class="column"><span>Tous droits réservés | © Terre de Liens - <?=date('Y')?></span></div>
            </div>
        </div>
    </section>
</footer>

