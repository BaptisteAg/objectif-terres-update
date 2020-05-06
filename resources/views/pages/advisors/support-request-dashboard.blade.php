@extends ('default')

@section ('title', 'Espace de suivi')

@section('main-content')
	<section class="section">
		<h1 class="title is-2 has-text-link">Suivi de l'accompagnement </h1>
		<div id="advisor-support-request-dashboard">
			<support-request-dashboard inline-template>
				<div class="columns">
					<div class="column is-half">
						<div class="card">
							<div class="tabs is-toggle is-fullwidth">
								<ul>
									<li :class="{ 'is-active' : tabsOpen.infoTabOpen === 'user-pp-info-tab'}">
										<a v-on:click="openInfoTab('user-pp-info-tab')">
											<span class="icon is-small"><i class="fas fa-user"></i></span>
											<span>Profil porteur de projet</span>
										</a>
									</li>
									<li :class="{ 'is-active' : tabsOpen.infoTabOpen === 'support-request-info-tab'}">
										<a v-on:click="openInfoTab('support-request-info-tab')">
											<span class="icon is-small"><i class="fas fa-hands-helping"></i></span>
											<span>Demande d'accompagnement</span>
										</a>
									</li>
									<li>
										<a>
											<span class="icon is-small"><i class="fas fa-newspaper"></i></span>
											<span>Annonces</span>
										</a>
									</li>
								</ul>
							</div>
							<div v-show="tabsOpen.infoTabOpen === 'user-pp-info-tab'" class=" user-info">
								@include('pages.advisors.partials.user-pp-info-tab')
							</div>
							<div v-show="tabsOpen.infoTabOpen === 'support-request-info-tab'"
								 class="support-request-info">
								@include('pages.advisors.partials.support-request-info-tab')
							</div>

						</div>
					</div>
					<div class="column is-half">
						<div class="card">
							<div class="tabs is-toggle is-fullwidth">
								<ul>
									<li :class="{ 'is-active' : tabsOpen.supportTabOpen === 'support-request-notes-tab'}">
										<a v-on:click="openSupportTab('support-request-notes-tab')">
											<span class="icon is-small"><i class="fas fa-sticky-note"></i></span>
											<span>Notes</span>
										</a>
									</li>
									<li :class="{ 'is-active' : tabsOpen.supportTabOpen === 'support-request-thread-tab'}">
										<a v-on:click="openSupportTab('support-request-thread-tab')">
											<span class="icon is-small"><i class="fas fa-comments"></i></span>
											<span>Messages</span>
										</a>
									</li>
									<li :class="{ 'is-active' : tabsOpen.supportTabOpen === 'support-request-documents-tab'}">
										<a v-on:click="openSupportTab('support-request-documents-tab')">
											<span class="icon is-small"><i class="fas fa-paperclip"></i></span>
											<span>Documents</span>
										</a>
									</li>
								</ul>
							</div>
							<div class="card-content">
								<div class="content">
									<div id="messages-display" class="content">
										<h3 class=" title is-3 has-text-link has-text-centered">Votre fil de discusion
											au sujet de cet accompagnement </h3>
									</div>
									<div id="advisor-support-request-thread">
										<vue-threads
												inline-template
												v-bind:is-display-in-thread-page=false
												v-bind:is-user-ad-owner=false
												init-thread='{{ $thread->id }}'
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
																:response-templates="{{json_encode($responseTemplates)}}"
														>
														</form-message-reply>
													</div>
												</div>
											</div>
										</vue-threads>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</support-request-dashboard>
		</div>
	</section>
@endsection

@section('script')
	<script>
        const vueAdvisorSupportRequestDashboard = new Vue({
            el: '#advisor-support-request-dashboard',
            name: 'content'
        });
	</script>

	<script>
        const vueAdvisorThread = new Vue({
            el: '#advisor-support-request-thread',
            name: 'sub-content'
        })
	</script>

	@if(count($ad->images) > 1)
		<script src="{{asset('/js/bulma-carousel.js')}}"></script>
		<script>
            const carousel = bulmaCarousel.attach('#support-request-dashboard-ad-images', {
                slidesToScroll: 1,
                slidesToShow: 1,
                loop: true,
                navigation: true,
            });
		</script>
	@endif
@endsection