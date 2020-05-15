<div class="card-content">
	<div class="columns">
		<div class="column is-half " style="border-right: 1px solid #DBDBDB;">

			@if(is_null($ad->adNotes) or $ad->adNotes->whereNull('project_data_key_id')->count() ===0)
				<p>Aucune note n'a été rédigée concernant cette demande</p>
			@else
				<div style=" overflow-x: hidden; max-height: 400px;">
					@foreach($ad->adNotes->whereNull('project_data_key_id') as $note)
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
								<time class="is-pulled-right has-text-weight-light ">
									Le {{$note->created_at->format("d/m/Y")}}</time>
								<br>
								{!! Form::open(['route' => 'advisor.deleteNote', 'method'=>'post']) !!}
								<input type="hidden" name="ad_note_id" value="{{$note->id}}">
								<button class="is-size-7 is-pulled-right has-text-link"
										style="border: none; background: transparent">
									<a>
										<span class="icon">
										<i class="fas fa-trash-alt"></i>
									</span>
										<span>Supprimer</span>
									</a>
								</button>
								{!! Form::close() !!}
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
						<textarea required class=" textarea has-fixed-size" name="value" type="text"
								  placeholder="Votre note..."></textarea>
					</div>
					<br>
					<div class="control ">
						<button class="button is-link">
							 <span class="icon is-small">
							<i class="fas fa-plus-circle"></i>
							</span>
							<span>Ajouter une note</span>
						</button>
					</div>
				</div>
			</div>
			{!! Form::close() !!}
		</div>
		<div class="column">
			{!! Form::open(['route' => 'advisor.updateProjectDataKeysValues', 'method'=>'post']) !!}
			<div class="content">
				<p class="has-text-centered title is-5">Indicateurs concernant cette demande</p>
			</div>
			@foreach($publicProjectDataKeys as $publicProjectDataKey)
				<div class="columns">
					<div class="column is-half">
						<p>{{$publicProjectDataKey->name}}</p>
					</div>
					<div class="column">

						@if(!is_null($currentProjectKeyDataValues->where('project_data_key_id',$publicProjectDataKey->id  )->first()))
							<input name="project_data_key[{{$publicProjectDataKey->id}}]" class="input" type="text"
								   value="{{$currentProjectKeyDataValues->where('project_data_key_id',$publicProjectDataKey->id  )->first()->value}}"
								   placeholder="Saisir...">
						@else
							<input name="project_data_key[{{$publicProjectDataKey->id}}]" class="input" type="text"
								   placeholder="Saisir...">
						@endif
					</div>
				</div>
			@endforeach

			<div class="control">
				<input type="hidden" name="ad_id" value="{{$ad->id}}">
				<input type="hidden" name="user_id" value="{{auth()->id()}}">
				<button class="button is-link">
						 <span class="icon is-small">
						  <i class="fas fa-save"></i>
						</span>
					<span>Sauvegarder</span>
				</button>
			</div>
		</div>
		{!! Form::close() !!}
	</div>
</div>

