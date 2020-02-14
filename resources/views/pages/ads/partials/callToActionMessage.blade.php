@auth
	@if( $ad->user_pp_id !== auth()->user()->id)
		@isset($userMessage)
			<div class="content">
				<div class="columns is-mobile is-centered">
					<div class="column is-half">
						<div class="box has-background-white-ter ">
							<article class="media">
								<div class="media-content">
									<div class="content has-text-centered ">
										<p class="has-text-centered is-size-4">Vous avez déjà envoyé une réponse
											à cette annnonce ! </p>
										<button  class="button is-link  is-large">
									 	<span class="icon is-small">
										<i class="fas fa-reply"></i>
										</span>
											<span> Consulter votre messagerie</span>
										</button>
									</div>
								</div>
							</article>
						</div>
					</div>
				</div>
			</div>
		@else
			<div class="content">
				<div class="columns is-mobile is-centered">
					<div class="column is-half">
						<div class="box has-background-white-ter ">
							<article class="media">
								<div class="media-content">
									<div class="content has-text-centered ">
										<p class="has-text-centered is-size-4">Vous souhaitez répondre à cette
											annonce
											?</p>
										<button id="open-modal-message" class="button is-link  is-large">
									 	<span class="icon is-small">
										<i class="fas fa-reply"></i>
										</span>
											<span> Répondre à l'annonce</span>
										</button>
									</div>
								</div>
							</article>
						</div>
					</div>
				</div>
			</div>
		@endisset
	@else
		@include('pages.ads.partials.listMessagesAd')
	@endif
@else
	<div class="content">
		<div class="columns is-mobile is-centered">
			<div class="column is-half">
				<div class="box has-background-white-ter ">
					<article class="media">
						<div class="media-content">
							<div class="content has-text-centered ">
								<p class="has-text-centered is-size-4">Vous souhaitez répondre à cette
									annonce
									?</p>
								<button id="open-modal-message" class="button is-link  is-large">
									 	<span class="icon is-small">
										<i class="fas fa-reply"></i>
										</span>
									<span> Répondre à l'annonce</span>
								</button>
							</div>
						</div>
					</article>
				</div>
			</div>
		</div>
	</div>

@endauth