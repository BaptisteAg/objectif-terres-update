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
				<p class="">Aucun document n'a été uploadé par le porteur de projet </p>
			@endif
		</div>
		<div class="is-divider"></div>
		<div class="content">
			<h5 class="has-text-centered">Documents téléversés par l'accompagnant</h5>
			<p class="">Aucun document n'a été uploadé</p>
			<div  class=" has-text-centered">
			<button class="button is-link ">
				<span class="icon">
				<i class="fas fa-file-upload"></i>
				</span>
				<span>Téléverser un document</span>
			</button>
			</div>
		</div>
	</div>

</div>