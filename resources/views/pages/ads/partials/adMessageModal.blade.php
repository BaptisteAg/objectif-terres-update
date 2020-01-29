{!! Form::open(['route' => 'adMessages.create', 'method'=>'post']) !!}
<div class="modal">
	<div class="modal-background"></div>
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