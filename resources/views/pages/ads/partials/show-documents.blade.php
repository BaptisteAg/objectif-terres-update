@if($ad->documentsUploadedByUser->count() > 0)
	<div class="content">
		<p>
			<span class="is-size-5 ad-show-feature-label">Documents joints au projet : </span><br>
			@foreach($ad->documentsUploadedByUser as $document)
				@if(strstr($document->type,'/',true) !== "image")
					<a href="{{URL::asset($document->path)}}"
					   target="_blank">
						<button class="button is-link is-light" style="margin-bottom: 10px">
						<span class="icon is-small">
							  @if($document->type === "application/pdf")
								<i class="fa fa-file-pdf"></i>
								@elseif($document->type === "application/msword")
								<i class="fa fa-file-alt"></i>
							@else
								<i class="fa fa-file"></i>
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