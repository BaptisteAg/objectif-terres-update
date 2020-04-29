@extends ('default')

@section ('title', 'Mon espace primo-accueillant')

@section('main-content')

	<div class="section">
		<h1 class="title is-2 has-text-link">Bienvenue sur votre espace primo-accueillant <span
					class="is-italic">{{ Auth::user()->first_name }} {{ Auth::user()->name }}</span></h1>

		@include('components.advisor-tabs')

		@if($numberOfNewProject !== 0 || $numberOfUnreadMessages !==0)
			<div id="notification-advisor" class="notification has-background-info">
				<button id="close-notification-advisor" class="delete"></button>
				@if($numberOfNewProject> 1)
					<p class="has-text-white-ter">
						<i class="far fa-bell has-text-white-ter"></i>
						Vous avez<a style="text-decoration: none"
									href="/">
							<strong>{{$numberOfNewProject}}
								nouvelles demandes d'accompagnement</strong></a> !
					</p>
				@elseif ($numberOfNewProject === 1)
					<p class="has-text-white-ter">
						<i class="far fa-bell has-text-white-ter"></i>
						Vous avez<a style="text-decoration: none"
									href="/">
							<strong>{{$numberOfNewProject}}
								nouvelle demande d'accompagnement </strong></a>!
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
		{{Form::open(['route'=>'advisor.show', 'method'=>'get'])}}
		<div id="vue-form-advisor">
			@include('components.dashboard-filters')
			<div class="columns  ">
				<div class="column is-1  ">
					<button class="button is-medium is-link is-rounded">
						 <span class="icon">
						  <i class="fas fa-table"></i>
						</span>
						<span>Exporter</span>
					</button>
				</div>
				<div class="column is-1">
					<a href="{{route('advisor.createNewPp')}}" class="button is-medium is-light is-rounded ">
						<span class="icon">
							<i class="fas fa-user-plus"></i>
						</span>
						<span>Ajouter un PP</span>
					</a>
				</div>
			</div>
		</div>
		{{Form::close()}}

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
									<a href="{{ route('advisor.show', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'date'])) }}">
										<span>Date</span>
									</a>
								@elseif(request()->input('sort') === 'date' && request()->input('order') === 'desc')
									<a href="{{ route('advisor.show', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'date'])) }}">
										<i class="fas fa-arrow-down"></i>
										<span>Date</span>
									</a>
								@else
									<a href="{{ route('advisor.show', array_merge(Request::all(), ['order'=>'', 'sort'=>''])) }}) }}">
										<i class="fas fa-arrow-up"></i>
										<span>Date</span>
									</a>
								@endif
							</th>
							<th>
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
									<a href="{{ route('advisor.show', array_merge(Request::all(), ['order'=>'', 'sort'=>''])) }}) }}">
										<i class="fas fa-arrow-down"></i>
										<span>Titre</span>
									</a>
								@endif

							</th>
							<th>Catégorie</th>
							<th>
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
									<a href="{{ route('advisor.show', array_merge(Request::all(), ['order'=>'', 'sort'=>''])) }}) }}">
										<i class="fas fa-arrow-down"></i>
										<span>Nom du porteur de projet</span>
									</a>
								@endif
							</th>
							<th>Adresse mail</th>
							<th>Localisation(s)</th>
							<th>
								@if(request()->input('sort') !== 'project_statuses.name')
									<a href="{{ route('advisor.show', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'project_statuses.name'])) }}">
										<span>Statut du projet</span>
									</a>
								@elseif(request()->input('sort') === 'project_statuses.name' && request()->input('order') === 'asc')
									<a href="{{ route('advisor.show', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'project_statuses.name'])) }}">
										<i class="fas fa-arrow-up"></i>
										<span>Statut du projet</span>
									</a>
								@else
									<a href="{{ route('advisor.show', array_merge(Request::all(), ['order'=>'', 'sort'=>''])) }}) }}">
										<i class="fas fa-arrow-down"></i>
										<span>Statut du projet</span>
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
									@if($ad->project()->exists())
										{{$ad->project->created_at->format("d/m/Y")}}
									@else
										{{$ad->attributionAd->created_at->format("d/m/Y")}}
									@endif
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
										@if($ad->project->projectStatus->name === "Accompagné")
											<span class="tag is-success is-light">{{$ad->project->projectStatus->name}}</span>
										@elseif($ad->project->projectStatus->name ==="Installé")
											<span class="tag is-success">{{$ad->project->projectStatus->name}}</span>
										@elseif($ad->project->projectStatus->name === "A rappeler")
											<span class="tag is-danger is-light">{{$ad->project->projectStatus->name}}</span>
										@elseif($ad->project->projectStatus->name === "Non assigné")
											<span class="tag is-warning ">{{$ad->project->projectStatus->name}}</span>
										@elseif($ad->project->projectStatus->name === "Idée")
											<span class="tag is-primary ">{{$ad->project->projectStatus->name}}</span>
										@elseif($ad->project->projectStatus->name === "Archivée")
											<span class="tag is-info is-light">{{$ad->project->projectStatus->name}}</span>
										@else
											<span class="tag is-info">{{$ad->project->projectStatus->name}}</span>
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
        const vueAdvisor = new Vue({
            el: '#vue-form-advisor',
            name: 'content'
        });

        let buttons = document.querySelectorAll('.form-research-buttons');
        let icons = document.querySelectorAll('.form-research-buttons-icons');

        let deleteButton = document.querySelector('#close-notification-advisor');
        deleteButton.addEventListener('click', function (e) {
            let notification = document.querySelector('#notification-advisor');
            notification.style.display = 'none';
        });
	</script>

@endsection
