<div class="card-content ">
	@if($listUserAds->count() === 0)
		<p class="has-text-centered">Cette personne n'a pas déposer d'annonces.</p>
	@else
		<div style="overflow-x: hidden; max-height: 700px">
		@foreach($listUserAds as $userAd)
				<h4 class="title is-4 has-text-centered">{{$userAd->title ?? ""}}</h4>
				<div class="columns">
					<div class="column is-three-fifths ">
						@if($userAd->hasImages)
							<div class="card">
								<div class="card-image">
									<a href="{{route('ads.show', $userAd->id)}}">
										<figure class="image is-4by1">
											@if($userAd->images->first()->path === "0")
												<img src="https://picsum.photos/480/320" alt="picsum">
											@else
												<img src="{{URL::asset($userAd->images->first()->path)}}"
													 alt="Placeholder image">
											@endif
										</figure>
									</a>
								</div>
							</div>
						@else
							<div class="card ">
								<div class="card-image">
									<a href="{{route('ads.show', $userAd->id)}}">
										<figure class="image is-2by1">
											<img src="/images/placeholder-ad.png">
										</figure>
									</a>
								</div>
							</div>
						@endif
					</div>
					<div class="column">
						<div class="content">
							<p><span class="is-italic">Date de soumission</span>
								: {{$userAd->submitDate ?? "Non renseignée"}} </p>
							<p><span class="is-italic">Catégorie</span>
								: {{$userAd->ad_type_full_name ?? "Non renseignée"}} </p>

							<p><span class="is-italic">Statut de l'annonce</span>
								:
								@if(isset($userAd->attributionAd->adStatus))
									@if($userAd->attributionAd->adStatus->id === \App\Models\AdStatus::APPROVE_ID)
										<span class="tag is-success">{{$userAd->attributionAd->adStatus->name}}</span>
									@elseif($userAd->attributionAd->adStatus->id === \App\Models\AdStatus::PENDING_ID)
										<span class="tag is-warning is-light">{{$userAd->attributionAd->adStatus->name}}</span>
									@elseif($userAd->attributionAd->adStatus->id ===  \App\Models\AdStatus::REFUSE_ID)
										<span class="tag is-danger">{{$userAd->attributionAd->adStatus->name}}</span>
									@elseif($userAd->attributionAd->adStatus->id === \App\Models\AdStatus::PENDING_MODERATION_STATUS_ID)
										<span class="tag is-warning">{{$userAd->attributionAd->adStatus->name}}</span>
									@else
										<span class="tag is-info">{{$userAd->attributionAd->adStatus->name}}</span>
									@endif
								@else
									<span class="tag is-light">Non renseigné</span>
								@endif
							</p>

							@if(isset($userAd->landOfferAd))
								<p><span class="is-italic">Localisations</span>:
							@else
								<p><span class="is-italic">Zone de recherche</span>:
									@endif
									{{$userAd->citiesList ?? ""}}
									{{$userAd->departmentsList ?? ""}}
									{{$userAd->regionsList ?? ""}}
									@if (is_null($userAd->citiesList) and is_null($userAd->departmentsList) and is_null($userAd->regionsList)   )
										Non renseignée
									@endif
								</p>
								@if(isset($userAd->landSeekAd))
									<p>
										<span class="is-italic">Dans un rayon de (en km)</span>:{{$userAd->landSeekAd->locationable_radius ?? 'Non renseigné'}}
									</p>
								@endif

								<a href="{{route('ads.show', $userAd->id)}}" class="button is-link ">
										<span class="icon is-small">
										  <i class="fas fa-search"></i>
										</span>
									<span>Voir le détail</span>
								</a>
						</div>
					</div>
				</div>
				@if(! $loop->last)
					<div class="is-divider"></div>
				@endif
			<br>
		@endforeach
		</div>
	@endif
</div>