<div class="column is-full-mobile is-half-tablet is-one-third-desktop">
	<div class="field">
		<label class="label">Choississez un départments</label>
		<multi-select
				:options="{{ json_encode($departments) }}"
				:multiple="true"
				v-model = "selectedDepartments"
				name="departments_location_researches_ids[]"
				selected-count-text="département(s) sélectionné(s)"
				placeholder="Choississez un/des département(s)">
		</multi-select>
	</div>
	<div class="is-divider" data-content="OU"></div>
	<div class="field">
		{!! Form::label('cities', 'Choisissez une ville', ['class' => 'label']); !!}
		<ajax-multi-select
				:multiple="true"
				selected-count-text="ville sélectionnée"
				placeholder="Choississez une ville"
				name-option-label="villes"
				src="/locations/cities"
				name="cities_location_researches_ids[]"
				>
		</ajax-multi-select>
	</div>
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

