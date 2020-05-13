<div class="card-content ">
	<div>
		<div class="content">
			<h5 class="has-text-centered">Documents téléversés par le porteur de projet</h5>
			@if($ad->documents->count() >0)
				@foreach($ad->documents as $document)
					<div class="buttons ">
						<a href="/" download="{{$document->path}}">
							<button class="button is-link is-light">
											<span class="icon is-small">
												@if(strstr($document->type,'/',true) === "image")
													<i class="fas fa-image"></i>
												@endif

											</span>
								<span>{{$document->name}}</span>
							</button>
						</a>
					</div>
				@endforeach
			@else
				<p class="">Aucun document n'a uploadé par le porteur de projet </p>
			@endif
		</div>
	</div>

</div>