@extends('default')

@section('title', 'Administration des indicateurs | Objectifs Terres')


@section('main-content')
	<div class="section">
		<h1 class="title is-2 has-text-link">Administration des indicateurs </h1>
		@include('components.supervisor-tabs')

		<section class="section">
			<div class="columns is-mobile is-centered">
				<div class="column is-half">
					{{Form::open(['route'=>'supervisor.projectDataKeysUpdate', 'method'=>'post'])}}
					<button type="submit" disabled style="display: none" aria-hidden="true"></button>
					<div class="content">
						<h3 class="title is-3 has-text-centered">Liste des indicateurs</h3>
						@if (!empty($allProjectDataKeys))
							<div class="field is-grouped is-grouped-multiline">
								@foreach($allProjectDataKeys as $projectDataKey)
									<div class="control">
										<div class="tags has-addons">
											<span class="tag is-medium is-light">{{$projectDataKey->name}}</span>
											<a class="tag is-medium ">
												<button value="{{$projectDataKey->id}}" name="project_data_key_id"
														class="button is-text is-small ">
													<span class="icon">
													  <i class="fas fa-trash-alt"></i>
													</span>
												</button>
											</a>
										</div>
									</div>
								@endforeach
							</div>
						@else
							<p>Il y a aucun indicateur disponible</p>
						@endif
					</div>
					<br>
					<div class="content">
						<h5 class="title is-5 has-text-centered">Ajout d'un nouvel indicateur</h5>
						<p class="">Remplissez le champ suivant pour ajouter un indicateur</p>
						<div class="field">
							<label class="label">Titre du nouvel indicateur</label>
							<div class="control">
								<input name="project_data_key_name" class="input" type="text"
									   placeholder="Saisir le titre de l'indicateur">
							</div>
						</div>
						<div class="field">
							<p class="control">
								<button type="submit" class="button is-success ">
									Ajouter
								</button>
							</p>
						</div>
					</div>
					{{Form::close()}}
				</div>
			</div>
		</section>
	</div>
@endsection
