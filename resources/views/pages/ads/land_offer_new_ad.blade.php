<div id="land_offer_form">
	<p class="is-size-7">Les champs marqués d'un astérisque (*) sont obligatoires</p>
	<div class="field">
		{!! Form::label('is_beneficiary', 'Je poste l\'annonce*', ['class' => 'label']); !!}
		<div class="select">
			{!! Form::select('is_beneficiary',
					 ['true' => 'En mon nom',
					 'false' => 'Pour le compte d\'une autre personne'],
					  old('is_beneficiary'),
					  ['placeholder' => 'Veuillez séléctionner...',
					  'required',
					  ':disabled' => 'land_offer_ads.is_input_disabled']);!!}
		</div>
	</div>
	<div class="columns">
		<div class="column is-half">
			<div class="field">
				{!! Form::label('zipCode', 'Code postal*', ['class' => 'label']); !!}
				<div class="control">
					{!! Form::number('zipCode',
							 old('zipCode'),
							 ['min' => 1,
							  'class' => 'input',
							  'required',
							  ':disabled' => 'land_offer_ads.is_input_disabled']) !!}
				</div>
			</div>
		</div>
		<div class="column"></div>
	</div>
	<div class="field">
		{!! Form::checkbox('accept_use_zip_code', 'true', old('accept_use_zip_code'), [':disabled'=>'land_offer_ads.is_input_disabled']) !!}
		J'accepte que le code postal soit utilisé pour localiser l'annonce(recommandé)
	</div>
	<div data-required="true" class="field">
		{!! Form::label('surface_range[]', 'Surface du foncier agricole(en ha)*', ['class' => 'label']); !!}

		@foreach ($surfaceRanges->pluck('surface') as $surface)
			{!! Form::checkbox('surface_range[]', $surface,  old('surface_range[]'), [':disabled'=>'land_offer_ads.is_input_disabled']) !!}
			{{$surface}}
		@endforeach
	</div>
	<div class="field">
		{!! Form::label('lands_offer_genre[]', 'Type de cession du foncier', ['class' => 'label']); !!}
		@foreach ($offerGenresLand->pluck('name') as $landOffer)
		{!! Form::checkbox('lands_offer_genre[]', $landOffer,  old('lands_offer_genre[]'), [':disabled'=>'land_offer_ads.is_input_disabled']) !!}
		{{$landOffer}}
		@endforeach
	</div>
	<p class="has-text-centered is-size-4">Bâti agricole</p>
	<div class="columns">
		<div class="column is-one-third">
			<div class="field">
				{!! Form::label('building_number', 'Nombre', ['class' => 'label']); !!}
				{!! Form::number('building_number', old('building_number'), ['min'=>0, 'class' => 'input', ':disabled'=>'land_offer_ads.is_input_disabled'] ) !!}
			</div>
		</div>
		<div class="column ">
			<div class="field">
				{!! Form::label('building_surface', 'Surface (en m²)', ['class' => 'label']); !!}
				{!! Form::number('building_surface',
						 old('building_surface'),
						  ['min' => 0,
						   'class' => 'input',
						   ':disabled' => 'land_offer_ads.is_input_disabled']) !!}
			</div>
		</div>
		<div class="column ">
			<div class="field">
				{!! Form::label('building_offer_genre[]', 'Type de cession', ['class' => 'label']); !!}

				@foreach ($offerGenresBuilding->pluck('name') as $buildingOffer)
				{!! Form::checkbox('building_offer_genre[]', $buildingOffer, old('building_offer_genre[]'), [':disabled'=>'land_offer_ads.is_input_disabled']) !!}
				{{$buildingOffer}}
				@endforeach
			</div>
		</div>
	</div>
	<p class="has-text-centered is-size-4">Habitation</p>
	<div class="columns">
		<div class="column is-one-third">
			<div class="field">
				{!! Form::label('house_number', 'Nombre de pièces', ['class' => 'label']); !!}
				{!! Form::number('house_number', old('house_number'), ['min'=> 0, 'class' => 'input', ':disabled'=>'land_offer_ads.is_input_disabled'] ) !!}
			</div>
		</div>
		<div class="column ">
			<div class="field">
				{!! Form::label('house_surface', 'Surface (en m²)', ['class' => 'label']); !!}
				{!! Form::number('house_surface', old('house_surface'), ['min'=> 0, 'class' => 'input', ':disabled'=>'land_offer_ads.is_input_disabled'] ) !!}
			</div>
		</div>
		<div class="column ">
			<div class="field">
				{!! Form::label('house_offer_genre[]', 'Type de cession', ['class' => 'label']); !!}
				@foreach ($offerGenresHouse->pluck('name') as $houseOffer)
				{!! Form::checkbox('house_offer_genre[]', $houseOffer, old('house_offer_genre[]'), [':disabled' => 'land_offer_ads.is_input_disabled']) !!}
				{{$houseOffer}}
				@endforeach
			</div>
		</div>
	</div>
	<p class="has-text-centered is-size-4">Appel à candidature</p>
	<div class="field">
		{!! Form::checkbox('is_call_for_application_community',
		'true',
		old('is_call_for_application_community[]'),
		[':disabled' => 'land_offer_ads.is_input_disabled']) !!}
		Il s'agit d’un appel à candidatures dans le cadre d'un projet soutenu par une collectivité
	</div>
	<div class="field">
		{!! Form::checkbox('is_call_for_application_terre_de_liens',
		'true',
		old('is_call_for_application_terre_de_liens'),
		[':disabled' => 'land_offer_ads.is_input_disabled']) !!}
		Il s’agit d’un appel à candidatures pour une ferme Terre de Liens
	</div>
	<div class="field">
		{!! Form::checkbox('is_call_for_application_test_area',
		'true',
		old('is_call_for_application_test_area'),
		[':disabled' => 'land_offer_ads.is_input_disabled']) !!}
		Il s’agit d’un appel à candidatures dans le cadre d'un Espace test
	</div>
	<div class="field">
		{!! Form::label('is_activity_transfert', 'Transmission d\'activité (ferme toujours en fonctionnement)*', ['class' => 'label']) !!}
		{!! Form::radio('is_activity_transfert',
		true,
		old('is_activity_transfert'),
		[':disabled' => 'land_offer_ads.is_input_disabled',
		'v-model' => 'land_offer_ads.is_activity_transfer']) !!}
		Oui
		{!! Form::radio('is_activity_transfert',
		false,
		old('is_activity_transfert'),
		[':disabled' => 'land_offer_ads.is_input_disabled',
		'v-model' => 'land_offer_ads.is_activity_transfer']) !!}
		Non
	</div>
	<div class="columns">
		<div class="column is-half" v-show="land_offer_ads.is_activity_transfer === ''">
			{!! Form::label('land_availability', 'A partir de quand votre terre est-elle disponible ?', ['class' => 'label']); !!}
			{!! Form::date('land_availability', old('land_availability'), [ ':disabled' => 'land_offer_ads.is_input_disabled'] ) !!}
		</div>
		<div class="column" v-show="land_offer_ads.is_activity_transfer === '1'">
			{!! Form::label('land_transfert_deadline', 'Avant quelle date souhaitez-vous transmettre votre ferme ?', ['class' => 'label']); !!}
			{!! Form::date('land_transfert_deadline', \Carbon\Carbon::now(), [ ':disabled' => 'land_offer_ads.is_input_disabled'] ) !!}
		</div>
	</div>
	<div class="field" v-show="land_offer_ads.is_activity_transfer === '1'">
		{!! Form::label('production_genre[]', 'Système de production en place*', ['class' => 'label']); !!}
		{!! Form::checkbox('production_genre[]',
		'production_genre_1',
		old('production_genre[]'),
		[':disabled' => 'land_offer_ads.is_input_disabled']) !!}
		Production 1
		{!! Form::checkbox('production_genre[]',
		'production_genre_2',
		old('production_genre[]'),
		[':disabled' => 'land_offer_ads.is_input_disabled']) !!}
		Production 2
		{!! Form::checkbox('production_genre[]',
		'autre',
		old('production_genre[]'),
		['v-model' => 'land_offer_ads.is_production_genre_other',
		':disabled' => 'land_offer_ads.is_input_disabled' ]) !!}
		Autre
	</div>
	<div class="field" v-show="land_offer_ads.is_production_genre_other">
		{!! Form::label('other_production_genre', 'Veuillez préciser', ['class' => 'label']); !!}
		{!! Form::text('other_production_genre',
				 null,
				 ['class' => 'input',
				 ':disabled' => 'land_offer_ads.is_input_disabled']) !!}
	</div>
	<div class="field">
		<div v-show="land_offer_ads.is_activity_transfer === '1'">
			{!! Form::label('production_genre_wanted[]', 'Production envisageables', ['class' => 'label']); !!}
		</div>
		{!! Form::label('production_genre_wanted[]', 'Production envisageables*', ['class' => 'label']); !!}
		{!! Form::checkbox('production_genre_wanted[]',
				'production_genre_1',
				old('production_genre_wanted[]'),
				[':disabled' => 'land_offer_ads.is_input_disabled']) !!}
		Production 1
		{!! Form::checkbox('production_genre_wanted[]',
				'production_genre_2',
				old('production_genre_wanted[]'),
				[':disabled' => 'land_offer_ads.is_input_disabled']) !!}
		Production 2
		{!! Form::checkbox('production_genre_wanted[]',
				'autre',
				old('production_genre_wanted[]'),
				['v-model' => 'land_offer_ads.is_production_genre_wanted_other',
				':disabled' => 'land_offer_ads.is_input_disabled' ]) !!}
		Autre
		{!! Form::checkbox('production_genre_wanted[]',
				'',
				old('production_genre_wanted[]'),
				[':disabled' => 'land_offer_ads.is_input_disabled' ]) !!}
		Je ne sais pas
	</div>
	<div class="field" v-show="land_offer_ads.is_production_genre_wanted_other">
		{!! Form::label('other_production_genre_wanted', 'Veuillez préciser', ['class' => 'label']); !!}
		{!! Form::text('other_production_genre_wanted',
				 old('other_production_genre_wanted'),
				  ['class' => 'input',
				   ':disabled' => 'land_offer_ads.is_input_disabled'] ) !!}
	</div>
	<div class="columns">
		<div class="column is-two-thirds">
			<div class="field">
				{!! Form::label('water_access', 'Accès à l\'eau (forage, réserve d\'eau, canal d’irrigation, borne)*', ['class' => 'label']); !!}
				<div class="select">
					{!! Form::select('water_access',
							 ['oui' => 'Oui',
							 'non' => 'Non',
							  '' => 'Je ne sais pas'],
							  old('water_access'),
							  ['placeholder' => 'Veuillez séléctionner...',
							  'required',
							  ':disabled' => 'land_offer_ads.is_input_disabled']); !!}
				</div>
			</div>
		</div>
		<div class="column">
			<div class="field">
				{!! Form::label('altitude', 'Altitude (en m)*', ['class' => 'label']); !!}
				<div class="control">
					{!! Form::number('altitude',
							 old('altitude'),
							 ['min'=> 0,
							  'class' => 'input',
							  ':disabled' => 'land_offer_ads.is_input_disabled',
							  'required'] ) !!}
				</div>
			</div>
		</div>
	</div>
	<div class="field">
		{!! Form::label('bio_certification[]', 'Certification bio des terres*', ['class' => 'label']); !!}
		@foreach ($bioCertifications->pluck('name') as $bioCertification)
		{!! Form::checkbox('bio_certification[]',
		$bioCertification,
		old('bio_certification[]'),
		[':disabled' => 'land_offer_ads.is_input_disabled']) !!}
		{{$bioCertification}}
		@endforeach
	</div>
	<p class="has-text-centered is-size-4">Prix de vente ou loyer mensuel (en €)</p>
	<div class="columns">
		<div class="column is-one-third">
			<div class="field">
				{!! Form::label('land_price', 'Foncier*', ['class' => 'label']); !!}
				{!! Form::number('land_price',
						 old('land_price'),
						  ['min' => 0,
						   'class' => 'input',
							':disabled' => 'land_offer_ads.is_input_disabled',
							'required'] ) !!}
			</div>
		</div>
		<div class="column ">
			<div class="field">
				{!! Form::label('house_price', 'Habitation*', ['class' => 'label']); !!}
				{!! Form::number('house_price',
						 old('house_price'),
						  ['min' => 0,
						   'class' => 'input',
						   ':disabled' => 'land_offer_ads.is_input_disabled',
						   'required'] ) !!}
			</div>
		</div>
		<div class="column ">
			<div class="field">
				{!! Form::label('building_price', 'Bâti*', ['class' => 'label']); !!}
				{!! Form::number('building_price',
						 old('building_price'),
						  ['min'=> 0,
						   'class' => 'input',
						   'required',
						   ':disabled' => 'land_offer_ads.is_input_disabled'] ) !!}
			</div>
		</div>
	</div>
	<div class="field">
		<label class="checkbox">
			<input type="checkbox" required>
			Je certifie que le prix est conforme à l’<a>indice des fermages de mon département</a>
		</label>
	</div>
	<div class="field">
		{!! Form::label('about_project', 'Et si vous nous en disiez un peu plus sur votre projet ?*', ['class' => 'label']); !!}
		{!! Form::textarea('about_project',
				 old('about_projet'),
				  ['class' => 'textarea',
				  'required',
				  ':disabled'=>'land_offer_ads.is_input_disabled',
				  'maxlength'=>1000,
				  'placeholder'=>'Limite de 1000 caractères'] ) !!}
	</div>
	<div class="field">
		{!! Form::label('about_content', 'Et si vous nous en disiez un peu plus sur vous ?*', ['class' => 'label']); !!}
		{!! Form::textarea('about_content',
				 old('about_content'),
				  ['class' => 'textarea',
				  'required',
				   ':disabled' => 'land_offer_ads.is_input_disabled',
				   'maxlength' => 1000,
				   'placeholder' => 'Limite de 1000 caractères'] ) !!}
	</div>
	<div class="field">
		{!! Form::label('title', 'Titre de votre annonce*', ['class' => 'label']); !!}
		{!! Form::text('title', old('title'),
				 ['class' => 'input',
				  'required',
				  ':disabled' => 'land_offer_ads.is_input_disabled'] ) !!}
	</div>
	<div class="field">
		<span>Des photos ? Chaque photo augmente vos chances d’être recontactés !</span>
		<div class="file">
			<label class="file-label">
				{!! Form::file('image1',
						 ['class' => 'file-input',
						  ':disabled' => 'land_offer_ads.is_input_disabled']) !!}
				{!! Form::file('image2',
						 ['class' => 'file-input',
						  ':disabled'=>'land_offer_ads.is_input_disabled'] ) !!}
				{!! Form::file('image3',
						 ['class' => 'file-input',
						  ':disabled'=>'land_offer_ads.is_input_disabled'] ) !!}
				{!! Form::file('image4',
						 ['class' => 'file-input',
						  ':disabled' => 'land_offer_ads.is_input_disabled'] ) !!}
				{!! Form::file('image5',
						 ['class' => 'file-input',
						  ':disabled' => 'land_offer_ads.is_input_disabled'] ) !!}
				<span class="file-cta">
                    <span class="file-icon">
                        <i class="fas fa-upload"></i>
                    </span>
                    <span class="file-label">
                        Importer une photo (maximum 5 photos)
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