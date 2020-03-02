<div id="vue-moderation-modal">
	<vue-moderation-modal inline-template
						  :refusal-types="{{json_encode($refusalTypes)}}"
						  :response-templates="{{json_encode($responseTemplates)}}"
						  :attribution-ad = "{{$ad->attributionAd->id}}"
	>
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

{{--					<a href="{{route('moderation.accept', $ad->attributionAd)}}">--}}
						<button @click="showModerationModal('acceptAd')"  class="button is-link ">
							Valider l'annonce
						</button>
{{--					</a>--}}
				</div>
				<div class="column is-3  is-centered">
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
					v-bind:form-url ="formUrl"
					v-bind:attribution-ad-id ="attributionAdId"
			>
			</moderation-modal>


		</div>
	</vue-moderation-modal>
</div>

