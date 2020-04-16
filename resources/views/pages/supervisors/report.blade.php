@extends('default')

@section ('title', 'Rapports et indicateurs')

@section('main-content')

	<div class="section">
		<h1 class="title is-2 has-text-link">Rapports et indicateurs</h1>
	</div>
	@include('components.supervisor-tabs')

	<div class="columns is-mobile is-centered is-variable is-8 ">
		<div class="column is-2 ">
			<div class="box has-background-link">
				<p class="title has-text-white">{{$numberOfUsersPp}}</p>
				<p class="heading has-text-white">porteurs de projet</p>
			</div>
		</div>
		<div class="column is-2">
			<div class="box has-background-info">
				<p class="title has-text-white">{{$numberOfAds}}</p>
				<p class="heading has-text-white">annonces soumises à modération</p>
			</div>
		</div>
		<div class="column is-2 ">
			<div class="box has-background-success">
				<p class="title has-text-white">{{$numberOfValidateAds}}</p>
				<p class="heading has-text-white">annonce en ligne</p>
			</div>
		</div>
		<div class="column is-2 ">
			<div class="box has-background-primary">
				<p class="title has-text-white">{{$numberOfProjects}}</p>
				<p class="heading has-text-white">accompagnements de projet</p>
			</div>
		</div>
	</div>
	<br>
	<h3 class="title is-4 has-text-centered ">Répartition des annonces et projets par catégorie</h3>
	<div class="columns is-mobile is-centered">
		<div class="column is-half">
			<table class="table is-hoverable ">
				<thead>
				<tr>
					<th>Type</th>
					<th>Offres foncière</th>
					<th>Recherche foncière</th>
					<th>Offres emplois</th>
					<th>Recherches emplois</th>
					<th>Total</th>
				</tr>
				</thead>
				<tbody>
				<tr>
					<td>Annonces</td>
					<td>{{$numberOfAdsByCategories['landOfferAd']}}</td>
					<td>{{$numberOfAdsByCategories['landSeekAd']}}</td>
					<td>{{$numberOfAdsByCategories['jobOfferAd']}}</td>
					<td>{{$numberOfAdsByCategories['jobSeekAd']}}</td>
					<th>{{array_sum($numberOfAdsByCategories)}}</th>
				</tr>
				<tr>
					<td>Projets</td>
					<td>{{$numberOfProjectsByCategories['landOfferAd']}}</td>
					<td>{{$numberOfProjectsByCategories['landSeekAd']}}</td>
					<td>-</td>
					<td>-</td>
					<th>{{array_sum($numberOfProjectsByCategories)}}</th>
				</tr>
				</tbody>
			</table>
		</div>
	</div>
	<section class="section">
		<div class="columns is-mobile is-centered">
			<div class="column is-two-thirds">
				<div class="box">
					<h3 class="title is-4 has-text-centered ">Répartition des annonces par statut</h3>
					<nav class="level is-mobile">
						<div class="level-item has-text-centered">
							<div>
								<p class="title is-1 has-text-success ">{{$percentageOfAdsByAdStatus['Validée']}} %</p>
								<p class="heading has-text-success"> validées</p>
							</div>

						</div>
					</nav>
					<nav class="level is-mobile">
						<div class="level-item has-text-centered">
							<div>
								<p class="title has-text-primary">{{$percentageOfAdsByAdStatus['En attente']}} %</p>
								<p class="heading ">en attentes de modification </p>
							</div>
						</div>
						<div class="level-item has-text-centered ">
							<div>
								<p class="title has-text-warning">{{$percentageOfAdsByAdStatus['À modérer']}} %</p>
								<p class="heading h">en attente de modération</p>
							</div>
						</div>
						<div class="level-item has-text-centered ">
							<div>
								<p class="title has-text-danger">{{$percentageOfAdsByAdStatus['Refusée']}} %</p>
								<p class="heading ">refusées</p>
							</div>
						</div>
						<div class="level-item has-text-centered ">
							<div>
								<p class="title has-text-info">{{$percentageOfAdsByAdStatus['Archivée']}} % </p>
								<p class="heading ">archivées</p>
							</div>
						</div>
					</nav>
				</div>
			</div>
		</div>
		<br>
		<br>
		<div class="columns is-mobile is-centered">
			<div class="column is-two-thirds">
				<div class="column">
					<div class="box">
						<h3 class="title is-4 has-text-centered ">Répartition des projets par statut</h3>
						<nav class="level is-mobile">
							<div class="level-item has-text-centered">
								<div>
									<p class="title is-1 has-text-success ">{{$percentageOfProjectsByProjectStatus['Installé']}}
										%</p>
									<p class="heading has-text-success"> installé</p>
								</div>
							</div>
						</nav>
						<nav class="level is-mobile">
							<div class="level-item has-text-centered">
								<div>
									<p class="title has-text-primary">{{$percentageOfProjectsByProjectStatus['Installé']}}
										%</p>
									<p class="heading ">accompagné </p>
								</div>
							</div>
							<div class="level-item has-text-centered ">
								<div>
									<p class="title has-text-warning">{{$percentageOfProjectsByProjectStatus['Accompagné']}}
										%</p>
									<p class="heading ">a rappeler</p>
								</div>
							</div>
							<div class="level-item has-text-centered ">
								<div>
									<p class="title has-text-danger">{{$percentageOfProjectsByProjectStatus['Non accompagné']}}
										%</p>
									<p class="heading ">non accompagné</p>
								</div>
							</div>
							<div class="level-item has-text-centered ">
								<div>
									<p class="title has-text-grey">{{$percentageOfProjectsByProjectStatus['En recherche']}}
										% </p>
									<p class="heading ">en recherche</p>
								</div>
							</div>
							<div class="level-item has-text-centered ">
								<div>
									<p class="title has-text-link">{{$percentageOfProjectsByProjectStatus['Idée']}}
										% </p>
									<p class="heading ">idée</p>
								</div>
							</div>
							<div class="level-item has-text-centered ">
								<div>
									<p class="title has-text-info">{{$percentageOfProjectsByProjectStatus['Archivée']}}
										% </p>
									<p class="heading ">archivée</p>
								</div>
							</div>
						</nav>
					</div>
				</div>
			</div>
		</div>
	</section>



@endsection