@extends('default')

@section('title', 'Administration des indicateurs | Objectifs Terres')


@section('header')
    @include('components.supervisor-tabs')
@endsection

@section('main-content')
    <div class="section">
        <h1 class="title is-2 text_primary ">Administration des indicateurs </h1>
        <section class="section">
            <div class="columns is-mobile is-centered">
                <div class="column is-half">
                    {{Form::open(['route'=>'supervisor.projectDataKeyDelete', 'method'=>'post'])}}
                    <button type="submit" disabled style="display: none" aria-hidden="true"></button>
                    <div class="content">
                        <h2 class="title is-3 has-text-centered">Liste des indicateurs</h2>
                        @if (!empty($allProjectDataKeys))
                            <div class="field is-grouped is-grouped-multiline">
                                @foreach($allProjectDataKeys as $projectDataKey)
                                    <div class="control">
                                        <div class="tags has-addons">
											<span class="tag is-medium is-light"><span>{{$projectDataKey->name}}</span>
												<span class="icon has-text-info has-tooltip-bottom"
                                                      data-tooltip="{{$projectDataKey->is_public === 1 ? "Cet indicateur est public" : "Cet indicateur est privé"}}{{$projectDataKey->immutable === 1 ? " et non supprimable" :""}}">
												  <i class="fas fa-info-circle"></i>
												</span>
											</span>

                                            @if($projectDataKey->immutable !== 1)
                                                <a class="tag is-medium ">
                                                    <button value="{{$projectDataKey->id}}" name="project_data_key_id"
                                                            class="button is-text is-small ">
													<span class="icon">
													  <i class="fas fa-trash-alt"></i>
													</span>
                                                    </button>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p>Il y a aucun indicateur disponible</p>
                        @endif
                    </div>
                    {{Form::close()}}
                    <br>
                    <br>
                    {{Form::open(['route'=>'supervisor.projectDataKeysCreate', 'method'=>'post'])}}
                    <div class="content ">
                        <h2 class="title is-2 has-text-centered">Ajout d'un nouvel indicateur</h2>
                        <div class="columns is-mobile is-centered">
                            <div class="column is-half ">
                                <p class="">Remplissez le formulaire suivant pour ajouter un indicateur</p>
                                <div class="field">
                                    <label class="label">Titre du nouvel indicateur</label>
                                    <div class="control">
                                        <input name="project_data_key_name" required class="input" type="text"
                                               placeholder="Saisir le titre de l'indicateur">
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="control">
                                        <label class="label">Indicateur public : </label>
                                        <label class="radio">
                                            <input type="radio" value="1" name="is_project_data_key_public" required>
                                            Oui
                                        </label>
                                        <label class="radio">
                                            <input type="radio" value="0" name="is_project_data_key_public">
                                            Non
                                        </label>
                                    </div>
                                </div>
                                <div class="field">
                                    <p class="control">
                                        <button class="button is-link" type="submit">
											 <span class="icon is-small">
											<i class="fas fa-plus-circle"></i>
											</span>
                                            <span>Ajouter un nouvel indicateur</span>
                                        </button>
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                    {{Form::close()}}
                </div>
            </div>
        </section>
    </div>
@endsection
