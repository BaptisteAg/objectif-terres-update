@extends('default')

@section('title', 'Bienvenue sur Objectif Terres')

@section('main-content')
    <section class="section is-medium">
        <div class="columns">
            <div class="column"></div>
            <div class="column is-half ">
                <div>
                    <h2 class="title is-1">Publiez votre annonce</h2>
                    <p>Vous avez un projet agricole ? Vous avez besoin d’aide ou d’un suivi sur mesure ?
                        Vous avez une idée de projet mais il n’est pas encore finalisé ? Eget risus varius
                        blandit sit amet non magna. Sed posuere consectetur est at lobortis.</p>
                </div>
                <br>
                <div>
                    <p class="has-text-grey">Pour nous permettre de vous valider votre annonce, veuillez nous en dire en peu plus…</p>
                </div>
                <div class="columns">
                    <div class="column is-half ">
                        {!! Form::open() !!}
                        <div class="field">
                            {!! Form::label('ad_type', 'Type d\'annonce', ['class' => 'label']); !!}
                            <div class="select">
                                {!! Form::select('ad_type', ['land_offer' => 'Proposition de foncier', 'land_seek' => 'Recherche de foncier', 'job_offer'=>'Proposition d\'emploi', 'job_seek' => 'Recherche d\'emploi'], null, ['placeholder' => 'Choisir un type d\'annonce...']); !!}
                            </div>
                        </div>

                        <div class="field is-grouped">
                            <div class="control">
                                {!! Form::submit('Envoyer',['class'=>'button is-link']) !!}
                            </div>
                            <div class="control">
                                <button class="button is-link is-light">Annuler</button>
                            </div>
                        </div>
                    </div>

                        {!! Form::close() !!}
                    </div>
                    <div class="column"></div>
                </div>
            <div class="column"></div>
        </div>

        @include('components.partnering')
        @include('components.support_terre_liens')
    </section>
@endsection