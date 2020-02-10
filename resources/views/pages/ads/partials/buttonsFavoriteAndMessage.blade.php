@auth
	@if( $ad->user_pp_id !== auth()->user()->id)
		<footer class="card-footer">

			@isset($userMessage)
				<p class="control">
					<a href="">
						<button type="button" class="card-footer-item button is-link is-fullwidth">
											<span class="icon is-small">
											<i class="fas fa-reply"></i>
											</span>
							<span> Ouvrir la messagerie </span>
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
			@endisset
			@isset($favoriteAdAlreadyExist)
				<p class="control">
					{{Form::open(['route' => 'favoriteAds.destroy'])}}
					<input type="hidden" value="{{$favoriteAdAlreadyExist->id}}"
						   name="favoriteAdId">
					<button type="submit" class="card-footer-item button is-danger is-light is-fullwidth">
									 <span class="icon is-small">
										 <i class="fas fa-trash"></i>
										</span>
						<span> Supprimer cette annonce  de vos favoris</span>
					</button>
					{{Form::close()}}
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