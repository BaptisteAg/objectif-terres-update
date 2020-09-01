<div class="card-content ">
    <h4 class="title is-4 has-text-centered">{{$ad->title ?? ""}}</h4>
    <div class="columns is-desktop is-vcentered">
        <div class="column is-three-fifths ">
            <div id="slider-container">
                <div id="support-request-dashboard-ad-images" class="carousel">
                    @if($ad->hasImages)
                        @foreach($ad->images as $document)
                            <div class="card">
                                <div class="card-image">
                                    <figure class="image ">
                                        @if($document->path === "0")
                                            <img class="custom-carousel-image-size" src="https://picsum.photos/480/320"
                                                 alt="picsum">
                                        @else
                                            <img class="custom-carousel-image-size"
                                                 data-source="{{URL::asset($document->path)}}"
                                                 src="{{URL::asset($document->path)}}" style="cursor : pointer;"
                                                 alt="Placeholder image">
                                        @endif
                                    </figure>
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
            <div id="image-extended-container" class="overlay">
                <img id="image-extended" src="/images/placeholder-ad.png">
            </div>
        </div>
        <div class="column">
            <div class="content">
                @if(isset($ad->is_partner) && $ad->is_partner === 1 )
                    <p class="custom-tags">
                        <span class="custom-tag warning">Partenaire Terre de Liens</span>
                    </p>
                @endif
                <p><span class="is-italic">Date de soumission</span>
                    : {{$ad->submitDate ?? "Non renseignée"}} </p>
                <p><span class="is-italic">Catégorie</span>
                    : {{$ad->ad_type_full_name ?? "Non renseignée"}} </p>
                @if(isset($ad->support_request_territory_id))
                    <p>
                        <span class="is-italic">Territoire </span>
                        : {{$ad->supportRequestTerritoryId->name}}
                    </p>
                @endif
                @if(isset($ad->landOfferAd))
                    <p><span class="is-italic">Localisations</span>:
                @else
                    <p><span class="is-italic">Zone de recherche</span> :
                        @endif
                        {{$ad->citiesList ?? ""}}
                        {{$ad->departmentsList ?? ""}}
                        {{$ad->regionsList ?? ""}}
                        @if (is_null($ad->citiesList) and is_null($ad->departmentsList) and is_null($ad->regionsList)   )
                            Non renseignée
                        @endif
                    </p>
                    @if(isset($ad->landSeekAd))
                        @if($ad->locationable_radius)
                            <p>
                                <span class="is-italic">Dans un rayon de (en km)</span>: {{$ad->locationable_radius }}
                            </p>
                        @endif
                    @endif

                    @if(isset($ad->landOfferAd))
                        <p><span class="is-italic">Surface (en ha)</span> :
                            {{$ad->landOfferAd->surface ?? "Non renseignée"}}
                        </p>
                        @if ($ad->landOfferAd->offerGenres->count() > 0)
                            <p>
                                <span class="is-italic">Type d'offre : </span>
                                {{$ad->landOfferAd->offerGenres->pluck('name')->implode(', ') }}
                            </p>
                        @endif
                    @elseif(isset($ad->landSeekAd))
                        <p><span class="is-italic">Surface recherchée (en ha)</span> :
                            @if(isset($ad->landSeekAd->surface_range_min) and isset($ad->landSeekAd->surface_range_max))
                                Entre {{$ad->landSeekAd->surface_range_min}}
                                et {{$ad->landSeekAd->surface_range_max}}
                            @elseif(isset($ad->landSeekAd->surface_range_min))
                                {{$ad->landSeekAd->surface_range_min}}
                            @elseif(isset($ad->landSeekAd->surface_range_max))
                                {{$ad->landSeekAd->surface_range_max}}
                            @else
                                Non renseignée
                            @endif
                        </p>
                    @endif
            </div>
        </div>
    </div>
    <div class="content mt-40">
        @if(isset($ad->landOfferAd))
            <div class="columns">
                <div class="column is-3">
                    @if(! is_null($ad->landOfferAd->price))
                        <p><span class="is-italic">Prix (en € ) </span> :
                            {{$ad->landOfferAd->price ?  number_format($ad->landOfferAd->price, 0, ",", " " ): "Non renseignée"}}
                        </p>
                    @endif
                    @if(! is_null($ad->landOfferAd->rent_price))
                        <p><span class="is-italic">Loyer (en € )</span> :
                            {{$ad->landOfferAd->rent_price ?  number_format($ad->landOfferAd->rent_price, 0, ",", " " ): "Non renseigné"}}
                        </p>
                    @endif
                </div>
                <div class="column is-3">
                    <p><span class="is-italic">Altitude (en m)</span> :
                        {{$ad->landOfferAd->altitude ?? "Non renseignée"}}
                    </p>
                </div>
            </div>
            @if($ad->landOfferAd->has_buildings)
                @if($ad->landOfferAd->buildings_description)
                    <p>
                        <span class="is-italic"></span>Description bâtiment(s) agricole(s) :
                        {{$ad->landOfferAd->buildings_description}}

                    </p>
                @endif
            @endif
            @if($ad->landOfferAd->has_houses)
                @if($ad->landOfferAd->has_houses)
                    <p>
                        <span class="is-italic"></span>Description habitation(s) :
                        {{$ad->landOfferAd->houses_description}}

                    </p>
                @endif
            @endif
            <p>
                <span class="is-italic">Bâtiments</span> :
            @if(isset($ad->landOfferAd->has_houses) and isset($ad->landOfferAd->has_buildings))
                <ul>
                    @if(isset($ad->landOfferAd->has_houses))
                        <li>{{$ad->landOfferAd->has_houses ? 'Avec habitation' : 'Sans habitation'}}</li>
                    @endif
                    @if(isset($ad->landOfferAd->has_buildings))
                        <li>{{$ad->landOfferAd->has_buildings ? ' Avec bâtiments agricoles' : 'Sans bâtiments agricoles'}}</li>
                    @endif
                </ul>
            @else
                <span>Non renseignés</span>
            @endif
            <p>
                <span class="is-italic">Transfert d'activité</span> :
                @if($ad->landOfferAd->is_activity_transfert)
                    @if($ad->landOfferAd->is_activity_transfert == 1)
                        Oui
                    @else
                        Non
                    @endif
                @else
                    Non renseigné
                @endif
            </p>
            <p>
                <span class="is-italic">Accès à l'eau existant</span> :
                {{$ad->waterAccess}}
            </p>
            @if(isset($ad->landOfferAd->water_access_description))
                <p>
                    <span class="is-italic">Description accès eau</span> :
                    {{$ad->landOfferAd->water_access_description}}
                </p>
            @endif
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
                <span class="is-italic">Certification bio des terres : </span>
                <br>
                @foreach($ad->landOfferAd->bioCertifications as $bioCertification)
                    @if(!$bioCertification->icon == "")
                        <span class=" has-tooltip-bottom" style="margin-right: 5px; margin-left: 5px"
                              data-tooltip="{{$bioCertification->name}}">
                            <img src="{{ $bioCertification->icon }}" alt="{{$bioCertification->name}}">
                        </span>
                    @else
                        <span>{{$bioCertification->name}}</span>
        @endif
        @endforeach
        <p>
            <span class="is-italic">Description SAU : </span>{{$ad->landOfferAd->sau_description?? "Non renseigné"}}
        </p>
        @endif
        @if(isset($ad->landSeekAd))
            <p>
                <span class="is-italic">Bâtiments recherchés</span> :
                @if($ad->landSeekAd->buildings->count() >0)
                    @foreach($ad->landSeekAd->buildings as $building)
                        <span class="is-lowercase">{{ $building->buildingType->label }}
                            : {{ $building->requirement->label }}</span>
                        {{ $loop->last ? '': ',' }}
                    @endforeach
                @else
                    Non renseignés
                @endif
            </p>
            <p>
                <span class="is-italic">Accès au foncier </span> :
                @if($ad->landSeekAd->offerGenres->count() >0)
                    @foreach($ad->landSeekAd->offerGenres as $offerGenres)
                        <span>{{ $offerGenres->name }}</span>
                        {{ $loop->last ? '': ',' }}
                    @endforeach
                @else
                    Non renseignés
                @endif
            </p>

            <p>
                <span class="is-italic">Budget maximum</span> :
                @if(isset($ad->landSeekAd->price_max))
                    @if($ad->landSeekAd->price_max > 300000)
                        Plus de 300 000 €
                    @else
                        Jusqu'à {{number_format($ad->landSeekAd->price_max, 2, ',', ' ')}} €
                    @endif
                @elseif(isset($ad->landSeekAd->rent_max))
                    Jusqu'à {{number_format($ad->landSeekAd->rent_max, 2, ',', ' ')}} €/mois
                @else
                    Non renseigné
                @endif
            </p>
            <p>
                <span class="is-italic">Projet en AB</span> :
                @if(isset($ad->landSeekAd->is_bio))
                    {{$ad->landSeekAd->is_bio ? 'Oui' : 'Non'}}
                @else
                    Ne sais pas
                @endif
            </p>
            <p>
                <span class="is-italic">Productions envisagées</span> :
                @if($ad->landSeekAd->productionGenres->count() > 0)
                    {{$ad->landSeekAd->productionGenres->pluck('name')->implode(', ') }}
                @else
                    Non renseignées
                @endif
            </p>
            <p>
                <span class="is-italic">Type d'installation</span> :
                {{$ad->landSeekAd->installationType->name ?? 'Non renseigné'}}
            </p>

        @endif
        <p>
            <span class="is-italic">Plus d'informations sur le projet
                : </span>{{$ad->about_project_content?? "Non renseigné"}}
        </p>
    </div>
    <div class="is-divider"></div>
    <div class="column">
        {!! Form::open(['route' => 'advisor.updateProjectDataKeysValues', 'method'=>'post']) !!}
        <div class="content">
            <p class="has-text-centered title is-5">Indicateurs concernant cette demande</p>
        </div>
        @foreach($publicProjectDataKeys as $publicProjectDataKey)
            <div class="columns">
                <div class="column is-one-third">
                    <p>{{$publicProjectDataKey->name}}</p>
                </div>
                <div class="column">
                    @php
                        $currentProjectData = $currentProjectKeyDataValues->where('project_data_key_id',$publicProjectDataKey->id)->first();
                    @endphp

                    @if(!is_null($currentProjectData))
                        @if($publicProjectDataKey->projectDataValues->count() >0)
                            <div class="select is-fullwidth">
                                <select {{$ad->userPp->trashed()? 'disabled' : ''}} name="project_data_key[{{$publicProjectDataKey->id}}]">
                                    <option selected disabled>Veuillez choisir...</option>
                                    @foreach ($publicProjectDataKey->projectDataValues as $projectDataValue)
                                        @if(isset($currentProjectData->projectDataValue))
                                            @if($projectDataValue->id === $currentProjectData->projectDataValue->id)
                                                <option selected value="{{$projectDataValue->value}}">
                                                    {{$projectDataValue->value}}
                                                </option>
                                            @else
                                                <option value="{{$projectDataValue->value}}">{{$projectDataValue->value}}</option>
                                            @endif
                                        @else
                                            <option value="{{$projectDataValue->value}}">{{$projectDataValue->value}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <input {{$ad->userPp->trashed()? 'disabled' : ''}} name="project_data_key[{{$publicProjectDataKey->id}}]"
                                   class="input" type="text"
                                   value="{{$currentProjectKeyDataValues->where('project_data_key_id',$publicProjectDataKey->id  )->first()->value}}"
                                   placeholder="Saisir...">
                        @endif
                    @else
                        @if($publicProjectDataKey->projectDataValues->count() >0)
                            <div class="select  is-fullwidth">
                                <select {{$ad->userPp->trashed()? 'disabled' : ''}} name="project_data_key[{{$publicProjectDataKey->id}}]">
                                    <option selected disabled>Veuillez choisir...</option>
                                    @foreach ($publicProjectDataKey->projectDataValues as $projectDataValue)
                                        <option value="{{$projectDataValue->value}}">{{$projectDataValue->value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <input {{$ad->userPp->trashed()? 'disabled' : ''}} name="project_data_key[{{$publicProjectDataKey->id}}]"
                                   class="input" type="text"
                                   placeholder="Saisir...">
                        @endif
                    @endif
                </div>
            </div>
        @endforeach

        <div class="control">
            <input type="hidden" name="ad_id" value="{{$ad->id}}">
            <input type="hidden" name="user_id" value="{{auth()->id()}}">
            <button {{$ad->userPp->trashed()? 'disabled' : ''}} class="button is-link">
                <span class="icon is-small">
                    <i class="fas fa-save"></i>
                </span>
                <span>Sauvegarder</span>
            </button>
        </div>
        {!! Form::close() !!}
    </div>
</div>