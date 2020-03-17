<section class="section testimony-section">
    <div class="container">
        <div class="rows">
            <div class="row is-full block-result-text has-text-centered has_margin">
                <h1 class="title is-2">Témoignages</h1>
            </div>
            <div class="row">
                <div class="columns block-testimony">
                    <div id="carousel-testimony" class="carousel column is-offset-6 is-6">
                        @for ($i = 0; $i < 4; $i++)
                            <div class="columns">
                                <div class="column is-1 quote">
                                    <i class="fas fa-quote-left"></i>
                                </div>
                                <div class="column quote-testimony">
                                    <p>
                                        Le soutien de Terre de Liens m’a permis lorem ipsum dolor sit amet,
                                        consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                                        labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                                        nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                        consequat.
                                    </p>
                                    <div class="person-testimony">
                                        <p>Marc Signorelli</p>
                                        <p>Paysan installé en Auvergne depuis 2017</p>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
