<dashboard-form-filter
        inline-template
        :old-input-selected="{{json_encode(old())}}"
        :more-filters-open="{{!is_null(old('price_max')) || !is_null(old('price_min')) || !is_null(old('surfaces_research')) || !is_null(old('bio_certifications'))|| !is_null(old('production_genres'))  ? "true" : "false"}}"
>
    <div>
        <div class="columns is-desktop is-vcentered">
            <div class="column ">
                <div class="columns is-desktop is-vcentered">
                    @foreach($adTypes as $i => $adType)
                        <div class="column is-desktop is-vcentered">
                            <custom-checkbox
                                    name="ad_type[]"
                                    input-value="{{$adType['value']}}"
                                    v-model="adTypeSelected"
                                    ref="typeSelected"
                                    value="true"
                                    :is-radio="false">
                                <i class="fa {{ $adTypesFaIcons[$i] }}"
                                   style="font-size: 30px;"></i><br><br>
                                <span style="font-size:16px">
                                    {{$adType['name']}}
                                </span>
                            </custom-checkbox>
                        </div>
                    @endforeach
                </div>
            </div>
            @if(Route::current()->getName() == 'moderator.index' ||  Route::current()->getName() == 'moderator.show')
            @else
                <div class="column is-2">
                    <p class="label has-text-centered">Type</p>
                    <div class="columns is-mobile is-multiline is-centered">
                        <div class="column pr-0 pl-0 is-narrow has-text-centered">
                            <label class="checkbox">
                                <input name="ads_show" value="true"
                                       type="checkbox" {{old('ads_show')  ? ' checked' : '' }}>
                                Annonces
                            </label>
                        </div>
                        <div class="column is-narrow pr-0 pl-0 has-text-centered">
                            <label class="checkbox">
                                @if(Route::current()->getName() == 'advisor.index' )
                                    <input name="projects_show" value="true"
                                           type="checkbox" checked>
                                @else
                                    <input name="projects_show" value="true"
                                           type="checkbox" {{old('projects_show') ? ' checked' : '' }}>
                                @endif

                                Accompagnements
                            </label>
                        </div>

                    </div>
                </div>

            @endif
            @if(Route::current()->getName() == 'moderator.index' ||  Route::current()->getName() == 'moderator.show')
                <div class="column is-one-fifth">
                    <div class="control has-icons-right ">
                        @if(Route::current()->getName() === 'moderator.index' &&  Route::current()->getName() === 'moderator.show')
                            <label class="label"> Date de soumission de l'annonce </label>
                        @else
                            <label class="label"> Date de soumission de la demande </label>
                        @endif
                        <date-range old-value-selected={{old('date-range-selected')}}></date-range>
                    </div>
                </div>
            @else
                <div class="column is-3 ">
                    <div class="columns is-mobile">
                        <div class="column ">
                            <div v-cloak class="field">
                                <label class="label">Localisations (département ou région)</label>
                                <autocomplete
                                        id="localisations"
                                        :placeholder="locations.length ? 'Saisissez une autre localisation' : 'Saisissez au moins 2 caractères pour faire apparaître la liste'"
                                        src="/locations/departments-and-regions"
                                        v-model="locations"
                                        :data-renderer="helper.renderZoneItemData"
                                        :multiple="true">
                                </autocomplete>
                                <div class="selected-zone" v-for="(location,i) in locations">
                                    <span @click="function() { locations.splice(i, 1); }"
                                          data-tooltip="Retirer cette localisation">
                                        <i class="fa fa-trash-alt" style="cursor:pointer;"></i>
                                    </span>
                                    <b>@{{helper.getLabel(location.value.type)}}</b> : @{{location.value.originalLabel}}
                                    <input type="hidden" :name="'locations['+location.value.type+'][]'"
                                           :value="location.value.id" v-if="location.value.id">
                                    <template v-if="location.value.ids">
                                        <input type="hidden"
                                               :name="'locations['+helper.getInputNameRangeMapping(location.value.type)+'][]'"
                                               :value="id" v-for="id in location.value.ids">
                                    </template>
                                    <input type="hidden" name="json_locations" :value="JSON.stringify(locations)">
                                </div>
                            </div>
                        </div>
                        <!--					TODO delete if research by cities is not necessary anymore-->
                        {{--					<div class="column is-half"  v-show="hasCities">--}}
                        {{--						<div class="field">--}}
                        {{--							<p class="label">(Communes) Dans un rayon de </p>--}}
                        {{--							<vue-slider--}}
                        {{--									name="radius_research"--}}
                        {{--									:old-data="{--}}
                        {{--											'value' : {{json_encode(old('radius_research'))}},--}}
                        {{--											'textValue' : {{json_encode(old('radius_research'))}}+'km'--}}
                        {{--											}"--}}
                        {{--									:data="{--}}
                        {{--													0: '0km',--}}
                        {{--													5: '5km',--}}
                        {{--													10: '10km',--}}
                        {{--													20: '20km',--}}
                        {{--													50: '50km'--}}
                        {{--												}"--}}
                        {{--							></vue-slider>--}}
                        {{--							<br>--}}
                        {{--						</div>--}}
                        {{--					</div>--}}
                    </div>
                </div>
                <div class="column is-2">
                    <div class="control has-icons-right ">
                        @if(Route::current()->getName() === 'moderator.index' &&  Route::current()->getName() === 'moderator.show')
                            <label class="label"> Date de soumission de l'annonce </label>
                        @else
                            <label class="label"> Date </label>
                        @endif
                        <date-range old-value-selected={{old('date-range-selected')}}></date-range>
                    </div>
                </div>
            @endif
        </div>
        <hr class="navbar-divider">
        <div class="columns is-desktop is-vcentered ">
            @if(Route::current()->getName() == 'moderator.index' ||  Route::current()->getName() == 'moderator.show')
                <div class="column is-5 ">
                    <div class="columns is-mobile">
                        <div class="column ">
                            <div v-cloak class="field">
                                <label class="label">Localisations (département ou région)</label>
                                <autocomplete
                                        id="localisations"
                                        :placeholder="locations.length ? 'Saisissez une autre localisation' : 'Saisissez au moins 2 caractères pour faire apparaître la liste'"
                                        src="/locations/departments-and-regions"
                                        v-model="locations"
                                        :data-renderer="helper.renderZoneItemData"
                                        :multiple="true">
                                </autocomplete>
                                <div class="selected-zone" v-for="(location,i) in locations">
                                    <span @click="function() { locations.splice(i, 1); }"
                                          data-tooltip="Retirer cette localisation">
                                        <i class="fa fa-trash-alt" style="cursor:pointer;"></i>
                                    </span>
                                    <b>@{{helper.getLabel(location.value.type)}}</b> : @{{location.value.originalLabel}}
                                    <input type="hidden" :name="'locations['+location.value.type+'][]'"
                                           :value="location.value.id" v-if="location.value.id">
                                    <template v-if="location.value.ids">
                                        <input type="hidden"
                                               :name="'locations['+helper.getInputNameRangeMapping(location.value.type)+'][]'"
                                               :value="id" v-for="id in location.value.ids">
                                    </template>
                                    <input type="hidden" name="json_locations" :value="JSON.stringify(locations)">
                                </div>
                            </div>
                        </div>
                        <!--					TODO delete if research by cities is not necessary anymore-->
                        {{--					<div class="column is-half"  v-show="hasCities">--}}
                        {{--						<div class="field">--}}
                        {{--							<p class="label">(Communes) Dans un rayon de </p>--}}
                        {{--							<vue-slider--}}
                        {{--									name="radius_research"--}}
                        {{--									:old-data="{--}}
                        {{--											'value' : {{json_encode(old('radius_research'))}},--}}
                        {{--											'textValue' : {{json_encode(old('radius_research'))}}+'km'--}}
                        {{--											}"--}}
                        {{--									:data="{--}}
                        {{--													0: '0km',--}}
                        {{--													5: '5km',--}}
                        {{--													10: '10km',--}}
                        {{--													20: '20km',--}}
                        {{--													50: '50km'--}}
                        {{--												}"--}}
                        {{--							></vue-slider>--}}
                        {{--							<br>--}}
                        {{--						</div>--}}
                        {{--					</div>--}}
                    </div>
                </div>
                <div class="column is-4 ">
                    <p class="label has-text-centered ">
                        Statut de l'annonce
                    </p>
                    <div class="columns is-mobile is-multiline is-centered">
                        @foreach($adStatuses as $adStatus)
                            <div class="column is-narrow has-text-centered">
                                <label class="checkbox custom-tooltip has-tooltip-multiline has-tooltip-top"
                                       data-tooltip=" {{\App\Models\AdStatus::TOOLTIPS[(int)$adStatus->id]}}"
                                >
                                    <input name="ad_statuses[]" value="{{(int)$adStatus->id}}"
                                           type="checkbox" {{old('ad_statuses') && in_array((int)$adStatus->id,old('ad_statuses'))  ? ' checked' : '' }}>
                                    <span class="icon">
                                        <i class="fas fa-info-circle has-text-info"></i>
                                    </span>
                                    <span>{{$adStatus->name}}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="column ">
                    <label class="label">Recherche par mot clé</label>
                    <input name="ad_keywords" class="input" type="text" placeholder="Votre recherche..."
                           value="{{old('ad_keywords')}}">
                </div>
            @else
                <div class="column ">
                    <p class="label has-text-centered ">
                        Stade dans l'accompagnement
                    </p>
                    <div class="columns is-mobile is-multiline is-centered">
                        @foreach($supportStages as $supportStage)
                            <div class="column is-narrow pl-0 pr-0 has-text-centered">
                                <label class="checkbox custom-tooltip has-tooltip-multiline has-tooltip-top"
                                       data-tooltip=" {{\App\Models\SupportStage::TOOLTIPS[(int)$supportStage->id]}}">
                                    <input name="support_stages[]" value="{{(int)$supportStage->id}}"
                                           type="checkbox"
                                            {{old('support_stages') && in_array((int)$supportStage->id,old('support_stages'))  ? ' checked' : '' }}>
                                    <span class="icon">
                                        <i class="fas fa-info-circle has-text-info"></i>
                                    </span>
                                    <span>{{$supportStage->name}}</span>

                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="column is-3 ">
                    <p class="label has-text-centered  ">
                        État de la demande
                    </p>
                    <div class="columns is-mobile is-multiline is-centered">
                        @foreach($supportStates as $supportState)
                            <div class="column is-narrow pl-0 pr-0 has-text-centered">
                                <label class="checkbox custom-tooltip has-tooltip-multiline has-tooltip-top"
                                       data-tooltip=" {{\App\Models\SupportState::TOOLTIPS[(int)$supportState->id]}}">
                                    <input name="support_states[]" value="{{(int)$supportState->id}}"
                                           type="checkbox"
                                            {{old('support_states') && in_array((int)$supportState->id,old('support_states'))  ? ' checked' : '' }}>
                                    <span class="icon">
                                        <i class="fas fa-info-circle has-text-info"></i>
                                    </span>
                                    <span>{{$supportState->name}}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="column is-3 ">
                    <p class="label has-text-centered">
                        Avancement du projet
                    </p>
                    <div class="columns is-mobile is-multiline is-centered">
                        @foreach($projectStatuses as $projectStatus)
                            <div class="column is-narrow pl-0 pr-0 has-text-centered">
                                <label class="checkbox custom-tooltip has-tooltip-multiline has-tooltip-top"
                                       data-tooltip=" {{\App\Models\ProjectStatus::TOOLTIPS[(int)$projectStatus->id]}}">
                                    <input name="project_statuses[]" value="{{(int)$projectStatus->id}}"
                                           type="checkbox"
                                            {{old('project_statuses') && in_array((int)$projectStatus->id,old('project_statuses'))  ? ' checked' : '' }}>
                                    <span class="icon">
                                        <i class="fas fa-info-circle has-text-info"></i>
                                    </span>
                                    <span>{{$projectStatus->name}}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="column is-2 ">
                    <label class="label">Recherche par mot clé</label>
                    <input name="ad_keywords" class="input" type="text" placeholder="Votre recherche..."
                           value="{{old('ad_keywords')}}">
                </div>

            @endif
            @if(Route::current()->getName() == 'supervisor.index' || Route::current()->getName() == 'supervisor.show')
                <div class="column is-2">
                    <p class="label has-text-centered">Suivi</p>
                    <div class="columns is-mobile is-multiline is-centered">
                        <div class="column is-narrow pl-0 pr-0 has-text-centered">
                            <label class="checkbox">
                                <input name="project_attribution[]" value="true"
                                       type="checkbox" {{old('project_attribution') && in_array('true',old('project_attribution'))  ? ' checked' : '' }}>
                                Attribué
                            </label>
                        </div>
                        <div class="column is-narrow pl-0 pr-0 has-text-centered">
                            <label class="checkbox">
                                @if(Route::current()->getName() == 'supervisor.index' )
                                    <input name="project_attribution[]" value="false" checked
                                           type="checkbox" {{old('project_attribution') && in_array('false',old('project_attribution')) ? ' checked' : '' }}>
                                @else
                                    <input name="project_attribution[]" value="false"
                                           type="checkbox" {{old('project_attribution') && in_array('false',old('project_attribution')) ? ' checked' : '' }}>
                                @endif
                                Non attribué
                            </label>
                        </div>

                    </div>
                </div>
            @endif
            <div class="column is-1 ">
                <br>
                <button type="submit" class="button basic form-button primary ">
                    <span class="icon">
                        <i class="fas fa-filter"></i>
                    </span>
                    <span>Filtrer</span>
                </button>
                <p style="margin-bottom: 10px"></p>
                <a v-on:click='isMoreFiltersOpen = !isMoreFiltersOpen'
                   class=" text_primary has-text-weight-semibold ">
                    Plus de critères
                </a>
                <br>

                @if(Route::current()->getName() == 'moderator.show')
                    <a href="{{route('moderator.index')}}" class="">
                        <span class="icon has-text-danger is-marginless">
                            <i class="fas fa-times"></i>
                        </span>
                        <span class="is-size-6">Réinitialiser</span>
                    </a>
                @elseif (Route::current()->getName() == 'supervisor.show' && !empty(request()->all()))
                    <p style="margin-top: 10px"></p>
                    <a href="{{route('supervisor.show')}}" class=" ">
                        <span class="icon has-text-danger is-marginless">
                            <i class="fas fa-times"></i>
                        </span>
                        <span class="is-size-6">Réinitialiser</span>
                    </a>
                @elseif (Route::current()->getName() === 'advisor.show' && !empty(request()->all()))
                    <p style="margin-top: 10px"></p>
                    <a href="{{route('advisor.show')}}" class="  ">
                        <span class="icon has-text-danger is-marginless ">
                            <i class="fas fa-times"></i>
                        </span>
                        <span class="is-size-6">Réinitialiser</span>
                    </a>
                @endif
            </div>
        </div>
        <hr class="navbar-divider">
        <div v-if="isMoreFiltersOpen">
            <div class="columns pr-20 pl-20 bg-l-pearl">
                <div class="column is-one-third">
                    <div class="field">
                        {{ form::label('price_min', 'Prix minimum', ['class' => 'label']) }}
                        {{ form::number('price_min', '', ['min' => '0', 'pattern' => "([0-9]{1,3}).([0-9]{1,3})", 'class'=>'input', ]) }}
                    </div>
                    <div class="field">
                        {{ form::label('price_max', 'Prix maximum', ['class' => 'label']) }}
                        {{ form::number('price_max', '', ['min' => '0', 'class' => 'input',]) }}
                    </div>
                </div>
                <div class="column is-one-third">
                    <div class="field" style="margin-top: 40px">
                        <p class="label">Surface maximale (ha)</p>
                        <vue-slider
                                name="surfaces_research"
                                :old-data="{
                                        'value' : {{json_encode(old('surfaces_research'))}},
                                        'textValue' : {{json_encode(old('surfaces_research'))}}
                                        }"
                                :data="{
                        0: '0',
                        5: '5',
                        10: '10',
                        20: '20',
                        50: '50',
                        100 : '100',
                        '+100' : '+100',
                    }"
                                :values="['0', '>100']"></vue-slider>
                        <br>
                    </div>
                </div>

                <div class="column">
                    <div class="field">
                        {!! Form::label('production_genres', 'Système de production en place', ['class' => 'label']); !!}
                        <multi-select
                                :options="{{ json_encode($productionGenres) }}"
                                name="production_genres[]"
                                v-model="selectedProductions"
                                selected-count-text="production(s) sélectionné(s)"
                                placeholder="Choississez"
                        >
                        </multi-select>
                    </div>
                    <div class="field">
                        {!! Form::label('bio_certifications', 'Systèmes de production bio ', ['class' => 'label']); !!}
                        <multi-select
                                :options="{{ json_encode($bioCertifications) }}"
                                :multiple="true"
                                name="bio_certifications[]"
                                v-model="selectedBioCertifications"
                                selected-count-text="production(s) bio sélectionné(s)"
                                placeholder="Choississez">
                        </multi-select>
                    </div>
                </div>
            </div>
        </div>

    </div>
</dashboard-form-filter>
