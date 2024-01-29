@if($ad->nonImageDocuments->count() > 0)
	<div class="content">
		<p>
			<span class="is-size-5 ad-show-feature-label has-text-black">Documents joints au projet : </span><br>
			@foreach($ad->nonImageDocuments as $document)
				@if(strstr($document->type,'/',true) !== "image")
					<a href="{{app('url')->assetFrom('https://objectif-terres.org', $document->path)}}"
					   target="_blank">
						<button class="button is-link is-light" style="margin-bottom: 10px">
						<span class="icon is-small">
							@if($document->type === "application/pdf")
								<i class="fa fa-file-pdf"></i>
							@elseif($document->type === "application/msword")
								<i class="fa fa-file-word"></i>
							@else
								<i class="far fa-file-image"></i>
							@endif
						</span>
							<span>{{$document->name}}</span>
						</button>
					</a>
				@endif
			@endforeach
		</p>
	</div>
@endif