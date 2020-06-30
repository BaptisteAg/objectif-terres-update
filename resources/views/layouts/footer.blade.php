<footer>
    <section class="bg-d-danger bg-trame_champs_dark">
        <div class="container is-full-width pt-50 pb-80">
            <div class="columns has-text-centered is-multiline is-marginless">
                <div class="column is-one-fifth-desktop is-half-tablet">
                    <h6 class="title is-6 text_white footer-site__title">NOS AUTRES SITES</h6>
                    <p><a class="" href="{{ url('/') }}">Terres de liens</a></p>
                    <p><a class="" href="{{ url('/') }}">Centres de Ressources</a></p>
                    <p><a class="" href="{{ url('/') }}">Parcel</a></p>
                </div>
                <div class="column is-one-fifth-desktop is-half-tablet">
                    <h6 class="title is-6 text_white footer-site__title">SUIVEZ-NOUS</h6>
                    <div class="level-item">
                        <a href="{{ url('/') }}" class="button round small secondary mr-10">
                            <span class="button__icon"><i class="fab fa-facebook-f" aria-hidden="true"></i></span>
                        </a>
                        <a href="{{ url('/') }}" class="button round small secondary mr-10"><span class="button__icon"><i class="fab fa-twitter" aria-hidden="true"></i></span></a>
                        <a href="{{ url('/') }}" class="button round small secondary mr-10"><span class="button__icon"><i class="fab fa-instagram" aria-hidden="true"></i></span></a>
                        <a href="{{ url('/') }}" class="button round small secondary"><span class="button__icon"><i class="fab fa-linkedin-in" aria-hidden="true"></i></span></a>
                    </div>
                </div>
                <div class="column pl-xl-50 pr-xl-50">
                    <h6 class="title is-6 text_white footer-site__title">NEWSLETTER TERRE DE LIENS</h6>
                    <p>On l’appelle newsletter, mais c’est beaucoup plus ! Abonnez-vous pour suivre notre mouvement.</p>
                    <div class="columns is-gapless is-mobile">
                        <div class="column">
                            <div class="field">
                                <p class="control has-icons-left has-icons-right is-marginless">
                                    <input class="input" type="email" placeholder="email">
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
                </div>
                <div class="column is-one-quarter-desktop is-half-tablet">
                    <h6 class="title is-6 text_white footer-site__title">Une question ?</h6>
                    <p>Nous répondrons à vos questions !</p>
                    <a class="button basic small primary " href="/contact"><span class="button__label">Poser une question</span></a>
                </div>
            </div>
        </div>
    </section>
    <section class="bottom-bar_2">
        <div class="container">
            <div class="columns menu menu-intersites">
                <div class="column is-narrow menu__item is-paddingless"><a class="menu__link " href="/mentions-legales">Mentions légales</a> </div>
                <div class="column is-narrow is-paddingless"><a class="menu__link " href="{{url('/')}}">Politique de cookie</a></div>
                <div class="column is-narrow is-paddingless"><a class="menu__link " href="{{url('/')}}">Conditions d'utilisation</a></div>
                <div class="column"><span>©<?=date('Y')?> - Terre de Liens | All right reserved</span></div>
            </div>
        </div>
    </section>
</footer>

