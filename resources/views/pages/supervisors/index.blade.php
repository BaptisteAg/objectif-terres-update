@extends('default')

@section ('title', 'Mon espace responsable territorial')

@section('main-content')

	<div class="section">
		<h1 class="title is-2 has-text-link">Bienvenue sur votre espace responsable territorial <span
					class="is-italic">{{ Auth::user()->first_name }} {{ Auth::user()->name }}</span></h1>

		@include('components.supervisor-tabs')

		<div id="notification-supervisor" class="notification has-background-info">
			<button id="close-notification-supervisor" class="delete"></button>
			<p class="has-text-white-ter">
				<i class="far fa-bell has-text-white-ter"></i>
				Vous avez<a style="text-decoration: none"
							href="/">
					<strong>5
						nouveaux porteurs de projets</strong></a> dans votre territoire !</p>
			@if($numberOfUnreadMessages > 1 )
				<a style="text-decoration: none" href="{{route('threads.index')}}"><p class="has-text-white"><i
								class="fas fa-envelope "></i> Vous
						avez <strong>{{$numberOfUnreadMessages}}
							nouveaux messages
							!</strong></p></a>

			@else
				<a style="text-decoration: none" href="{{route('threads.index')}}">
					<p class="has-text-white"><i class="fas fa-envelope"></i> Vous avez
						<strong>{{$numberOfUnreadMessages}} nouveau message !</strong>
					</p>
				</a>
			@endif
		</div>

		{{Form::open(['route'=>'supervisor.show', 'method'=>'get'])}}
		<div id="vue-form-supervisor">
			@include('components.dashboard-filters')
		</div>
		{{Form::close()}}

		<div class="section">
			<h1 class="title is-1 has-text-centered">Liste des demandes d'accompagnement dans votre territoire</h1>
			@if (count($projectAds) ==0)
				<p class="has-text-centered">Aucun résultat</p>
			@else
				<div class="table-container">
					<table class="table is-striped is-hoverable is-fullwidth ">
						<thead>
						<tr>
							<th>
								@if(request()->input('sort') !== 'date')
									<a href="{{ route('supervisor.show', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'date'])) }}">
										<span>Date de demande</span>
									</a>
								@elseif(request()->input('sort') === 'date' && request()->input('order') === 'desc')
									<a href="{{ route('supervisor.show', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'date'])) }}">
										<i class="fas fa-arrow-down"></i>
										<span>Date de demande</span>
									</a>
								@else
									<a href="{{ route('supervisor.show', array_merge(Request::all(), ['order'=>'', 'sort'=>''])) }}) }}">
										<i class="fas fa-arrow-up"></i>
										<span>Date de demande</span>
									</a>
								@endif
							</th>
							<th>
								@if(request()->input('sort') !== 'title')
									<a href="{{ route('supervisor.show', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'title'])) }}">
										<span>Titre de la demande</span>
									</a>
								@elseif(request()->input('sort') === 'title' && request()->input('order') === 'asc')
									<a href="{{ route('supervisor.show', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'title'])) }}">
										<i class="fas fa-arrow-up"></i>
										<span>Titre de la demande</span>
									</a>
								@else
									<a href="{{ route('supervisor.show', array_merge(Request::all(), ['order'=>'', 'sort'=>''])) }}) }}">
										<i class="fas fa-arrow-down"></i>
										<span>Titre de la demande</span>
									</a>
								@endif

							</th>
							<th>Type de demande</th>
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
									<a href="{{ route('supervisor.show', array_merge(Request::all(), ['order'=>'', 'sort'=>''])) }}) }}">
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
										<span>Statut du projet</span>
									</a>
								@elseif(request()->input('sort') === 'project_statuses.name' && request()->input('order') === 'asc')
									<a href="{{ route('supervisor.show', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'project_statuses.name'])) }}">
										<i class="fas fa-arrow-up"></i>
										<span>Statut du projet</span>
									</a>
								@else
									<a href="{{ route('supervisor.show', array_merge(Request::all(), ['order'=>'', 'sort'=>''])) }}) }}">
										<i class="fas fa-arrow-down"></i>
										<span>Statut du projet</span>
									</a>
								@endif
							</th>
							<th></th>
						</tr>
						</thead>
						<tbody>
						@foreach($projectAds as $projectAd)
							<tr>
								<td>{{$projectAd->created_at->format("d/m/Y")}}</td>
								<td>
									<a href="{{route('ads.show', $projectAd->ad->id)}}">{{$projectAd->ad->title}}</a>
								</td>
								<td>{{$projectAd->ad->ad_type_full_name}}</td>
								<td>
									<a href="{{route('user.show', $projectAd->ad->userPp->id)}}">{{$projectAd->ad->userPp->first_name}} {{$projectAd->ad->userPp->name}}</a>
								</td>
								<td>{{$projectAd->ad->userPp->email}}</td>
								<td>
									@if(! is_null($projectAd->ad->regionsList))
										<p>Region(s) : {{$projectAd->ad->regionsList}}</p>
									@endif
									@if(! is_null($projectAd->ad->departmentList))
										<p>Département(s) : {{$projectAd->ad->departmentsList}}</p>
									@endif
									@if(! is_null($projectAd->ad->citiesList))
										<p>Communes(s) : {{$projectAd->ad->citiesList}}</p>
									@endif
								</td>
								<td>
									@if(is_null($projectAd->ad->project))
										<span class="tag is-light">L'annonce n'a pas le statut de projet</span>
									@else
										@if($projectAd->projectStatus->name === "Accompagné")
											<span class="tag is-success is-light">{{$projectAd->projectStatus->name}}</span>
										@elseif($projectAd->projectStatus->name ==="Installé")
											<span class="tag is-success is-light">{{$projectAd->projectStatus->name}}</span>
										@elseif($projectAd->projectStatus->name === "A rappeler")
											<span class="tag is-danger is-light">{{$projectAd->projectStatus->name}}</span>

										@elseif($projectAd->projectStatus->name === "Non accompagné")
											<span class="tag is-warning is-light">{{$projectAd->projectStatus->name}}</span>
										@else
											<span class="tag is-info is-light">{{$projectAd->projectStatus->name}}</span>
										@endif
									@endif
								</td>
								<td><a href="{{route('ads.show', $projectAd->ad->id)}}"><span><i
													class="fas fa-search"></i></span> <span>Voir le détail</span></a>
								</td>
							</tr>
						@endforeach
						</tbody>
					</table>
				</div>
				<div class="columns is-mobile is-centered">
					<div class="column is-half ">
						{{ $projectAds->appends(Request::all())->links() }}
					</div>
				</div>
			@endif
		</div>


	</div>

@endsection

@section('script')

	<script>
        const vueSupervisor = new Vue({
            el: '#vue-form-supervisor',
            name: 'content'
        });

        let buttons = document.querySelectorAll('.form-research-buttons');
        let icons = document.querySelectorAll('.form-research-buttons-icons')

        buttons.forEach(function (btn) {
            btn.addEventListener('click', () => {
                buttons.forEach(function (b) {
                    b.classList.add('is-light');
                    b.firstElementChild.classList.add('is-hidden')
                });
                btn.classList.remove('is-light');
                btn.firstElementChild.classList.remove('is-hidden')
            });

        });

        let deleteButton = document.querySelector('#close-notification-supervisor');
        deleteButton.addEventListener('click', function (e) {
            let notification = document.querySelector('#notification-supervisor');
            notification.style.display = 'none';
        })
	</script>

@endsection
