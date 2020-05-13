<div id="vue-moderation-modal">
	<vue-moderation-modal inline-template
						  :refusal-types="{{json_encode($refusalTypes)}}"
						  :response-templates="{{json_encode($responseTemplates)}}"
						  :ad-id="{{$ad->id}}"
						  :attribution-ad-id="{{$ad->attributionAd->id}}"
	>
		@if($isAdToModerate and $isLoggedUserModeratorAd)
			<div class="box has-text-centered">
				<div class="container">
					<p class="title is-2 has-text-centered">Modération de l'annonce</p>
					<p class="subtitle has-text-black">Retrouvez ici les diférentes options pour la modération de cette
						annonce </p>
					<p>Statut actuel de l'annonce : {{$ad->attributionAd->adStatus->name}}</p>
					<br>
				</div>
				<div class="columns is-mobile is-centered is-vcentered">
					<div class="column is-3  is-centered">
						<button @click="showModerationModal('acceptAd')" class="button is-link ">
							Valider l'annonce
						</button>
					</div>
					<div class="column is-5  is-centered">
						<button @click="showModerationModal('modifyAd')" class="button">
							Demander la modification de l'annonce
						</button>
					</div>
					<div class="column is-3 is-centered">
						<button @click="showModerationModal('rejectAd')" class="button is-danger">
							Refuser l'annonce
						</button>
					</div>
				</div>
				<moderation-modal
						v-if="showModal"
						@close="showModerationModal(false)"
						v-bind:moderation-choice="moderationChoice"
						v-bind:select-options="selectOptions"
						v-bind:form-url="formUrl"
						v-bind:ad-id="adIdShow"
						v-bind:attribution-ad-id="attributionAd"
				>
				</moderation-modal>
			</div>

		@elseif (!$isAdToModerate && $isLoggedUserModeratorAd)
			<div class="box has-text-centered">
				<div class="container">
					<p class="title is-2 has-text-centered">Modération de l'annonce</p>
					<p class="subtitle is-6 has-text-black">Vous avez déjà modérée l'annonce ! </p>
					<div class="content is-medium">
						<p class="title is-5 is-spaced" >Statut actuel de l'annonce : <strong>{{$ad->attributionAd->adStatus->name}}</strong></p>
					</div>
					<p class="has-text-centered" >Vous souhaitez modifier votre choix ? </p>
				</div>
				<br>
				<div class="columns is-mobile is-centered is-vcentered">
					@if ($ad->attributionAd->adStatus->name !== "Validée")
						<div class="column is-3  is-centered">
							<button @click="showModerationModal('acceptAd')" class="button is-link ">
								Valider l'annonce
							</button>
						</div>
					@endif
					@if($ad->attributionAd->adStatus->name !== "En attente")
						<div class="column is-5  is-centered">
							<button @click="showModerationModal('modifyAd')" class="button">
								Demander la modification de l'annonce
							</button>
						</div>
					@endif
					@if ($ad->attributionAd->adStatus->name !== "Refusée")
						<div class="column is-3 is-centered">
							<button @click="showModerationModal('rejectAd')" class="button is-danger">
								Refuser l'annonce
							</button>
						</div>
					@endif
				</div>
				<moderation-modal
						v-if="showModal"
						@close="showModerationModal(false)"
						v-bind:moderation-choice="moderationChoice"
						v-bind:select-options="selectOptions"
						v-bind:form-url="formUrl"
						v-bind:ad-id="adIdShow"
						v-bind:attribution-ad-id="attributionAd"
				>
				</moderation-modal>
			</div>
		@else
			<div class="box has-text-centered">
				<div class="container">
					<p class="title is-2 has-text-centered">Modération de l'annonce</p>
					<br>
						<p class="subtitle has-text-black">L'annonce est modérée
							par
							<strong>{{$ad->attributionAd->userModerator->first_name}} {{$ad->attributionAd->userModerator->name}}</strong>
						</p>
					<p>Statut actuel de l'annonce : <span
								class="has-text-link">{{$ad->attributionAd->adStatus->name}}</span></p>
					<br>
				</div>
			</div>
		@endif
	</vue-moderation-modal>
</div>
<br>

