<div class="columns is-mobile is-multiline">
	@include('layouts.partials.headerResearchLocation')
	<div class="column is-full-mobile is-half-tablet is-one-third-desktop">
		<div class="field is-flex">
			@foreach ($offerGenres as $offerGenre)
				<label class="checkbox">
					<input type="checkbox" name="offer_genres[]"
						   value="{{$offerGenre->id}}" {{old('offer_genres') && in_array($offerGenre->id,old('offer_genres'))  ? ' checked' : '' }}>
					{{$offerGenre->name}}
				</label>
			@endforeach
		</div>
		<div class="field">
			<p class="label">Surface (ha)</p>
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
		<div v-if="offerTypeSelected === 'OfferAd'" class="field">
			{{ form::label('price_min', 'Prix minimum', ['class' => 'label']) }}
			{{ form::number('price_min', '', ['min' => '0', 'pattern' => "([0-9]{1,3}).([0-9]{1,3})", 'class'=>'input', ]) }}
			{{ form::label('price_max', 'Prix maximum', ['class' => 'label']) }}
			{{ form::number('price_max', '', ['min' => '0', 'class' => 'input',]) }}
		</div>

	</div>
	<div class="column if-full-mobile is-one-third-desktop" v-if="offerTypeSelected === 'OfferAd'">
        <div class="field is-flex">
            <label class="checkbox">
                <input type="checkbox" name="has_pics" value="1" {{ old('has_pics') === "1" ? ' checked' : '' }}>
                Avec photos
            </label>
            <label class="checkbox">
                <input type="checkbox" name="has_buildings"
                       value="1" {{ old('has_buildings') === "1" ? ' checked' : '' }}>
                Habitation
            </label>
        </div>

        <div class="field">
            {!! Form::label('production_genres', 'Choisissez des types de production', ['class' => 'label']); !!}
            <multi-select
                    :options="{{ json_encode($productionGenres) }}"
                    v-model="selectedProductions"
                    name="production_genres[]"
                    selected-count-text="production(s) sélectionné(s)"
                    placeholder="Choississez">
            </multi-select>
        </div>
        <div class="field">
            {!! Form::label('bio_certification', 'Choisissez des systèmes de production bio ou aucun', ['class' => 'label']); !!}
            <multi-select
                    :options="{{ json_encode($bioCertifications) }}"
                    :multiple="true"
                    v-model="selectedBioCertifications"
                    name="bio_certifications[]"
                    selected-count-text="production(s) bio sélectionné(s)"
                    placeholder="Choississez">
            </multi-select>
        </div>
    </div>
</div>

