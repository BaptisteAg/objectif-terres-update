@extends('default')

@section ('title', 'Rapports et indicateurs')


@section('header')
	@include('components.supervisor-tabs')
@endsection

@section('main-content')

	<div class="section">
		<h1 class="title is-2 has-text-link">Rapports et indicateurs</h1>
	</div>
	@if ($numberOfAds == 0 and $numberOfProjects == 0 )

		<div class="columns is-mobile is-centered">
			<div class="column is-half">
				<p class="has-text-centered">Il n'y a pas d'annonces ou de demande d'accompagnement sur votre
					territoire.</p>
			</div>
		</div>
	@else
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
					<p class="heading has-text-white">accompagnement</p>
				</div>
			</div>
		</div>
		<br>
		<h3 class="title is-4 has-text-centered ">Répartition des annonces et accompagnement par catégorie</h3>
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

						<td>Accompagnement</td>
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
	@endif


@endsection