@extends('default')
@section('title', 'Page inaccessible')
@section('main-content')
	<section class="section">
		<h3 class="title is-3 has-text-centered">Désolé mais la page que vous souhaitez consulter n'est plus disponible</h3>
		<p class="has-text-centered">{{$message}}</p>
		<br>
		<div class=" has-text-centered">
			<a class="button is-medium basic primary  " href="{{route('home')}}">Retour à la page d'accueil</a>
		</div>
	</section>
@endsection