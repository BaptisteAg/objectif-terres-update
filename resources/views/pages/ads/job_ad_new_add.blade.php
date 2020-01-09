<div id="land_offer_form">
    <div class="field">
        {!! Form::label('is_beneficiary', 'Je poste l\'annonce', ['class' => 'label']); !!}
        <div class="select">
            {!! Form::select('is_beneficiary',
                ['true' => 'En mon nom',
                'false' => 'Pour le compte d\'une autre personne'],
                 null,
                 ['placeholder' => 'Veuillez séléctionner...',
                 'required',
                 ':disabled'=>'job_ads.is_input_disabled']);
                 old('is_beneficiary');!!}
        </div>
    </div>
    <div class="field">
        {!! Form::label('is_offer', 'Offre ou recherche ', ['class' => 'label']); !!}
        <div class="select">
            {!! Form::select('is_offer',
                ['true' => 'Je propose une opportunité professionnelle',
                'false' => 'Je cherche une opportunité professionnelle'],
                null,
                ['placeholder' => 'Veuillez séléctionner...',
                'required',
                ':disabled'=>'job_ads.is_input_disabled',
                'v-model'=>'job_ads.is_job_opportunity']
                ); old('is_offer')!!}
        </div>
    </div>
    <div class="columns">
        <div class="column is-half">
            <div class="field">
                {!! Form::label('zipCode', 'Code postal', ['class' => 'label']); !!}
                {!! Form::number('zipCode',
                 null,
                 ['min'=>1,
                  'class' => 'input',
                  ':disabled'=>'job_ads.is_input_disabled']
                  );old('zipCode') !!}

            </div>
        </div>
        <div class="column">
            <div class="field">
                {!! Form::label('city', 'Commune', ['class' => 'label']); !!}
                {!! Form::text('city',
                     null,
                     ['class' => 'input',
                     ':required'=>'job_ads.is_job_opportunity',
                      ':disabled'=>'job_ads.is_input_disabled']
                     ); old('city')!!}
            </div>
        </div>
    </div>
    <div class="field">
        {!! Form::label('agricultural_activity', 'Activités agricoles', ['class' => 'label']); !!}
        {!! Form::checkbox('agricultural_activity', 'option 1', false, [':disabled'=>'job_ads.is_input_disabled']); old('agricultural_activity') !!}
        Activité 1
        {!! Form::checkbox('agricultural_activity', 'option 2', false, [':disabled'=>'job_ads.is_input_disabled']); old('agricultural_activity') !!}
        Activité 2
        {!! Form::checkbox('agricultural_activity', 'option 3', false, [':disabled'=>'job_ads.is_input_disabled']); old('agricultural_activity') !!}
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
                ],null,
                 ['placeholder' => 'Veuillez séléctionner...',
                 'required',
                 ':disabled'=>'job_ads.is_input_disabled',
                 ':required'=>'job_ads.is_job_opportunity'
                 ]
	          );
            old('job_status') !!}
        </div>
    </div>
    <div class="field">
        {!! Form::label('experience_farming', 'Expérience dnas le milieu agricole (en années)', ['class' => 'label']); !!}
        {!! Form::number('experience_farming', null, ['min'=>0, 'class' => 'input', ':disabled'=>'job_ads.is_input_disabled'] ) !!}
    </div>
    <div class="field">
        {!! Form::label('is_offer', 'Niveau de formation agricole ', ['class' => 'label']); !!}
        <div class="select">
            {!! Form::select('is_offer', ['sans_diplome' => 'Sans diplôme','cap_agricole'=>'CAP Agricole','brevet_professionnelle_agricole' => 'Brevet professionnelle agricole', 'ingenieur_agricole'=>'Ingénieur agricole', 'bac+2'=>'Bac + 2','bac+3'=>'Bac + 3','bac+4'=>'Bac + 4','master'=>'Master','doctorat'=>'Doctorat', ], null, ['placeholder' => 'Veuillez séléctionner...','required', ':disabled'=>'job_ads.is_input_disabled']); !!}
        </div>
    </div>

    <div class="field">
        {!! Form::label('about_project', 'Et si vous nous en disiez un peu plus sur votre projet ?', ['class' => 'label']); !!}
        {!! Form::textarea('about_project', null, ['class' => 'textarea',':required'=>'job_ads.is_job_opportunity', ':disabled'=>'job_ads.is_input_disabled', 'maxlength'=>1000, 'placeholder'=>'Limite de 1000 caractères'] ) !!}
    </div>
    <div class="field">
        {!! Form::label('about_content', 'Et si vous nous en disiez un peu plus sur vous ?', ['class' => 'label']); !!}
        {!! Form::textarea('about_content', null, ['class' => 'textarea','required', ':disabled'=>'job_ads.is_input_disabled', 'maxlength'=>1000, 'placeholder'=>'Limite de 1000 caractères'] ) !!}
    </div>
    <div class="field">
        {!! Form::label('title', 'Titre de votre annonce', ['class' => 'label']); !!}
        {!! Form::text('title', null, ['class' => 'input', 'required', ':disabled'=>'job_ads.is_input_disabled'] ) !!}
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
    <div class="field is-grouped">
        <div class="control">
            {!! Form::submit('Envoyer',['class'=>'button is-link', ':disabled'=>'job_ads.is_input_disabled']) !!}
        </div>
        <div class="control">
            <button class="button is-light">Sauvergder</button>
        </div>
        <div class="control">
            <button class="button is-link is-light">Annuler</button>
        </div>
    </div>
</div>