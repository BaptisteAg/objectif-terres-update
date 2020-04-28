@auth
	@if( $ad->user_pp_id !== auth()->user()->id)
		@if(sizeof($threads) == 0)
			@if(auth()->user()->role >= 1)
				<div class="content">
					<div class="columns is-mobile is-centered">
						<div class="column is-half">
							<div class="box has-background-white-ter ">
								<article class="media">
									<div class="media-content">
										<div class="content has-text-centered ">
											<p class="has-text-centered is-size-4">Vous souhaitez contacter ce porteur
												de projet
												?</p>
											<button id="open-modal-message" class="button is-link  is-large">
									 	<span class="icon is-small">
										<i class="fas fa-reply"></i>
										</span>
												<span> Contacter le porteur de projet</span>
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
			@endif
		@else
			<div id="messages-display" class="content">
				<h3 class=" title is-3 has-text-link has-text-centered">Votre fil de discusion au sujet de cette
					annonce </h3>
			</div>
			<div id="vue-messages">
				<vue-threads
						inline-template
						v-bind:is-display-in-thread-page=false
						v-bind:is-user-ad-owner=false
						init-thread='{{ $threads[0]->id }}'
						:user-logged-id="{{auth()->id()}}"
						:user-role="{{auth()->user()->role}}"
				>
					<div>
						<div class="columns is-vcentered " v-if="initialLoading === true">
							<div class="column is-7">
								<div id="loading" class="is-pulled-right">
								</div>
							</div>
						</div>
						<div class="columns" v-else-if="initialLoading === false">
							<div class="column is-one-quarter" v-if="isUserAdOwner">
								<list-threads
										:threads="{{json_encode($threads)}}"
										:number-of-unread-messages="0"
										v-model="messages"
										v-bind:is-display="isDisplay"
										v-bind:is-user-logged-ad-owner="isUserAdOwner"
										:user-id="{{auth()->id()}}"
										@on-thread-click="onThreadClick"
								>
								</list-threads>
							</div>
							<div class="column box ">
								<header-message
										v-bind:is-display="isDisplay"
										v-model="messages"
										:user-id="{{auth()->id()}}"
								></header-message>
								<display-message-content
										v-model="messages"
										:user-id="{{auth()->id()}}"
								></display-message-content>
								<form-message-reply
										v-model="messages"
										:user-id="{{auth()->id()}}"
										@message-reply-success="onMessageReplySuccess"
										v-bind:is-user-moderator="isUserModerator"
										:response-templates = "{{json_encode($responseTemplates)}}"
								>
								</form-message-reply>
							</div>
						</div>
					</div>

				</vue-threads>
			</div>
		@endif
	@else
		@if(sizeof($threads) <= 0)
			<div class="content">
				<div class="columns is-mobile is-centered">
					<div class="column is-half">
						<div class="box has-background-white-ter ">
							<article class="media">
								<div class="media-content">
									<div class="content has-text-centered ">
										<p class="has-text-centered is-size-4">Vous n'avez pas encore reçu de messages
											concernant cette annonce</p>
									</div>
								</div>
							</article>
						</div>
					</div>
				</div>
			</div>
		@else
			<div id="messages-display" class="content">
				<h3 class="title is-3 has-text-link has-text-centered">Vos messages reçus pour votre annonce</h3>
			</div>
			<div id="vue-messages">
				<vue-threads
						inline-template
						v-bind:is-display-in-thread-page=false
						v-bind:is-user-ad-owner=true
						init-thread='{{ $threads[0]->id }}'
						:user-logged-id="{{auth()->id()}}"
				>
					<div>
						<div class="columns is-vcentered " v-if="initialLoading === true">
							<div class="column is-7 ">
								<div id="loading" class="is-pulled-right">
								</div>
							</div>
						</div>
						<div class="columns" v-else-if="initialLoading === false">
							<div class="column is-one-quarter" v-if="isUserAdOwner">
								<list-threads
										:threads="{{json_encode($threads)}}"
										:number-of-unread-messages="0"
										:threads-with-unread-messages="{{$threadsWithUnreadMessages}}"
										v-model="messages"
										v-bind:is-display="isDisplay"
										v-bind:is-user-logged-ad-owner="isUserAdOwner"
										:user-id="{{auth()->id()}}"
										@on-thread-click="onThreadClick"
								>
								</list-threads>
							</div>
							<div class="column box ">
								<header-message
										v-bind:is-display="isDisplay"
										v-model="messages"
										:user-id="{{auth()->id()}}"
								></header-message>
								<display-message-content
										v-model="messages"
										:user-id="{{auth()->id()}}"
								></display-message-content>
								<form-message-reply
										v-model="messages"
										:user-id="{{auth()->id()}}"
										@message-reply-success="onMessageReplySuccess"
								>
								</form-message-reply>
							</div>
						</div>
					</div>
				</vue-threads>
			</div>
		@endif
	@endif
@else
	<div id="messages-display" class="content">
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