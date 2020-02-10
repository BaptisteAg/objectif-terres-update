<div class="column">
	<div class="field">
		{!! Form::label('departments', 'Choisissez un département', ['class' => 'label']); !!}
		<multi-select
				:data="{{ json_encode($departments) }}"
				:multiple="true"
				name="departments_location_researches[]"
				selected-count-text="département(s) sélectionné(s)"
				placeholder="Choississez un/des département(s)">
		</multi-select>
	</div>
	<p class="has-text-centered">ou</p>
	<div class="field">
		{!! Form::label('cities', 'Choisissez une ville', ['class' => 'label']); !!}
		<ajax-multi-select
				:multiple="true"
				selected-count-text="ville sélectionnée"
				placeholder="Choississez un département"
				name-option-label="villes"
				src="/json/cities"
				name="cities_location_researches[]">
		</ajax-multi-select>
	</div>
	<div class="field">
		<p class="label">Dans un rayon de </p>
		<vue-slider
				name="radius_research"
                :data="{
                    0: '0km',
                    5: '5km',
                    10: '10km',
                    20: '20km',
                    50: '50km'
                }"
		></vue-slider>
	</div>
</div>

