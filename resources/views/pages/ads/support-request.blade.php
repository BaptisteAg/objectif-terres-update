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

    <section class="section pt-0 mt-0  pb-0">
        <div class="container">
            <div class="  has-text-centered">
                <h2>Comment ça marche ?</h2>
            </div>
            <div class="columns">
                <div class="column">
                    <div class="rows">
                        <div class="row-is-full block-step-numbers">
                            <div class="number-step">1</div>
                            <div class="content-numbers">
                                <h4 class="title is-4">Vous sélectionnez le territoire où vous souhaitez être
                                    accompagné(e)</h4>
                                <p>C’est le
                                    territoire où vous souhaitez vous installer ou le territoire où se situe votre bien
                                    à transmettre. Attention, vous ne pouvez soumettre qu’une seule demande
                                    d’accompagnement* !
                                </p>
                            </div>
                        </div>
                        <div class="row-is-full block-step-numbers">
                            <div class="number-step">2</div>
                            <div class="content-numbers">
                                <h4 class="title is-4">Vous découvrez les modalités d’accompagnement de l’association
                                    Terre de Liens de
                                    votre territoire</h4>
                                <p> Chacune des 19 associations territoriales de Terre de Liens a un
                                    fonctionnement différent, avec des forces vives et des disponibilités variant d’un
                                    territoire à l’autre.
                                </p>
                            </div>
                        </div>
                        <div class="row-is-full block-step-numbers">
                            <div class="number-step">3</div>
                            <div class="content-numbers">
                                <h4 class="title is-4">Vous déposez votre demande d’accompagnement</h4>
                                <p>A travers un formulaire**, vous nous
                                    décrivez précisément votre projet pour que nous puissions vous répondre dans les
                                    meilleurs délais.
                                </p>
                            </div>
                        </div>
                        <div class="row-is-full block-step-numbers">
                            <div class="number-step">4</div>
                            <div class="content-numbers">
                                <h4 class="title is-4">Vous échangez sur votre projet avec Terre de Liens</h4>
                                <p>Nous vous recontactons pour vous orienter, vous donner des informations ou envisager
                                    un prochain rendez-vous pour donner vie à votre projet !
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="section pt-0 mt-0" id="support-request-vue">
        <support-request-start inline-template
                               :text-regions="{{json_encode($pageContent)}}">
            <form method="post">
                @csrf
                <div class="container">
                    <h2 class="title is-2 has-text-centered">Choisissez votre territoire</h2>
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
                        <div class="">
                            <div class="columns is-centered">
                                <div id="text-territory" class="column is-three-quarters">
                                    <span v-html="textRegionsContent"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h2 class="title is-2 has-text-centered">Précisez brièvement ce que vous attendez de Terre de
                        Liens</h2>
                    <div class="columns is-mobile is-centered">
                        <div class="column is-two-thirds">
                            <br>
                            <div class="columns">
                                <div class="column">
                                    <div class="has-text-centered">
                                        Vous serez amené(e) à décrire votre projet plus précisément à l’étape
                                        suivante.<br><br>
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
        <div class="content mt-40">
            <p>
                *Notre capacité à vous accompagner pouvant être limitée, merci de cibler le territoire prioritaire sur
                lequel porte votre projet d’installation.</p>
            <p> **Les informations remplies dans ce formulaire sont susceptibles d’être enregistrées ; vous pouvez à
                tout moment gérer vos informations personnelles dans <a href="{{route('user.edit')}}">votre compte</a>
            </p>

        </div>

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
