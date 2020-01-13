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
                old('job_ad[is_beneficiary]'),
                [
                     'placeholder' => 'Veuillez séléctionner...',
                     'required',
                     ':disabled'=>'jobAd.isInputDisabled'
                ]
             ) !!}
        </div>
    </div>
    <div class="field">
        {!! Form::label('job_ad[is_offer]', 'Offre ou recherche* ', ['class' => 'label']); !!}
        <div class="select">
            {!! Form::select('job_ad[is_offer]',
                [
                    true => 'Je propose une opportunité professionnelle',
                    false => 'Je cherche une opportunité professionnelle'
                ],
                old('job_ad[is_offer]'),
                [
                    'placeholder' => 'Veuillez séléctionner...',
                    'required',
                    ':disabled'=>'jobAd.isInputDisabled',
                    'v-model'=>'jobAd.isJobOpportunity',
                ]
            ) !!}
        </div>
    </div>
    <div class="columns">
        <div class="column is-half">
            <div class="field">
                {!! Form::label('job_ad[zipCode]', 'Code postal', ['class' => 'label']); !!}
                {!! Form::number('job_ad[zipCode]',
                         old('job_ad[zipCode]'),
                         ['min'=>1,
                          'class' => 'input',
                          'required',
                          ':disabled'=>'jobAd.isInputDisabled']
                          ); !!}
            </div>
        </div>
        <div class="column">
            <div class="field">
                <div v-show="jobAd.isInputRequired === true">
                    {!! Form::label('job_ad[city]', 'Commune*', ['class' => 'label']); !!}
                </div>
                {!! Form::label('job_ad[city]', 'Commune', ['class' => 'label']); !!}
                {!! Form::text('job_ad[city]',
                         old('job_ad[city]'),
                         ['class' => 'input',
                         ':required'=>'jobAd.isInputRequired',
                          ':disabled'=>'jobAd.isInputDisabled']
                         );!!}
            </div>
        </div>
    </div>
    <div class="field">
        {!! Form::label('job_ad[agricultural_activity][]', 'Activités agricoles*', ['class' => 'label']); !!}
        {!! Form::checkbox('job_ad[agricultural_activity][]', 'option 1',  old('job_ad[agricultural_activity[]]'), [':disabled'=>'jobAd.isInputDisabled']); !!}
        Activité 1
        {!! Form::checkbox('job_ad[agricultural_activity][]', 'option 2',  old('job_ad[agricultural_activity[]]'), [':disabled'=>'jobAd.isInputDisabled']);!!}
        Activité 2
        {!! Form::checkbox('job_ad[agricultural_activity][]', 'option 3',  old('job_ad[agricultural_activity[]]'), [':disabled'=>'jobAd.isInputDisabled']); !!}
        Activité 3

    </div>
    <div class="field">
        <div v-show="jobAd.isInputRequired === true">
            {!! Form::label('job_ad[job_status]', 'Statut* ', ['class' => 'label']); !!}
        </div>
        {!! Form::label('job_ad[job_status]', 'Statut ', ['class' => 'label']); !!}
        <div class="select">
            {!! Form::select('job_ad[job_status]',
                    $jobStatus->pluck('name'),
                    old('job_ad[job_status]'),
                     ['placeholder' => 'Veuillez séléctionner...',
                     'required',
                     ':disabled'=>'jobAd.isInputDisabled',
                     ':required'=>'jobAd.isInputRequired']);!!}
        </div>
    </div>
    <div class="field">
        {!! Form::label('job_ad[experience_farming]', 'Expérience dnas le milieu agricole (en années)', ['class' => 'label']); !!}
        {!! Form::number('job_ad[experience_farming]',
                 old('job_ad[experience_farming]'),
                 ['min'=>0,
                  'class' => 'input',
                  ':disabled'=>'jobAd.isInputDisabled'])
                   !!}
    </div>
    <div class="field">
        {!! Form::label('job_ad[is_offer]', 'Niveau de formation agricole ', ['class' => 'label']); !!}
        <div class="select">
            {!! Form::select('job_ad[is_offer]',
                    ['sans_diplome' => 'Sans diplôme',
                     'cap_agricole'=>'CAP Agricole',
                     'brevet_professionnelle_agricole' => 'Brevet professionnelle agricole',
                     'ingenieur_agricole'=>'Ingénieur agricole'],
                      old('job_ad[is_offer]'),
                      ['placeholder' => 'Veuillez séléctionner...',
                       'required',
                       ':disabled'=>'jobAd.isInputDisabled']);
                    !!}
        </div>
    </div>
    <div v-show="jobAd.isInputRequired === true">
        {!! Form::label('job_ad[about_project]', 'Et si vous nous en disiez un peu plus sur votre projet ?*', ['class' => 'label']); !!}
    </div>
    <div class="field">
        {!! Form::label('job_ad[about_project]', 'Et si vous nous en disiez un peu plus sur votre projet ?', ['class' => 'label']); !!}
        {!! Form::textarea('job_ad[about_project]',
                 old('job_ad[about_project]'),
                ['class' => 'textarea',
                 ':required'=>'jobAd.isInputRequired',
                 ':disabled'=>'jobAd.isInputDisabled',
                 'maxlength'=>1000,
                 'placeholder'=>'Limite de 1000 caractères'])
                  !!}
    </div>
    <div class="field">
        {!! Form::label('job_ad[about_content]', 'Et si vous nous en disiez un peu plus sur vous ?*', ['class' => 'label']); !!}
        {!! Form::textarea('job_ad[about_content]',
                old('job_ad[about_content]'),
                ['class' => 'textarea',
                'required',
                ':disabled'=>'jobAd.isInputDisabled',
                 'maxlength'=>1000,
                  'placeholder'=>'Limite de 1000 caractères'])
                !!}
    </div>
    <div class="field">
        {!! Form::label('job_ad[title]', 'Titre de votre annonce*', ['class' => 'label']); !!}
        {!! Form::text('job_ad[title]',
                 old('job_ad[title]'),
                  ['class' => 'input',
                   'required',
                    ':disabled'=>'jobAd.isInputDisabled'] ) !!}
    </div>
    <div class="field">
        <span>Augmentez votre chance d'être vu! Une photo augmente vos chances d’être recontactés !</span>
        <div class="file">
            <label class="file-label">
                {!! Form::file('job_ad[image]', ['class' => 'file-input', ':disabled'=>'jobAd.isInputDisabled'] ) !!}
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