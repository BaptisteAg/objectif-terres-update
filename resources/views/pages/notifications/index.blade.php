@extends ('default')

@section ('title', 'Mes notifications')

@section('main-content')
	<div class="section pt-0">
		<h1 class="page__title">Vos notifications</h1>
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
							<a href="{{route ('moderator.show', ['ad_statuses[0]=4&order=asc&sort=date'])}}">
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
				@if($notification->type == \App\Notifications\OverdueModerationNotification::class)
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
								<input type="hidden" value="moderator.show" name="route">
								<br>
								<input type="submit" class="button is-link "
									   value="@lang('Consulter votre tableau de bord')">
							</form>
						</div>
					</article>
				@elseif($notification->type == \App\Notifications\NewSupportRequestNotification::class)
					<article class="message is-info">
						<div class="message-header">
							<p>Nouvelle demande d'accompagnement</p>
						</div>
						<div class="message-body">
							Une nouvelle demande d'accompagnement  vient d'être créée par
							<a href="{{route('user.show', $notification->data['user_pp_id'])}}">{{$notification->data['user_pp_first_name']}} {{$notification->data['user_pp_name']}}</a>.

							<form action="{{route('notification.update', $notification->id)}}" method="POST">
								@csrf
								@method('PATCH')
								<input type="hidden" value="ads.show" name="route">
								<br>
								<input type="submit" class="button is-link " value="@lang('Voir le détail du projet')">
							</form>
						</div>
					</article>
				@elseif ($notification->type == \App\Notifications\NewAdToModerateNotification::class)
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
								<input type="submit" class="is-link" value="@lang('Modérer l\'annonce')">
							</form>
						</div>
					</article>
				@elseif ($notification->type == \App\Notifications\SupportRequestAttributionNotification::class)
					<article class="message is-info">
						<div class="message-header">
							<p>Nouvelle attribution d'une demande d'accompagnement</p>
						</div>
						<div class="message-body">
							Une demande d'accompagnement vient de vous être attribuée. Elle a été soumise par
							<a href="{{route('user.show', $notification->data['user_pp_id'])}}">{{$notification->data['user_pp_first_name']}} {{$notification->data['user_pp_name']}}</a>.

							<form action="{{route('notification.update', $notification->id)}}" method="POST">
								@csrf
								@method('PATCH')
								<input type="hidden" value="advisor.showSupport" name="route">
								<br>
								<input type="submit" class="button is-link "
									   value="@lang('Espace de suivi')">
							</form>
						</div>
					</article>
				@endif
			@endforeach
		@endif
	</div>

@endsection