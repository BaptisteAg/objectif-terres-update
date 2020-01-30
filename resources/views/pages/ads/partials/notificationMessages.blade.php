<div class="columns ">
	<div class="column is-two-thirds">
		@if ($message = Session::get('success'))
			<article class="message is-success">
				<div class="message-header">
					<p>Succès</p>
					<button id="close-notification" class="delete" aria-label="delete"></button>
				</div>
				<div class="message-body">
					Votre message a bien été envoyé !
				</div>
			</article>
		@endif
		@if ($message = Session::get('save'))
			<article class="message is-success">
				<div class="message-header">
					<p>Succès</p>
					<button id="close-notification" class="delete" aria-label="delete"></button>
				</div>
				<div class="message-body">
					Cette annonce a été sauvegardée dans vos favoris !
				</div>
			</article>
		@endif
		@if ($message = Session::get('error'))
			<article class="message is-warning">
				<div class="message-header">
					<p>Avertissement</p>
					<button id="close-notification" class="delete" aria-label="delete"></button>
				</div>
				<div class="message-body">
					Vous avez déjà sauvegardé cette annonce dans vos favoris !
				</div>
			</article>
		@endif
	</div>
	<div class="column"></div>
</div>