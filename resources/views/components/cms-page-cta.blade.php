<div class="content has-text-centered mt-60  fw-section CTA bg-trame_champs_light bg-l-cream pt-100 pb-100 mb-0">
    <div class=" mb-50">
        <h4 class="text_size x-large ">Bénéficiez des services d'Objectif Terres</h4>
        @if(Route::currentRouteName() === "trouver-une-terre-ou-des-financements")
            <p class="has-text-centered">Pour votre recherche de terres agricoles nous vous invitons à :</p>
        @elseif(Route::currentRouteName() === "transmettre-ma-ferme")
            <p class="has-text-centered">Pour votre projet de transmission nous vous invitons à :</p>
        @endif
    </div>

    <div class="container">
        <div class=" columns is-centered">
            <div class="column has-text-centered">
                @if(Route::currentRouteName() === "trouver-une-terre-ou-des-financements")
                    <p>Déposer une annonce pour rendre visible votre recherche</p>
                @elseif(Route::currentRouteName() === "transmettre-ma-ferme")
                    <p>Déposer une annonce pour rendre visible votre offre</p>
                @endif
                <a href="{{route('ads.create')}}">
                    <button class="button is-link basic primary">
                        <span class="button__label"> Déposer une annonce</span>
                    </button>
                </a>
            </div>
            <div class="column has-text-centered">
                @if(Route::currentRouteName() === "trouver-une-terre-ou-des-financements")
                    <p>Solliciter un accompagnement sur le volet foncier de votre projet auprès de l’une des dix-neuf
                        associations territoriales Terre de Liens </p>
                @elseif(Route::currentRouteName() === "transmettre-ma-ferme")
                    <p>Solliciter un accompagnement de votre projet auprès de l’une des dix-neuf
                        associations territoriales Terre de Liens </p>
                @endif


                <a href="/accompagnement/demarrer">
                    <button class="button is-link  basic primary">
                        <span class="button__label">
                            Être accompagné
                        </span>
                    </button>
                </a>
            </div>
        </div>
    </div>

</div>