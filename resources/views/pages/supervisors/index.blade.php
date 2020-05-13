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
									<a v-on:click="closeModal()" id="close-modal" class="modal-close is-large"
									   aria-label="close"></a>
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
					<table class="table is-striped is-hoverable is-fullwidth ">
						<thead>
						<tr>
							<th>Type</th>
							<th>
								@if(request()->input('sort') !== 'date')
									<a href="{{ route('supervisor.show', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'date'])) }}">
										<span>Date</span>
									</a>
								@elseif(request()->input('sort') === 'date' && request()->input('order') === 'desc')
									<a href="{{ route('supervisor.show', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'date'])) }}">
										<i class="fas fa-arrow-down"></i>
										<span>Date</span>
									</a>
								@else
									<a href="{{ route('supervisor.show', array_diff_key(Request::all(), ['order'=>'', 'sort'=>''])) }}">
										<i class="fas fa-arrow-up"></i>
										<span>Date</span>
									</a>
								@endif
							</th>
							<th>
								@if(request()->input('sort') !== 'title')
									<a href="{{ route('supervisor.show', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'title'])) }}">
										<span>Titre</span>
									</a>
								@elseif(request()->input('sort') === 'title' && request()->input('order') === 'asc')
									<a href="{{ route('supervisor.show', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'title'])) }}">
										<i class="fas fa-arrow-up"></i>
										<span>Titre</span>
									</a>
								@else
									<a href="{{ route('supervisor.show', array_diff_key(Request::all(), ['order'=>'', 'sort'=>''])) }}">
										<i class="fas fa-arrow-down"></i>
										<span>Titre</span>
									</a>
								@endif

							</th>
							<th>Catégorie</th>
							<th>
								@if(request()->input('sort') !== 'name')
									<a href="{{ route('supervisor.show', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'name'])) }}">
										<span>Nom du porteur de projet</span>
									</a>
								@elseif(request()->input('sort') === 'name' && request()->input('order') === 'asc')
									<a href="{{ route('supervisor.show', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'name'])) }}">
										<i class="fas fa-arrow-up"></i>
										<span>Nom du porteur de projet</span>
									</a>
								@else
									<a href="{{ route('supervisor.show', array_diff_key(Request::all(), ['order'=>'', 'sort'=>''])) }}">
										<i class="fas fa-arrow-down"></i>
										<span>Nom du porteur de projet</span>
									</a>
								@endif
							</th>
							<th>Adresse mail</th>
							<th>Localisation(s)</th>
							<th>
								@if(request()->input('sort') !== 'project_statuses.name')
									<a href="{{ route('supervisor.show', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'project_statuses.name'])) }}">
										<span>Avancement projet</span>
									</a>
								@elseif(request()->input('sort') === 'project_statuses.name' && request()->input('order') === 'asc')
									<a href="{{ route('supervisor.show', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'project_statuses.name'])) }}">
										<i class="fas fa-arrow-up"></i>
										<span>Avancement projet</span>
									</a>
								@else
									<a href="{{ route('supervisor.show', array_diff_key(Request::all(), ['order'=>'', 'sort'=>''])) }}">
										<i class="fas fa-arrow-down"></i>
										<span>Avancement projet</span>
									</a>
								@endif
							</th>
							<th></th>
						</tr>
						</thead>
						<tbody>
						@foreach($ads as $ad)
							<tr>
								<td>
									@if($ad->project()->exists())
										<span class="tag is-link">Demande d'accompagnement</span>
									@else
										<span class="tag is-link is-light">Annonce</span>
									@endif
								</td>
								<td>
										{{$ad->attributionAd->created_at->format("d/m/Y")}}
								</td>
								<td>
									<a href="{{route('ads.show', $ad->id)}}">{{$ad->title}}</a>
								</td>
								<td>{{$ad->ad_type_full_name}}</td>
								<td>
									<a href="{{route('user.show', $ad->userPp->id)}}">{{$ad->userPp->first_name}} {{$ad->userPp->name}}</a>
								</td>
								<td>{{$ad->userPp->email}}</td>
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
								<td>
									@if(is_null($ad->project))
									@else
										@if($ad->project->projectStatus->id === \App\Models\ProjectStatus::EMERGING_ID)
											<span class="tag is-info">{{$ad->project->projectStatus->name}}</span>
										@elseif($ad->project->projectStatus->id ===\App\Models\ProjectStatus::IN_PROGRESSING_ID)
											<span class="tag is-info is-light">{{$ad->project->projectStatus->name}}</span>
										@elseif($ad->project->projectStatus->id === \App\Models\ProjectStatus::ABANDONED_ID)
											<span class="tag is-danger is-light">{{$ad->project->projectStatus->name}}</span>
										@elseif($ad->project->projectStatus->id === \App\Models\ProjectStatus::ACCOMPLISHED_ID)
											<span class="tag is-success ">{{$ad->project->projectStatus->name}}</span>
										@else
											<span class="tag is-warning">Pas de statut définis</span>
										@endif
									@endif
								</td>
								<td><a href="{{route('ads.show', $ad->id)}}"><span><i
													class="fas fa-search"></i></span> <span>Voir le détail</span></a>
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
