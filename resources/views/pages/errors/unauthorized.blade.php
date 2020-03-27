@extends('default')
@section('title', 'Erreur authorisation')
@section('main-content')
	<section class="section">
		<h3 class="title is-3 has-text-centered">Désolé mais vous ne possédez pas les autorisations nécessaires pour
			consulter cette page.</h3>
		<p class="has-text-centered">Seul les {{$role}} peuvent accéder à cette page.</p>
		<br>
		<div class=" has-text-centered">
			<a class="button is-medium is-link " href="{{route('home')}}">Retour à la page d'accueil</a>
		</div>
	</section>
@endsection