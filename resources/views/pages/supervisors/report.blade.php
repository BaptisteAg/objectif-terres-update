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
	<section class="section">
		<div class="columns is-mobile is-centered">
			<div class="column is-half">
			</div>
			<div class="column"></div>
		</div>

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
						<td>{{$adsSortByCategories['landOfferAd']}}</td>
						<td>{{$adsSortByCategories['landSeekAd']}}</td>
						<td>{{$adsSortByCategories['jobOfferAd']}}</td>
						<td>{{$adsSortByCategories['jobSeekAd']}}</td>
						<th>{{array_sum($adsSortByCategories)}}</th>
					</tr>
					<tr>
						<td>Projets</td>
						<td>{{$projectsSortByCategories['landOfferAd']}}</td>
						<td>{{$projectsSortByCategories['landSeekAd']}}</td>
						<td>-</td>
						<td>-</td>
						<th>{{array_sum($projectsSortByCategories)}}</th>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
	</section>
@endsection