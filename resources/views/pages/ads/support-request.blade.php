@extends ('default')

@section ('title', "Être accompagné")

@section('main-content')
    <section class="section">
        <div class="container">
            <div class="rows">
                <div class="row is-full">
                    <h1 class="title is-1 has_margin is-marginless">Être accompagné</h1>
                    @if(isset($pageContent))
                        @if($pageContent->has('etre-accompagne-texte-dintroduction-sous-le-titre-principal'))
                            {!! $pageContent['etre-accompagne-texte-dintroduction-sous-le-titre-principal']->content !!}
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="columns">
                <div class="column block-demarrer  has-text-centered">
                    <h2 class="title is-2">Par où démarrer ?</h2>
                    <h4 class="title is-4">Tout simplement par ici.</h4>
                    <div class="has-text-left">
                        Nullam quis risus eget urna mollis ornare
                        vel eu leo. Aenean lacinia bibendum nulla
                        sed consectetur, lorem ipsum dolor.
                        sit amet, consectetur adipiscing elit. Cum
                    </div>
                </div>
                <div class="column">
                    <div class="rows">
                        <div class="row-is-full block-step-numbers">
                            <div class="number-step">1</div>
                            <div class="content-numbers">
                                <h4 class="title is-4">Vous déposez votre demande</h4>
                                <p>Lorem ipsum dolor sit amet, consectetur
                                    adipisicing elit, sed do eiusmod tempor
                                    incididunt ut labore et dolore magna.
                                </p>
                            </div>
                        </div>
                        <div class="row-is-full block-step-numbers">
                            <div class="number-step">2</div>
                            <div class="content-numbers">
                                <h4 class="title is-4">Vous échangez</h4>
                                <p>Lorem ipsum dolor sit amet, consectetur
                                    adipisicing elit, sed do eiusmod tempor
                                    incididunt ut labore et dolore magna.
                                </p>
                            </div>
                        </div>
                        <div class="row-is-full block-step-numbers">
                            <div class="number-step">3</div>
                            <div class="content-numbers">
                                <h4 class="title is-4">Vos projets prennent vie</h4>
                                <p>Lorem ipsum dolor sit amet, consectetur
                                    adipisicing elit, sed do eiusmod tempor
                                    incididunt ut labore et dolore magna.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="section" id="support-request-vue">
        <support-request-start inline-template
                               :text-regions="{{json_encode($pageContent)}}">
            <form method="post">
                @csrf
                <div class="container">
                    <h2 class="title is-2 has-text-centered">Précisez votre territoire</h2>
                    <div class="section has-text-centered">
                        <div class="is-half">
                            Terre de Liens peut accompagner les projets d’offre ou de recherche de foncier agricole.<br>
                            Pour connaître nos modalités d’accueil, indiquez la région concernée par votre projet.
                        </div>
                        <br>

                        <div class="has-text-centered">
                            <select id="region" class="select is-large" name="support_request_territory_id" required
                                    v-model="region">
                                <option></option>
                                @foreach($territories as $territory)
                                    <option value="{{$territory->id}}">{{$territory->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modalites" v-if="region">
                        <h2 class="title is-2 has-text-centered">Vos modalités d'accueil</h2>
                        <div class="section">
                            <div class="columns is-centered">
                                    <div id="text-territory" class="column is-three-quarters">
                                        <span  v-html="textRegionsContent"></span>
                                    </div>
                            </div>
                        </div>
                    </div>

                    <h2 class="title is-2 has-text-centered">Description de votre projet</h2>
                    <div class="columns is-mobile is-centered">
                        <div class="column is-two-thirds">
                            <br>
                            <div class="columns">
                                <div class="column">
                                    <div class="has-text-centered">
                                        Précisez brièvement ce que vous attendez de Terre de Liens,
                                        en quoi nous pourrions vous aider.<br><br>
                                    </div>
                                    <div class="field">
                                        <div class="control">
                                            <text-area-counter
                                                    :required="true"
                                                    name="support_request_text"
                                                    :max-length="400">
                                            </text-area-counter>
                                        </div>
                                    </div>

                                    <div class="field is-grouped is-grouped-centered">
                                        <div class="control is-pulled-right">
                                            <button type="submit" class="button is-link is-size-3">Étape suivante
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </support-request-start>
        <br>
        <br>
        <br>
    </section>
@endsection

@section('script')
    <script>
        const supportRequestVue = new Vue({
            el: '#support-request-vue',
            name: 'support-request'
        });
    </script>
@endsection
