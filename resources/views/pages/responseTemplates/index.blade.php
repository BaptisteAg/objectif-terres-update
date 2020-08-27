@extends('default')

@section('title', 'Gestion des messages types | Objectifs Terres')

@section('header')
    @if(auth()->user()->role >= 3)
        @include('components.supervisor-tabs')
    @elseif (auth()->user()->role ===2)
        @include('components.advisor-tabs')
    @endif
@endsection

@section('main-content')
    <div class="section " style="padding-top: 0px">
        <h1 class="title is-2 has-text-link">Gestion des messages types </h1>
        {{Form::open(['route'=>'responseTemplates.create', 'method'=>'post'])}}
        <div class="content ">
            <h5 class="title is-5 has-text-centered">Créer un nouveau message type</h5>
            <div class="columns is-mobile is-centered">
                <div class="column is-half ">
                    <p class="">Remplissez le formulaire suivant pour créer un nouveau message type</p>
                    <div class="field">
                        <label class="label">Titre du message</label>
                        <div class="control">
                            <input name="title" required class="input" type="text"
                                   placeholder="Saisir le titre du message">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Contenu du message</label>
                        <div class="control">
							<textarea class="textarea" name="content" required
                                      placeholder="Saisir le contenu du message"></textarea>
                        </div>
                    </div>
                    <div class="field">
                        <p class="control">
                            <button class="button is-link" type="submit">
							 <span class="icon is-small">
							<i class="fas fa-plus-circle"></i>
							</span>
                                <span>Créer un nouveau message type</span>
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
            <h5 class="title is-5 has-text-centered">Liste des messages types</h5>
            @if($responseTemplates->count() === 0)
                <p class="has-text-centered">Aucun message type trouvée</p>
            @else
                <div class="columns is-centered is-mobile">
                    <div class="column is-10 ">
                        <table class="table is-hoverable is-striped">
                            <thead>
                            <tr>
                                <th>Titre du message</th>
                                <th>Contenu du message</th>
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