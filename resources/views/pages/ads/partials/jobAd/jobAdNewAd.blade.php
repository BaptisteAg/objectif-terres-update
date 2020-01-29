<div id="job_ad_form">
	<div class="field">
		{!! Form::label('jobAd[is_beneficiary]', 'Je poste l\'annonce*', ['class' => 'label']); !!}
		<div class="select">
			{!! Form::select('jobAd[is_beneficiary]',
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
		{!! Form::label('jobAd[is_offer]', 'Offre ou recherche* ', ['class' => 'label']); !!}
		<div class="select">
			{!! Form::select('jobAd[is_offer]',
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

    <zone-select
        name="job_ad[locationable]"
        radius-name="job_ad[locationable_radius]"
        json-name="job_ad[selected_zones]"
        ref="selectedZones"
        v-model="formInput.selectedZones"
        :vuelidate="$v.formInput.selectedZones"
        :disabled="isInputDisabled">
    </zone-select>

	<div class="field">
		<div v-if="isInputRequired === true">
			{!! Form::label('jobAd[agricultural_activity][]', 'Activités agricoles*', ['class' => 'label']); !!}

		</div>
		<div v-else>
			{!! Form::label('jobAd[agricultural_activity][]', 'Activités agricoles', ['class' => 'label']); !!}
		</div>
		@foreach ($agriculturalActivities->pluck('name', 'id') as $id => $agriculturalActivity)
			{!! Form::checkbox(
					'jobAd[agricultural_activity][]',
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
			{!! Form::label('jobAd[job_status]', 'Statut* ', ['class' => 'label']); !!}
		</div>
		<div v-else>
			{!! Form::label('jobAd[job_status]', 'Statut ', ['class' => 'label']); !!}
		</div>
		<div class="select">
			{!! Form::select('jobAd[job_status]',
					$jobStatus->pluck('name'),
					old('jobAd[job_status]'),
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
		{!! Form::label('jobAd[experience_farming]', 'Expérience dans le milieu agricole (en années)', ['class' => 'label']); !!}
		{!! Form::text('jobAd[experience_farming]',
				 old('jobAd[experience_farming]'),
				 ['min'=>0,
				  'class' => 'input',
				  ':disabled'=>'isInputDisabled',
				  'v-model.trim.lazy' => 'formInput.experienceFarming'])
				   !!}
		<p class="help is-danger" v-if="!$v.formInput.experienceFarming.numeric">Veuillez saisir des chiffres.</p>
	</div>
	<div class="field">
		{!! Form::label('jobAd[education_level]', 'Niveau de formation agricole ', ['class' => 'label']); !!}
		<div class="select">
			{!! Form::select('jobAd[is_offer]',
					$educationLevels->pluck('name', 'id'),
					  old('jobAd[education_level]'),
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
		{!! Form::label('jobAd[title]', 'Titre de votre annonce*', ['class' => 'label is-inline-block']); !!}
		<button type="button" class="button icon has-text-info has-tooltip-multiline has-tooltip-right" data-tooltip="Le titre de l’annonce est primordial ! Il
				s’agit de votre carte de visite sur la
				plateforme. Un titre clair et bien
				formulé augmentera vos chances de
				contacts !">
			<i class="fas fa-info-circle"></i>
		</button>
		{!! Form::text('jobAd[title]',
				 old('jobAd[title]'),
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
				{!! Form::file('jobAd[image]', ['class' => 'file-input', ':disabled'=>'isInputDisabled'] ) !!}
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
