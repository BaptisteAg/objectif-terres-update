@extends ('default')

@section ('title', 'Mes notifications')

@section('main-content')
	<div class="section">
		<h1 class="title is-2 has-text-link">Vos notifications</h1>

		@if ($user->unreadNotifications->isEmpty())
			<div class="container">
				<p class="is-size-5">Vous n'avez pas de nouvelle notification !</p>
			</div>
		@else
			@foreach ($user->unreadNotifications as $notification)
				<article class="message is-info">
					<div class="message-header">
						<p>Nouvelle demande de modération</p>
					</div>
					<div class="message-body">
						Une nouvelle annonce vient d'être soumise par
						<a href="{{route('user.show', $notification->data['user_pp_id'])}}">{{$notification->data['user_pp_first_name']}} {{$notification->data['user_pp_name']}}</a>.

						<form action="{{route('notification.update', $notification->id)}}" method="POST">
							@csrf
							@method('PATCH')
							<br>
							<input type="submit" class="button is-link " value="@lang('Modérer l\'annonce')">
						</form>
					</div>
				</article>
			@endforeach
		@endif
	</div>

@endsection