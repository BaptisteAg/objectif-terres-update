<table>
	<thead>
	<tr>
		<th colspan="10" ><h1>Données générales</h1></th>
		<th colspan="16"><h1>Détails offres foncières</h1>
		</th>
		<th colspan="6"><h1>Détails recherche de
				foncier</h1></th>
	</tr>
	</thead>
	<tr>
		<th>Date de la demande</th>
		<th>Stade de l'accompagnement</th>
		<th>Etat de la demande</th>
		<th>Avancement du projet</th>
		<th>Titre du projet</th>
		<th>Type de projet</th>
		<th>Nom du porteur de projet</th>
		<th>Adresse mail</th>
		<th>Localisation(s)</th>
		<th>Nom du primo-accueillant</th>
		<th>Nom du responsable territorial</th>
		<th>Descritpion du projet</th>
		<th>Description du porteur de projet</th>
		<th>Surface (en ha)</th>
		<th>Description Surface Agricole Utiles (SAU)</th>
		<th>Accès à l'eau</th>
		<th>Description accès à l'eau</th>
		<th>Altitude en (en m)</th>
		<th>Production(s) en place</th>
		<th>Production(s) possibles</th>
		<th>Certification des terres</th>
		<th>Avec bâtiment(s) agricole(s)</th>
		<th>Description bâtiment(s) agricole(s)</th>
		<th>Avec habitationt(s)</th>
		<th>Description habitation(s)</th>
		<th>Type d'offre</th>
		<th>Prix (en €)</th>
		<th>Loyer (en €)</th>
		<th>Modalité test agricole</th>
		<th>Surface recherchée (en ha)</th>
		<th>Habitation(s) et bâti(s) recherché(s)</th>
		<th>Projet agriculture bio</th>
		<th>Productions(s) envisagée(s)</th>
		<th>Type d'installation</th>
		<th>Expérience dans le domaine agricole</th>
	</tr>

	<tbody>
	@foreach($ads as $ad)
		@if(isset($ad->project))
			<tr>
				<td>{{$ad->project->created_at?: ''}}</td>
				<td>{{$ad->project->supportStage->name ?? ''}}</td>
				<td>{{$ad->project->supportState->name ?? ''}}</td>
				<td>{{$ad->project->projectStatus->name ?? ''}}</td>
				<td>{{$ad->title ?? ''}}</td>
				<td>{{$ad->ad_type_full_name?: ''}}</td>
				<td>{{$ad->userPp->first_name ?? ''}} {{$ad->userPp->name ?? ''}}</td>
				<td>{{$ad->userPP->email ?? ''}}</td>
				<td>
					@if(! is_null($ad->regionsList))
						<p>Region(s) : {{$ad->regionsList}}</p>
					@endif
					@if(! is_null($ad->departmentList))
						<p>Département(s) : {{$ad->departmentsList}}</p>
					@endif
					@if(! is_null($ad->citiesList))
						<p>Communes(s) : {{$ad->citiesList}}</p>
					@endif
				</td>
				<td>{{$ad->attributionAd->userAdvisor->first_name ?? '' }} {{ $ad->attributionAd->userAdvisor->name ?? ''}}</td>
				<td>{{$ad->attributionAd->userSupervisor->first_name ?? ''}} {{ $ad->attributionAd->userSupervisor->name ?? ''}}</td>
				<td style="width: auto">{{$ad->about_project_content ?? ''}}</td>
				<td>{{$ad->about_content ?? ''}}</td>
				<td>{{$ad->landOfferAd->surface ?? '' }}</td>
				<td>{{$ad->landOfferAd->sau_description ?? '' }}</td>
				<td>
					@if(isset($ad->landOfferAd))
						@if($ad->landOfferAd->water_access === 1)
							oui
						@else
							non
						@endif
					@endif
				</td>
				<td>{{$ad->landOfferAd->water_access_description ?? '' }}</td>
				<td>{{$ad->landOfferAd->altitude ?? '' }}</td>
				<td>
					@if(isset($ad->landOfferAd))
						@if(isset($ad->landOfferAd->productionGenres))
							{{$ad->landOfferAd->productionGenres->pluck('name')->implode(', ')}}
						@endif
					@endif
				</td>
				<td>
					@if(isset($ad->landOfferAd))
						@if(isset($ad->landOfferAd->productionGenresPossible))
							{{$ad->landOfferAd->productionGenresPossible->pluck('name')->implode(', ')}}
						@endif
					@endif
				</td>
				<td>
					@if(isset($ad->landOfferAd))
						@if(isset($ad->landOfferAd->bioCertifications))
							{{$ad->landOfferAd->bioCertifications->pluck('name')->implode(', ')}}
						@endif
					@endif
				</td>
				<td>
					@if(isset($ad->landOfferAd))
						@if($ad->landOfferAd->has_buildings === 1)
							oui
						@else
							non
						@endif
					@endif
				</td>
				<td>{{$ad->landOfferAd->buildings_description ?? '' }}</td>
				<td>
					@if(isset($ad->landOfferAd))
						@if($ad->landOfferAd->has_houses === 1)
							oui
						@else
							non
						@endif
					@endif
				</td>
				<td>{{$ad->landOfferAd->houses_description ?? '' }}</td>
				<td>
					@if(isset($ad->landOfferAd))
						@if(isset($ad->landOfferAd->offerGenres))
							{{$ad->landOfferAd->offerGenres->pluck('name')->implode(', ')}}
						@endif
					@endif
				</td>
				<td>{{$ad->landOfferAd->price ?? '' }}</td>
				<td>{{$ad->landOfferAd->rent_price ?? '' }}</td>
				<td>{{$ad->landOfferAd->test_description ?? '' }}</td>
				<td>
					@if(isset($ad->landSeekAd))
						@if(isset($ad->landSeekAd->surface_range_min) and isset($ad->landSeekAd->surface_range_max))
							{{'entre '.$ad->landSeekAd->surface_range_min. ' et '.$ad->landSeekAd->surface_range_max }}
						@endif
					@endif
				</td>
				<td>
					@if(isset($ad->landSeekAd))
						@if(isset($ad->landSeekAd->buildings))
							@foreach($ad->landSeekAd->buildings as $building)
								{{ $building->buildingType->label }} : {{ $building->requirement->label }}<br>
							@endforeach
						@endif
					@endif
				</td>
				<td>@if(isset($ad->landSeekAd))
						@if($ad->landSeekAd->is_bio === 1)
							oui
						@else
							non
						@endif
					@endif
				</td>
				<td>
					@if(isset($ad->landSeekAd))
						@if($ad->landSeekAd->offerGenres)
							{{$ad->landSeekAd->offerGenres->pluck('name')->implode(', ')}}
						@endif
					@endif
				</td>
				<td>{{$ad->landSeekAd->installationType->name ?? '' }}</td>
				<td>{{$ad->landSeekAd->experience_farming ?? '' }}</td>
			</tr>
		@else
		@endif
	@endforeach
	</tbody>
</table>
