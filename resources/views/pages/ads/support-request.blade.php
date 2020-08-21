@extends ('default')

@section ('title', "Être accompagné")

@section('main-content')
    <section class="section">
        <div class="container">
            <div class="rows">
                <div class="row is-full">
                    <h1 class="title is-1 has_margin is-marginless">Être accompagné</h1>
                    @if(isset($pageContent))
                            {!! $pageContent->content !!}
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="columns">
                <div class="column block-demarrer">
                    <h2 class="title is-2">Par où démarrer ?</h2>
                    <h4 class="title is-4">Tout simplement par ici.</h4>
                    <p>
                        Nullam quis risus eget urna mollis ornare
                        vel eu leo. Aenean lacinia bibendum nulla
                        sed consectetur, lorem ipsum dolor.
                        sit amet, consectetur adipiscing elit. Cum
                    </p>
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
        <support-request-start inline-template>
            <form method="post">
                @csrf
                <div class="container">
                    <h2 class="title is-2 has-text-centered">Précisez brièvement ce que vous attendez de Terre de Liens,
                        en quoi nous pourrions vous aider.</h2>
                    <div class="columns is-mobile is-centered">
                        <div class="column is-two-thirds">
                            <br>
                            <div class="columns">
                                <div class="column">
                                    <div class="field">
                                        <label for="support_request_text" class="label">Texte</label>
                                        <div class="control">
                                            <text-area-counter
                                                    name="support_request_text"
                                                    :max-length="200">
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
