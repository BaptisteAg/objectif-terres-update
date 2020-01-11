<div id="land_seek_form">
	<p class="is-size-7">Les champs marqués d'un astérisque (*) sont obligatoires</p>
	<div class="field">
		{!! Form::label('installation_type', 'Type d\'installation*', ['class' => 'label']); !!}
		<div class="select">
			{!! Form::select('installation_type',
 				$installationTypes->pluck('name'),
				 old('installation_type'),
				 ['placeholder' => 'Choisir un type d\'installation...',
				 'required',
				 ':disabled' => 'land_seek_ads.is_input_disabled']); !!}
		</div>
	</div>
	<div class="columns">
		<div class=" column is-one-quarter">
			<div class="field">
				{!! Form::label('city', 'Commune ou Code postal*', ['class' => 'label']); !!}
				{!! Form::text('city',
						old('city'),
						['class' => 'input',
						 'required',
						 ':disabled' => 'land_seek_ads.is_input_disabled']) !!}
			</div>
		</div>
		<div class="column ">
			<p class="label">Dans un rayon de </p>
			{!! Form::checkbox('city_range[]', '5', old('city_range[]'), [':disabled'=>'land_seek_ads.is_input_disabled', 'required']) !!}
			5 km
			{!! Form::checkbox('city_range[]', '10', old('city_range[]'),[':disabled'=>'land_seek_ads.is_input_disabled', 'required']) !!}
			10km
			{!! Form::checkbox('city_range[]', '20', old('city_range[]'),[':disabled'=>'land_seek_ads.is_input_disabled', 'required']) !!}
			15km
			{!! Form::checkbox('city_range[]', '50', old('city_range[]'),[':disabled'=>'land_seek_ads.is_input_disabled', 'required']) !!}
			20km
		</div>
		<div class="column">
			<div class="field">
				{!! Form::label('region', 'Région', ['class' => 'label']); !!}
				<div class="select">
					{!! Form::select('region',
							 $regions->pluck('name'),
							 old('region'),
							 ['placeholder' => 'Veuillez choisir...',
							  ':disabled'=>'land_seek_ads.is_input_disabled']); !!}
				</div>
			</div>
		</div>
		<div class="column">
			<div class="field">
				{!! Form::label('departments', 'Départements', ['class' => 'label']); !!}
				{!! Form::text('departments',
					 old('departments'),
					['class' => 'input',
					':disabled'=>'land_seek_ads.is_input_disabled']) !!}
			</div>
		</div>
	</div>
	<div class="field">
		{!! Form::label('is_bio', 'Je souhaite m\'installer en bio', ['class' => 'label']); !!}
		{!! Form::radio('is_bio', 'true',old('is_bio'), [':disabled'=>'land_seek_ads.is_input_disabled']) !!}
		oui
		{!! Form::radio('is_bio', 'false', old('is_bio'), [':disabled'=>'land_seek_ads.is_input_disabled']) !!}
		non
	</div>
	<div class="field">
		{!! Form::label('surface_range[]', 'Surface recherchée(en ha)', ['class' => 'label']); !!}
		@foreach ($surfaceRanges->pluck('surface') as $surface)
			{!! Form::checkbox('surface_range[]', $surface, old('surface_rang[]'), [':disabled'=>'land_seek_ads.is_input_disabled']) !!}
			{{$surface}}
		@endforeach
	</div>
	<div class="field">
		{!! Form::label('production_genre[]', 'Production(s) envisagée(s)', ['class' => 'label']); !!}
		{!! Form::checkbox('production_genre[]', 'production_genre_1', old('production_genre[]'), [':disabled'=>'land_seek_ads.is_input_disabled']) !!}
		Production 1
		{!! Form::checkbox('production_genre[]', 'production_genre_2', old('production_genre[]'), [':disabled'=>'land_seek_ads.is_input_disabled']) !!}
		Production 2
		{!! Form::checkbox('production_genre[]',
		'other',
		old('production_genre'),
		['v-model'=>'land_seek_ads.is_production_genre_other',
		':disabled'=>'land_seek_ads.is_input_disabled']) !!}
		Autre
	</div>
	<div class="field" v-show="land_seek_ads.is_production_genre_other">
		{!! Form::label('other_production_genre', 'Veuillez préciser', ['class' => 'label']); !!}
		{!! Form::text('other_production_genre',
				 old('other_production_genre'),
				  ['class' => 'input',
				  ':disabled'=>'land_seek_ads.is_input_disabled']) !!}
	</div>
	<div class="field">
		{!! Form::label('building[]', 'Habitation(s) et bâti(s)', ['class' => 'label']); !!}
		{!! Form::checkbox('building[]', 'has_houses', old('building[]'), [':disabled'=>'land_seek_ads.is_input_disabled']) !!}
		Avec une maison d'habitation existante
		{!! Form::checkbox('building[]', 'has_farm_building', old('building[]'), [':disabled'=>'land_seek_ads.is_input_disabled']) !!}
		Avec des bâtis agricoles existants
	</div>
	<div class="field">
		{!! Form::label('offer_genre', 'Accès au foncier souhaité', ['class' => 'label']); !!}
		<div class="select">
			{!! Form::select('offer_genre',
					 $offerGenresLandSeek->pluck('name'),
					 old('offer_genre'),
					  ['placeholder' => 'Veuillez choisir...',
					   'v-model' => 'land_seek_ads.offer_genre']);!!}
		</div>
	</div>
	<div class="field" v-show="land_seek_ads.offer_genre === '1'">
		{!! Form::label('price[]', 'Prix (en €)', ['class' => 'label']); !!}
		@foreach ($priceRanges->pluck('price') as $price)
			{!! Form::checkbox('price[]', $price, old('price[]'), [':disabled'=>'land_seek_ads.is_input_disabled']) !!}
			{{$price}}
		@endforeach
	</div>
	<div class="columns">
		<div class="column is-half">
			<div class="field" v-show="land_seek_ads.offer_genre === '2'">
				{!! Form::label('rent_min', 'Loyer minimum (en €)', ['class' => 'label']); !!}
				{!! Form::number('rent_min', old('rent_min'), ['min'=>0,'class' => 'input', ':disabled'=>'land_seek_ads.is_input_disabled'] ) !!}
			</div>
		</div>
		<div class="column">
			<div class="field" v-show="land_seek_ads.offer_genre === '2'">
				{!! Form::label('rent_max', 'Loyer maximum', ['class' => 'label']); !!}
				{!! Form::number('rent_max', old('rent_max'), ['min'=>1,'class' => 'input', ':disabled'=>'land_seek_ads.is_input_disabled'] ) !!}
			</div>
		</div>
	</div>
	<div class="field">
		{!! Form::label('experience_farming', 'Expérience dans le domaine agricole', ['class' => 'label']); !!}
		{!! Form::textarea('experience_farming',
					 old('experience_farming'),
					  ['class' => 'textarea',
					   ':disabled' => 'land_seek_ads.is_input_disabled',
					   'maxlength' => 1000,
					   'placeholder' => 'Limite de 1000 caractères']) !!}
	</div>
	<div class="field">
		{!! Form::label('about_project', 'Et si vous nous en disiez un peu plus sur votre projet ?*', ['class' => 'label']); !!}
		{!! Form::textarea('about_project',
				 old('about_projet'),
				  ['class' => 'textarea',
				  'required',
				  ':disabled'=>'land_seek_ads.is_input_disabled',
				   'maxlength'=>1000,
				   'placeholder'=>'Limite de 1000 caractères']) !!}
	</div>
	<div class="field">
		{!! Form::label('about_content', 'Et si vous nous en disiez un peu plus sur vous ?*', ['class' => 'label']); !!}
		{!! Form::textarea('about_content',
				 old('about_content'),
				 ['class' => 'textarea',
				 'required',
				 ':disabled'=>'land_seek_ads.is_input_disabled',
				 'maxlength'=>1000,
				 'placeholder'=>'Limite de 1000 caractères']) !!}
	</div>
	<div class="field">
		{!! Form::label('title', 'Titre de votre annonce*', ['class' => 'label']); !!}
		{!! Form::text('title',
				 old('title'),
				 ['class' => 'input',
				  "required",
				  ':disabled'=>'land_seek_ads.is_input_disabled']) !!}
	</div>
	<div class="field">
		<span>Une photo de vous ? Une synthèse de votre projet ? Les photos sont importantes pour donner envie de consulter votre annonce.</span>
		<div class="file">
			<label class="file-label">
				{!! Form::file('image', ['class' => 'file-input', ':disabled'=>'land_seek_ads.is_input_disabled'] ) !!}
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