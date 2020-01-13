<div id="land_offer_form">
	<p class="is-size-7">Les champs marqués d'un astérisque (*) sont obligatoires</p>
	<div class="field">
		{!! Form::label('land_offer[is_beneficiary]', 'Je poste l\'annonce*', ['class' => 'label']); !!}
		<div class="select">
			{!! Form::select('land_offer[is_beneficiary]',
					 ['true' => 'En mon nom',
					 'false' => 'Pour le compte d\'une autre personne'],
					  old('land_offer[is_beneficiary]'),
					  ['placeholder' => 'Veuillez séléctionner...',
					  'required',
					  ':disabled' => 'isInputDisabled']);!!}
		</div>
	</div>
	<div class="columns">
		<div class="column is-half">
			<div class="field">
				{!! Form::label('land_offer[zipCode]', 'Code postal*', ['class' => 'label']); !!}
				<div class="control">
					{!! Form::text('land_offer[zipCode]',
							 old('land_offer[zipCode]'),
							 ['min' => 1,
							  'class' => 'input',
							  'required',
							  ':disabled' => 'isInputDisabled']) !!}
				</div>
			</div>
		</div>
		<div class="column"></div>
	</div>
	<div class="field">
		{!! Form::checkbox('land_offer[accept_use_zip_code]', 'true', old('land_offer[accept_use_zip_code]'), [':disabled'=>'isInputDisabled']) !!}
		J'accepte que le code postal soit utilisé pour localiser l'annonce(recommandé)
	</div>
	<div data-required="true" class="field">
		{!! Form::label('land_offer[surface_range][]', 'Surface du foncier agricole(en ha)*', ['class' => 'label']); !!}

		@foreach ($surfaceRanges->pluck('surface', 'id') as $surface)
			{!! Form::checkbox('land_offer[surface_range][]', $surface,  old('land_offer[surface_range[]]'), [':disabled'=>'isInputDisabled']) !!}
			{{$surface}}
		@endforeach
	</div>
	<div class="field">
		{!! Form::label('land_offer[lands_offer_genre][]', 'Type de cession du foncier', ['class' => 'label']); !!}
		@foreach ($offerGenresLand->pluck('name','id') as $landOffer)
		{!! Form::checkbox('land_offer[lands_offer_genre][]', $landOffer,  old('land_offer[lands_offer_genre[]]'), [':disabled'=>'isInputDisabled']) !!}
		{{$landOffer}}
		@endforeach
	</div>
	<p class="has-text-centered is-size-4">Bâti agricole</p>
	<div class="columns">
		<div class="column is-one-third">
			<div class="field">
				{!! Form::label('land_offer[building_number]', 'Nombre', ['class' => 'label']); !!}
				{!! Form::number('land_offer[building_number]', old('land_offer[building_number]'), ['min'=>0, 'class' => 'input', ':disabled'=>'isInputDisabled'] ) !!}
			</div>
		</div>
		<div class="column ">
			<div class="field">
				{!! Form::label('land_offer[building_surface]', 'Surface (en m²)', ['class' => 'label']); !!}
				{!! Form::number('land_offer[building_surface]',
						 old('land_offer[building_surface]'),
						  ['min' => 0,
						   'class' => 'input',
						   ':disabled' => 'isInputDisabled']) !!}
			</div>
		</div>
		<div class="column ">
			<div class="field">
				{!! Form::label('land_offer[building_offer_genre][]', 'Type de cession', ['class' => 'label']); !!}
				@foreach ($offerGenresBuilding->pluck('name' ,'id') as $buildingOffer)
				{!! Form::checkbox('land_offer[building_offer_genre][]', $buildingOffer, old('land_offer[building_offer_genre[]]'), [':disabled'=>'isInputDisabled']) !!}
				{{$buildingOffer}}
				@endforeach
			</div>
		</div>
	</div>
	<p class="has-text-centered is-size-4">Habitation</p>
	<div class="columns">
		<div class="column is-one-third">
			<div class="field">
				{!! Form::label('land_offer[house_number]', 'Nombre de pièces', ['class' => 'label']); !!}
				{!! Form::number('land_offer[house_number]', old('land_offer[house_number]'), ['min'=> 0, 'class' => 'input', ':disabled'=>'isInputDisabled']); !!}
			</div>
		</div>
		<div class="column ">
			<div class="field">
				{!! Form::label('land_offer[house_surface]', 'Surface (en m²)', ['class' => 'label']); !!}
				{!! Form::number('land_offer[house_surface]', old('land_offer[house_surface]'), ['min'=> 0, 'class' => 'input', ':disabled'=>'isInputDisabled']); !!}
			</div>
		</div>
		<div class="column ">
			<div class="field">
				{!! Form::label('land_offer[house_offer_genre][]', 'Type de cession', ['class' => 'label']); !!}
				@foreach ($offerGenresHouse->pluck('name', 'id') as $houseOffer)
				{!! Form::checkbox('land_offer[house_offer_genre][]', $houseOffer, old('land_offer[house_offer_genre[]]'), [':disabled' => 'isInputDisabled']) !!}
				{{$houseOffer}}
				@endforeach
			</div>
		</div>
	</div>
	<p class="has-text-centered is-size-4">Appel à candidature</p>
	<div class="field">
		{!! Form::checkbox('land_offer[is_call_for_application_community]',
		'true',
		old('land_offer[is_call_for_application_community[]]'),
		[':disabled' => 'isInputDisabled']) !!}
		Il s'agit d’un appel à candidatures dans le cadre d'un projet soutenu par une collectivité
	</div>
	<div class="field">
		{!! Form::checkbox('land_offer[is_call_for_application_terre_de_liens]',
		'true',
		old('land_offer[is_call_for_application_terre_de_liens]'),
		[':disabled' => 'isInputDisabled']) !!}
		Il s’agit d’un appel à candidatures pour une ferme Terre de Liens
	</div>
	<div class="field">
		{!! Form::checkbox('land_offer[is_call_for_application_test_area]',
		'true',
		old('land_offer[is_call_for_application_test_area]'),
		[':disabled' => 'isInputDisabled']) !!}
		Il s’agit d’un appel à candidatures dans le cadre d'un Espace test
	</div>
	<div class="field">
		{!! Form::label('land_offer[is_activity_transfert]', 'Transmission d\'activité (ferme toujours en fonctionnement)*', ['class' => 'label']) !!}
		{!! Form::radio('land_offer[is_activity_transfert]',
		true,
		old('land_offer[is_activity_transfert]'),
		[':disabled' => 'isInputDisabled',
		'v-model' => 'is_activity_transfer']) !!}
		Oui
		{!! Form::radio('land_offer[is_activity_transfert]',
		false,
		old('land_offer[is_activity_transfert]'),
		[':disabled' => 'isInputDisabled',
		'v-model' => 'is_activity_transfer']) !!}
		Non
	</div>
	<div class="columns">
		<div class="column is-half" v-show="is_activity_transfer === ''">
			{!! Form::label('land_offer[land_availability]', 'A partir de quand votre terre est-elle disponible ?', ['class' => 'label']); !!}
			{!! Form::date('land_offer[land_availability]', old('land_offer[land_availability]'), [ ':disabled' => 'isInputDisabled'] ) !!}
		</div>
		<div class="column" v-show="is_activity_transfer === '1'">
			{!! Form::label('land_offer[land_transfert_deadline]', 'Avant quelle date souhaitez-vous transmettre votre ferme ?', ['class' => 'label']); !!}
			{!! Form::date('land_offer[land_transfert_deadline]', old('land_offer[land_availability]'), [ ':disabled' => 'isInputDisabled'] ) !!}
		</div>
	</div>
	<div class="field" v-show="is_activity_transfer === '1'">
		{!! Form::label('land_offer[production_genre][]', 'Système de production en place*', ['class' => 'label']); !!}
		@foreach ($productionGenres->pluck('name', 'id') as $id => $productionGenre)
		{!! Form::checkbox(
		'land_offer[production_genre][]',
		$id,
		in_array($id, old('land_offer[production_genre][]', [])),
		[
		':disabled' => 'isInputDisabled'
		]
		) !!}
		{{$productionGenre}}
		@endforeach
		{!! Form::checkbox('land_offer[production_genre][]',
		'autre',
		old('land_offer[production_genre[]]'),
		['v-model' => 'isProductionGenreOther',
		':disabled' => 'isInputDisabled' ]) !!}
		Autre
	</div>
	<div class="field" v-show="isProductionGenreOther">
		{!! Form::label('land_offer[other_production_genre]', 'Veuillez préciser', ['class' => 'label']); !!}
		{!! Form::text('land_offer[other_production_genre]',
				 null,
				 ['class' => 'input',
				 ':disabled' => 'isInputDisabled']) !!}
	</div>
	<div class="field">
		<div v-show="is_activity_transfer === '1'">
			{!! Form::label('land_offer[production_genre_wanted][]', 'Production envisageables', ['class' => 'label']); !!}
		</div>
		{!! Form::label('land_offer[production_genre_wanted][]', 'Production envisageables*', ['class' => 'label']); !!}
		@foreach ($productionGenres->pluck('name', 'id') as $id => $productionGenre)
			{!! Form::checkbox(
			'land_offer[production_genre_wanted][]',
			$id,
			in_array($id, old('land_offer[production_genre_wanted][]', [])),
			[
			':disabled' => 'isInputDisabled'
			]
			) !!}
			{{$productionGenre}}
		@endforeach
		{!! Form::checkbox('land_offer[production_genre_wanted][]',
				'autre',
				old('land_offer[production_genre_wanted[]]'),
				['v-model' => 'isProductionGenreWantedOther',
				':disabled' => 'isInputDisabled' ]) !!}
		Autre
		{!! Form::checkbox('land_offer[production_genre_wanted][]',
				'',
				old('land_offer[production_genre_wanted[]]'),
				[':disabled' => 'isInputDisabled' ]) !!}
		Je ne sais pas
	</div>
	<div class="field" v-show="isProductionGenreWantedOther">
		{!! Form::label('land_offer[other_production_genre_wanted]', 'Veuillez préciser', ['class' => 'label']); !!}
		{!! Form::text('land_offer[other_production_genre_wanted]',
				 old('land_offer[other_production_genre_wanted]'),
				  ['class' => 'input',
				   ':disabled' => 'isInputDisabled'] ) !!}
	</div>
	<div class="columns">
		<div class="column is-two-thirds">
			<div class="field">
				{!! Form::label('land_offer[water_access]', 'Accès à l\'eau (forage, réserve d\'eau, canal d’irrigation, borne)*', ['class' => 'label']); !!}
				<div class="select">
					{!! Form::select('land_offer[water_access]',
							 ['oui' => 'Oui',
							 'non' => 'Non',
							  '' => 'Je ne sais pas'],
							  old('land_offer[water_access]'),
							  ['placeholder' => 'Veuillez séléctionner...',
							  'required',
							  ':disabled' => 'isInputDisabled']); !!}
				</div>
			</div>
		</div>
		<div class="column">
			<div class="field">
				{!! Form::label('land_offer[altitude]', 'Altitude (en m)*', ['class' => 'label']); !!}
				<div class="control">
					{!! Form::number('land_offer[altitude]',
							 old('land_offer[altitude]'),
							 ['min'=> 0,
							  'class' => 'input',
							  ':disabled' => 'isInputDisabled',
							  'required'] ) !!}
				</div>
			</div>
		</div>
	</div>
	<div class="field">
		{!! Form::label('land_offer[bio_certification][]', 'Certification bio des terres*', ['class' => 'label']); !!}
		@foreach ($bioCertifications->pluck('name') as $bioCertification)
		{!! Form::checkbox('land_offer[bio_certification][]',
		$bioCertification,
		old('land_offer[bio_certification[]]'),
		[':disabled' => 'isInputDisabled']) !!}
		{{$bioCertification}}
		@endforeach
	</div>
	<p class="has-text-centered is-size-4">Prix de vente ou loyer mensuel (en €)</p>
	<div class="columns">
		<div class="column is-one-third">
			<div class="field">
				{!! Form::label('land_offer[land_price]', 'Foncier*', ['class' => 'label']); !!}
				{!! Form::number('land_offer[land_price]',
						 old('land_offer[land_price]'),
						  ['min' => 0,
						   'class' => 'input',
							':disabled' => 'isInputDisabled',
							'required'] ) !!}
			</div>
		</div>
		<div class="column ">
			<div class="field">
				{!! Form::label('land_offer[house_price]', 'Habitation*', ['class' => 'label']); !!}
				{!! Form::number('land_offer[house_price]',
						 old('land_offer[house_price]'),
						  ['min' => 0,
						   'class' => 'input',
						   ':disabled' => 'isInputDisabled',
						   'required'] ) !!}
			</div>
		</div>
		<div class="column ">
			<div class="field">
				{!! Form::label('land_offer[building_price]', 'Bâti*', ['class' => 'label']); !!}
				{!! Form::number('land_offer[building_price]',
						 old('land_offer[building_price]'),
						  ['min'=> 0,
						   'class' => 'input',
						   'required',
						   ':disabled' => 'isInputDisabled'] ) !!}
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
		{!! Form::label('land_offer[about_project]', 'Et si vous nous en disiez un peu plus sur votre projet ?*', ['class' => 'label']); !!}
		{!! Form::textarea('land_offer[about_project]',
				 old('land_offer[about_projet]'),
				  ['class' => 'textarea',
				  'required',
				  ':disabled'=>'isInputDisabled',
				  'maxlength'=>1000,
				  'placeholder'=>'Limite de 1000 caractères'] ) !!}
	</div>
	<div class="field">
		{!! Form::label('land_offer[about_content]', 'Et si vous nous en disiez un peu plus sur vous ?*', ['class' => 'label']); !!}
		{!! Form::textarea('land_offer[about_content]',
				 old('land_offer[about_content]'),
				  ['class' => 'textarea',
				  'required',
				   ':disabled' => 'isInputDisabled',
				   'maxlength' => 1000,
				   'placeholder' => 'Limite de 1000 caractères'] ) !!}
	</div>
	<div class="field">
		{!! Form::label('land_offer[title]', 'Titre de votre annonce*', ['class' => 'label']); !!}
		{!! Form::text('land_offer[title]', old('land_offer[title]'),
				 ['class' => 'input',
				  'required',
				  ':disabled' => 'isInputDisabled'] ) !!}
	</div>
	<div class="field">
		<span>Des photos ? Chaque photo augmente vos chances d’être recontactés !</span>
		<div class="file">
			<label class="file-label">
				{!! Form::file('land_offer[image1]',
						 ['class' => 'file-input',
						  ':disabled' => 'isInputDisabled']) !!}
				{!! Form::file('land_offer[image2]',
						 ['class' => 'file-input',
						  ':disabled'=>'isInputDisabled'] ) !!}
				{!! Form::file('land_offer[image3]',
						 ['class' => 'file-input',
						  ':disabled'=>'isInputDisabled'] ) !!}
				{!! Form::file('land_offer[image4]',
						 ['class' => 'file-input',
						  ':disabled' => 'isInputDisabled'] ) !!}
				{!! Form::file('land_offer[image5]',
						 ['class' => 'file-input',
						  ':disabled' => 'isInputDisabled'] ) !!}
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
			<input type="checkbox" name="certification_charte" required>
			Je certifie que mon projet correspond à la <a href="/">charte de Terre de Liens</a>
		</label>
	</div>
</div>