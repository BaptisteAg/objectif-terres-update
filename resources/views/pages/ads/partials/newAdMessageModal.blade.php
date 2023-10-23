{!! Form::open(['route' => 'threads.create', 'method'=>'post']) !!}
<h3 class="title is-4">Envoyer un message à l'annonceur</h3>
<label class="label">Votre message :</label>
<input type="hidden" name="ad_id" value="{{$ad->id}}">
<textarea id="textearea_message" required name="content" class="textarea is-medium"
          placeholder="Votre message..."></textarea>
@if(auth()->user()->role >= 1 )
    <div class="field">
        <label class="label">Ou choisissez une réponse type :</label>
        <div class="control is-expanded ">
            <div class="select">
                <select id="response_templates_list" onchange="sendResponseTemplateMessage()">
                    <option disabled selected hidden>Choisir...</option>
                    @foreach($responseTemplates as $response)
                        <option value="{{$response->content}}" name="response_template">{{$response->title}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="field is-grouped">
        <p class="control is-expanded">
            <a href="{{route('responseTemplates.index')}}">
										<span class="icon">
										<i class="fas fa-plus"></i>
									</span>
                <span>Créer une nouvelle réponse type</span>
            </a>
        </p>
    </div>
@endif
<b-button class="mt-3" rounded native-type="submit" expanded type="is-primary">Envoyer
</b-button>
{!! Form::close() !!}
