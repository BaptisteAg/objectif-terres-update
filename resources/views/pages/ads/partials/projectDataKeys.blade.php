{!! Form::open(['route' => 'support-request.show.update-project-data-keys-values', 'method'=>'post']) !!}
<div class="content ">
    <h3 class="title is-3">Renseignez vos indicateurs</h3>
    <p>Ces indicateurs sont <strong>optionnels</strong>. Néanmoins, ils sont pour nous importants : ils nous permettent de mieux vous accompagner mais aussi d'observer les signaux faibles de l'installation et de la transmission en France en anonymisant ces informations et en les croisant au niveau national, à la manière d'un observatoire. Merci pour votre contribution !</p>
</div>
@foreach($allProjectDataKeys as $projectDataKey)
    <div class="columns">
        <div class="column is-one-third">
            <p>{{$projectDataKey->name}}</p>
        </div>
        <div class="column">
            @php
                $currentProjectData = $currentProjectKeyDataValues->where('project_data_key_id',$projectDataKey->id)->first();
            @endphp

            @if(!is_null($currentProjectData))
                @if($projectDataKey->projectDataValues->count() >0)
                    <div class="select is-fullwidth">
                        <select {{$ad->userPp->trashed()? 'disabled' : ''}} name="project_data_key[{{$projectDataKey->id}}]">
                            <option selected disabled>Veuillez choisir...</option>
                            @foreach ($projectDataKey->projectDataValues as $projectDataValue)
                                @if(isset($currentProjectData->projectDataValue))
                                    @if($projectDataValue->id === $currentProjectData->projectDataValue->id)
                                        <option selected value="{{$projectDataValue->value}}">
                                            {{$projectDataValue->value}}
                                        </option>
                                    @else
                                        <option value="{{$projectDataValue->value}}">{{$projectDataValue->value}}</option>
                                    @endif
                                @else
                                    <option value="{{$projectDataValue->value}}">{{$projectDataValue->value}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                @else
                    <input {{$ad->userPp->trashed()? 'disabled' : ''}} name="project_data_key[{{$projectDataKey->id}}]"
                           class="input" type="text"
                           value="{{$currentProjectKeyDataValues->where('project_data_key_id',$projectDataKey->id  )->first()->value}}"
                           placeholder="Saisir..." style="background-color: #4a4a4a82">
                @endif
            @else
                @if($projectDataKey->projectDataValues->count() >0)
                    <div class="select  is-fullwidth">
                        <select {{$ad->userPp->trashed()? 'disabled' : ''}} name="project_data_key[{{$projectDataKey->id}}]">
                            <option selected disabled>Veuillez choisir...</option>
                            @foreach ($projectDataKey->projectDataValues as $projectDataValue)
                                <option value="{{$projectDataValue->value}}">{{$projectDataValue->value}}</option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <input {{$ad->userPp->trashed()? 'disabled' : ''}} name="project_data_key[{{$projectDataKey->id}}]"
                           class="input" type="text"
                           placeholder="Saisir...">
                @endif
            @endif
        </div>
    </div>
@endforeach
<div class="control is-pulled-right ml-60 mb-60">
    <button {{$ad->userPp->trashed()? 'disabled' : ''}} class="button is-link">
        <span class="icon is-small">
            <i class="fas fa-save"></i>
        </span>
        <span>Sauvegarder</span>
    </button>
</div>
<div class="control">
    <input type="hidden" name="ad_id" value="{{$ad->id}}">
    <input type="hidden" name="user_id" value="{{auth()->id()}}">
    {{--            <button {{$ad->userPp->trashed()? 'disabled' : ''}} class="button is-link">--}}
    {{--                <span class="icon is-small">--}}
    {{--                    <i class="fas fa-save"></i>--}}
    {{--                </span>--}}
    {{--                <span>Sauvegarder</span>--}}
    {{--            </button>--}}
</div>
{!! Form::close() !!}