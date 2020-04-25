<dashboard-form-filter
		inline-template
		:old-input-selected="{{json_encode(old())}}"
>
	<div>
		<div class="columns">
			<div class="column ">
				<div class="columns">
					@foreach($adTypes as $i => $adType)
						<div class="column">
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
			@endif
		</div>
		<hr class="navbar-divider">
		<div class="columns ">
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
					<p class="label has-text-centered">Statut de l'annonce</p>
					<div class="columns is-mobile is-multiline is-centered">
						@foreach($adStatuses as $adStatus)
							<div class="column is-narrow has-text-centered">
								<label class="checkbox">
									<input name="ad_statuses[]" value="{{(int)$adStatus->id}}"
										   type="checkbox" {{old('ad_statuses') && in_array((int)$adStatus->id,old('ad_statuses'))  ? ' checked' : '' }}>
									{{$adStatus->name}}
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
				<div class="column ">
					<p class="label has-text-centered">Statut du projet</p>
					<div class="columns is-mobile is-multiline is-centered">
						@foreach($projectStatuses as $projectStatus)
							<div class="column is-narrow has-text-centered">
								<label class="checkbox">
									<input name="project_statuses[]" value="{{(int)$projectStatus->id}}"
										   type="checkbox"
											{{old('project_statuses') && in_array((int)$projectStatus->id,old('project_statuses'))  ? ' checked' : '' }}>
									{{$projectStatus->name}}
								</label>
							</div>
						@endforeach
					</div>
				</div>
				<div class="column is-3 ">
					<label class="label">Recherche par mot clé</label>
					<input name="ad_keywords" class="input" type="text" placeholder="Votre recherche..."
						   value="{{old('ad_keywords')}}">
				</div>
			@endif
			<div class="column is-1">
				<br>
				<button type="submit" class="button is-link is-large ">
					<span>Filtrer</span>
				</button>
				<br>
				@if(Route::current()->getName() == 'moderator.show')
					<a href="{{route('moderator.index')}}" class="">
						<span class="icon has-text-danger is-marginless">
  							<i class="fas fa-times"></i>
						</span>
						<span class="is-size-6">Réinitialiser</span>
					</a>
				@elseif (Route::current()->getName() == 'supervisor.show')
					<a href="{{route('supervisor.index')}}" class=" ">
						<span class="icon has-text-danger is-marginless">
  							<i class="fas fa-times"></i>
						</span>
						<span class="is-size-6">Réinitialiser</span>
					</a>
				@elseif (Route::current()->getName() == 'advisor.show')
					<a href="{{route('advisor.index')}}" class="  ">
						<span class="icon has-text-danger is-marginless ">
  							<i class="fas fa-times"></i>
						</span>
						<span class="is-size-6">Réinitialiser</span>
					</a>
				@endif
			</div>
		</div>
		<hr class="navbar-divider">
	</div>
</dashboard-form-filter>
