<div id="land_offer_form">
    <div class="field">
        {!! Form::label('is_beneficiary', 'Je poste l\'annonce', ['class' => 'label']); !!}
        <div class="select">
            {!! Form::select('is_beneficiary',
                ['true' => 'En mon nom',
                'false' => 'Pour le compte d\'une autre personne'],
                 old('is_beneficiary'),
                 ['placeholder' => 'Veuillez séléctionner...',
                 'required',
                 ':disabled'=>'job_ads.is_input_disabled']);
                 ;!!}
        </div>
    </div>
    <div class="field">
        {!! Form::label('is_offer', 'Offre ou recherche ', ['class' => 'label']); !!}
        <div class="select">
            {!! Form::select('is_offer',
                ['true' => 'Je propose une opportunité professionnelle',
                'false' => 'Je cherche une opportunité professionnelle'],
                old('is_offer'),
                ['placeholder' => 'Veuillez séléctionner...',
                'required',
                ':disabled'=>'job_ads.is_input_disabled',
                'v-model'=>'job_ads.is_job_opportunity']
                ); !!}
        </div>
    </div>
    <div class="columns">
        <div class="column is-half">
            <div class="field">
                {!! Form::label('zipCode', 'Code postal', ['class' => 'label']); !!}
                {!! Form::number('zipCode',
                 old('zipCode'),
                 ['min'=>1,
                  'class' => 'input',
                  ':disabled'=>'job_ads.is_input_disabled']
                  ); !!}

            </div>
        </div>
        <div class="column">
            <div class="field">
                {!! Form::label('city', 'Commune', ['class' => 'label']); !!}
                {!! Form::text('city',
                     old('city'),
                     ['class' => 'input',
                     ':required'=>'job_ads.is_job_opportunity',
                      ':disabled'=>'job_ads.is_input_disabled']
                     );!!}
            </div>
        </div>
    </div>
    <div class="field">
        {!! Form::label('agricultural_activity', 'Activités agricoles', ['class' => 'label']); !!}
        {!! Form::checkbox('agricultural_activity', 'option 1',  old('agricultural_activity'), [':disabled'=>'job_ads.is_input_disabled']); !!}
        Activité 1
        {!! Form::checkbox('agricultural_activity', 'option 2',  old('agricultural_activity'), [':disabled'=>'job_ads.is_input_disabled']);!!}
        Activité 2
        {!! Form::checkbox('agricultural_activity', 'option 3',  old('agricultural_activity'), [':disabled'=>'job_ads.is_input_disabled']); !!}
        Activité 3

    </div>
    <div class="field">
        {!! Form::label('job_status', 'Statut ', ['class' => 'label']); !!}
        <div class="select">
            {!! Form::select('job_status',
                ['Espace test' => 'Espace test',
                'Stage' => 'Stage',
                'Associé' => 'Associé',
                'Salariat' => 'Salariat',
                'Salariat' => 'Membre d\'un collectif'
                ],
                old('job_status'),
                 ['placeholder' => 'Veuillez séléctionner...',
                 'required',
                 ':disabled'=>'job_ads.is_input_disabled',
                 ':required'=>'job_ads.is_job_opportunity'
                 ]
	          );
            !!}
        </div>
    </div>
    <div class="field">
        {!! Form::label('experience_farming', 'Expérience dnas le milieu agricole (en années)', ['class' => 'label']); !!}
        {!! Form::number('experience_farming',
                 old('experience_farming'),
                 ['min'=>0,
                  'class' => 'input',
                  ':disabled'=>'job_ads.is_input_disabled'])
                   !!}
    </div>
    <div class="field">
        {!! Form::label('is_offer', 'Niveau de formation agricole ', ['class' => 'label']); !!}
        <div class="select">
            {!! Form::select('is_offer',
                    ['sans_diplome' => 'Sans diplôme',
                     'cap_agricole'=>'CAP Agricole',
                     'brevet_professionnelle_agricole' => 'Brevet professionnelle agricole',
                     'ingenieur_agricole'=>'Ingénieur agricole'],
                      old('is_offer'),
                      ['placeholder' => 'Veuillez séléctionner...',
                       'required',
                       ':disabled'=>'job_ads.is_input_disabled']);
                    !!}
        </div>
    </div>

    <div class="field">
        {!! Form::label('about_project', 'Et si vous nous en disiez un peu plus sur votre projet ?', ['class' => 'label']); !!}
        {!! Form::textarea('about_project',
                     old('about_project'),
                    ['class' => 'textarea',
                     ':required'=>'job_ads.is_job_opportunity',
                     ':disabled'=>'job_ads.is_input_disabled',
                     'maxlength'=>1000,
                     'placeholder'=>'Limite de 1000 caractères'])
                      !!}
    </div>
    <div class="field">
        {!! Form::label('about_content', 'Et si vous nous en disiez un peu plus sur vous ?', ['class' => 'label']); !!}
        {!! Form::textarea('about_content',
             old('about_content'),
            ['class' => 'textarea',
            'required',
            ':disabled'=>'job_ads.is_input_disabled',
             'maxlength'=>1000,
              'placeholder'=>'Limite de 1000 caractères'])
            !!}
    </div>
    <div class="field">
        {!! Form::label('title', 'Titre de votre annonce', ['class' => 'label']); !!}
        {!! Form::text('title', old('title'), ['class' => 'input', 'required', ':disabled'=>'job_ads.is_input_disabled'] ) !!}
    </div>
    <div class="field">
        <span>Augmentez votre chance d'être vu! Une photo augmente vos chances d’être recontactés !</span>
        <div class="file">
            <label class="file-label">
                {!! Form::file('image', ['class' => 'file-input', ':disabled'=>'job_ads.is_input_disabled'] ) !!}
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