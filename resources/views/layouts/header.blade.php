<header>
    <div class="container-custom">
        <nav class="level">
            <div class="level-left">
                <div class="level-item">
                    <a href="/" class="button">Nous soutenir</a>
                </div>
                <div class="level-item">
                    <a href="/" class="">Qui sommes nous ?</a>
                </div>
                <div class="level-item">
                    <a href="/" class="">Contactez-nous</a>
                </div>
            </div>
            <div class="level-right">
                <div class="level-item">Bienvenue !  </div>
                <div class="level-item"><a href="">Connectez-vous</a></div>
                <div class="level-item">ou</div>
                <div class="level-item"><a href="">créez un compte</a></div>
                <div class="level-item">
                <span class="icon">
                    <a href=""><i class="far fa-bell"></i></a>
                </span>
                </div>
                <div class="level-item">
                <span class="icon">
                    <a href=""><i class="far fa-envelope"></i></a>
                </span>
                </div>
                <div class="level-item">
                <span class="icon">
                    <a href=""><i class="far fa-user"></i></a>
                </span>
                </div>
            </div>
        </nav>
    </div>
    <div class="container-custom has-background-grey-lighter">
        <div class="columns">
            <div class="column is-1">
                <figure class="image is-128x128">
                    <img class="is-rounded" src="http://placehold.it/200x200" alt="">
                </figure>
            </div>
            <div class="column is-2">
                <h3 class="title">Objectif Terre</h3>
                <h4 class="subtitle">Réalisez votre projet agricole.</h4>
                <p>Une initiative Terre de Liens</p>
            </div>
            <div class="column is-2">
                <p>Je cherche</p>
                <div class="select">
                    <label for="select"></label>
                    <select id="select">
                        <option>Des offres</option>
                        <option>Des propositions</option>
                    </select>
                </div>
            </div>
            <div class="column is-2">
                <div class="control">
                    <label class="radio is-block">
                        <input type="radio" name="answer">
                        de terres/ferme
                    </label>
                    <label class="radio is-block is-marginless">
                        <input type="radio" name="answer">
                        d'emploi
                    </label>
                </div>
            </div>
            <div class="column is-3">
                <p>Où</p>
                <div class="select">
                    <label for="select"></label>
                    <select id="select">
                        <option>Toutes les régions</option>
                        <option>Auvergne Rhône Alpes</option>
                    </select>
                </div>
                <button class="button">Rechercher</button>
            </div>
            <div class="column is-2">
                <a href="/">Plus de critère</a>
            </div>
        </div>
    </div>
    <div class="container is-fluid">
        <nav class="navbar is-boxed">
            <div class="navbar-brand">
                <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarMenu">
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                </a>
            </div>
            <div class="navbar-menu" id="navbarMenu">
                <div class="navbar-start">
                    <a class="navbar-item">Accueil</a>
                    <div class="navbar-item has-dropdown is-hoverable">
                        <a class="navbar-link">Je souhaite</a>
                        <div class="navbar-dropdown">
                            <a class="navbar-item">About</a>
                            <a class="navbar-item">Jobs</a>
                            <a class="navbar-item">Contact</a>
                        </div>
                    </div>
                    <div class="navbar-item has-dropdown is-hoverable">
                        <a class="navbar-link">Je suis</a>
                        <div class="navbar-dropdown">
                            <a class="navbar-item">About</a>
                            <a class="navbar-item">Jobs</a>
                            <a class="navbar-item">Contact</a>
                        </div>
                    </div>
                    <a class="navbar-item">Orientation & accompagnement</a>
                </div>
                <div class="navbar-end">
                    <div class="navbar-item">
                        <div class="buttons">
                            <a class="navbar-item">Ressources utiles</a>
                            <a class="navbar-item">Témoignages & chiffres clés</a>
                            <a href="{{ url('new') }}" class="button is-bordered">Déposer une annonce</a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    
</header>


<script>
    document.addEventListener('DOMContentLoaded', () => {

        // Get all "navbar-burger" elements
        const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

        // Check if there are any navbar burgers
        if ($navbarBurgers.length > 0) {

            // Add a click event on each of them
            $navbarBurgers.forEach( el => {
                el.addEventListener('click', () => {

                    // Get the target from the "data-target" attribute
                    const target = el.dataset.target;
                    const $target = document.getElementById(target);

                    // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
                    el.classList.toggle('is-active');
                    $target.classList.toggle('is-active');

                });
            });
        }
    });
</script>
