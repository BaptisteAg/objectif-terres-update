<div id="reponses" class="content">
	<hr class="navbar-divider">
	<h1 class="title has-text-centered has-text-link">Liste des messages reçus concernant votre annonce</h1>


	@if(count ($ad->adMessages) > 0)
		@foreach($ad->adMessages as $adMessage)
			<div class="box">
				<article class="media">
					<div class="media-content">
						<div class="content">
							<p>
								<strong>{{$adMessage->user->first_name}} {{$adMessage->user->name}} </strong>
								<small>{{$adMessage->created_at_diff}}</small>
								<br>
								{{$adMessage->content}}
							</p>
						</div>
						<nav class="level is-mobile">
							<div class="level-left">
								<a class="level-item" aria-label="reply">
									<span class="icon is-small">
									  <i class="fas fa-reply" aria-hidden="true"></i>
									</span>
									<span> Répondre</span>
								</a>
							</div>
						</nav>
					</div>
				</article>
			</div>
		@endforeach
	@else
		<p class="has-text-centered">Vous n'avez pas encore reçu de messages pour votre annonce.</p>
	@endisset
</div>