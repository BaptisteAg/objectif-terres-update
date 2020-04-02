<dashboard-form-filter
		inline-template
		:old-input-selected="{{json_encode(old())}}"
>
	<div>
		<div class="columns">
			<div class="column is-four-fifths">
				<div class="columns">
					<?php
					$adTypes = [
						['name' => 'Offre foncière', 'value' => 'landOfferAd'],
						['name' => 'Recherche foncière', 'value' => 'landSeekAd'],
						['name' => 'Offre d\'emploi', 'value' => 'jobOfferAd'],
						['name' => 'Recherche d\'emploi', 'value' => 'jobSeekAd'],
					];
					$adTypesFaIcons = ["fa-home", "fa-home", "fa-universal-access", "fa-universal-access"]
					?>
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
			<div class="column">
				<div class="control has-icons-right ">
					<label class="label"> Annonces soumises depuis le </label>
					<date-picker
							old-value= {{old('date_research_range')}}
					></date-picker>
				</div>
			</div>
		</div>
		<hr class="navbar-divider">
		<div class="columns is-mobile">
			<div class="column is-5 ">
				<div class="columns is-mobile">
					<div class="column ">
						<div class="field">
							<label class="label">Localisations (code postal, département, région)</label>
							<autocomplete
									id="localisations"
									:placeholder="locations.length ? 'Saisissez une autre localisation' : 'Saisissez au moins 2 caractères pour faire apparaître la liste'"
									src="/locations"
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
					<div class="column is-half"  v-show="hasCities">
						<div class="field">
							<p class="label">(Communes) Dans un rayon de </p>
							<vue-slider
									name="radius_research"
									:old-data="{
											'value' : {{json_encode(old('radius_research'))}},
											'textValue' : {{json_encode(old('radius_research'))}}+'km'
											}"
									:data="{
													0: '0km',
													5: '5km',
													10: '10km',
													20: '20km',
													50: '50km'
												}"
							></vue-slider>
							<br>
						</div>
					</div>
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
				<input name="ad_title" class="input" type="text" placeholder="Votre recherche..."
					   value="{{old('ad_title')}}">
			</div>
			<div class="column is-1  ">
				<br>
				<button type="submit" class="button is-link is-large is-pulled-right">
					<span>Filtrer</span>
				</button>
			</div>

			{{--			<div class="is-divider-vertical" data-content="OU"></div>--}}
			{{--			<div class="column is-one-third">--}}
			{{--				<label class="label">Départements</label>--}}
			{{--				<multi-select--}}
			{{--						:options="{{ json_encode($departments) }}"--}}
			{{--						:multiple="true"--}}
			{{--						v-model="departmentsSelected"--}}
			{{--						name="departments_location_researches[]"--}}
			{{--						selected-count-text="département(s) sélectionné(s)"--}}
			{{--						placeholder="Choississez un/des département(s)">--}}
			{{--				</multi-select>--}}
			{{--			</div>--}}
			{{--			@if(Route::current()->getName() == 'moderator.index' &&  Route::current()->getName() != 'moderator.show')--}}
			{{--				<div class="is-divider-vertical" data-content="OU"></div>--}}
			{{--				<div class="column is-one-quarter">--}}
			{{--					<label class="label">Régions</label>--}}
			{{--					<multi-select--}}
			{{--							:options="{{ json_encode($regions) }}"--}}
			{{--							:multiple="true"--}}
			{{--							v-model="regionsSelected"--}}
			{{--							name="regions_location_researches[]"--}}
			{{--							selected-count-text="département(s) sélectionné(s)"--}}
			{{--							placeholder="Choississez un/des département(s)">--}}
			{{--					</multi-select>--}}
			{{--				</div>--}}
			{{--			@endif--}}
		</div>
		<hr class="navbar-divider">
		@if(Route::current()->getName() != 'moderator.index' &&  Route::current()->getName() != 'moderator.show')
			<div class="columns">
				<div class="column is-half">
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
				<div class=" column is-one-third ">
					<label class="label">Recherche par titre de l'annonce</label>
					<input name="ad_title" class="input" type="text" placeholder="Votre recherche..."
						   value="{{old('ad_title')}}">
				</div>
				<div class="column">
					<br>
					<button type="submit" class="button is-link is-large is-pulled-right ">
						<span>Filtrer</span>
					</button>
				</div>
			</div>
			<hr class="navbar-divider">
		@endif
	</div>
</dashboard-form-filter>