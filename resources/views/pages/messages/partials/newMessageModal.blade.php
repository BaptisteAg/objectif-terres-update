@if(auth()->user()->role >= 1)
	{!! Form::open(['route' => 'threads.create', 'method'=>'post']) !!}
	<div class="modal" ref="newMessageModal">
		<div ref="closeMessageModal" class="modal-background"></div>
		<div class="modal-content">
			<div class="card">
				<div class="card-content">
					<h3 class="title is-3 has-text-centered has-text-black ">Créer une nouvelle discussion </h3>
				</div>
				<div class="card-content">
					<div class="container">
						<div class="field">
							{!! Form::label('receivers_user_message[]', 'Choisissez votre ou vos interlocuteurs', ['class' => 'label']); !!}
							<multi-select
									:options="{{ $users }}"
									v-model="usersSelected"
									name="receivers_user_message[]"
									selected-count-text="personne(s) séléctionnée(s)"
									placeholder="Choississez"
							>
							</multi-select>
						</div>
						<div class="field">
							<label class="label">Donnez un titre à votre discussion : </label>
							<div class="field">
								<div class="control">
									<input type="text" name="title" class="input is-medium"
										   placeholder="Votre titre...">
								</div>
							</div>
						</div>
						<div class="field">
							<label class="label">Votre message :</label>
							<div class="field">
								<div class="control">
								<textarea required name="content" class="textarea is-medium"
										  placeholder="Votre message..."> </textarea>
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
@endif