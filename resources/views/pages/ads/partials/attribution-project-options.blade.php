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
				@elseif($ad->project->projectStatus->name === "Non accompagné")
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
		@if($ad->project->projectStatus->name === "Non accompagné")
			<p class="">Vous souhaitez attribuer cette demande à un primo-accueillant ?</p>
		@else
			<p class="">Cette annonce est attribué à
				<strong>{{$ad->attributionAd->userAdvisor->first_name}} {{$ad->attributionAd->userAdvisor->name}}</strong>.
			</p>
			<p>Vous souhaitez attribuer cette demande à un autre primo-accueillant ?</p>
		@endif
	</div>
	<br>
	<div class="columns is-centered ">
		<div class="column is-half has-text-centered ">
			<div class="field">
				<label class="label">Séléctionner une personne parmi les primo-accueilants de votre territoire</label>
				<div class="select">
					<select onchange="showValidationSupervisorModal()">
						@foreach ($advisorUsers as $advisor)
							<option name="advisor_id" {{$ad->attributionAd->userAdvisor->id === $advisor->id ? 'selected' : '' }} value="{{$advisor->id}}">{{$advisor->first_name}} {{$advisor->name}}</option>
						@endforeach
					</select>
				</div>
			</div>
		</div>
	</div>
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
					<a href="{{route('login')}}">
						<button class="button is-link">
							<span>Valider</span></button>
					</a>
					<a onclick ="javascript:window.location.reload()">
						<button class="button is-link is-light">
							<span>Annuler</span></button>
					</a>
				</div>
				<button id="close-modal" class="modal-close is-large" aria-label="close"></button>
			</footer>
		</div>
	</div>
</div>