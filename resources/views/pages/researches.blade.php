@extends ('default')

@section ('title', 'Rechercher parmis les annonces posté sur Objectif Terres')

@section('main-content')


    <section class="section">
        <div class="container">
            <nav class="level">
                <div class="level-left">
                    <div class="level-item">
                        @include('components.breadcrumb')
                    </div>
                </div>
                <div class="level-right">
                    <div class="level-item">
                        <span class="icon"><a href=""><i class="far fa-heart"></i></a></span>
                        Sauvegarder cette recherche
                    </div>
                </div>
            </nav>

            <nav class="level">
                <div class="level-left">
                    <div class="">
                        <h1 class="title">Offres Foncières</h1>
                        <h2 class="subtitle">147 annonces trouvées.</h2>
                    </div>
                </div>
                <div class="level-right">
                    <div class="level-item">
                        {!! Form::open(['url' => '']) !!}
                        {!! Form::submit('Tout', ['class' => 'button']) !!}
                        {!! Form::close() !!}
                        {!! Form::open(['url' => '']) !!}
                        {!! Form::submit('Vente', ['class' => 'button']) !!}
                        {!! Form::close() !!}
                        {!! Form::open(['url' => '']) !!}
                        {!! Form::submit('Location', ['class' => 'button']) !!}
                        {!! Form::close() !!}
                    </div>
                    <div class="level-item">
                        <div class="help">Trier : </div>
                        {!! Form::open(['url' => '']) !!}
                        <div class="select">
                            {!! Form::select('select', ['date' => 'Date: du plus récent au plus ancien', 'S' => 'Small']) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </nav>

            <section class="section">
                <div class="columns is-gapless">
                    <div class="column is-two-fifths">
                        <figure><img src="https://picsum.photos/500/300" alt="Placeholder image"></figure>
                        <div>Région</div>
                        <div><span>350 000</span>€ | <span>25</span> ha</div>
                    </div>
                    <div class="column">
                        <nav class="level">
                            <div class="level-left">
                                <div class="level-item">
                                    <span>Partenaire Objectif Terre</span>
                                </div>
                            </div>
                            <div class="level-right">
                                <div class="level-item">
                                    <span>Publié aujourd'hui</span>
                                </div>
                            </div>
                        </nav>
                        <div></div>
                        <h1 class="title">JE susi un titre</h1>
                        <div class="descritption">Je suis une discritpion</div>
                        <a href="#">Voir</a>
                    </div>
                </div>
                <div class="columns is-gapless">
                    <div class="column is-two-fifths">
                        <figure><img src="https://picsum.photos/500/300" alt="Placeholder image"></figure>
                        <div>Région</div>
                        <div><span>350 000</span>€ | <span>25</span> ha</div>
                    </div>
                    <div class="column">
                        <nav class="level">
                            <div class="level-left">
                                <div class="level-item">
                                    <span>Partenaire Objectif Terre</span>
                                </div>
                            </div>
                            <div class="level-right">
                                <div class="level-item">
                                    <span>Publié aujourd'hui</span>
                                </div>
                            </div>
                        </nav>
                        <div></div>
                        <h1 class="title">JE susi un titre</h1>
                        <div class="descritption">Je suis une discritpion</div>
                        <a href="#">Voir</a>
                    </div>
                </div>
                <div class="columns is-gapless">
                    <div class="column is-two-fifths">
                        <figure><img src="https://picsum.photos/500/300" alt="Placeholder image"></figure>
                        <div>Région</div>
                        <div><span>350 000</span>€ | <span>25</span> ha</div>
                    </div>
                    <div class="column">
                        <nav class="level">
                            <div class="level-left">
                                <div class="level-item">
                                    <span>Partenaire Objectif Terre</span>
                                </div>
                            </div>
                            <div class="level-right">
                                <div class="level-item">
                                    <span>Publié aujourd'hui</span>
                                </div>
                            </div>
                        </nav>
                        <div></div>
                        <h1 class="title">JE susi un titre</h1>
                        <div class="descritption">Je suis une discritpion</div>
                        <a href="#">Voir</a>
                    </div>
                </div>
            </section>

            <section class="section">
                <nav class="pagination is-centered" role="navigation" aria-label="pagination">
                    <ul class="pagination-list">
                        <li><a class="pagination-link" aria-label="Goto page 1">1</a></li>
                        <li><span class="pagination-ellipsis">&hellip;</span></li>
                        <li><a class="pagination-link" aria-label="Goto page 45">45</a></li>
                        <li><a class="pagination-link is-current" aria-label="Page 46" aria-current="page">46</a></li>
                        <li><a class="pagination-link" aria-label="Goto page 47">47</a></li>
                        <li><span class="pagination-ellipsis">&hellip;</span></li>
                        <li><a class="pagination-link" aria-label="Goto page 86">86</a></li>
                    </ul>
                </nav>
            </section>

            <section class="section">
                <div class="columns">
                    <div class="column">
                        <h1 class="title is-1">Orientation & Accompagnement</h1>
                        <div><p>Objectif Terre est là pour vous aider à réaliser votre projet agricole ! Avec un suivi sur mesure et notre expérience secteur, n ous sommes en mesure de vous apporter une vraie plus value,  de l'idée initiale au projet déjà défini. <u>Rencontrons-nous !</u></p></div>
                        <div>
                            <p><i class="far fa-check-circle"></i> Un suivi sur mesure</p>
                            <p><i class="far fa-check-circle"></i> Des experts du secteur foncier</p>
                            <p><i class="far fa-check-circle"></i> Des ressources</p>
                            <p><i class="far fa-check-circle"></i> Des formations adaptées</p>
                        </div>
                        <a href="/" class="button is-dark is-uppercase is-medium">Contactez-nous</a>
                    </div>
                    <div class="column">
                        <figure><img src="https://picsum.photos/600/350" alt="Placeholder image"></figure>
                        <div><p>En 2018, plus de xx fermiers ont pu s'installer ou céder leurs terres avec succès, grâce à la platerforme Objectif Terre et au travail mené sur le terrain par l'association Terre de Liens</p></div>
                    </div>
                </div>
            </section>
            <section class="section">
                <div class="columns">
                    <div class="column">
                        <h1 class="title is-1">Avez-vous un projet agricole ?</h1>
                        <div><p>Objectif Terre est là pour vous aider à le réaliser ! Avec un suivi sur mesure et notre expérience du secteur, nous sommes en mesure de vous apporter une vraie plus value, de l'idée initiale au projet déjà défini. <u>Rencontrons-nous !</u></p></div>
                        <div>
                            <p><i class="far fa-check-circle"></i> Un suivi sur mesure</p>
                            <p><i class="far fa-check-circle"></i> Des experts du secteur foncier</p>
                            <p><i class="far fa-check-circle"></i> Des ressources</p>
                            <p><i class="far fa-check-circle"></i> Des formations adaptées</p>
                        </div>
                        <a href="/" class="button is-dark is-uppercase is-medium">Contactez-nous</a>
                    </div>
                    <div class="column">
                        <figure><img src="https://picsum.photos/600/350" alt="Placeholder image"></figure>
                        <div><p>En 2018, plus de xx fermiers ont pu s'installer ou céder leurs terres avec succès, grâce à la platerforme Objectif Terre et au travail mené sur le terrain par l'association Terre de Liens</p></div>
                    </div>
                </div>
            </section>


            @include('components.partnering')
            @include('components.support_terre_liens')

        </div>
    </section>
@endsection
