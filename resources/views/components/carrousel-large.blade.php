<section class="hero has_margin">
    <div id="carousel-installations" class="carousel carousel-large hero-body">
        @for ($i = 0; $i < 4; $i++)
            <div class="card">
                <div class="card-content">
                    <div class="title-slider">
                        <span>HISTOIRES D’UNE RÉUSSITE</span>
                        <h2 class="title is-2">La Tournerie : histoire d’une ferme pas comme les autres.</h2>
                    </div>
                    <div class="text-slider">
                        <p>Didascalie vidéo, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore
                            et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.
                        </p>
                    </div>
                    <div class="media">
                        <figure class="image is-centered is-fullwidth">
                            <img src="https://picsum.photos/800/600?random=1" alt="Placeholder image">
                        </figure>
                    </div>
                </div>
            </div>
        @endfor
    </div>
</section>
