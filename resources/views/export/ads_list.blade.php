<table>
    <thead>
    <tr>
        <th colspan="18"><b>Données générales</b></th>
        <th colspan="16"><b>Détails offres foncières</b></th>
        <th colspan="7"><b>Détails recherche de foncier</b></th>
        <th colspan="4"><b>Détails offre d'emploi</b></th>
        <th colspan="4"><b>Détails recherche d'emploi</b></th>
    </tr>
    </thead>
    <tr>
        <th>ID</th>
        <th>Date de la soumission</th>
        <th>Date de mise en ligne</th>
        <th>Titre de l'annonce</th>
        <th>Type de l'annonce</th>
        <th>Nom du porteur de projet</th>
        <th>Prénom</th>
        <th>Civilité</th>
        <th>Adresse mail</th>
        <th>Téléphone</th>
        <th>Code Postal du PP</th>
        <th>Région(s)</th>
        <th>Département(s)</th>
        <th>Commune(s)</th>
        <th>Nom du modérateur</th>
        <th>Prénom du modérateur</th>
        <th>Description de l'annonce</th>
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
        <th>Habitation(s) et bâti(s) recherché(s)</th>
        <th>Projet agriculture bio</th>
        <th>Productions(s) envisagée(s)</th>
        <th>Type d'installation</th>
        <th>Expérience dans le domaine agricole</th>
        <th>Transmission d'activité</th>
        <th>Type d'offre</th>
        <th>Description du poste</th>
        <th>Expérience souhaité</th>
        <th>Niveau de formation souhaité</th>
        <th>Type d'opportunité recherché</th>
        <th>Expérience dans le milieu agricole</th>
        <th>Niveau de formation</th>


    </tr>

    <tbody>
    @foreach($ads as $ad)
        @if(! isset($ad->project) )
            <tr>
                <td>{{$ad->id}}</td>
                <td>{{$ad->attributionAd->created_at ?? ''}}</td>
                <td>{{$ad->attributionAd->published_on ?? ''}}</td>
                <td>{{$ad->title?: ''}}</td>
                <td>{{$ad->ad_type_full_name?: ''}}</td>
                <td>{{$ad->userPp->name ?? ''}}</td>
                <td>{{$ad->userPp->first_name ?? ''}}</td>
                <td>{{$ad->userPp->civilityFullName ?? ''}}</td>
                <td>{{$ad->userPP->email ?? ''}}</td>
                <td>{{$ad->userPP->phone ?? ''}}</td>
                <td>{{$ad->userPP->zipCode->zip_code ?? ''}}</td>
                <td>
                    @if(! is_null($ad->regionsList))
                        <p>{{$ad->regionsList}}</p>
                    @endif
                </td>
                <td>
                    @if(! is_null($ad->departmentsList))
                        <p>{{$ad->departmentsList}}</p>
                    @endif
                </td>
                <td>
                    @if(! is_null($ad->citiesList))
                        <p>{{$ad->citiesList}}</p>
                    @endif
                </td>
                <td>{{$ad->attributionAd->userModerator->name ?? ''}}</td>
                <td>{{$ad->attributionAd->userModerator->first_name ?? ''}}</td>
                <td>{{utf8_decode($ad->about_project_content) ?: ''}}</td>
                <td>{{utf8_encode($ad->about_content) ?: ''}}</td>
                <td>{{$ad->landOfferAd->surface?? '' }}</td>
                <td>{{$ad->landOfferAd->sau_description?? '' }}</td>
                <td>
                    @if(isset($ad->landOfferAd))
                        @if($ad->landOfferAd->water_access === 1)
                            oui
                        @else
                            non
                        @endif
                    @endif
                </td>
                <td>{{$ad->landOfferAd->water_access_description ??'' }}</td>
                <td>{{$ad->landOfferAd->altitude ??'' }}</td>
                <td>
                    @if(isset($ad->landOfferAd))
                        @if(isset($ad->landOfferAd->productionGenres))
                            {{$ad->landOfferAd->productionGenres->pluck('name')->implode(', ') }}
                        @endif
                    @endif
                </td>
                <td>
                    @if(isset($ad->landOfferAd))
                        @if(isset($ad->landOfferAd->productionGenresPossible))
                            {{$ad->landOfferAd->productionGenresPossible->pluck('name')->implode(', ') ?? '' }}
                        @endif
                    @endif
                </td>
                <td>
                    @if(isset($ad->landOfferAd))
                        @if(isset($ad->landOfferAd->bioCertifications))
                            {{$ad->landOfferAd->bioCertifications->pluck('name')->implode(', ') ?? '' }}
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
                            {{$ad->landOfferAd->offerGenres->pluck('name')->implode(', ')  }}
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
                    @else
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
                <td>
                    @if(isset($ad->landSeekAd))
                        @if($ad->landSeekAd->is_bio === 1)
                            oui
                        @else
                            non
                        @endif
                    @endif
                </td>
                <td>
                    @if(isset($ad->landSeekAd))
                        @if(isset($ad->landSeekAd->offerGenres))
                            {{$ad->landSeekAd->offerGenres->pluck('name')->implode(', ') }}
                        @endif
                    @endif

                </td>
                <td>{{$ad->landSeekAd->installationType->name ?? '' }}</td>
                <td>{{$ad->landSeekAd->experience_farming ?? '' }}</td>
                <td>
                    @if(isset($ad->jobOfferAd))
                        @if($ad->jobOfferAd->is_activity_transmission === 1)
                            oui
                        @else
                            non
                        @endif
                    @endif
                </td>
                <td>
                    @if(isset($ad->jobOfferAd))
                        @if(isset($ad->jobOfferAd->jobOfferTypes))
                            @foreach($ad->jobOfferAd->jobOfferTypes as $offerType)
                                {{$offerType->name}}
                            @endforeach
                        @endif
                    @endif
                </td>
                <td>{{$ad->jobOfferAd->job_description ?? '' }}</td>
                <td>{{$ad->jobOfferAd->experience_farming ?? '' }}</td>
                <td>
                    @if(isset($ad->jobOfferAd))
                        @if(isset($ad->jobOfferAd->educationLevels))
                            {{$ad->jobOfferAd->educationLevels->pluck('name')->implode(', ')}}
                        @endif
                    @endif
                </td>
                <td>
                    @if(isset($ad->jobOfferAd))
                        @if(isset($ad->jobSeekAd->jobOfferTypes))
                            {{$ad->jobSeekAd->jobOfferTypes->pluck('name')->implode(', ') }}
                        @endif
                    @endif
                </td>
                <td>{{$ad->jobSeekAd->experience_farming ?? ""}}</td>
                <td>
                    @if(isset($ad->jobOfferAd))
                        @if(isset($ad->jobSeekAd->educationLevels))
                            {{$ad->jobSeekAd->educationLevels->pluck('name')->implode(', ') }}
                        @endif
                    @endif
                </td>
            </tr>
        @endif
    @endforeach
    </tbody>
</table>
