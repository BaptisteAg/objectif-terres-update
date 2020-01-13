<div id="land_seek_form">
	<p class="is-size-7">Les champs marqués d'un astérisque (*) sont obligatoires</p>
	<div class="field">
		{!! Form::label('land_seek[installation_type_id]', 'Type d\'installation*', ['class' => 'label']); !!}
		<div class="select">
			{!! Form::select('land_seek[installation_type_id]',
				 $installationTypes->pluck('name', 'id'),
				 old('land_seek[installation_type]'),
				 ['placeholder' => 'Choisir un type d\'installation...',
				 'required',
				 ':disabled' => 'landSeekAd.isInputDisabled',
				 'v-model.trim'=>"landSeekAd.installationType",]); !!}
				<p class="help is-danger" v-show="!$v.landSeekAd.installationType.required">Ce champs est requis.</p>

		</div>
	</div>
	<div class="field">
		<div class="columns">
			<div class=" column is-one-quarter">
				<div class="field">
					{!! Form::label('land_seek[city]', 'Commune ou Code postal*', ['class' => 'label']); !!}
					{!! Form::text('land_seek[city]',
							old('land_seek[city]'),
							['class' =>'input',
							 ':disabled' => 'landSeekAd.isInputDisabled',
							 'v-model.trim'=>"landSeekAd.zipCode",
							 ]) !!}
					<p class="help is-danger" v-if="!$v.landSeekAd.zipCode.minLength">Veuillez saisir au moins
						@{{$v.landSeekAd.zipCode.$params.minLength.min}} caractères.</p>
				</div>
			</div>
			<div class="column ">
				<p class="label">Dans un rayon de </p>
				@foreach ($cityRanges as $cityRange)
					{!! Form::checkbox('land_seek[city_range][]',
					 $cityRange,
					  [':disabled' => 'landSeekAd.isInputDisabled']) !!}
					{{$cityRange}} km
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
								  ':disabled' => 'landSeekAd.isInputDisabled',
								   'v-model.trim'=>"landSeekAd.regions",]); !!}
					</div>
				</div>
			</div>
			<div class="column">
				<div class="field">
					{!! Form::label('land_seek[departments][]', 'Départements', ['class' => 'label']); !!}
					{!! Form::text('land_seek[departments][]',
						 old('land_seek[departments]'),
						['class' => 'input',
						':disabled' => 'landSeekAd.isInputDisabled',
						 'v-model.trim'=>"landSeekAd.departments",]) !!}
					<p class="help is-danger" v-show="$v.validationGroup.$invalid">Ce champs est requis.</p>

				</div>
			</div>
		</div>


	</div>
	<div class="field">
		{!! Form::label('land_seek[is_bio]', 'Je souhaite m\'installer en bio', ['class' => 'label']) !!}
		{!! Form::radio('land_seek[is_bio]', 'true',old('land_seek[is_bio]'), [':disabled' => 'landSeekAd.isInputDisabled']) !!}
		oui
		{!! Form::radio('land_seek[is_bio]', 'false', old('land_seek[is_bio]'), [':disabled' => 'landSeekAd.isInputDisabled']) !!}
		non
	</div>
	<div class="field">
		{!! Form::label('land_seek[surface_range][]', 'Surface recherchée(en ha)', ['class' => 'label']); !!}
		@foreach ($surfaceRanges->pluck('surface', 'id') as $id => $surface)
			{!! Form::checkbox(
				'land_seek[surface_range][]',
				$id,
				in_array($id, old('land_seek[surface_range]', [])),
				[
					':disabled' => 'landSeekAd.isInputDisabled'
				]
			) !!}
			{{$surface}}
		@endforeach
	</div>
	<div class="field">
		{!! Form::label('land_seek[production_genre][]', 'Production(s) envisagée(s)', ['class' => 'label']); !!}
		@foreach ($productionGenres->pluck('name', 'id') as $id => $productionGenre)
		{!! Form::checkbox(
		'land_seek[production_genre][]',
		$id,
		in_array($id, old('land_seek[production_genre][]', [])),
		[
		':disabled' => 'landSeekAd.isInputDisabled'
		]
		) !!}
		{{$productionGenre}}
		@endforeach
		{!! Form::checkbox('land_seek[production_genre][]',
		'other',
		old('land_seek[production_genre]'),
		[':disabled' => 'landSeekAd.isInputDisabled',
		'v-model'=>'landSeekAd.isProductionGenreOther']) !!}
		Autre
	</div>
	<div class="field" v-show="landSeekAd.isProductionGenreOther">
		{!! Form::label('land_seek[other_production_genre]', 'Veuillez préciser', ['class' => 'label']); !!}
		{!! Form::text('land_seek[other_production_genre]',
				 old('land_seek[other_production_genre]'),
				  ['class' => 'input',
				  ':disabled' => 'landSeekAd.isInputDisabled']) !!}
	</div>
	<div class="field">
		{!! Form::label('land_seek[land_seek_building][]', 'Habitation(s) et bâti(s)', ['class' => 'label']); !!}
		{!! Form::checkbox('land_seek[building][]', 'has_houses', old('land_seek[building[]]'), [':disabled' => 'landSeekAd.isInputDisabled']) !!}
		Avec une maison d'habitation existante
		{!! Form::checkbox('land_seek[building][]', 'has_farm_building', old('land_seek[building[]]'), [':disabled' => 'landSeekAd.isInputDisabled']) !!}
		Avec des bâtis agricoles existants
	</div>
	<div class="field">
		{!! Form::label('land_seek[offer_genre]', 'Accès au foncier souhaité', ['class' => 'label']); !!}
		<div class="select">
			{!! Form::select('land_seek[offer_genre]',
					 $offerGenresLandSeek->pluck('name', 'id'),
					 old('land_seek[offer_genre]'),
					  ['placeholder' => 'Veuillez choisir...',
					   ':disabled' => 'landSeekAd.isInputDisabled',
					   'v-model'=>'landSeekAd.offerGenre']);!!}
		</div>
	</div>
	<div class="field" v-show="landSeekAd.offerGenre === '2'">
		{!! Form::label('land_seek[price][]', 'Prix (en €)', ['class' => 'label']); !!}
		@foreach ($priceRanges->pluck('price', "id") as $k => $price)
			{!! Form::checkbox('land_seek[price][]', $price, old('price[]', ["id" => 'price'.$k]), [':disabled' => 'landSeekAd.isInputDisabled']) !!}
			{{$price}}
		@endforeach
	</div>
	<div class="columns">
		<div class="column is-half">
			<div class="field" v-show="landSeekAd.offerGenre === '1'">
				{!! Form::label('land_seek[rent_min]', 'Loyer minimum (en €)', ['class' => 'label']); !!}
				{!! Form::number('land_seek[land_seek_rent_min]', old('land_seek[rent_min]'), ['min'=>0,'class' => 'input', ':disabled' => 'landSeekAd.isInputDisabled'] ) !!}
			</div>
		</div>
		<div class="column">
			<div class="field" v-show="landSeekAd.offerGenre === '1'">
				{!! Form::label('land_seek[rent_max]', 'Loyer maximum', ['class' => 'label']); !!}
				{!! Form::number('land_seek[land_seek_rent_max]', old('land_seek[rent_max]'), ['min'=>1,'class' => 'input', ':disabled' => 'landSeekAd.isInputDisabled'] ) !!}
			</div>
		</div>
	</div>
	<div class="field">
		{!! Form::label('land_seek[experience_farming]', 'Expérience dans le domaine agricole', ['class' => 'label']); !!}
		{!! Form::textarea('land_seek[experience_farming]',
					 old('land_seek[experience_farming]'),
					  ['class' => 'textarea',
					   ':disabled' => 'landSeekAd.isInputDisabled',
					   'maxlength' => 1000,
					   'placeholder' => 'Limite de 1000 caractères']) !!}
	</div>
	<div class="field">
		{!! Form::label('land_seek[about_project]', 'Et si vous nous en disiez un peu plus sur votre projet ?*', ['class' => 'label']); !!}
		{!! Form::textarea('land_seek[about_project]',
				 old('land_seek[about_projet]'),
				  ['class' => 'textarea',
				  'required',
				  ':disabled' => 'landSeekAd.isInputDisabled',
				   'maxlength'=>1000,
				   'placeholder'=>'Limite de 1000 caractères']) !!}
	</div>
	<div class="field">
		{!! Form::label('land_seek[about_content]', 'Et si vous nous en disiez un peu plus sur vous ?*', ['class' => 'label']); !!}
		{!! Form::textarea('land_seek[about_content]',
				 old('land_seek[about_content]'),
				 ['class' => 'textarea',
				 'required',
				 ':disabled' => 'landSeekAd.isInputDisabled',
				 'maxlength'=>1000,
				 'placeholder'=>'Limite de 1000 caractères']) !!}
	</div>
	<div class="field">
		{!! Form::label('land_seek[title]', 'Titre de votre annonce*', ['class' => 'label']); !!}
		{!! Form::text('land_seek[title]',
				 old('land_seek[title]'),
				 ['class' => 'input',
				  "required",
				  ':disabled' => 'landSeekAd.isInputDisabled']) !!}
	</div>
	<div class="field">
		<span>Une photo de vous ? Une synthèse de votre projet ? Les photos sont importantes pour donner envie de consulter votre annonce.</span>
		<div class="file">
			<label class="file-label">
				{!! Form::file('land_seek[image]', ['class' => 'file-input', ':disabled' => 'landSeekAd.isInputDisabled'] ) !!}
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