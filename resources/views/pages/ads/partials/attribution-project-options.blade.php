{!! Form::open(['route' => 'supervisor.attribute', 'method'=>'post']) !!}
<div class="box has-text-centered">
	<div class="container">
		<p class="title is-2 has-text-centered">Suivi de la demande d'accompagnement</p>
		<p class="subtitle has-text-black ">Statut actuel de la demande :
			@if(is_null($ad->project))
				<span class="tag is-light">L'annonce n'a pas le statut de projet</span>
			@else
				@if($ad->project->projectStatus->name === "Accompagné")
					<span class="tag is-success is-light is-medium">{{$ad->project->projectStatus->name}}</span>
				@elseif($ad->project->projectStatus->name ==="Installé")
					<span class="tag is-success is-medium">{{$ad->project->projectStatus->name}}</span>
				@elseif($ad->project->projectStatus->name === "A rappeler")
					<span class="tag is-danger is-light is-medium">{{$ad->project->projectStatus->name}}</span>
				@elseif($ad->project->projectStatus->name === "Non assigné")
					<span class="tag is-warning is-medium">{{$ad->project->projectStatus->name}}</span>
				@elseif($ad->project->projectStatus->name === "Idée")
					<span class="tag is-primary is-medium">{{$ad->project->projectStatus->name}}</span>
				@elseif($ad->project->projectStatus->name === "Archivée")
					<span class="tag is-info is-light is-medium">{{$ad->project->projectStatus->name}}</span>
				@else
					<span class="tag is-info is-medium">{{$ad->project->projectStatus->name}}</span>
				@endif
			@endif

		</p>
		@if($ad->attributionAd->user_supervisor_id !== auth()->id())
			@if(isset($ad->attributionAd->user_supervisor_id))
				<p class="">Le responsable territorial de cette demande est
					<strong>{{$ad->attributionAd->userSupervisor->first_name}} {{$ad->attributionAd->userSupervisor->name}}</strong>.
				</p>
			@endif
			@if($ad->project->projectStatus->name !== "Non assigné")
				@if(isset($ad->attributionAd->user_advisor_id))
					<p class="">Cette demande est attribuée à
						<strong>{{$ad->attributionAd->userAdvisor->first_name}} {{$ad->attributionAd->userAdvisor->name}}</strong>.
					</p>
				@endif
			@endif
		@else
			@if($ad->project->projectStatus->name === "Non assigné")
				<p class="">Vous souhaitez attribuer cette demande à un primo-accueillant ?</p>
			@else
				@if(isset($ad->attributionAd->user_advisor_id))
					<p class="">Cette demande est attribuée à
						<strong>{{$ad->attributionAd->userAdvisor->first_name}} {{$ad->attributionAd->userAdvisor->name}}</strong>.
					</p>
				@endif
				<p>Vous souhaitez attribuer cette demande à un autre primo-accueillant ?</p>
			@endif
		@endif
	</div>
	<br>
	@if($ad->attributionAd->user_supervisor_id === auth()->id())
		<div class="columns is-centered ">
			<div class="column is-half has-text-centered ">
				<div class="field">
					<label class="label">Séléctionnez une personne parmi les primo-accueilants de votre
						territoire</label>
					<div class="select">
						<select name="user_advisor_id" onchange="showValidationSupervisorModal()">
							<option selected class="has-text-grey-light">Veuillez choisir...</option>
							@foreach ($advisorUsers as $advisor)
								<option value="{{$advisor->id}}">{{$advisor->first_name}} {{$advisor->name}}</option>
							@endforeach
						</select>
					</div>
					<input value="{{$ad->id}}" name="ad_id" type="hidden">
				</div>
			</div>
		</div>
	@endif
	<br>
</div>
<div id="modal-supervisor-validation" class="modal">
	<div id="modal-supervisor-validation-background" class="modal-background"></div>
	<div class="modal-content-validation">
		<div class="card">
			<div class="card-content">
				<div class="content">
					<p class="title is-3 has-text-centered has-text-link">Vous êtes sûre de votre choix ?</p>
				</div>
			</div>
			<footer class="card-footer">
				<div class="buttons card-footer-item">
					<button type="submit" class="button is-link">
						<span>Valider</span>
					</button>
					<a class="button is-link is-light" onclick="javascript:window.location.reload()">
						<span>Annuler</span>
					</a>
				</div>
				<a id="close-modal" class="modal-close is-large" aria-label="close"></a>
			</footer>
		</div>
	</div>
</div>
{!! Form::close() !!}