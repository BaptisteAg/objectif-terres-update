@extends ('default')

@section ('title', 'Mon espace primo-accueillant')

@section('main-content')

	<div class="section">
		<h1 class="title is-2 has-text-link">Bienvenue sur votre espace primo-accueillant <span
					class="is-italic">{{ Auth::user()->first_name }} {{ Auth::user()->name }}</span></h1>

		@include('components.advisor-tabs')

		<div class="notification has-background-info">
			<button class="delete"></button>
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

		{{Form::open(['route'=>'advisors.index', 'method'=>'get'])}}
		<div id="vue-form-advisor">
			@include('components.dashboard-filters')
		</div>
		{{Form::close()}}
		<div class="section">
			<h1 class="title is-1 has-text-centered">Liste des annonces dans votre territoire</h1>
			@if (count($attributionAds) ==0)
				<p class="has-text-centered">Il n'y a pas d'annonces dans votre territoire.</p>
			@else
				<div class="table-container">
					<table class="table is-striped is-hoverable is-fullwidth ">
						<thead>
						<tr>
							<th>
								@if(request()->input('sort') !== 'date')
									<a href="{{ route('moderator.show', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'date'])) }}">
										<span>Date de publication</span>
									</a>
								@elseif(request()->input('sort') === 'date' && request()->input('order') === 'desc')
									<a href="{{ route('moderator.show', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'date'])) }}">
										<i class="fas fa-arrow-down"></i>
										<span>Date de publication</span>
									</a>
								@else
									<a href="{{ route('moderator.show') }}">
										<i class="fas fa-arrow-up"></i>
										<span>Date de publication</span>
									</a>
								@endif
							</th>
							<th>
								@if(request()->input('sort') !== 'title')
									<a href="{{ route('moderator.show', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'title'])) }}">
										<span>Titre de l'annonce</span>
									</a>
								@elseif(request()->input('sort') === 'title' && request()->input('order') === 'asc')
									<a href="{{ route('moderator.show', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'title'])) }}">
										<i class="fas fa-arrow-up"></i>
										<span>Titre de l'annonce</span>
									</a>
								@else
									<a href="{{ route('moderator.show') }}">
										<i class="fas fa-arrow-down"></i>
										<span>Titre de l'annonce</span>
									</a>
								@endif

							</th>
							<th>Type d'annonce</th>
							<th>
								@if(request()->input('sort') !== 'name')
									<a href="{{ route('moderator.show', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'name'])) }}">
										<span>Nom du porteur de projet</span>
									</a>
								@elseif(request()->input('sort') === 'name' && request()->input('order') === 'asc')
									<a href="{{ route('moderator.show', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'name'])) }}">
										<i class="fas fa-arrow-up"></i>
										<span>Nom du porteur de projet</span>
									</a>
								@else
									<a href="{{ route('moderator.show') }}">
										<i class="fas fa-arrow-down"></i>
										<span>Nom du porteur de projet</span>
									</a>
								@endif
							</th>
							<th>Adresse mail</th>
							<th>Localisation(s)</th>
							<th>
								@if(request()->input('sort') !== 'project_statuses.name')
									<a href="{{ route('moderator.show', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'project_statuses.name'])) }}">
										<span>Statut du projet</span>
									</a>
								@elseif(request()->input('sort') === 'project_statuses.name' && request()->input('order') === 'asc')
									<a href="{{ route('moderator.show', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'project_statuses.name'])) }}">
										<i class="fas fa-arrow-up"></i>
										<span>Statut du projet</span>
									</a>
								@else
									<a href="{{ route('moderator.show') }}">
										<i class="fas fa-arrow-down"></i>
										<span>Statut du projet</span>
									</a>
								@endif
							</th>
							<th></th>
						</tr>
						</thead>
						<tbody>
						@foreach($attributionAds as $attributionAd)
							<tr>
								<td>{{$attributionAd->ad->created_at}}</td>
								<td>
									<a href="{{route('ads.show', $attributionAd->ad->id)}}">{{$attributionAd->ad->title}}</a>
								</td>
								<td>{{$attributionAd->ad->ad_type_full_name}}</td>
								<td>
									<a href="{{route('user.show', $attributionAd->ad->userPp->id)}}">{{$attributionAd->ad->userPp->first_name}} {{$attributionAd->ad->userPp->name}}</a>
								</td>
								<td>{{$attributionAd->ad->userPp->email}}</td>
								<td>
									@if(! is_null($attributionAd->ad->regionsList))
										<p>Region(s) : {{$attributionAd->ad->regionsList}}</p>
									@endif
									@if(! is_null($attributionAd->ad->departmentList))
										<p>Département(s) : {{$attributionAd->ad->departmentsList}}</p>
									@endif
									@if(! is_null($attributionAd->ad->citiesList))
										<p>Communes(s) : {{$attributionAd->ad->citiesList}}</p>
									@endif
								</td>
								<td>
									@if(is_null($attributionAd->ad->project))
										<span class="tag is-light">L'annonce n'a pas le statut de projet</span>
									@else
										@if($attributionAd->ad->project->projectStatus->name === "Accompagné")
											<span class="tag is-success is-light">{{$attributionAd->ad->project->projectStatus->name}}</span>
										@elseif($attributionAd->ad->project->projectStatus->name ==="Installé")
											<span class="tag is-success is-light">{{$attributionAd->ad->project->projectStatus->name}}</span>
										@elseif($attributionAd->ad->project->projectStatus->name === "A rappeler")
											<span class="tag is-danger is-light">{{$attributionAd->ad->project->projectStatus->name}}</span>

										@elseif($attributionAd->ad->project->projectStatus->name === "Non accompagné")
											<span class="tag is-warning is-light">{{$attributionAd->ad->project->projectStatus->name}}</span>
										@else
											<span class="tag is-info is-light">{{$attributionAd->ad->project->projectStatus->name}}</span>
										@endif
									@endif
								</td>
								<td><a href="{{route('ads.show', $attributionAd->ad->id)}}"><span><i
													class="fas fa-search"></i></span> <span>Voir le détail</span></a>
								</td>
							</tr>
						@endforeach
						</tbody>
					</table>
				</div>
				<div class="columns is-mobile is-centered">
					<div class="column is-half ">
						{{ $attributionAds->appends(Request::all())->links() }}
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
	</script>

@endsection
