@extends ('default')

@section ('title', 'Mon compte')

@section('main-content')


	<div class="section">
		<div class="container">
			<div class="columns is-mobile is-centered">
				<div class="column is-two-thirds">
					<h1 class="title is-2 has-text-centered has-text-link">Bienvenue sur votre espace <span
								class="is-italic">{{ Auth::user()->first_name }} {{ Auth::user()->name }}</span></h1>
					<h2 class="subtitle has-text-centered">Retrouvez tous les services d'Objectif Terres dans votre
						espace personnel </h2>
					<br>
					<br>
				</div>
			</div>
		</div>

		@include('layouts.partials.users-tabs')


	</div>

	@include('components.partnering')
	@include('components.support-terre-liens')
@endsection
