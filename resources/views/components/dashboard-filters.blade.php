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
				{{--							<div class="columns">--}}
				{{--								<div class="column">--}}
				{{--									<div @click="adTypeSelected('landOfferAd')"--}}
				{{--										 class="button is-link is-fullwidth form-research-buttons">--}}
				{{--											<span class="icon is-small  ">--}}
				{{--												  <i class="fas fa-check"></i>--}}
				{{--										</span>--}}
				{{--										<span>Offre foncière</span>--}}
				{{--									</div>--}}
				{{--								</div>--}}
				{{--								<div class="column">--}}
				{{--									<div @click="adTypeSelected('landSeekAd')"--}}
				{{--										 class="button is-link is-light is-fullwidth form-research-buttons">--}}
				{{--											<span class="icon is-small is-hidden ">--}}
				{{--												  <i class="fas fa-check"></i>--}}
				{{--										</span>--}}
				{{--										<span>Recherche foncière</span>--}}
				{{--									</div>--}}
				{{--								</div>--}}
				{{--								<div class="column">--}}
				{{--									<div @click="adTypeSelected('jobOfferAd')"--}}
				{{--										 class="button is-link is-light is-fullwidth form-research-buttons">--}}
				{{--											<span class="icon is-small is-hidden ">--}}
				{{--												  <i class="fas fa-check"></i>--}}
				{{--										</span>--}}
				{{--										<span>Offre d'emploi</span>--}}
				{{--									</div>--}}
				{{--								</div>--}}
				{{--								<div class="column">--}}
				{{--									<div @click="adTypeSelected('jobSeekAd')"--}}
				{{--										 class="button is-link is-light is-fullwidth form-research-buttons">--}}
				{{--											<span class="icon is-small is-hidden ">--}}
				{{--												  <i class="fas fa-check"></i>--}}
				{{--										</span>--}}
				{{--										<span>Recherche d'emploi</span>--}}
				{{--									</div>--}}
				{{--								</div>--}}
				{{--							</div>--}}
			</div>
			{{--						<input type="hidden" v-bind:value="typeSelected" name="ad_type">--}}
			<div class="column">
				<div class="control has-icons-right ">
					<label class="label"> Annonces soumises depuis le </label>
					<date-picker
							old-value= {{old('date_research_range')}}
					></date-picker>
				</div>
			</div>
		</div>
		<div class="columns">
			<div class="column is-one-third">
				<div class="columns">
					<div class="column is-half">
						<div class="field">
							<label class="label">Commune ou Code postal</label>
							<autocomplete
									name="citySelect"
									id="citySelect"
									placeholder="Saisissez les premiers caractères"
									ref='citySelect'
									src="/locations/cities"
									v-model="citySelect">

								<input type="hidden" name="city_location_researches" :value="zone.value.id"
									   v-for="(zone,i) in citySelect">

								<div class="tag autocomplete-input-tag is-info"
									 v-for="(zone,i) in citySelect"
									 @click="_ => citySelect.splice(i,1)">
									@{{ zone.label }}
									&nbsp;&nbsp;
									<i class="fa fa-trash" style="cursor:pointer"></i>
								</div>
							</autocomplete>
						</div>
					</div>
					<div class="column">
						<div class="field">
							<p class="label">Dans un rayon de </p>
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
			<div class="is-divider-vertical" data-content="OU"></div>
			<div class="column is-one-third">
				<label class="label">Départements</label>
				<multi-select
						:options="{{ json_encode($departments) }}"
						:multiple="true"
						v-model="departmentsSelected"
						name="departments_location_researches[]"
						selected-count-text="département(s) sélectionné(s)"
						placeholder="Choississez un/des département(s)">
				</multi-select>
			</div>
			<div class="is-divider-vertical" data-content="OU"></div>
			<div class="column ">
				<label class="label">Régions</label>
				<multi-select
						:options="{{ json_encode($regions) }}"
						:multiple="true"
						v-model="regionsSelected"
						name="regions_location_researches[]"
						selected-count-text="département(s) sélectionné(s)"
						placeholder="Choississez un/des département(s)">
				</multi-select>
			</div>
		</div>
		<hr class="navbar-divider">
		@if(auth()->user()->role === 1 )
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
		@else
			<div class="columns">
				<div class="column is-half">
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
				<div class="column is-half">
					<p class="label has-text-centered">Statut du projet</p>
					<div class="columns  is-mobile is-multiline is-centered">
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
			</div>
			<hr class="navbar-divider">
			<div class="columns">
				<div class=" column is-one-third ">
					<label class="label">Recherche par titre de l'annonce</label>
					<input name="ad_title" class="input" type="text" placeholder="Votre recherche..."
						   value="{{old('ad_title')}}">
				</div>
				{{--						<div v-if="adType === 'land'" class=" column is-3">--}}
				{{--							<label class="label">Système de production</label>--}}
				{{--							<div class="select">--}}
				{{--								<select name="production_genres">--}}
				{{--									@foreach($productionGenres as $productionGenre)--}}
				{{--										<option value="{{$productionGenre->id}}">{{$productionGenre->name}} </option>--}}
				{{--									@endforeach--}}
				{{--								</select>--}}
				{{--							</div>--}}
				{{--						</div>--}}
				{{--						<div v-if="adType === 'land'" class="column is-4">--}}
				{{--							<div class="field">--}}
				{{--								<p class="label">Surface(en ha) </p>--}}
				{{--								<vue-slider-range--}}
				{{--										name-min="land_seek[surface_range_min]"--}}
				{{--										name-max="land_seek[surface_range_max]"--}}
				{{--										:data="{--}}
				{{--													0: '0 ha',--}}
				{{--													5: '5 ha',--}}
				{{--													10: '10 ha',--}}
				{{--													20: '20 ha',--}}
				{{--													50: '50 ha'--}}
				{{--												}"--}}
				{{--										:value="0"--}}
				{{--								></vue-slider-range>--}}
				{{--							</div>--}}
				{{--						</div>--}}
				{{--						<div v-if="adType === 'job'" class="column is-4 has-text-center">--}}
				{{--							<label class="label">Statut de l'emploi</label>--}}
				{{--							<div class="select">--}}
				{{--								<select name="projectStatus">--}}
				{{--									@foreach($jobOfferTypes as $jobOfferType)--}}
				{{--										<option value="{{$jobOfferType->id}}">{{$jobOfferType->name}} </option>--}}
				{{--									@endforeach--}}
				{{--								</select>--}}
				{{--							</div>--}}
				{{--						</div>--}}
				<div class="column  ">
					<button type="submit" class="button is-link is-large is-pulled-right">
						<span>Filtrer</span>
					</button>
				</div>
			</div>
		@endif
	</div>
</dashboard-form-filter>