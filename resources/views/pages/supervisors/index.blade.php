@extends('default')

@section ('title', 'Mon espace responsable territorial')

@section('main-content')

	<div class="section">
		<h1 class="title is-2 has-text-link">Bienvenue sur votre espace responsable territorial <span
					class="is-italic">{{ Auth::user()->first_name }} {{ Auth::user()->name }}</span></h1>

		@include('components.supervisor-tabs')

		@if($numberOfNotAssignProject !== 0 || $numberOfUnreadMessages !==0)
			<div id="notification-supervisor" class="notification has-background-info">
				<button id="close-notification-supervisor" class="delete"></button>
				@if($numberOfNotAssignProject>1)
					<p class="has-text-white-ter">
						<i class="far fa-bell has-text-white-ter"></i>
						Vous avez<a style="text-decoration: none"
									href="/">
							<strong>{{$numberOfNotAssignProject}}
								demandes d'accompagnement non assignées</strong></a> dans votre territoire !
					</p>
				@elseif ($numberOfNotAssignProject === 1)
					<p class="has-text-white-ter">
						<i class="far fa-bell has-text-white-ter"></i>
						Vous avez<a style="text-decoration: none"
									href="/">
							<strong>{{$numberOfNotAssignProject}}
								demande d'accompagnement non assignée</strong></a> dans votre territoire !
					</p>
				@else
				@endif
				@if($numberOfUnreadMessages > 1 )
					<a style="text-decoration: none" href="{{route('threads.index')}}"><p class="has-text-white"><i
									class="fas fa-envelope "></i> Vous
							avez <strong>{{$numberOfUnreadMessages}}
								nouveaux messages
								!</strong></p></a>
				@elseif ($numberOfUnreadMessages === 1 )
					<a style="text-decoration: none" href="{{route('threads.index')}}">
						<p class="has-text-white"><i class="fas fa-envelope"></i> Vous avez
							<strong>{{$numberOfUnreadMessages}} nouveau message !</strong>
						</p>
					</a>
				@else
				@endif
			</div>
		@endif
		{{Form::open(['route'=>'supervisor.show', 'method'=>'get'])}}
		<div id="vue-form-supervisor">
			@include('components.dashboard-filters')
		</div>
		{{Form::close()}}

		<div id="supervisor-form-export-data">
			<export-to-spreadsheet-form inline-template>
				<div>
					<div class="container is-fluid">
						<a v-on:click="openModal()">
							<span class="icon is-medium has-text-link">
								<i class="fas fa-table fa-2x "></i>
							</span>
							<span>Exporter les données</span>
						</a>
					</div>
					{!! Form::open(['route' => 'supervisor.export', 'method' => 'get']) !!}
					<div v-cloak id="modal-supervisor-form-data" :class="isActive ? 'modal is-active': 'modal'">
						<div id="modal-supervisor-form-data-background" class="modal-background"
							 v-on:click="closeModal()"></div>
						<div class="modal-content-validation">
							<div class="card">
								<div class="card-content">
									<div class="content">
										<a v-on:click="closeModal()" id="close-modal" class="modal-close is-large"
										   aria-label="close" style="position : relative; float: right; background-color: rgba(10, 10, 10, 0.2); right: 0px; top:0px;"></a>
										<p class="title is-3 has-text-centered has-text-link">Exportation des
											données</p>
										<p class="subtitle has-text-centered ">Veuillez séléctionner une plage de
											date</p>
										<div class="columns is-mobile is-centered">
											<div class="column">
												<div class="control has-icons-right ">
													<date-range></date-range>
												</div>
											</div>
										</div>
									</div>
								</div>
								<footer class="card-footer">
									<div class="buttons card-footer-item">
										<button type="submit" class="button is-link">
											<span>Télécharger</span>
										</button>
										<a class="button is-link is-light" v-on:click="closeModal()">
											<span>Annuler</span>
										</a>
									</div>
								</footer>
							</div>
						</div>
					</div>
					{{Form::close()}}
				</div>
			</export-to-spreadsheet-form>
		</div>
		<div class="section">
			<h1 class="title is-1 has-text-centered">Liste des annonces et demandes d'accompagnement sur votre
				territoire</h1>
			@if (count($ads) ==0)
				<p class="has-text-centered">Aucun résultat</p>
			@else
				<div class="table-container">
					<table class="table is-bordered  is-striped is-narrow is-hoverable is-fullwidth "
						   style="border :2px solid #dbdbdb">
						<thead>
						<tr>
							<th colspan="5" class="has-text-centered  " style="border-right :2px solid #dbdbdb">Profil
								et nature de la
								demande
							</th>
							<th colspan="4" class="has-text-centered" style="border-right :2px solid #dbdbdb">Suivi de
								l'accompagnement
							</th>
							<th style="border-bottom: none;"></th>
						</tr>
						<tr>
							<th class="has-text-weight-semibold" style="border-bottom :3px solid #dbdbdb">Catégorie</th>
							<th class="has-text-weight-semibold" style="border-bottom :3px solid #dbdbdb">
								@if(request()->input('sort') !== 'name')
									<a href="{{ route('advisor.show', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'name'])) }}">
										<span>Nom du porteur de projet</span>
									</a>
								@elseif(request()->input('sort') === 'name' && request()->input('order') === 'asc')
									<a href="{{ route('advisor.show', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'name'])) }}">
										<i class="fas fa-arrow-up"></i>
										<span>Nom du porteur de projet</span>
									</a>
								@else
									<a href="{{ route('advisor.show', array_diff_key(Request::all(), ['order'=>'', 'sort'=>''])) }}">
										<i class="fas fa-arrow-down"></i>
										<span>Nom du porteur de projet</span>
									</a>
								@endif
							</th>
							<th class="has-text-weight-semibold" style="border-bottom :3px solid #dbdbdb">
								@if(request()->input('sort') !== 'project_statuses.name')
									<a href="{{ route('advisor.show', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'project_statuses.name'])) }}">
										<span>Avancement du projet</span>
									</a>
								@elseif(request()->input('sort') === 'project_statuses.name' && request()->input('order') === 'asc')
									<a href="{{ route('advisor.show', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'project_statuses.name'])) }}">
										<i class="fas fa-arrow-up"></i>
										<span>Avancement du projet</span>
									</a>
								@else
									<a href="{{ route('advisor.show', array_diff_key(Request::all(), ['order'=>'', 'sort'=>''])) }}) }}">
										<i class="fas fa-arrow-down"></i>
										<span>Avancement du projet</span>
									</a>
								@endif
							</th>

							<th class="has-text-weight-semibold" style="border-bottom :3px solid #dbdbdb">
								Localisation(s)
							</th>
							<th class="has-text-weight-semibold"
								style="border-right :2px solid #dbdbdb; border-bottom :3px solid #dbdbdb">
								@if(request()->input('sort') !== 'title')
									<a href="{{ route('advisor.show', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'title'])) }}">
										<span>Titre</span>
									</a>
								@elseif(request()->input('sort') === 'title' && request()->input('order') === 'asc')
									<a href="{{ route('advisor.show', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'title'])) }}">
										<i class="fas fa-arrow-up"></i>
										<span>Titre</span>
									</a>
								@else
									<a href="{{ route('advisor.show', array_diff_key(Request::all(), ['order'=>'', 'sort'=>''])) }}">
										<i class="fas fa-arrow-down"></i>
										<span>Titre</span>
									</a>
								@endif
							</th>


							<th class="has-text-weight-semibold" style="border-bottom :3px solid #dbdbdb">
								@if(request()->input('sort') !== 'date')
									<a href="{{ route('advisor.show', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'date'])) }}">
										<span>Date</span>
									</a>
								@elseif(request()->input('sort') === 'date' && request()->input('order') === 'desc')
									<a href="{{ route('advisor.show', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'date'])) }}">
										<i class="fas fa-arrow-down"></i>
										<span>Date</span>
									</a>
								@else
									<a href="{{ route('advisor.show', array_diff_key(Request::all(), ['order'=>'', 'sort'=>''])) }}">
										<i class="fas fa-arrow-up"></i>
										<span>Date</span>
									</a>
								@endif
							</th>

							<th class="has-text-weight-semibold" style="border-bottom :3px solid #dbdbdb">Suivi par</th>
							<th class="has-text-weight-semibold" style="border-bottom :3px solid #dbdbdb">Stade de
								l'accompagnement
							</th>
							<th class="has-text-weight-semibold"
								style="border-right :2px solid #dbdbdb;  border-bottom :3px solid #dbdbdb">Etat de la
								demande
							</th>

							<th class="has-text-weight-semibold"
								style="width: 142px; border-width: 0px;  border-bottom :3px solid #dbdbdb "></th>
						</tr>
						</thead>
						<tbody>
						@foreach($ads as $ad)
							@if(!is_null($ad->project))
								@if(auth()->id() === $ad->attributionAd->user_supervisor_id and is_null($ad->attributionAd->userAdvisor))
									<tr style="border: 4px solid red">
								@endif
							@else
								<tr>
									@endif
									<td>
										@if(!is_null($ad->project))
											<span class="icon is-medium  has-text-link has-tooltip-right"
												  data-tooltip="C'est une demande d'accompagnement">
											  <i class="fas fa-lg fa-hands-helping"></i>
											</span>
										@else
											<span class="icon is-medium  has-text-link has-tooltip-right"
												  data-tooltip="C'est une annonce">
											  <i class="fas fa-lg fa-newspaper"></i>
											</span>
										@endif
										{{$ad->ad_type_full_name}}
										<br>
									</td>
									<td>
										<a href="{{route('user.show', $ad->userPp->id)}}">{{$ad->userPp->first_name}} {{$ad->userPp->name}}</a>
									</td>
									<td>
										@if(is_null($ad->project))
											<span>-</span>
										@else
											@if(!is_null($ad->project->projectStatus))
												@if($ad->project->projectStatus->id === \App\Models\ProjectStatus::EMERGING_ID)
													<span class="tag is-info">{{$ad->project->projectStatus->name}}</span>
												@elseif($ad->project->projectStatus->id ===\App\Models\ProjectStatus::IN_PROGRESSING_ID)
													<span class="tag is-info is-light">{{$ad->project->projectStatus->name}}</span>
												@elseif($ad->project->projectStatus->id === \App\Models\ProjectStatus::ABANDONED_ID)
													<span class="tag is-danger is-light">{{$ad->project->projectStatus->name}}</span>
												@elseif($ad->project->projectStatus->id === \App\Models\ProjectStatus::ACCOMPLISHED_ID)
													<span class="tag is-success ">{{$ad->project->projectStatus->name}}</span>
												@endif
											@else
												<span class="tag is-warning">Non définis</span>
											@endif
										@endif
									</td>
									<td>
										@if(! is_null($ad->regionsList))
											<p>Region(s) : {{$ad->regionsList}}</p>
										@endif
										@if(! is_null($ad->departmentsList))
											<p>Département(s) : {{$ad->departmentsList}}</p>
										@endif
										@if(! is_null($ad->citiesList))
											<p>Communes(s) : {{$ad->citiesList}}</p>
										@endif
									</td>
									<td style="border-right:2px solid #dbdbdb">
										@if(is_null($ad->project))
											<a href="{{route('ads.show', $ad->id)}}">{{$ad->title}}</a>

										@else
											<a href="{{route('advisor.showSupport', $ad->id)}}">{{$ad->title}}</a>

										@endif
									</td>
									<td>
										{{$ad->attributionAd->created_at->format("d/m/Y")}}
									</td>
									<td>
										@if(!is_null($ad->project_id))
											@if(isset($ad->attributionAd->userAdvisor))
												{{$ad->attributionAd->userAdvisor->first_name}} {{$ad->attributionAd->userAdvisor->name}}
											@else
												<span class="tag is-danger">Non attribué</span>
											@endif
										@else
											-
										@endif
									</td>
									<td>
										@if(is_null($ad->project))
											<span>-</span>
										@else
											@if(!is_null($ad->project->supportStage))
												@if($ad->project->supportStage->id === \App\Models\SupportStage::FIRST_CONTACT_ID)
													<span class="tag is-info">{{$ad->project->supportStage->name}}</span>
												@elseif($ad->project->supportStage->id ===\App\Models\SupportStage::FIRST_RECEPTION_ID)
													<span class="tag is-info is-light">{{$ad->project->supportStage->name}}</span>
												@elseif($ad->project->supportStage->id === \App\Models\SupportStage::ACCOMPANYING_ID)
													<span class="tag is-success is-light">{{$ad->project->supportStage->name}}</span>
												@endif
											@else
												<span class="tag is-warning">Non définis</span>
											@endif
										@endif
									</td>
									<td style="border-right:2px solid #dbdbdb">
										@if(is_null($ad->project))
											<span>-</span>
										@else
											@if(!is_null($ad->project->supportState))
												@if($ad->project->supportState->id === \App\Models\SupportState::TO_HANDLE_ID)
													<span class="tag is-info">{{$ad->project->supportState->name}}</span>
												@elseif($ad->project->supportState->id ===\App\Models\SupportState::HANDLE_ID)
													<span class="tag is-success is-light">{{$ad->project->supportState->name}}</span>
												@elseif($ad->project->supportState->id === \App\Models\SupportState::PENDING_ID)
													<span class="tag is-info is-light">{{$ad->project->supportState->name}}</span>
												@elseif($ad->project->supportState->id === \App\Models\SupportState::ARCHIVE_ID)
													<span class="tag is-light ">{{$ad->project->supportState->name}}</span>
												@endif
											@else
												<span class="tag is-warning">Non définis</span>
											@endif
										@endif
									</td>

									<td>
										@if(! is_null($ad->project))
											@if(isset($ad->attributionAd->userAdvisor))
												<a href="{{route('ads.show', $ad->id)}}">
													<span><i class="fas fa-search"></i></span>
													<span>Voir le détail</span>
												</a>
											@else
												<a href="{{route('ads.show', $ad->id)}}">
													<span><i class="fas fa-hands-helping"></i></span>
													<span>Attribuer un primo-accueillant</span>
												</a>
											@endif
										@else
											<a href="{{route('ads.show', $ad->id)}}">
												<span><i class="fas fa-search"></i></span>
												<span>Voir le détail</span>
											</a>
										@endif
									</td>
								</tr>
								@endforeach
						</tbody>
					</table>
				</div>
				<div class="columns is-mobile is-centered">
					<div class="column is-half ">
						{{ $ads->appends(Request::all())->links() }}
					</div>
				</div>
			@endif
		</div>


	</div>

@endsection

@section('script')
	<script>
        const vueSupervisorFilters = new Vue({
            el: '#vue-form-supervisor',
            name: 'content'
        });

        const vueSupervisorExportForm = new Vue({
            el: '#supervisor-form-export-data',
            name: 'content'
        });

        let deleteButton = document.querySelector('#close-notification-supervisor');
        deleteButton.addEventListener('click', function (e) {
            let notification = document.querySelector('#notification-supervisor');
            notification.style.display = 'none';
        });
	</script>

@endsection
