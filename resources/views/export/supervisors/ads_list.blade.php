<table>
	<thead>
	<tr>
		<th colspan="9" style="text-align: center"><h1>Données générales</h1></th>
		<th colspan="16" style="text-align: center; border-left: solid #000000 1px;"><h1>Détails offres foncières</h1>
		</th>
		<th colspan="6" style="text-align: center; border-left: solid #000000 1px;"><h1>Détails recherche de
				foncier</h1></th>
		<th colspan="6" style="text-align: center; border-left: solid #000000 1px;"><h1>Détails offre d'emploi</h1></th>
		<th colspan="3" style="text-align: center; border-left: solid #000000 1px;"><h1>Détails recherche d'emploi</h1>
		</th>
	</tr>
	</thead>
	<tr style="border-bottom: solid #000000 2px">
		<th style="background-color: #bdbdbd; width: auto">Date de la soumission</th>
		<th style="background-color: #bdbdbd; width: auto">Titre de l'annonce</th>
		<th style="background-color: #bdbdbd; width: auto">Type de l'annonce</th>
		<th style="background-color: #bdbdbd; width: auto">Nom du porteur de projet</th>
		<th style="background-color: #bdbdbd; width: auto">Adresse mail</th>
		<th style="background-color: #bdbdbd; width: auto">Localisation(s)</th>
		<th style="background-color: #bdbdbd; width: auto">Nom du modérateur</th>
		<th style="background-color: #bdbdbd; width: auto ">Descritpion de l'annonce</th>
		<th style="background-color: #bdbdbd; width: auto">Description du porteur de projet</th>
		<th style="background-color: #8fb5d9; width: auto ">Surface (en ha)</th>
		<th style="background-color: #8fb5d9; width: auto ">Description Surface Agricole Utiles (SAU)</th>
		<th style="background-color: #8fb5d9; width: auto ">Accès à l'eau</th>
		<th style="background-color: #8fb5d9; width: auto ">Description accès à l'eau</th>
		<th style="background-color: #8fb5d9; width: auto ">Altitude en (en m)</th>
		<th style="background-color: #8fb5d9; width: auto ">Production(s) en place</th>
		<th style="background-color: #8fb5d9; width: auto ">Production(s) possibles</th>
		<th style="background-color: #8fb5d9; width: auto ">Certification des terres</th>
		<th style="background-color: #8fb5d9; width: auto ">Avec bâtiment(s) agricole(s)</th>
		<th style="background-color: #8fb5d9; width: auto ">Description bâtiment(s) agricole(s)</th>
		<th style="background-color: #8fb5d9; width: auto ">Avec habitationt(s)</th>
		<th style="background-color: #8fb5d9; width: auto ">Description habitation(s)</th>
		<th style="background-color: #8fb5d9; width: auto ">Type d'offre</th>
		<th style="background-color: #8fb5d9; width: auto ">Prix (en €)</th>
		<th style="background-color: #8fb5d9; width: auto ">Loyer (en €)</th>
		<th style="background-color: #8fb5d9; width: auto ">Modalité test agricole</th>
		<th style="background-color: #74f765; width: auto">Surface recherchée (en ha)</th>
		<th style="background-color: #74f765; width: auto">Habitation(s) et bâti(s) recherché(s)</th>
		<th style="background-color: #74f765; width: auto">Projet agriculture bio</th>
		<th style="background-color: #74f765; width: auto">Productions(s) envisagée(s)</th>
		<th style="background-color: #74f765; width: auto">Type d'installation</th>
		<th style="background-color: #74f765; width: auto">Expérience dans le domaine agricole</th>
		<th style="background-color: #f06060; width: auto">Transmission d'activité</th>
		<th style="background-color: #f06060; width: auto">Type d'offre</th>
		<th style="background-color: #f06060; width: auto">Description du poste</th>
		<th style="background-color: #f06060; width: auto">Expérience souhaité</th>
		<th style="background-color: #f06060; width: auto">Niveau de formation souhaité</th>
		<th style="background-color: #e3cb5f; width: auto">Type d'opportunité recherché</th>
		<th style="background-color: #e3cb5f; width: auto">Expérience dans le milieu agricole</th>
		<th style="background-color: #e3cb5f; width: auto">Niveau de formation</th>


	</tr>

	<tbody>
	@foreach($ads as $ad)
		@if(! $ad->project()->exists())
			<tr>
				<td>{{$ad->attributionAd->created_at}}</td>
				<td>{{$ad->title}}</td>
				<td>{{$ad->ad_type_full_name}}</td>
				<td>{{$ad->userPp->first_name ?: ''}} {{$ad->userPp->name ?: ''}}</td>
				<td>{{$ad->userPP->email}}</td>
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
				<td>{{$ad->attributionAd->userAdvisor->first_name}} {{$ad->attributionAd->userAdvisor->name}}</td>
				<td style="width: auto">{{$ad->about_project_content}}</td>
				<td>{{$ad->about_content}}</td>
				<td>{{$ad->landOfferAd()->exists() ?$ad->landOfferAd->surface : '' }}</td>
				<td>{{$ad->landOfferAd()->exists() ?$ad->landOfferAd->sau_description : '' }}</td>
				<td>
					@if($ad->landOfferAd()->exists())
						@if($ad->landOfferAd->water_access === 1)
							oui
						@else
							non
						@endif
					@endif
				</td>
				<td>{{$ad->landOfferAd()->exists() ?$ad->landOfferAd->water_access_description : '' }}</td>
				<td>{{$ad->landOfferAd()->exists() ?$ad->landOfferAd->altitude : '' }}</td>
				<td>{{$ad->landOfferAd()->exists() ?$ad->landOfferAd->productionGenres->pluck('name')->implode(', ')  : '' }}</td>
				<td>{{$ad->landOfferAd()->exists() ?$ad->landOfferAd->productionGenresPossible->pluck('name')->implode(', ') : '' }}</td>
				<td>{{$ad->landOfferAd()->exists() ?$ad->landOfferAd->bioCertifications->pluck('name')->implode(', ') : '' }}</td>
				<td>
					@if($ad->landOfferAd()->exists())
						@if($ad->landOfferAd->has_buildings === 1)
							oui
						@else
							non
						@endif
					@endif
				</td>
				<td>{{$ad->landOfferAd()->exists() ?$ad->landOfferAd->buildings_description : '' }}</td>
				<td>
					@if($ad->landOfferAd()->exists())
						@if($ad->landOfferAd->has_houses === 1)
							oui
						@else
							non
						@endif
					@endif
				</td>
				<td>{{$ad->landOfferAd()->exists() ?$ad->landOfferAd->houses_description : '' }}</td>
				<td>{{$ad->landOfferAd()->exists() ?$ad->landOfferAd->offerGenres->pluck('name')->implode(', ') : '' }}</td>
				<td>{{$ad->landOfferAd()->exists() ?$ad->landOfferAd->price : '' }}</td>
				<td>{{$ad->landOfferAd()->exists() ?$ad->landOfferAd->rent_price : '' }}</td>
				<td>{{$ad->landOfferAd()->exists() ?$ad->landOfferAd->test_description : '' }}</td>
				<td>{{$ad->landSeekAd()->exists() ?'entre '.$ad->landSeekAd->surface_range_min. ' et '.$ad->landSeekAd->surface_range_max  : '' }}</td>
				<td>@if($ad->landSeekAd()->exists())
						@if($ad->landSeekAd->buildings)
							@foreach($ad->landSeekAd->buildings as $building)
								{{ $building->buildingType->label }} : {{ $building->requirement->label }}<br>
							@endforeach
						@endif
					@endif
				</td>
				<td>@if($ad->landSeekAd()->exists())
						@if($ad->landSeekAd->is_bio === 1)
							oui
						@else
							non
						@endif
					@endif
				</td>
				<td>{{$ad->landSeekAd()->exists() ?$ad->landSeekAd->offerGenres->pluck('name')->implode(', ') : '' }}</td>
				<td>{{$ad->landSeekAd()->exists() ?$ad->landSeekAd->installationType->name : '' }}</td>
				<td>{{$ad->landSeekAd()->exists() ?$ad->landSeekAd->experience_farming : '' }}</td>
				<td>@if($ad->jobOfferAd()->exists())
						@if($ad->jobOfferAd->is_activity_transmission === 1)
							oui
						@else
							non
						@endif
					@endif
				</td>
				<td>
					@if($ad->jobOfferAd()->exists())
						@foreach($ad->jobOfferAd->jobOfferTypes as $offerType)
							{{$offerType->name}}
						@endforeach
					@endif
				</td>
				<td>{{$ad->jobOfferAd()->exists() ?$ad->jobOfferAd->job_description : '' }}</td>
				<td>{{$ad->jobOfferAd()->exists() ?$ad->jobOfferAd->experience_farming : '' }}</td>
				<td>
					@if($ad->jobOfferAd()->exists())
						{{$ad->jobOfferAd->educationLevels->pluck('name')->implode(', ')}}
					@endif
				</td>
				<td>
					@if($ad->jobSeekAd()->exists())
						{{$ad->jobSeekAd->jobOfferTypes->pluck('name')->implode(', ') }}
					@endif
				</td>
				<td>{{$ad->jobSeekAd()->exists() ? $ad->jobSeekAd->experience_farming : ""}}</td>
				<td>
					@if($ad->jobSeekAd()->exists())
						{{$ad->jobSeekAd->educationLevels->pluck('name')->implode(', ') }}
					@endif
				</td>
			</tr>
		@else
		@endif
	@endforeach
	</tbody>
</table>
