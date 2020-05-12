@extends ('default')

@section ('title', 'Espace de suivi')

@section('head-script')
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma-carousel@4.0.4/dist/css/bulma-carousel.min.css">
@endsection

@section('main-content')
	<section class="section">
		<h1 class="title is-2 has-text-link">Suivi de l'accompagnement </h1>
		@if($ad->attributionAd->userAdvisor->id === auth()->user()->id)
			<p>Vous êtes le primo-accueillant pour cette demande !</p>
		@else
			<p>Cette demande est attribuée
				à {{$ad->attributionAd->userAdvisor->first_name}} {{$ad->attributionAd->userAdvisor->name}}
				.</p>
		@endif
		<div id="advisor-support-request-dashboard">
			<support-request-dashboard
					inline-template
					:thread='{{ $thread->id }}'
			>
				<div>
					{!! Form::open(['route' => 'advisor.updateSupport', 'method'=>'post']) !!}
					<div class="columns ">
						<div class="column "></div>
						<div class="column is-2 ">
							<div class="field">
								<div class="control has-text-centered">
									<div class="select  ">
										<select name="support_stage" v-on:change="showValidationModal()">
											<option disabled selected hidden>Stade de l'accompagnement</option>
											@foreach ($supportStages as $supportStage)
												@if(isset($ad->project->supportStage) and $supportStage->id === $ad->project->supportStage->id)
													<option disabled
															value="{{$supportStage->id}}">{{$supportStage->name}}</option>
												@else
													<option value="{{$supportStage->id}}">{{$supportStage->name}}</option>
												@endif
											@endforeach
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="column is-2">
							<div class="field">
								<div class="control  has-text-centered">
									<div class="select">
										<select name="support_state" v-on:change="showValidationModal()">
											<option disabled selected hidden>État de la demande</option>
											@foreach ($supportStates as $supportState)
												@if(isset($ad->project->supportState) and $supportState->id === $ad->project->supportState->id)
													<option disabled
															value="{{$supportState->id}}">{{$supportState->name}}</option>
												@else
													<option value="{{$supportState->id}}">{{$supportState->name}}</option>
												@endif
											@endforeach
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="column is-2">
							<div class="field">
								<div class="control  has-text-centered">
									<div class="select ">
										<select name="project_status" v-on:change="showValidationModal()">
											<option disabled selected hidden>Avancement du projet</option>
											@foreach ($projectStatuses as $projectStatus)
												@if(isset($ad->project->projectStatus) and $projectStatus->id === $ad->project->projectStatus->id)
													<option disabled
															value="{{$projectStatus->id}}">{{$projectStatus->name}}</option>
												@else
													<option value="{{$projectStatus->id}}">{{$projectStatus->name}}</option>
												@endif
											@endforeach
										</select>
									</div>
								</div>
							</div>
						</div>
						<input value="{{$ad->id}}" name="ad_id" type="hidden">
						@include('pages.advisors.partials.validation-modal')
					</div>
					{!! Form::close() !!}
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
									@include('pages.advisors.partials.support-info-tab')
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
									@include('pages.advisors.partials.support-thread-tab')
								</div>
								<div v-show="tabsOpen.supportTabOpen === 'support-request-documents-tab'"
									 class="support-request-documents-tab">
									<div class="card-content">
										<h3 class=" title is-3 has-text-link has-text-centered">Listes de documents
										</h3>
										<p class="subtitle">Retrouvez ici l'ensemble des documents concernant le suivi
											de
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