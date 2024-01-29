<div class="CTA bg-trame_champs_light bg-l-cream py-6">
    <div class="container mb-4">
        <h4 class="title is-2">Bénéficiez des services d'Objectif Terres</h4>
        @if(Route::currentRouteName() === "trouver-une-terre-ou-des-financements")
            <p class="subtitle has-text-centered">Pour votre recherche de terres agricoles nous vous invitons à :</p>
        @elseif(Route::currentRouteName() === "transmettre-ma-ferme")
            <p class="subtitle has-text-centered">Pour votre projet de transmission nous vous invitons à :</p>
        @endif
    </div>

    <div class="container">
        <div class="columns">
            <div class="column is-flex is-flex-direction-column">
                @if(Route::currentRouteName() === "trouver-une-terre-ou-des-financements")
                    <p class="mb-3">Déposer une annonce pour rendre visible votre recherche</p>
                @elseif(Route::currentRouteName() === "transmettre-ma-ferme")
                    <p class="mb-3">Déposer une annonce pour rendre visible votre offre</p>
                @endif
                <b-button class="mt-auto" tag="a" rounded type="is-primary" href="{{route('ads.create')}}">Déposer une annonce
                </b-button>
            </div>
            <div class="column is-flex is-flex-direction-column">
                @if(Route::currentRouteName() === "trouver-une-terre-ou-des-financements")
                    <p class="mb-3">Solliciter un accompagnement sur le volet foncier de votre projet auprès de l’une des dix-neuf
                        associations territoriales Terre de Liens </p>
                @elseif(Route::currentRouteName() === "transmettre-ma-ferme")
                    <p class="mb-3">Solliciter un accompagnement de votre projet auprès de l’une des dix-neuf
                        associations territoriales Terre de Liens </p>
                @endif

                <b-button class="mt-auto" tag="a" rounded type="is-primary" href="/accompagnement/demarrer">Être accompagné
                </b-button>
            </div>
        </div>
    </div>

</div>
