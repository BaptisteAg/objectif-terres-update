<div class="card-content">
	<div class="columns">
		<div class="column is-half " style="border-right: 1px solid #DBDBDB;">
			
			@if(is_null($ad->adNotes) or $ad->adNotes->whereNull('project_data_key_id')->count() ===0)
				<p>Aucune note n'a été rédigée concernant cette demande</p>
			@else
				<div style=" overflow-x: hidden; max-height: 400px;">
					@foreach($ad->adNotes->whereNull('project_data_key_id')->sortByDesc('created_at') as $note)
							<div class="card has-background-white-ter"
								 style="border: 2px solid transparent; border-radius: 12px; margin : 5px; margin-right : 10px; ">
								<div class="card-content">
									<div class="content">
										<p>
											{{$note->value}}
										</p>
									</div>
									<p class=" is-6">
										Note rédigée par
										<strong>{{$note->user->first_name}} {{$note->user->name}}</strong>
									</p>
									<time>Le {{$note->created_at->format("d/m/Y")}}</time>
									<br>
									<p class="is-size-7 is-pulled-right has-text-link"><span class="icon"><i
													class="fas fa-trash-alt"></i></span><span>Supprimer</span></p>
								</div>
							</div>
							<br>
					@endforeach
				</div>
			@endif
			<div class="is-divider"></div>
			{!! Form::open(['route' => 'advisor.createNote', 'method'=>'post']) !!}
			<div class="field">
				<label class=" label has-text-black"> Écrire une note</label>
				<div class="field ">
					<div class="control is-expanded">
						<input type="hidden" name="ad_id" value="{{$ad->id}}">
						<input type="hidden" name="user_id" value="{{auth()->id()}}">
						<textarea class=" textarea has-fixed-size" name="value" type="text"
								  placeholder="Votre note..."></textarea>
					</div>
					<br>
					<div class="control ">
						<button class="button is-link ">
							Envoyer
						</button>
					</div>
				</div>
			</div>
			{!! Form::close() !!}
		</div>
		<div class="column">
			{!! Form::open(['route' => 'advisor.createNote', 'method'=>'post']) !!}
			<div class="content">
				<p class="has-text-centered title is-5">Indicateurs concernant cette demande</p>
				<p class="">Séléctionnez un des indicateurs pour le consulter/modifier </p>
			</div>
			<div class="field">
				<div class="control  has-text-centered">
					<div class="select">
						<select v-model="projectDataKeyId" name="project_data_key_id"
								v-on:change="getAllNotesByProjectDataKey()">
							<option value="" disabled selected>Veuillez séléctionner...</option>
							@foreach($projectDataKeys as $projectDataKey)
								<option value="{{$projectDataKey->id}}">{{$projectDataKey->name}}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
			<br>
			<div class="content">
				<div v-if="notes.length >0" style=" overflow-x: hidden; max-height: 300px;">
					<div v-for="note in notes" class="card "
						 style="border: 2px solid transparent; border-radius: 12px; margin : 5px; margin-right : 10px; ">
						<div class="card-content">
							<div class="content">
								<p>
									@{{note.value}}
								</p>
							</div>
							<p class=" is-6">
								Créé le <strong>@{{note.user.first_name}} @{{note.user.name}}</strong>
							</p>
							<time>Le @{{note.created_at}}</time>
							<br>
							<p class="is-size-7 is-pulled-right has-text-link"><span class="icon"><i
											class="fas fa-trash-alt"></i></span><span>Supprimer</span></p>
						</div>
					</div>
					<br>
				</div>
				<div v-else-if="notes.length <=0">
					<p class="has-text-centered">Pas de notes </p>
				</div>
			</div>
			<div class="field">
				<textarea name="value" class="textarea" placeholder="Veuillez saisir...">
				</textarea>
				<input type="hidden" name="ad_id" value="{{$ad->id}}">
				<input type="hidden" name="user_id" value="{{auth()->id()}}">
			</div>
			<div class="field ">
				<div class="control">
					<button class="button is-link">Envoyer</button>
				</div>
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
