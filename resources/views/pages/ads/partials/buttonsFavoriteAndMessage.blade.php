@auth
	@if (auth()->user()->role >= 1)
		<footer class="card-footer">
			@if(count($threads))
				<button onclick="window.location.href='#messages-display'" type="button"
						class="card-footer-item button is-link is-fullwidth">
					<span class="icon is-small">
											<i class="fas fa-reply"></i>
											</span>
					<span> Voir votre fil de discussion </span>
				</button>
			@else
				<button id="open-modal-message" type="button"
						class="card-footer-item button is-link is-fullwidth">
										 <span class="icon is-small">
											<i class="fas fa-reply"></i>
										</span>
					<span> Contacter ce porteur de projet</span>
				</button>
		</footer>
	@endif
@elseif($ad->user_pp_id !== auth()->user()->id)
	<footer class="card-footer">
		@if(count($threads))
			<p class="control">
				<a href="#messages-display">
					<button type="button" class="card-footer-item button is-link is-fullwidth">
											<span class="icon is-small">
											<i class="fas fa-reply"></i>
											</span>
						<span> Voir votre fil de discussion </span>
					</button>
				</a>
			</p>
		@else
			<p class="control">
				<button id="open-modal-message" type="button"
						class="card-footer-item button is-link is-fullwidth">
										 <span class="icon is-small">
											<i class="fas fa-reply"></i>
										</span>
					<span> Répondre à l'annonce</span>
				</button>
			</p>
		@endif
		@isset($favoriteAdAlreadyExist)
			<p class="control">
				<a href="{{route ('favoriteAds.destroy', $favoriteAdAlreadyExist->id)}}">
					<button class="card-footer-item button is-danger is-light is-fullwidth">
									 <span class="icon is-small">
										 <i class="fas fa-trash"></i>
										</span>
						<span> Supprimer cette annonce  de vos favoris</span>
					</button>
				</a>
			</p>
		@else
			<p class="control">
				{!! Form::open(['route'=>'favoriteAds.create', 'method'=>'get']) !!}
				<input name="ad_id" value="{{$ad->id}}" type="hidden">
				<button class="card-footer-item button is-link is-light is-fullwidth ">
									 	<span class="icon is-small">
												<i class="fas fa-star"></i>
										</span>
					<span> Mettre cette annonce en favoris</span>
				</button>
				{!! Form::close() !!}
			</p>
		@endisset
	</footer>
@endif
@else
	<footer class="card-footer">
		<button id="open-modal-message" type="button"
				class="card-footer-item button is-link">
								 <span class="icon is-small">
								<i class="fas fa-reply"></i>
								</span>
			<span> Répondre à l'annonce</span>
		</button>
		{!! Form::open(['route'=>'favoriteAds.create', 'method'=>'get']) !!}
		<input name="ad_id" value="{{$ad->id}}" type="hidden">
		<button class="card-footer-item button is-link is-light">
							 <span class="icon is-small">
								<i class="fas fa-star"></i>
								</span>
			<span> Mettre cette annonce en favoris</span>
		</button>
		{!! Form::close() !!}
	</footer>
@endauth