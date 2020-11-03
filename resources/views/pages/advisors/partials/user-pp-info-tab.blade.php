<div class="card-content ">
	<div class="content">
		@if(! $ad->userPp->trashed())
			<h4 class="title is-4 has-text-centered"><a
						href="{{route('user.show', $ad->userPp->id)}}">{{$ad->pp_display_name}}</a>
			</h4>
		@else
			<h4 class="title is-4 has-text-centered">{{$ad->pp_display_name}}</h4>
		@endif
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
				{{$ad->userPp->zipCode->zip_code ?? 'Code postal non renseignée'}} {{$ad->userPp->city ?? 'Ville non renseignée'}}
			</div>
			<div class="column has-text-centered">
				<p>
					<span class="icon">
						<i class="fas fa-phone"></i>
					</span>
					{{$ad->userPp->phone ?? "Numéro de téléphone non renseigné"}}
				</p>
			</div>
		</div>
		<p><span class="is-italic">Civilité</span> : {{$ad->userPp->civilityFullName?? 'Non renseignée'}}</p>
		<p><span class="is-italic">Type de porteur de projet</span> : {{$ad->userPp->profile?? 'Non renseigné'}}
		</p>
		@if($ad->userPp->accept_communication)
			<p>Cet utilisateur a accepté de recevoir les communications de Terre de Liens. </p>
		@else
			<p>Cet utilisateur n'a pas accepté de recevoir les communications de Terre de
				Liens. </p>
		@endif
		@if(isset($ad->landSeekAd))
			<p><span class="is-italic">Expérience dans le domaine agricole </span>
				: {{$ad->landSeekAd->experience_farming ?? "Non renseigné"}}</p>
		@endif
		<p><span class="is-italic">Plus d'informations sur la personne </span>
			: {{$ad->about_content ?? "Non renseigné"}}</p>
		<p>Nombre d'annonces soumises : {{$listUserAds->count()}}</p>
		<p>Membre depuis le <strong>{{$ad->userPp->created_at}}</strong></p>
		@if(! $ad->userPp->trashed())
			<div class="columns ">
				<div class="column is-2">
					<a href="{{route('user.edit', $ad->userPp->id)}}">
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
					{!! Form::open(['route'=>'advisor.blockUser']) !!}
					<input type="hidden" name="user_pp_id" value="{{$ad->userPp->id}}">
					<a @click="showUserBlockedValidationModal = true">
						<span class="icon  has-text-link">
							<i class="fas fa-ban"></i>
						</span>
						<span>Bloquer </span>
					</a>
					@include('pages.advisors.partials.block-user-confiramtion-modal')
					{!! Form::close() !!}
				</div>
			</div>
		@endif
	</div>
</div>

