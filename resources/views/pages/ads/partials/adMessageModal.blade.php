@guest
	<div class="modal" data-type="modal-message">
		<div class="modal-background" data-type="modal-message-background"></div>
		<div class="modal-content">
			<div class="card">
				<div class="card-content">
					<div class="content">
						<p class="title is-3 has-text-centered has-text-link">Pas encore connecté·e ?</p>
						<p class="subtitle is-6">Pour envoyer un message à ce porteur de projet, vous devez vous connecter ou créer un
							compte sur Objectif Terres</p>
					</div>
				</div>
				<footer class="card-footer">
					<div class="buttons card-footer-item">
						<a href="{{route('login')}}">
							<button class="button is-link">
								<span>Se connecter</span></button>
						</a>
						<a href="{{route('register')}}">
							<button class="button is-link is-light">
								<span>S'inscrire</span></button>
						</a>
					</div>
					<button id="close-modal" class="modal-close is-large" aria-label="close"></button>
				</footer>
			</div>
		</div>
	</div>
@else
	{!! Form::open(['route' => 'threads.create', 'method'=>'post']) !!}
	<div class="modal" data-type ="modal-message">
		<div class="modal-background" data-type ="modal-message-background"></div>
		<div class="modal-content">
			<div class="card">
				<div class="card-content">
					<h3 class="title is-3 has-text-centered has-text-black ">Envoyer un message au porteur de
						projet</h3>
				</div>
				<div class="card-content">
					<div class="container">
						<div class="field">
							<label class="label">Votre message :</label>
							<div class="field">
								<div class="control">
									<input type="hidden" name="ad_id" value="{{$ad->id}}">
									<textarea required name="content" class="textarea is-medium"
											  placeholder="Votre message..."></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
				<footer class="card-footer">
					<div class="buttons card-footer-item">
						<button type="submit" class="button is-link">
							<span>Envoyer</span></button>
					</div>
					<button id="close-modal" class="modal-close is-large" aria-label="close"></button>
				</footer>
			</div>
		</div>
	</div>
	{!! Form::close() !!}
@endguest