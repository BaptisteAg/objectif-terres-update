@extends('default')

@section ('title', 'Cette annonce a été suprimée')

@section('main-content')
	<div class="section pt-0">
		<div class="container">
			<div class="columns is-mobile is-centered">
				<div class="column is-two-thirds">
					<h1 class="page__title">Erreur</h1>
					<h2 class="page__subtitle">
						Annonce supprimée par l'utilsateur
					</h2>
					<p class="has-text-centered">
						L'annonce <em>{{$ad->title ?? ""}}</em> a été supprimée le {{$ad->deleted_at->format('d/m/Y')}}.
					</p>
					<br>
					<br>
					<div class=" has-text-centered">
						<a class="button is-medium basic primary  " href="{{route('home')}}">Page
							d'accueil</a>
					</div>
				</div>
			</div>
		</div>
@endsection