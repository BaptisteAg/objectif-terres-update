@extends('default')

@section('title', 'Gestion des réponses types | Objectifs Terres')

@section('main-content')
    <div class="content ml-80 mt-30">
        @if(Session::has('url.intended'))
            <a class="text_size large" href="{{Session::get('url.intended')}}">
                <span class="icon is-medium"><i class="fas fa-arrow-left"></i></span>
                <span>Retour </span>
            </a>
        @else
            <a class="text_size large" href="{{URL::previous()}}">
                <span class="icon is-medium"><i class="fas fa-arrow-left"></i></span>
                <span>Retour </span>
            </a>
        @endif
    </div>

    <div class="section " style="padding-top: 0px">
        <h1 class="title is-2 has-text-link">Gestion des réponses types </h1>
        {{Form::open(['route'=>'responseTemplates.create', 'method'=>'post'])}}
        <div class="content ">
            <h5 class="title is-5 has-text-centered">Créer une nouvelle réponse type</h5>
            <div class="columns is-mobile is-centered">
                <div class="column is-half ">
                    <p class="">Remplissez le formulaire suivant pour créer une nouvelle réponse type</p>
                    <div class="field">
                        <label class="label">Titre de la réponse</label>
                        <div class="control">
                            <input name="title" required class="input" type="text"
                                   placeholder="Saisir le titre de la réponse">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Contenu de la réponse</label>
                        <div class="control">
							<textarea class="textarea" name="content" required
                                      placeholder="Saisir le contenu de la réponse"></textarea>
                        </div>
                    </div>
                    <div class="field">
                        <p class="control">
                            <button class="button is-link" type="submit">
							 <span class="icon is-small">
							<i class="fas fa-plus-circle"></i>
							</span>
                                <span>Créer une nouvelle réponse type</span>
                            </button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        {{Form::close()}}
        <br>
        <br>
        <div class="content">
            <h5 class="title is-5 has-text-centered">Liste des réponses types</h5>
            @if($responseTemplates->count() === 0)
                <p class="has-text-centered">Aucune réponse type trouvée</p>
            @else
                <div class="columns is-centered is-mobile">
                    <div class="column is-10 ">
                        <table class="table is-hoverable is-striped">
                            <thead>
                            <tr>
                                <th>Titre de la réponse</th>
                                <th>Contenu de la réponse</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($responseTemplates->sortBy('created_at') as $response)
                                <tr>
                                    <td>{{$response->title}}</td>
                                    <td>{{$response->content}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection