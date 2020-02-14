<div id="reponses" class="content">
	<hr class="navbar-divider">
	<h1 class="title has-text-centered has-text-link">Liste des messages reçus concernant votre annonce</h1>


	@if(count ($ad->threads) > 0)
		@foreach($ad->threads as $thread)
			<div class="box">
				<article class="media">
					<div class="media-content">
						<div class="content">
							<p>
								<strong>{{$thread->messages[0]->senderUser->first_name}} {{$thread->messages[0]->senderUser->name}} </strong>
								<small>{{$thread->messages[0]->created_at_diff}}</small>
								<br>
								{{$thread->messages[0]->content}}
							</p>
						</div>
						<nav class="level is-mobile">
							<div class="level-left">
								<a href="{{route("threads.index")}}" class="level-item" aria-label="reply">
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