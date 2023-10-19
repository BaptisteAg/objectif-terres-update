<table>
	<thead>
	<tr>
		<th colspan="27" ><b>Données générales</b></th>
		<th colspan="16"><b>Détails offres foncières</b></th>
		<th colspan="9"><b>Détails recherche de foncier</b></th>
		<th><b>Indicateurs</b></th>
		<th><b>Notes</b></th>
	</tr>
	</thead>
	<tr>
		<!-- Ajouter :
		 	- ID
		 	- ID PP
		 	- Code Région
		 	- Codes départements
		 	- Codes communes
		 	- ID Resp. Terr;
		 	- ID Primo Accueillant
		 	- Une colonnes contenant tous les indicateurs
		 	- Une colonne contenant toutes les notes libres chronologiques
		 	- Séparer en deux colonnes Habitation(s) et bâti(s) recherché(s)
		 -->

		<th>ID</th>
		<th>Date de la demande</th>
		<th>Stade de l'accompagnement</th>
		<th>Etat de la demande</th>
		<th>Avancement du projet</th>
		<th>Titre du projet</th>
		<th>Type de projet</th>
		<th>ID PP</th>
		<th>Nom du porteur de projet</th>
		<th>Prénom</th>
		<th>Civilité</th>
		<th>Adresse mail</th>
		<th>Téléphone</th>
		<th>Code Postal du PP</th>
		<th>Territoire</th>
		<th>Région(s)</th>
		<th>Code Région(s)</th>
		<th>Département(s)</th>
		<th>Code Département(s)</th>
		<th>Commune(s)</th>
		<th>Code Commune(s)</th>
		<th>ID du primo-accueillant</th>
		<th>Nom du primo-accueillant</th>
		<th>ID du responsable territorial</th>
		<th>Nom du responsable territorial</th>
		<th>Description du projet</th>
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
		<th>Avec habitation(s)</th>
		<th>Description habitation(s)</th>
		<th>Type d'offre</th>
		<th>Prix (en €)</th>
		<th>Loyer (en €)</th>
		<th>Modalité test agricole</th>
		<th>Surface recherchée (en ha)</th>
		<th>Habitation(s) recherché(s)</th>
		<th>Bâti(s) recherché(s)</th>
		<th>Projet agriculture bio</th>
		<th>Production(s) envisagée(s)</th>
		<th>Productions(s) envisagée(s)</th>
		<th>Type d'installation</th>
		<th>Expérience dans le domaine agricole</th>
		<th>Niveau de formation</th>
		<th>Indicateurs</th>
		<th>Notes</th>
	</tr>

	<tbody>
	@foreach($ads as $ad)

		<?php /** @var \App\Models\Ad $ad */ ?>


		@if(isset($ad->project))
			<tr>
				<td>{{$ad->id }}</td>
				<td>{{$ad->project->created_at?: ''}}</td>
				<td>{{$ad->project->supportStage->name ?? ''}}</td>
				<td>{{$ad->project->supportState->name ?? ''}}</td>
				<td>{{$ad->project->projectStatus->name ?? ''}}</td>
				<td>{{$ad->title ?? ''}}</td>
				<td>{{$ad->landSeekAd ? 'Recherche de foncier' : 'Offre de foncier'}}</td>
				<td>{{$ad->userPp->id ?? ''}}</td>
				<td>{{$ad->userPp->name ?? ''}}</td>
				<td>{{$ad->userPp->first_name ?? ''}}</td>
				<td>{{$ad->userPp->civilityFullName ?? ''}}</td>
				<td>{{$ad->userPp->email ?? ''}}</td>
				<td>{{$ad->userPp->phone ?? ''}}</td>
				<td>{{$ad->userPp->zipCode->zip_code ?? ''}}</td>
				<td>{{$ad->supportRequestTerritoryId?->name}}</td>
				<td>
					@if(! is_null($ad->regionsList))
						<p>{{$ad->regionsList}}</p>
					@endif
				</td>
				<td>
					@if(! is_null($ad->regions))
						<p>{{$ad->regions->map(fn(\App\Models\Region $r) => $r->code)->join(', ')}}</p>
					@endif
				</td>
				<td>
					@if(! is_null($ad->departmentsList))
						<p>{{$ad->departmentsList}}</p>
					@endif
				</td>
				<td>
					@if(! is_null($ad->departments))
						<p>{{$ad->departments->map(fn(\App\Models\Department $r) => $r->code)->join(', ')}}</p>
					@endif
				</td>
				<td>
					@if(! is_null($ad->citiesList))
						<p>{{$ad->citiesList}}</p>
					@endif
				</td>
				<td>
					@if(! is_null($ad->cities))
						<p>{{$ad->cities->map(fn(\App\Models\City $r) => $r->insee_code)->join(', ')}}</p>
					@endif
				</td>
				<td>{{$ad->attributionAd?->userAdvisor?->id}}</td>
				<td>{{$ad->attributionAd->userAdvisor->first_name ?? '' }} {{ $ad->attributionAd->userAdvisor->name ?? ''}}</td>
				<td>{{$ad->attributionAd?->userSupervisor?->id}}</td>
				<td>{{$ad->attributionAd->userSupervisor->first_name ?? ''}} {{ $ad->attributionAd->userSupervisor->name ?? ''}}</td>
				<td>{{$ad->about_project_content ?? ''}}</td>
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
								@if($building->buildingType->id === 1)
									{{ $building->buildingType->label }} : {{ $building->requirement->label }}<br>
								@endif
							@endforeach
						@endif
					@endif
				</td>
				<td>
					@if(isset($ad->landSeekAd))
						@if(isset($ad->landSeekAd->buildings))
								<?php /** @var \App\Models\Ad $ad */ ?>
							@foreach($ad->landSeekAd->buildings as $building)
								@if($building->buildingType->id === 2)
									{{ $building->buildingType->label }} : {{ $building->requirement->label }}<br>
								@endif
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
						@if(isset($ad->landSeekAd->productionGenres))
							{{$ad->landSeekAd->productionGenres->pluck('name')->implode(', ')}}
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
				<td>
					@if(isset($ad->landSeekAd))
						@if(isset($ad->landSeekAd->educationLevels))
							{{$ad->landSeekAd->educationLevels->pluck('name')->implode(', ') }}
						@endif
					@endif
				</td>

				<td>
					@if($ad->adNotes)
						@foreach($ad->adNotes as $note)
							@if($note->project_data_key_id)
								- {{$note->projectDataKey->name ?? ''}} :
								{{$note->value ?? ''}}<br>
							@endif
						@endforeach
					@endif
				</td>
				<td>
					@if($ad->adNotes)
						@foreach($ad->adNotes as $note)
							@if(!$note->project_data_key_id)
								Note {{$note->created_at ?? ''}} :<br>
								{{$note->value ?? ''}}<br><br>
							@endif
						@endforeach
					@endif
				</td>

			</tr>
		@endif
	@endforeach
	</tbody>
</table>
