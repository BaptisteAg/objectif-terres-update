@extends('default')

@section ('title', 'Cette annonce a été suprimée')

@section('main-content')
	<div class="section pt-0">
		<div class="container">
			<div class="columns is-mobile is-centered">
				<div class="column is-two-thirds">
					<h1 style="text-align:center;font-weight:bold;font-size:30px;">Erreur</h1>
					<p class="has-text-centered">
						L'annonce <em>{{$ad->title ?? ""}}</em> n'est plus disponible.<br>
						Raison:

						@if($ad->trashed())
							Annonce supprimée
						@else
							Annonceur supprimé
						@endif
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