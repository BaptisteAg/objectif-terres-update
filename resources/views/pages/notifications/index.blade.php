@extends ('default')

@section ('title', 'Mes notifications')

@section('main-content')
	<div class="section">
		<h1 class="title is-2 has-text-link">Vos notifications</h1>

		@if(! $user->readNotifications->isEmpty())
			@foreach ($user->readNotifications as $notification)
				@if(isset($notification->data['number_of_ads_to_moderate']))
					<article class="message is-link ">
						<div class="message-body">
							@if($notification->data['number_of_ads_to_moderate'] <=1)
								Vous avez {{$notification->data['number_of_ads_to_moderate']}} annonce soumise depuis
								plus de 7 jours  à modérer !
							@else
								Vous avez {{$notification->data['number_of_ads_to_moderate']}} annonces soumises depuis
								plus de 7 jours à modérer !
							@endif
							<br>
							<br>
							<a href="{{route ('moderator.index')}}">
								<button class="button is-link ">Consulter votre tableau de bord</button>
							</a>
						</div>
					</article>
				@else
					<div class="container">
						<p class="is-size-5">Vous n'avez pas de nouvelle notification !</p>
					</div>
				@endif
			@endforeach
		@elseif ($user->unreadNotifications->isEmpty())
			<div class="container">
				<p class="is-size-5">Vous n'avez pas de nouvelle notification !</p>
			</div>
		@else
			@foreach ($user->unreadNotifications as $notification)
				@if(isset($notification->data['number_of_ads_to_moderate']))
					<article class="message is-info">
						<div class="message-header">
							<p>Des annonces sont en attente de modération ! </p>
						</div>
						<div class="message-body">
							@if($notification->data['number_of_ads_to_moderate'] <=1)
								Vous avez {{$notification->data['number_of_ads_to_moderate']}} annonce soumise depuis
								plus de 7 jours  à modérer !
							@else
								Vous avez {{$notification->data['number_of_ads_to_moderate']}} annonces soumises depuis
								plus de 7 jours à modérer !
							@endif
							<form action="{{route('notification.update', $notification->id)}}" method="POST">
								@csrf
								@method('PATCH')
								<input type="hidden" value="moderator.index" name="route">
								<br>
								<input type="submit" class="button is-link "
									   value="@lang('Consulter votre tableau de bord')">
							</form>
						</div>
					</article>
				@else
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
								<input type="hidden" value="ads.show" name="route">
								<br>
								<input type="submit" class="button is-link " value="@lang('Modérer l\'annonce')">
							</form>
						</div>
					</article>
				@endif
			@endforeach
		@endif
	</div>

@endsection