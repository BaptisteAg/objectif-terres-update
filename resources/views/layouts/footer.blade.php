<footer>
    <section class="bg-d-danger bg-trame_champs_dark">
        <div class="container is-full-width pt-50 pb-80">
            <div class="columns has-text-centered">
                <div class="column is-one-fifth">
                    <h6 class="title is-6">NOS AUTRES SITES</h6>
                    <p><a href="{{ url('/') }}">Terres de liens</a></p>
                    <p><a href="{{ url('/') }}">Centres de Ressources</a></p>
                    <p><a href="{{ url('/') }}">Parcel</a></p>
                </div>
                <div class="column">
                    <h6 class="title is-6">SUIVEZ-NOUS</h6>
                    <div class="level-item">
                        <a href="{{ url('/') }}" class="button round small secondary mr-5">
                            <span class="button__icon"><i class="fab fa-facebook-f" aria-hidden="true"></i></span>
                        </a>
                        <a href="{{ url('/') }}" class="button round small secondary mr-5"><span class="button__icon"><i class="fab fa-twitter" aria-hidden="true"></i></span></a>
                        <a href="{{ url('/') }}" class="button round small secondary mr-5"><span class="button__icon"><i class="fab fa-instagram" aria-hidden="true"></i></span></a>
                        <a href="{{ url('/') }}" class="button round small secondary"><span class="button__icon"><i class="fab fa-linkedin-in" aria-hidden="true"></i></span></a>
                    </div>
                </div>
                <div class="column">
                    <h6 class="title is-6">NEWSLETTER TERRE DE LIENS</h6>
                    <p>On l’appelle newsletter, mais c’est beaucoup plus ! Abonnez-vous pour suivre notre mouvement.</p>
                    <div class="columns is-gapless">
                        <div class="column is-three-fifths">
                            <div class="field">
                                <p class="control has-icons-left has-icons-right">
                                    <input class="input" type="email" placeholder="email">
                                    <span class="icon is-small is-left">
                                     <i class="fas fa-envelope"></i>
                                </span>
                                </p>
                            </div>
                        </div>
                        <div class="column">
                            <button class="button is-normal is-link">S'abonner</button>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <h6 class="title is-6">Une question ?</h6>
                    <p>Nous répondrons à vos questions !</p>
                    <a href="/contact">Poser une question</a>
                </div>
            </div>
        </div>
    </section>
    <section class="bottom-bar_2 pt-15 pb-15">
        <div class="container">
            <div class="columns">
                <div class="column is-two-thirds">
                    <div class="columns menu menu-intersites">
                        <div class="column is-narrow menu__item"><a class="menu__link" href="/mentions-legales">Mentions légales</a> </div>
                        <div class="column is-narrow "><a class="menu__link" href="{{url('/')}}">Politique de cookie</a></div>
                        <div class="column is-narrow"><a class="menu__link" href="{{url('/')}}">Conditions d'utilisation</a></div>
                        <div class="column"><span>©<?=date('Y')?> - Terre de Liens | All right reserved</span></div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</footer>

