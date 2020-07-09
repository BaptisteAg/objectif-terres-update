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
					@if(! is_null($ad->attributionAd->adStatus))
						<p>Statut actuel de l'annonce :
							<span class="has-tooltip-right"  data-tooltip="{{\App\Models\AdStatus::TOOLTIPS[$ad->attributionAd->adStatus->id]}}"> {{$ad->attributionAd->adStatus->name}}
							<i class="fas fa-info-circle has-text-info"></i>
							</span>
						</p>
					@endif
					<br>
				</div>
				<div class="columns is-mobile is-centered is-vcentered">
					<div class="column is-3  is-centered">
						<button @click="showModerationModal('acceptAd')" class="button form-button basic success ">
							 <span class="icon is-small">
      							<i class="fas fa-check"></i>
   							 </span>
							<span>Valider l'annonce</span>
						</button>
					</div>
					<div class="column is-5  is-centered">
						<button @click="showModerationModal('modifyAd')" class="button form-button basic warning">
							 <span class="icon is-small">
      							<i class="fas fa-pen"></i>
   							 </span>
							<span>Demander la modification de l'annonce</span>
						</button>
					</div>
					<div class="column is-3 is-centered">
						<button @click="showModerationModal('rejectAd')" class="button form-button basic danger">
							 <span class="icon is-small">
      							<i class="fas fa-times"></i>
   							 </span>
							<span>Refuser l'annonce</span>
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
						accept-ad-message = "{{\App\Models\AttributionAd::VALIDATION_MESSAGE}}"
				>
				</moderation-modal>
			</div>

		@elseif (!$isAdToModerate && $isLoggedUserModeratorAd)
			<div class="box has-text-centered">
				<div class="container">
					<p class="title is-2 has-text-centered">Modération de l'annonce</p>
					<p class="subtitle is-6 has-text-black">L'annonce a déjà été modérée!  </p>
					<div class="content is-medium">
						<p class="title is-5 is-spaced">Statut actuel de l'annonce :
							<strong>{{$ad->attributionAd->adStatus && $ad->attributionAd->adStatus->name}}</strong></p>
					</div>
					<p class="has-text-centered">Vous souhaitez modifier ce choix ? </p>
				</div>
				<br>
				<div class="columns is-mobile is-centered is-vcentered">
					@if ($ad->attributionAd->adStatus && $ad->attributionAd->adStatus->name !== "Validée")
						<div class="column is-3  is-centered">
							<button @click="showModerationModal('acceptAd')" class="button form-button basic success ">
								Valider l'annonce
							</button>
						</div>
					@endif
					@if($ad->attributionAd->adStatus && $ad->attributionAd->adStatus->name !== "En attente")
						<div class="column is-5  is-centered">
							<button @click="showModerationModal('modifyAd')" class="button form-button basic warning">
								Demander la modification de l'annonce
							</button>
						</div>
					@endif
					@if ($ad->attributionAd->adStatus && $ad->attributionAd->adStatus->name !== "Refusée")
						<div class="column is-3 is-centered">
							<button @click="showModerationModal('rejectAd')" class="button form-button basic danger">
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
						accept-ad-message = "{{\App\Models\AttributionAd::VALIDATION_MESSAGE}}"
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

