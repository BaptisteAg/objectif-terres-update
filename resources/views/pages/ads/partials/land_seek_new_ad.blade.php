<div id="land_seek_form">
	<p class="is-size-7">Les champs marqués d'un astérisque (*) sont obligatoires</p>
	<div class="field">
		{!! Form::label('land_seek[installation_type_id]', 'Type d\'installation*', ['class' => 'label']); !!}
		<div class="select">
			{!! Form::select('land_seek[installation_type_id]',
				 $installationTypes->pluck('name', 'id'),
				 old('land_seek[installation_type]'),
				 ['placeholder' => 'Choisir un type d\'installation...',
				 "v-model.trim.lazy"=>"formInput.installationType",
				 ':disabled' => 'isInputDisabled']); !!}
		</div>
		<p class="help is-danger" v-show="!$v.formInput.installationType.required">Ce champs est requis.</p>
	</div>
	<div class="columns">
		<div class=" column is-one-quarter">
			<div class="field">
				{!! Form::label('land_seek[city]', 'Commune ou Code postal*', ['class' => 'label']); !!}
				{!! Form::text('land_seek[city]',
						old('land_seek[city]'),
						['class' => 'input',
						 'required',
						 ':disabled' => 'isInputDisabled']) !!}
			</div>
		</div>
		<div class="column ">
			<p class="label">Dans un rayon de </p>

			@foreach ($cityRanges as $cityRange)
				{!! Form::checkbox('land_seek[city_range][]', $cityRange,  old('land_seek[city_range][]'), [':disabled'=>'isInputDisabled']) !!}
				{{$cityRange}}
			@endforeach

		</div>
		<div class="column">
			<div class="field">
				{!! Form::label('land_seek[regions][]', 'Régions', ['class' => 'label']); !!}
				<div class="select">
					{!! Form::select('land_seek[regions][]',
							 $regions->pluck('name', 'id'),
							 old('land_seek[region]'),
							 ['placeholder' => 'Veuillez choisir...',
							  ':disabled' => 'isInputDisabled']); !!}
				</div>
			</div>
		</div>
		<div class="column">
			<div class="field">
				{!! Form::label('land_seek[departments][]', 'Départements', ['class' => 'label']); !!}
				{!! Form::text('land_seek[departments][]',
					 old('land_seek[departments]'),
					['class' => 'input',
					':disabled' => 'isInputDisabled']) !!}
			</div>
		</div>
	</div>
	<div class="field">
		{!! Form::label('land_seek[is_bio]', 'Je souhaite m\'installer en bio', ['class' => 'label']) !!}
		{!! Form::radio('land_seek[is_bio]', 'true',old('land_seek[is_bio]'), [':disabled' => 'isInputDisabled']) !!}
		oui
		{!! Form::radio('land_seek[is_bio]', 'false', old('land_seek[is_bio]'), [':disabled' => 'isInputDisabled']) !!}
		non
	</div>
	<div class="field">
		{!! Form::label('land_seek[surface_range][]', 'Surface recherchée(en ha)', ['class' => 'label']); !!}
		@foreach ($surfaceRanges->pluck('surface', 'id') as $id => $surface)
			{!! Form::checkbox(
				'land_seek[surface_range][]',
				$id,
				[
					':disabled' => 'isInputDisabled'
				]
			) !!}
			{{$surface}}
		@endforeach
	</div>
	<div class="field">
		{!! Form::label('land_seek[production_genre][]', 'Production(s) envisagée(s)*', ['class' => 'label']); !!}

		@foreach ($productionGenres->pluck('name', 'id') as $id => $productionGenre)
			{!! Form::checkbox(
			'land_seek[production_genre][]',
			$id,
			old('land_seek[production_genre][]'),
			[
			':disabled' => 'isInputDisabled',
			'v-model'=>'formInput.productionGenre',
			]) !!}
			{{$productionGenre}}
		@endforeach
		{!! Form::checkbox('land_seek[production_genre][]',
		'other',
		old('land_seek[production_genre]'),
		[':disabled' => 'isInputDisabled',
		'v-model'=>'isProductionGenreOther',
		'v-model.trim.lazy'=>'formInput.productionGenre']) !!}
		Autre
		<p class="help is-danger" v-show="!$v.formInput.productionGenre.required">Ce champs est requis.</p>
	</div>

	<div class="field" v-show="isProductionGenreOther">
		{!! Form::label('land_seek[other_production_genre]', 'Veuillez préciser', ['class' => 'label']); !!}
		{!! Form::text('land_seek[other_production_genre]',
				 old('land_seek[other_production_genre]'),
				  ['class' => 'input',
				  ':disabled' => 'isInputDisabled']) !!}
	</div>
	<div class="field">
		{!! Form::label('land_seek[land_seek_building][]', 'Habitation(s) et bâti(s)', ['class' => 'label']); !!}
		{!! Form::checkbox('land_seek[building][]', 'has_houses', old('land_seek[building[]]'), [':disabled' => 'isInputDisabled']) !!}
		Avec une maison d'habitation existante
		{!! Form::checkbox('land_seek[building][]', 'has_farm_building', old('land_seek[building[]]'), [':disabled' => 'isInputDisabled']) !!}
		Avec des bâtis agricoles existants
	</div>
	<div class="field">
		{!! Form::label('land_seek[offer_genre]', 'Accès au foncier souhaité', ['class' => 'label']); !!}
		<div class="select">
			{!! Form::select('land_seek[offer_genre]',
					 $offerGenresLandSeek->pluck('name', 'id'),
					 null,
					  ['placeholder' => 'Veuillez choisir...',
					   ':disabled' => 'isInputDisabled',
					   'v-model'=> 'offerGenre']);!!}
		</div>
	</div>
	<div class="field" v-show="offerGenre === '1'">
		{!! Form::label('land_seek[price][]', 'Prix (en €)', ['class' => 'label']); !!}
		@foreach ($priceRanges->pluck('price', "id") as $k => $price)
			{!! Form::checkbox('land_seek[price][]', $price, old('price[]', ["id" => 'price'.$k]), [':disabled' => 'isInputDisabled']) !!}
			{{$price}}
		@endforeach
	</div>
	<div class="columns">
		<div class="column is-half">
			<div class="field" v-show="offerGenre === '2'">
				{!! Form::label('land_seek[rent_min]', 'Loyer minimum (en €)', ['class' => 'label']); !!}
				{!! Form::number('land_seek[land_seek_rent_min]', old('land_seek[rent_min]'), ['min'=>0,'class' => 'input', ':disabled' => 'isInputDisabled'] ) !!}
			</div>
		</div>
		<div class="column">
			<div class="field" v-show="offerGenre === '2'">
				{!! Form::label('land_seek[rent_max]', 'Loyer maximum', ['class' => 'label']); !!}
				{!! Form::number('land_seek[land_seek_rent_max]', old('land_seek[rent_max]'), ['min'=>1,'class' => 'input', ':disabled' => 'isInputDisabled'] ) !!}
			</div>
		</div>
	</div>
	<div class="field">
		<label class="label">Expérience dans le domaine agricole</label>
		<text-area-counter
				id="land_seek[experience_farming]"
				:max-length=1000
				:disabled="isInputDisabled"
				:input-required=false
		>
		</text-area-counter>
	</div>
	<div class="field">
		<label class="label">Et si vous nous en disiez un peu plus sur votre projet ?*</label>

		<text-area-counter
				id="land_seek[about_project]"
				:max-length=1000
				:disabled="isInputDisabled"
				:input-required=true
		>
		</text-area-counter>

	</div>
	<div class="field">
		<label class="label">Et si vous nous en disiez un peu plus sur vous ?*</label>

		<text-area-counter
				id="land_seek[about_content]"
				:max-length=1000
				:disabled="isInputDisabled"
				:input-required=true
		>
		</text-area-counter>
	</div>
	<div class="field">
		{!! Form::label('land_seek[title]', 'Titre de votre annonce*', ['class' => 'label']); !!}
		{!! Form::text('land_seek[title]',
				 old('land_seek[title]'),
				 ['class' => 'input',
				  "required",
				  ':disabled' => 'isInputDisabled',
				  'v-model.trim.lazy' => 'formInput.title']) !!}
		<p class="help is-danger" v-show="!$v.formInput.title.required">Ce champs est requis.</p>
		<p class="help is-danger" v-show="!$v.formInput.title.minLength">Le titre de votre annonce doit faire au minimum
			@{{$v.formInput.title.$params.minLength.min}} caractères .</p>
	</div>
	<div class="field">
		<span>Une photo de vous ? Une synthèse de votre projet ? Les photos sont importantes pour donner envie de consulter votre annonce.</span>
		<div class="file">
			<label class="file-label">
				{!! Form::file('land_seek[image]', ['class' => 'file-input', ':disabled' => 'isInputDisabled'] ) !!}
				<span class="file-cta">
                    <span class="file-icon">
                        <i class="fas fa-upload"></i>
                    </span>
                    <span class="file-label">
                        Importer une photo
                    </span>
                </span>
			</label>
		</div>
	</div>
	<div class="field">
		<label class="checkbox">
			<input type="checkbox" required>
			Je certifie que mon projet correspond à la <a href="/">charte de Terre de Liens</a>
		</label>
	</div>
</div>
