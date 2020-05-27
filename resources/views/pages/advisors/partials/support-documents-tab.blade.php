<div class="card-content ">
	<div>
		<div class="content">
			<h5 class="has-text-centered">Documents téléversés par le porteur de projet</h5>
			@if($ad->documentsUploadedByUser->count() >0)
				@foreach($ad->documentsUploadedByUser as $document)
					<div class="buttons ">
						<a href="{{'/'.$document->path}}" download="{{$document->name}}">
							<button class="button is-link is-light">
											<span class="icon is-small">
												@if(strstr($document->type,'/',true) === "image")
													<i class="fas fa-image"></i>
												@elseif($document->type === "application/pdf")
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
					</div>
				@endforeach
			@else
				<p class="">Aucun document n'a été téléversé par le porteur de projet. </p>
			@endif
		</div>
		<div class="is-divider"></div>
		<div class="content">
			<h5 class="has-text-centered">Documents téléversés par les membres de Terre de Liens</h5>
			<div class="content">
				@if($ad->documentsUploadedByAdvisors->count() >0)
					<div class="columns  is-multiline is-mobile" style="max-height: 600px; overflow-x: hidden">
						@foreach($ad->documentsUploadedByAdvisors as $document)
							<div class="column is-6 has-text-centered">

								<a href="{{'/'.$document->path}}" download="{{$document->name}}">
									<button class="button is-link is-light">
										<span class="icon is-small">
											@if(strstr($document->type,'/',true) === "image")
												<i class="fas fa-image"></i>
											@elseif($document->type === "application/pdf")
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
								<p class=" has-text-weight-light is-size-6 ">Téléversé
									par {{$document->user->first_name}} {{$document->user->name}}</p>
							</div>
						@endforeach
					</div>
				@else
					<p class="">Aucun document n'a été uploadé.</p>
				@endif
			</div>
			<br>
			<div class="content">
				<div class=" has-text-centered">
					{!! Form::open(['route' => 'advisor.uploadDocuments', 'method'=>'post']) !!}
					<documents-upload
							url="/documents/upload"
							type="ads"
							name="documents"
							v-model="documents"
							@uploading="setUploading"
							ref="documents">
					</documents-upload>
					<input type="hidden" name="ad_id" value="{{$ad->id}}">
					<input type="hidden" name="documents_ids[]" :value="document.id" v-for="document in documents">
					<input type="hidden" name="documents" :value="JSON.stringify(documents)">
					<div>
						<p class="help is-danger" v-show="$v.documents.$error && !$v.documents.notCurrentlyUploading">
							Vous devez attendre la fin du téléversement de vos documents pour publier.
						</p>
					</div>
					<br>
					<button :disabled="uploading"
							v-bind:class="[uploading ?'button is-link is-loading ' : 'button is-link']">
								<span class="icon">
								<i class="fas fa-file-upload"></i>
								</span>
						<span>Téléverser</span>
					</button>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>

</div>