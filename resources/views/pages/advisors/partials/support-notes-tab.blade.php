<div class="card-content">
	<div class="columns is-centered is-mobile">
		<div class="column is-12 ">

			@if(is_null($ad->adNotes) or $ad->adNotes->whereNull('project_data_key_id')->count() ===0)
				<p>Aucune note n'a été rédigée concernant cette demande.</p>
			@else
				<div style=" overflow-x: hidden; max-height: 500px;">
					@foreach($ad->adNotes->whereNull('project_data_key_id') as $note)
						<div class="card has-background-white-ter"
							 style="border: 2px solid transparent; border-radius: 12px; margin : 5px; margin-right : 10px; ">
							<div class="card-content" style="margin-bottom: 15px">
								<div v-if="noteToModify === {{$note->id}}">
									{!! Form::open(['route' => 'advisor.editNote', 'method'=>'post']) !!}
									<input type="hidden" name="user_id" value="{{auth()->id()}}">
									<input type="hidden" name="ad_id" value="{{$ad->id}}">
									<input type="hidden" name="ad_note_id" value="{{$note->id}}">
									<div class="field">
										<div class="control">
											<textarea class="textarea"
													  name="value"
													  placeholder="Remplissez...">{{$note->value}}</textarea>
										</div>
									</div>
									<div class="field is-grouped">
										<div class="control">
											<button type="submit"
													class="button is-link">
													<span class="icon">
													<i class="fas fa-check"></i>
												</span>
												<span>Valider</span>
											</button>
										</div>
										<div class="control">
											<button v-on:click="modifyNote(0)"
													class="button is-link is-light">
												<span class="icon">
													<i class="fas fa-times"></i>
												</span>
												<span>Annuler</span>
											</button>
										</div>
									</div>
									{!! Form::close() !!}
								</div>
								<div v-else>
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
								</div>
								<br>
								<div v-if="noteToModify === {{$note->id}}">
									<button v-on:click="modifyNote(0)"
											class="is-size-7 is-pulled-right has-text-link"
											style="border: none; background: transparent">
										<a>
										<span class="icon">
										<i class="fas fa-times"></i>
									</span>
											<span>Annuler</span>
										</a>
									</button>
								</div>
								<div v-else>
									<button v-on:click="modifyNote({{$note->id}})"
											class="is-size-7 is-pulled-right has-text-link"
											style="border: none; background: transparent">
										<a>
										<span class="icon">
										<i class="fas fa-pen"></i>
									</span>
											<span>Modifier</span>
										</a>
									</button>
								</div>
								{!! Form::open(['route' => 'advisor.deleteNote', 'method'=>'post']) !!}
								<input type="hidden" name="ad_note_id" value="{{$note->id}}">
{{--								<button class="is-size-7 is-pulled-right has-text-link"--}}
{{--										style="border: none; background: transparent">--}}
									<a class="is-pulled-right" v-on:click="showValidationModal()">
										<span class="icon">
										<i class="fas fa-trash-alt"></i>
									</span>
										<span>Supprimer</span>
									</a>
								@include('pages.advisors.partials.validation-modal')
{{--								</button>--}}
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
				<p class="is-italic">Ces notes sont internes. Le porteur de projet n’y a pas accès.</p>
				<br>
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
	</div>
</div>

