@extends ('default')

@section ('title', 'Espace de suivi')

@section('head-script')
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma-carousel@4.0.4/dist/css/bulma-carousel.min.css">
@endsection

@section('main-content')
	<section class="section">
		<h1 class="title is-2 has-text-link">Suivi de l'accompagnement </h1>
		<div id="advisor-support-request-dashboard">
			<support-request-dashboard
					inline-template
					:thread='{{ $thread->id }}'
			>
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
							<div v-show="tabsOpen.infoTabOpen === 'user-pp-info-tab'" class=" user-info-tab">
								@include('pages.advisors.partials.user-pp-info-tab')
							</div>
							<div v-show="tabsOpen.infoTabOpen === 'support-request-info-tab'"
								 class="support-request-info-tab">
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
							<div v-show="tabsOpen.supportTabOpen === 'support-request-thread-tab'"
								 class="support-request-thread-tab">
								@include('pages.advisors.partials.support-request-thread-tab')
							</div>
							<div v-show="tabsOpen.supportTabOpen === 'support-request-documents-tab'"
								 class="support-request-documents-tab">
								<div class="card-content">
									<h3 class=" title is-3 has-text-link has-text-centered">Listes de documents
									</h3>
									<p class="subtitle">Retrouvez ici l'ensemble des documents concernant le suivi de
										cette demande d'accomapgnement</p>

									<div class="content">
										<div class="buttons">
											<button class="button is-link is-light">
											<span class="icon is-small">
											<i class="fas fa-file"></i>
											</span>
												<span>rapport-entretien.pdf</span>
											</button>
										</div>
										<div class="buttons">
											<button class="button is-link is-light">
											<span class="icon is-small">
											<i class="fas fa-image"></i>
											</span>
												<span>photo-terrain.png</span>
											</button>
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
	@if(count($ad->images) > 1)
		<script src="{{asset('/js/bulma-carousel.js')}}"></script>
		<script>
            const carouselSupportRequestDashboard = bulmaCarousel.attach('#support-request-dashboard-ad-images', {
                slidesToScroll: 1,
                slidesToShow: 1,
                loop: true,
                navigation: true,
            });
		</script>
	@endif
@endsection