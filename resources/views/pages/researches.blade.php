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
            
            <div class="section">
    
                <div class="columns is-gapless">
                    <div class="column is-two-fifths">
                        <figure><img src="https://picsum.photos/500/300" alt="Placeholder image"></figure>
                    </div>
                    <div class="column">
                        <div><span>Partenaire Objectif Terre</span></div>
                    </div>
                </div>
            
            </div>
        </div>
        
    </section>

@endsection
