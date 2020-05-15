<div class="card-content ">
	<h4 class="title is-4 has-text-centered">{{$ad->title ?? ""}}</h4>
	<div class="columns">
		<div class="column is-three-fifths ">
			<div id="slider-container">
				<div id="support-request-dashboard-ad-images" class="carousel">
					@if($ad->hasImages)
						@foreach($ad->images as $document)
							<div class="card">
								<div class="card-image">
									<a href="{{route('ads.show', $ad->id)}}">
										<figure class="image is-2by1">
											@if($document->path === "0")
												<img src="https://picsum.photos/480/320" alt="picsum">
											@else
												<img src="{{URL::asset($document->path)}}"
													 alt="Placeholder image">
											@endif
										</figure>
									</a>
								</div>
							</div>
						@endforeach
					@else
						<div class="card carousel-item  ad-carousel">
							<div class="card-image">
								<figure class="image is-2by1">
									<img src="/images/placeholder-ad.png">
								</figure>
							</div>
						</div>
					@endif
				</div>
			</div>
		</div>
		<div class="column">
			<div class="content">
				<p><span class="is-italic">Date de soumission</span>
					: {{$ad->submitDate ?? "Non renseignée"}} </p>
				<p><span class="is-italic">Catégorie</span>
					: {{$ad->ad_type_full_name ?? "Non renseignée"}} </p>

				<p><span class="is-italic">Stade de l'accompagnement</span>
					: {{$ad->project->supportStage->name ?? "Non renseignée"}} </p>

				<p><span class="is-italic">État de la demande</span>
					: {{$ad->project->supportState->name ?? "Non définis"}} </p>


				@if(isset($ad->landOfferAd))
					<p><span class="is-italic">Localisations</span>:
				@else
					<p><span class="is-italic">Zone de recherche</span>:
						@endif
						{{$ad->citiesList ?? ""}}
						{{$ad->departmentsList ?? ""}}
						{{$ad->regionsList ?? ""}}
						@if (is_null($ad->citiesList) and is_null($ad->departmentsList) and is_null($ad->regionsList)   )
							Non renseignée
						@endif
					</p>
					@if(isset($ad->landSeekAd))
						<p>
							<span class="is-italic">Dans un rayon de (en km)</span>:{{$ad->landSeekAd->locationable_radius ?? 'Non renseigné'}}
						</p>
					@endif

					@if(isset($ad->landOfferAd))
						<p><span class="is-italic">Surface (en ha)</span> :
							{{$ad->landOfferAd->surface ?? "Non renseignée"}}
						</p>
					@elseif(isset($ad->landSeekAd))
						<p><span class="is-italic">Surface recherchée (en ha)</span> :
							@if(isset($ad->landSeekAd->surface_range_min) and isset($ad->landSeekAd->surface_range_max))
								Entre {{$ad->landSeekAd->surface_range_min}}
								et {{$ad->landSeekAd->surface_range_max}}
							@else
								Non renseignée
							@endif
						</p>
					@endif
					<a href="{{route('ads.show', $ad->id)}}" class="button is-link ">
										<span class="icon is-small">
										  <i class="fas fa-search"></i>
										</span>
						<span>Voir le détail</span>
					</a>
			</div>
		</div>
	</div>
	<div class="content">
		@if(isset($ad->landOfferAd))
			<div class="columns">
				<div class="column is-3">
					<p><span class="is-italic">Prix (en € )</span> :
						{{$ad->landOfferAd->price ?? "Non renseignée"}} </p>
				</div>
				<div class="column is-3">
					<p><span class="is-italic">Altitude (en m)</span> :
						{{$ad->landOfferAd->altitude ?? "Non renseignée"}} </p>
				</div>
				<div class="column">
					<p>
						<span class="is-italic">Bâtiments</span> :
						@if(isset($ad->landOfferAd->has_houses) and isset($ad->landOfferAd->has_buildings))
							@if(isset($ad->landOfferAd->has_houses))
								{{$ad->landOfferAd->has_houses ? 'Avec habitation' : 'Sans habitation'}}
							@endif
							@if(isset($ad->landOfferAd->has_buildings))
								{{$ad->landOfferAd->has_buildings ? ' Avec bâtiments agricoles' : 'Sans bâtiments agricoles'}}
							@endif
						@else
							Non renseignés
						@endif
					</p>
				</div>
			</div>

			<p>
				<span class="is-italic">Productions en place</span> :
				@if($ad->landOfferAd->productionGenres->count() > 0)
					{{$ad->landOfferAd->productionGenres->pluck('name')->implode(', ') }}
				@else
					Non renseignées
				@endif
			</p>
			<p>
				<span class="is-italic">Productions possibles</span> :
				@if($ad->landOfferAd->productionGenresPossible->count() > 0)
					{{$ad->landOfferAd->productionGenresPossible->pluck('name')->implode(', ') }}
				@else
					Non renseignées
				@endif
			</p>
			<p>
				<span class="is-italic">Description SAU : </span>{{$ad->sau_description?? "Non renseigné"}}
			</p>
		@endif
		@if(isset($ad->landSeekAd))
			<p>
				<span class="is-italic">Bâtiments recherchés</span> :
				@if(isset($ad->landSeekAd->buildings))
					@foreach($ad->landSeekAd->buildings as $building)
						<span class="is-lowercase">{{ $building->buildingType->label }} : {{ $building->requirement->label }}</span>
						{{ $loop->last ? ' ' : ',' }}
					@endforeach
				@else
					Non renseignés
				@endif
			</p>
			<p>
				<span class="is-italic">Installation en bio</span> :
				@if(isset($ad->landSeekAd->is_bio))
					{{$ad->landSeekAd->is_bio ? 'Oui' : 'Non'}}
				@else
					Non renseignée
				@endif
			</p>
			<p>
				<span class="is-italic">Productions envisagées</span> :
				@if($ad->landSeekAd->offerGenres->count() > 0)
					{{$ad->landSeekAd->offerGenres->pluck('name')->implode(', ') }}
				@else
					Aucune
				@endif
			</p>
			<p>
				<span class="is-italic">Type d'installation</span> :
				{{$ad->landSeekAd->installationType->name ?? 'Non renseigné'}}
			</p>

		@endif
		<p>
			<span class="is-italic">Plus d'informations sur la demande : </span>{{$ad->about_project_content?? "Non renseigné"}}
		</p>
	</div>
</div>