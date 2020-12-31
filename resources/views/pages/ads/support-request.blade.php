@extends ('default')

@section ('title', "Être accompagné par Terre deLiens")

@section('main-content')
    @guest()
        <div class="content has-text-centered fw-section CTA bg-trame_champs_light bg-trame_champs_dark pt-10 pb-30 mb-0">
            <div class=" mb-50">
                <h4 class="text_size x-large ">Bénéficiez des services d'Objectif Terres</h4>
                <p class="has-text-centered">Pour faire une demande d'accompagnement, il vous faut au préalable :</p>
            </div>
            <div class="container">
                <div class=" columns is-centered is-mobile">
                    <div class="column is-3 has-text-centered">
                        <a href="{{route("register")}}">
                            <button class="button is-link  basic primary">
                                <span class="button__label">
                                    CREER UN COMPTE
                                </span>
                            </button>
                        </a>
                    </div>
                    <div class="column is-1 has-text-centered">
                        <p>OU</p>
                    </div>
                    <div class="column is-3 has-text-centered">
                        <a href="{{route('login')}}">
                            <button class="button is-link basic primary">
                                <span class="button__label">SE CONNECTER</span>
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endguest
    @auth
        <h2 class="title is-2 has-text-centered">Être accompagné par Terre de Liens</h2>
    @endauth
    <section>
        <div class="container">
            @if(isset($pageContent))
                @if($pageContent->has('etre-accompagne-texte-dintroduction-sous-le-titre-principal'))
                    {!! $pageContent['etre-accompagne-texte-dintroduction-sous-le-titre-principal']->content !!}
                @endif
            @endif
        </div>
    </section>
    <section class="section pt-0 mt-0 bg-trame_champs_light bg-l-cream" id="support-request-vue">
        <support-request-start inline-template
                               :text-regions="{{json_encode($pageContent)}}">
            <form method="post">
                @csrf
                <div class="container pt-10">
                    <h2 class="title is-2 has-text-centered">Choisissez votre territoire</h2>
                    <div class="has-text-centered">
                        <div class="is-half">
{{--                            Terre de Liens peut accompagner les projets d’offre ou de recherche de foncier agricole.<br>--}}
                            Pour connaître nos modalités d’accueil,
                            <span class="is-size-5 has-text-weight-bold ">indiquez la région concernée par votre
                                projet </span>.<br>

                            Notre capacité à vous accompagner pouvant être limitée, merci de cibler le territoire prioritaire sur
                            lequel porte votre projet d’installation.<br>

                            Par exemple, si vous habitez en Rhône-Alpes mais que vous souhaitez vous installez en
                            Midi-Pyrénées, il vous faut sélectionner le territoire Midi-Pyrénées.
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
                    <div class="modalites mt-30" v-if="region">
                        <h6 class="title is-5 has-text-centered">Vos modalités d'accueil</h6>
                        <div class="">
                            <div class="columns is-centered">
                                <div id="text-territory" class="column is-three-quarters">
                                    <span v-html="textRegionsContent"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-15" v-if="showSubmitFormButton">
                        <p class="title is-5 has-text-centered mb-0">Précisez brièvement ce que vous attendez de Terre
                            de
                            Liens</p>
                        <div class="columns is-mobile is-centered">
                            <div class="column is-two-thirds">
                                <div class="columns">
                                    <div class="column">
                                        <div class="has-text-centered mb-10">
                                            <p>
                                                Vous serez amené(e) à décrire votre projet plus précisément à l’étape
                                                suivante.
                                            </p>
                                            @guest()
                                                <p class="mb-20">
                                                    <span class="icon">
                                                        <i class="fas fa-info-circle has-text-info"></i>
                                                    </span>
                                                    <span>Attention, si vous n'avez pas créé de compte ou si vous n'êtes
                                                        pas connecté, vous serez bloqué à l'étape suivante.</span>
                                                </p>

                                            @endguest
                                        </div>
                                        <div class="field mt-30">
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

                </div>
            </form>
        </support-request-start>

        <div class="content mt-80">
{{--            <p> **Les informations remplies dans ce formulaire sont susceptibles d’être enregistrées ; vous pouvez à--}}
{{--                tout moment gérer vos informations personnelles dans--}}
{{--                @guest()--}}
{{--                    <a href="{{route('login')}}">votre compte.</a>--}}
{{--                @else--}}
{{--                    <a href="{{route('user.edit',  auth()->user()->id)}}">votre compte.</a>--}}
{{--                @endif--}}

{{--            </p>--}}

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
