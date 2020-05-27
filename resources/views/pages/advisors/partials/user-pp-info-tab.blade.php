<div class="card-content ">
	<div class="content">
		<h4 class="title is-4 has-text-centered">{{$ad->userPp->first_name}} {{$ad->userPp->name}}</h4>
		<div class="columns">
			<div class="column has-text-centered">
				<p>
					<span class="icon">
						<i class="fas fa-envelope"></i>
					</span>
					{{$ad->userPp->email ?? 'Adresse mail non renseignée'}}
				</p>
			</div>
			<div class="column has-text-centered">
				<span class="icon">
					<i class="fas fa-map-marker-alt"></i>
				</span>
				{{$ad->userPp->street ?? 'Adresse non renseignée'}}
				<br>
				{{$ad->userPp->city ?? 'Ville non renseignée'}}
			</div>
			<div class="column has-text-centered">
				<p>
					<span class="icon">
						<i class="fas fa-phone"></i>
					</span>
					@if(is_null($ad->userPp->phone))
						Numéro de téléphone non renseigné
					@else
						{{$ad->userPp->phone}}
					@endif
				</p>
			</div>
		</div>
		<p><span class="is-italic">Civilité</span> : {{$ad->userPp->civility?? ''}}</p>
		<p><span class="is-italic">Type de porteur de projet</span> : {{$ad->userPp->profile?? ''}}</p>
		@if($ad->userPp->accept_communication)
			<p>Cet utilisateur a accepté de recevoir les communications de Terre de Liens. </p>
		@else
			<p>Cet utilisateur n'a pas accepté de recevoir les communications de Terre de
				Liens. </p>
		@endif
		@if(isset($ad->landSeekAd))
			<p><span class="is-italic">Expérience dans le domaine agricole </span> : {{$ad->landSeekAd->experience_farming ?? ""}}</p>
		@endif
		<p><span class="is-italic">Plus d'informations sur la personne </span> : {{$ad->about_content ?? ""}}</p>
		<p>Membre depuis le <strong>{{$ad->userPp->created_at}}</strong></p>
		<div class="columns">
			<div class="column is-2">
				<a href="{{route('user.edit', $ad->userPp)}}">
					<span class="icon  has-text-link">
						<i class="fas fa-user-edit "></i>
					</span>
					<span>Modifier </span>
				</a>
			</div>
			<div class="column is-2">
				<a>
					<span class="icon  has-text-link">
						<i class="fas fa-table "></i>
					</span>
					<span>Exporter </span>
				</a>
			</div>
			<div class="column is-2">
				<a>
					<span class="icon  has-text-link">
						<i class="fas fa-ban"></i>
					</span>
					<span>Bloquer </span>
				</a>
			</div>

		</div>
	</div>
</div>