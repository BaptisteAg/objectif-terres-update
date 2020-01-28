<div id="job_ad_form">
	<p class="is-size-7">Les champs marqués d'un astérisque (*) sont obligatoires</p>
	<div class="field">
		{!! Form::label('job_ad[is_beneficiary]', 'Je poste l\'annonce*', ['class' => 'label']); !!}
		<div class="select">
			{!! Form::select('job_ad[is_beneficiary]',
				[
					'true' => 'En mon nom',
					'false' => 'Pour le compte d\'une autre personne'
				],
				null,
				[
					 'placeholder' => 'Veuillez séléctionner...',
					 ':disabled'=>'isInputDisabled',
					 'v-model.trim.lazy' => 'formInput.beneficiary',
					 'ref' => 'beneficiary',
                   	'aria-describedby'=>'beneficiaryError']) !!}
		</div>
		<p class="help is-danger" id="beneficiaryError" v-if="$v.formInput.beneficiary.$error">Ce champ est requis.</p>
	</div>
	<div class="field">
		{!! Form::label('job_ad[is_offer]', 'Offre ou recherche* ', ['class' => 'label']); !!}
		<div class="select">
			{!! Form::select('job_ad[is_offer]',
				[
					1 => 'Je propose une opportunité professionnelle',
					0 => 'Je cherche une opportunité professionnelle'
				],
				null,
				[
					'placeholder' => 'Veuillez séléctionner...',
					':disabled'=>'isInputDisabled',
					'v-model' => 'formInput.isJobOpportunity',
					'ref' => 'isJobOpportunity',
                    'aria-describedby'=>'isJobOpportunityError']) !!}
		</div>
		<p class="help is-danger" id="isJobOpportunityError" v-if="$v.formInput.isJobOpportunity.$error">Ce champ est
			requis.</p>
	</div>
	<div class="columns">
		<div class="column is-half">
			<div class="field">
				<div v-if="isInputRequired === true">
					{!! Form::label('job_ad[zipCode]', 'Code postal*', ['class' => 'label']); !!}
				</div>
				<div v-else>
					{!! Form::label('job_ad[zipCode]', 'Code postal', ['class' => 'label']); !!}
				</div>
				{!! Form::text('job_ad[zipCode]',
						 old('job_ad[zipCode]'),
						 ['min'=>1,
						  'class' => 'input',
						   'v-model.trim.lazy'=>'formInput.zipCode',
						  ':disabled'=>'isInputDisabled',
						   'ref' => 'zipCode',
                   			'aria-describedby'=>'zipCodeError']
						  ); !!}
			</div>
			<p class="help is-danger" id="zipCodeError" v-if="$v.formInput.zipCode.$error">Ce champ est
				obligatoire.</p>
			<p class="help is-danger" v-if="!$v.formInput.zipCode.numeric">Veuillez saisir des chiffres.</p>
			<p class="help is-danger" v-if="!$v.formInput.zipCode.minLength || !$v.formInput.zipCode.maxLength">
				Veuillez saisir les 5 numéros d'un code postal valide.</p>
		</div>
		<div class="column">
			<div class="field">
				<div v-if="isInputRequired === true">
					{!! Form::label('job_ad[city]', 'Commune*', ['class' => 'label']); !!}
				</div>
				<div v-else>
					{!! Form::label('job_ad[city]', 'Commune', ['class' => 'label']); !!}
				</div>
				{!! Form::text('job_ad[city]',
						 old('job_ad[city]'),
						 ['class' => 'input',
						  'v-model.trim.lazy'=>'formInput.city',
						  ':disabled'=>'isInputDisabled',
						  'ref' => 'city',
						  'aria-describedby'=>'cityError']
						 );!!}
			</div>
			<p class="help is-danger" id="cityError" v-if="$v.formInput.city.$error">Ce champ est obligatoire.</p>
		</div>
	</div>
	<div class="field">
		<div v-if="isInputRequired === true">
			{!! Form::label('job_ad[agricultural_activity][]', 'Activités agricoles*', ['class' => 'label']); !!}

		</div>
		<div v-else>
			{!! Form::label('job_ad[agricultural_activity][]', 'Activités agricoles', ['class' => 'label']); !!}
		</div>
		@foreach ($agriculturalActivities->pluck('name', 'id') as $id => $agriculturalActivity)
			{!! Form::checkbox(
					'job_ad[agricultural_activity][]',
					$id,
					null,
					[':disabled'=>'isInputDisabled',
					  'v-model'=>'formInput.agriculturalActivity',
					  'ref' => 'agriculturalActivity',
					  'aria-describedby'=>'agriculturalActivityError'
					]) !!}
			{{$agriculturalActivity}}
		@endforeach
		<p class="help is-danger" id="agriculturalActivityError" v-if="$v.formInput.agriculturalActivity.$error">Ce
			champs est obligatoire.</p>
	</div>
	<div class="field">
		<div v-if="isInputRequired === true">
			{!! Form::label('job_ad[job_status]', 'Statut* ', ['class' => 'label']); !!}
		</div>
		<div v-else>
			{!! Form::label('job_ad[job_status]', 'Statut ', ['class' => 'label']); !!}
		</div>
		<div class="select">
			{!! Form::select('job_ad[job_status]',
					$jobStatus->pluck('name'),
					old('job_ad[job_status]'),
					 ['placeholder' => 'Veuillez séléctionner...',
					 ':disabled'=>'isInputDisabled',
					 'v-model.trim.lazy'=>'formInput.jobStatus',
					  'ref' => 'jobStatus',
					  'aria-describedby'=>'jobStatusError']);!!}
		</div>
		<p class="help is-danger" id="jobStatusError" v-if="$v.formInput.jobStatus.$error">Ce champ est
			obligatoire.</p>
	</div>
	<div class="field">
		{!! Form::label('job_ad[experience_farming]', 'Expérience dans le milieu agricole (en années)', ['class' => 'label']); !!}
		{!! Form::text('job_ad[experience_farming]',
				 old('job_ad[experience_farming]'),
				 ['min'=>0,
				  'class' => 'input',
				  ':disabled'=>'isInputDisabled',
				  'v-model.trim.lazy' => 'formInput.experienceFarming'])
				   !!}
		<p class="help is-danger" v-if="!$v.formInput.experienceFarming.numeric">Veuillez saisir des chiffres.</p>
	</div>
	<div class="field">
		{!! Form::label('job_ad[education_level]', 'Niveau de formation agricole ', ['class' => 'label']); !!}
		<div class="select">
			{!! Form::select('job_ad[is_offer]',
					$educationLevels->pluck('name', 'id'),
					  old('job_ad[education_level]'),
					  ['placeholder' => 'Veuillez séléctionner...',
					   ':disabled'=>'isInputDisabled']);!!}
		</div>
	</div>
	<div v-if="isInputRequired === true">
		<label class="label">Et si vous nous en disiez un peu plus sur votre projet ?*</label>
	</div>
	<div v-else>
		<label class="label">Et si vous nous en disiez un peu plus sur votre projet ?</label>
	</div>
	<div class="field">

		<text-area-counter
				name="job_ad[about_project_content]"
				:max-length=1000
				:disabled="isInputDisabled"
				v-model="formInput.aboutProject"
				:vuelidate="$v.formInput.aboutProject">
		</text-area-counter>
	</div>

	<div class="field">
		<label class="label is-inline-block">Et si vous nous en disiez un peu plus sur vous ?*</label>
		<button type="button" class="button icon has-text-info has-tooltip-multiline has-tooltip-right" data-tooltip="Dans le cas où vous êtes une personne
				morale dans le cadre d’un appel à
				candidatures, présentez votre structure
				et vos missions principales en quelques
				lignes.">
			<i class="fas fa-info-circle"></i>
		</button>
		<text-area-counter
				name="job_ad[about_content]"
				:max-length=1000
				:disabled="isInputDisabled"
				v-model="formInput.aboutContent"
				:vuelidate="$v.formInput.aboutContent">
		</text-area-counter>
	</div>
	<div class="field">
		{!! Form::label('job_ad[title]', 'Titre de votre annonce*', ['class' => 'label is-inline-block']); !!}
		<button type="button" class="button icon has-text-info has-tooltip-multiline has-tooltip-right" data-tooltip="Le titre de l’annonce est primordial ! Il
				s’agit de votre carte de visite sur la
				plateforme. Un titre clair et bien
				formulé augmentera vos chances de
				contacts !">
			<i class="fas fa-info-circle"></i>
		</button>
		{!! Form::text('job_ad[title]',
				 old('job_ad[title]'),
				  ['class' => 'input',
					':disabled'=>'isInputDisabled',
					'v-model.trim.lazy' => 'formInput.title',
					'ref' => 'title',
                    'aria-describedby'=>'titleError'] ) !!}

		<p class="help is-danger" id="titleError" v-show="$v.formInput.title.$error">Ce champ est requis.</p>
		<p class="help is-danger" v-show="!$v.formInput.title.minLength">Le titre de votre annonce doit faire au minimum
			@{{$v.formInput.title.$params.minLength.min}} caractères .</p>
	</div>
	<div class="field">
		<span>Augmentez votre chance d'être vu! Une photo augmente vos chances d’être recontactés !</span>
		<div class="file">
			<label class="file-label">
				{!! Form::file('job_ad[image]', ['class' => 'file-input', ':disabled'=>'isInputDisabled'] ) !!}
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
</div>