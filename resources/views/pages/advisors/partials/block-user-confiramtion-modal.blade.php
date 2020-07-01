<div  class="modal" v-bind:class="{'is-active': showUserBlockedValidationModal}">
	<div class="modal-background" v-on:click="showUserBlockedValidationModal = false"></div>
	<div class="modal-content-validation">
		<div class="card">
			<div class="card-content">
				<div class="content">
					<p class="title is-3 has-text-centered has-text-link">Êtes-vous sûre de votre choix ?</p>
					<p class="has-text-centered ">Bloquer l'utilisateur <strong>{{$ad->userPp->first_name}} {{$ad->userPp->name}}</strong> </p>

				</div>
			</div>
			<footer class="card-footer">
				<div class="buttons card-footer-item">
					<button type="submit" class="button is-link">
						<span>Valider</span>
					</button>
					<a class="button is-link is-light" v-on:click="showUserBlockedValidationModal = false">
						<span>Annuler</span>
					</a>
				</div>
				<a  class="modal-close is-large" aria-label="close" v-on:click="showUserBlockedValidationModal = false"></a>
			</footer>
		</div>
	</div>
</div>