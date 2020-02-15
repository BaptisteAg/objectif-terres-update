<div id="land_offer_form">
    <div class="field">
        {!! Form::label('landOffer[is_beneficiary]', 'Je poste l\'annonce*', ['class' => 'label']); !!}
        <div class="select">
            {!! Form::select('landOffer[is_beneficiary]',
                     ['true' => 'En mon nom',
                     'false' => 'Pour le compte d\'une autre personne'],
                      old('landOffer[is_beneficiary]'),
                      [
                          'placeholder' => 'Veuillez séléctionner...',
                          ':disabled' => 'isInputDisabled',
                          'v-model.trim'=>'formInput.isBeneficiary',
                          'ref' => 'isBeneficiary',
                          'aria-describedby'=>'isBeneficiaryError'
              ]); !!}
        </div>
        <p class="help is-danger" id="isBeneficiaryError" v-if="$v.formInput.isBeneficiary.$error">Ce champ est requis.</p>
    </div>
    <div class="columns">
        <div class="column is-half">
            <div class="field">
                {!! Form::label('landOffer[zip_code]', 'Code postal*', ['class' => 'label']); !!}
                <div class="control">
                    <autocomplete
                            id="land_offer_zone-autocomplete"
                            class="input"
                            placeholder="Saisissez les premiers chiffres"
                            ref='selectedZones'
                            :disabled="isInputDisabled"
                            src="/locations/cities"
                            v-model="formInput.selectedZones"
                            aria-describedby='zipCodeError'>
                    </autocomplete>
                    <input type="hidden" name="land_offer[zip_code]" :value="zone.value.id"  v-for="(zone,i) in formInput.selectedZones">
                    <input type="hidden" name="land_offer[selected_zones]" :value="JSON.stringify(formInput.selectedZones)">
                    <div>
                        <span class="tag is-info"
                              v-for="(zone,i) in formInput.selectedZones"
                              @click="_ => formInput.selectedZones.splice(i,1)">
                            Code postal sélectionné :&nbsp;&nbsp;
                            <b>@{{ zone.label }}</b>
                            &nbsp;&nbsp;
                            <i class="fa fa-trash" style="cursor:pointer"></i>
                        </span>
                    </div>
                </div>
                <p class="help is-danger" if="zipCodeError" v-if="$v.formInput.selectedZones.$error">Ce champ est requis. Vous devez sélectionner un code postal dans la liste.</p>
            </div>
        </div>
        <div class="column"></div>
    </div>
    <div class="field">
        {!! Form::checkbox('landOffer[accept_use_zip_code]', '1', old('landOffer[accept_use_zip_code]'), [':disabled'=>'isInputDisabled']) !!}
        J'accepte que le code postal soit utilisé pour localiser l'annonce (recommandé). A défaut, l'annonce sera localisée au niveau départemental.
    </div>
    <div class="field">
        {!! Form::label('landOffer[surface]', 'Surface totale du foncier agricole(en ha)*', ['class' => 'label']); !!}
        {!! Form::number('landOffer[surface]', null, ['min'=>0, 'class' => 'input', ':disabled'=>'isInputDisabled', 'v-model' => 'formInput.surface'] ) !!}
        <p class="help is-danger" id="surfaceError" v-if="$v.formInput.surface.$error">Ce champ est
            requis.</p>
    </div>
    <div class="field">
        {!! Form::label('landOffer[lands_offer_genre][]', 'Type de cession du foncier', ['class' => 'label']); !!}
        @foreach ($offerGenresLand->pluck('name','id') as $landOffer)
            {!! Form::checkbox('landOffer[lands_offer_genre][]', $landOffer,  old('landOffer[lands_offer_genre[]]'), [':disabled'=>'isInputDisabled']) !!}
            {{$landOffer}}
        @endforeach
    </div>
    <p class="has-text-centered is-size-4">Bâti agricole</p>
    <div class="columns">
        <div class="column is-one-third">
            <div class="field">
                {!! Form::label('landOffer[building_number]', 'Nombre', ['class' => 'label']); !!}
                {!! Form::number('landOffer[building_number]', old('landOffer[building_number]'), ['min'=>0, 'class' => 'input', ':disabled'=>'isInputDisabled'] ) !!}
            </div>
        </div>
        <div class="column ">
            <div class="field">
                {!! Form::label('landOffer[building_surface]', 'Surface totale (en m²)', ['class' => 'label']); !!}
                {!! Form::number('landOffer[building_surface]',
                         old('landOffer[building_surface]'),
                          ['min' => 0,
                           'class' => 'input',
                           ':disabled' => 'isInputDisabled']) !!}
            </div>
        </div>
        <div class="column ">
            <div class="field">
                {!! Form::label('landOffer[building_offer_genre][]', 'Type de cession', ['class' => 'label']); !!}
                @foreach ($offerGenresBuilding->pluck('name' ,'id') as $buildingOffer)
                    {!! Form::checkbox('landOffer[building_offer_genre][]', $buildingOffer, old('landOffer[building_offer_genre[]]'), [':disabled'=>'isInputDisabled']) !!}
                    {{$buildingOffer}}
                @endforeach
            </div>
        </div>
    </div>
    <p class="has-text-centered is-size-4">Habitation</p>
    <div class="columns">
        <div class="column is-one-third">
            <div class="field">
                {!! Form::label('landOffer[house_number]', 'Nombre de pièces', ['class' => 'label']); !!}
                {!! Form::number('landOffer[house_number]', old('landOffer[house_number]'), ['min'=> 0, 'class' => 'input', ':disabled'=>'isInputDisabled']); !!}
            </div>
        </div>
        <div class="column ">
            <div class="field">
                {!! Form::label('landOffer[house_surface]', 'Surface (en m²)', ['class' => 'label']); !!}
                {!! Form::number('landOffer[house_surface]', old('landOffer[house_surface]'), ['min'=> 0, 'class' => 'input', ':disabled'=>'isInputDisabled']); !!}
            </div>
        </div>
        <div class="column ">
            <div class="field">
                {!! Form::label('landOffer[house_offer_genre][]', 'Type de cession', ['class' => 'label']); !!}
                @foreach ($offerGenresHouse->pluck('name', 'id') as $houseOffer)
                    {!! Form::checkbox('landOffer[house_offer_genre][]', $houseOffer, old('landOffer[house_offer_genre[]]'), [':disabled' => 'isInputDisabled']) !!}
                    {{$houseOffer}}
                @endforeach
            </div>
        </div>
    </div>
    <p class="has-text-centered is-size-4">Appel à candidature</p>
    <div class="field">
        {!! Form::checkbox('landOffer[is_call_for_application_community]',
        'true',
        old('landOffer[is_call_for_application_community]'),
        [':disabled' => 'isInputDisabled']) !!}
        Il s'agit d’un appel à candidatures dans le cadre d'un projet soutenu par une collectivité
    </div>
    <div class="field">
        {!! Form::checkbox('landOffer[is_call_for_application_terre_de_liens]',
        'true',
        old('landOffer[is_call_for_application_terre_de_liens]'),
        [':disabled' => 'isInputDisabled']) !!}
        Il s’agit d’un appel à candidatures pour une ferme Terre de Liens
    </div>
    <div class="field">
        {!! Form::checkbox('landOffer[is_call_for_application_test_area]',
        'true',
        old('landOffer[is_call_for_application_test_area]'),
        [':disabled' => 'isInputDisabled']) !!}
        Il s’agit d’un appel à candidatures dans le cadre d'un Espace test
    </div>
    <div class="field">
        {!! Form::label('landOffer[is_activity_transfer]', 'Transmission d\'activité (ferme toujours en fonctionnement)*', ['class' => 'label']) !!}
        {!! Form::radio('landOffer[is_activity_transfer]',
        1,
        old('landOffer[is_activity_transfer]'),
        [':disabled' => 'isInputDisabled',
        'v-model' => 'formInput.isActivityTransfer',
		'ref' => 'formInput.isActivityTransfer',
		'aria-describedby'=>'isActivityTransferError']) !!}
        Oui
        {!! Form::radio('landOffer[is_activity_transfer]',
        0,
        old('landOffer[is_activity_transfer]'),
        [':disabled' => 'isInputDisabled',
        'v-model' => 'formInput.isActivityTransfer',
		'ref' => 'formInput.isActivityTransfer',
		'aria-describedby'=>'isActivityTransferError']) !!}
        Non
    </div>
    <p class="help is-danger" id="isActivityTransferError" v-show="$v.formInput.isActivityTransfer.$error">Ce champ est
        requis.</p>

    <div class="columns">
        <div class="column is-half" v-show="formInput.isActivityTransfer === '0'">
            {!! Form::label('landOffer[land_availability]', 'A partir de quand votre terre est-elle disponible ?', ['class' => 'label']); !!}
            {!! Form::date('landOffer[land_availability]', old('landOffer[land_availability]'), [ ':disabled' => 'isInputDisabled'] ) !!}
        </div>
        <div class="column" v-show="formInput.isActivityTransfer === '1' ">
            {!! Form::label('landOffer[land_transfer_deadline]', 'Avant quelle date souhaitez-vous transmettre votre ferme ?', ['class' => 'label']); !!}
            {!! Form::date('landOffer[land_transfer_deadline]', old('landOffer[land_availability]'), [ ':disabled' => 'isInputDisabled'] ) !!}
        </div>
    </div>
    <div class="field" v-show="formInput.isActivityTransfer === '1' ">
        {!! Form::label('landOffer[production_genre][]', 'Système de production en place*', ['class' => 'label']); !!}
        @foreach ($productionGenres->pluck('name', 'id') as $id => $productionGenre)
            {!! Form::checkbox(
                'landOffer[production_genre][]',
                $id,
                in_array($id, old('landOffer[production_genre][]', [])),
                [
                    ':disabled' => 'isInputDisabled || !formInput.isActivityTransfer',
                    'v-model'=>'formInput.productionGenre',
                    'ref' => 'productionGenre',
                ]
            ) !!}
            {{$productionGenre}}
        @endforeach
        <p class="help is-danger" id="productionGenreError" v-show="$v.formInput.productionGenre.$error">Ce champ est requis.</p>
    </div>

    <div class="field">
        <div v-if="formInput.isActivityTransfer === '0'">
            {!! Form::label('land_offer_production_genre_wanted_list', 'Production envisageables*', ['class' => 'label']); !!}
        </div>
        <div v-else>
            {!! Form::label('land_offer_production_genre_wanted_list', 'Production envisageables', ['class' => 'label']); !!}
        </div>

        @foreach ($productionGenres->pluck('name', 'id') as $id => $productionGenre)
            {!! Form::checkbox(
            'landOffer[production_genre_wanted][]',
            $id,
            in_array($id, old('landOffer[production_genre_wanted][]', [])),
            [
                ':disabled' => 'isInputDisabled',
                'v-model'=>'formInput.productionGenreWanted',
                'ref' => 'productionGenre',
            ]
            ) !!}
            {{$productionGenre}}
        @endforeach
        {!! Form::checkbox('landOffer[production_genre_wanted][]',
                '',
                old('landOffer[production_genre_wanted[]]'),
                [':disabled' => 'isInputDisabled' ]) !!}
        Je ne sais pas
    </div>
    <div class="columns">
        <div class="column is-two-thirds">
            <div class="field">
                {!! Form::label('landOffer[water_access]', 'Accès à l\'eau (forage, réserve d\'eau, canal d’irrigation, borne)*', ['class' => 'label']); !!}
                <div class="select">
                    {!! Form::select('landOffer[water_access]',
                             ['oui' => 'Oui',
                             'non' => 'Non',
                              '' => 'Je ne sais pas'],
                              old('landOffer[water_access]'),
                              ['placeholder' => 'Veuillez séléctionner...',
                              ':disabled' => 'isInputDisabled']); !!}
                </div>
            </div>
        </div>
        <div class="column">
            <div class="field">
                {!! Form::label('landOffer[altitude]', 'Altitude (en m)*', ['class' => 'label']); !!}
                <div class="control">
                    {!! Form::text('landOffer[altitude]',
                             null,
                             ['min'=> 0,
                              'class' => 'input',
                              ':disabled' => 'isInputDisabled',
                              'v-model.trim.lazy' => 'formInput.altitude',
                              'ref' => 'altitude',
                              'aria-describedby'=>'altitudeError']) !!}
                </div>
                <p class="help is-danger" id="altitudeError" v-if="$v.formInput.altitude.$error">Ce champ est
                    requis.</p>
                <p class="help is-danger" v-if="!$v.formInput.altitude.numeric">Veuillez saisir des chiffres.</p>
            </div>
        </div>
    </div>
    <div class="field">
        {!! Form::label('landOffer[bio_certification][]', 'Certification bio des terres*', ['class' => 'label']); !!}
        @foreach ($bioCertifications->pluck('name') as $bioCertification)
            {!! Form::checkbox('landOffer[bio_certification][]',
            $bioCertification,
            old('landOffer[bio_certification[]]'),
            [':disabled' => 'isInputDisabled',
            'v-model.trim.lazy' => 'formInput.bioCertification',
            'ref' => 'bioCertification',
            'aria-describedby'=>'bioCertificationError']) !!}
            {{$bioCertification}}
        @endforeach
        <p class="help is-danger" id="bioCertificationError" v-if="$v.formInput.bioCertification.$error">Ce champ est
            requis.</p>
    </div>
    <p class="has-text-centered is-size-4">Prix de vente ou loyer mensuel (en €)</p>

    <div class="columns">
        <div class="column is-one-third">
            <div class="field">
                {!! Form::label('landOffer[land_price]', 'Foncier', ['class' => 'label']); !!}
                {!! Form::number('landOffer[land_price]',
                         old('landOffer[land_price]'),
                          ['min' => 0,
                           'class' => 'input',
                            ':disabled' => 'isInputDisabled',
                            ] ) !!}
            </div>
        </div>
        <div class="column">
            <div class="field">
                {!! Form::label('landOffer[house_price]', 'Habitation', ['class' => 'label']); !!}
                {!! Form::number('landOffer[house_price]',
                         old('landOffer[house_price]'),
                          ['min' => 0,
                           'class' => 'input',
                           ':disabled' => 'isInputDisabled',
                           ] ) !!}
            </div>
        </div>
        <div class="column ">
            <div class="field">
                {!! Form::label('landOffer[building_price]', 'Bâti', ['class' => 'label']); !!}
                {!! Form::number('landOffer[building_price]',
                         old('landOffer[building_price]'),
                          ['min'=> 0,
                           'class' => 'input',
                           ':disabled' => 'isInputDisabled'] ) !!}
            </div>
        </div>
    </div>
    <div class="field">
        <label class="checkbox">
            <input type="checkbox"
                   id="land_offer[confirm_price_fermage]"
                   name="confirm_price_fermage"
                   :disabled="isInputDisabled"
                   v-model.trim.lazy="formInput.confirmPriceFermage"
                   ref='confirmPriceFermage'
                   aria-describedby='confirmPriceFermageError'>

            Je certifie que le prix est conforme à l’<a>indice des fermages de mon département</a>
        </label>
    </div>
    <div class="field">
        <label class="label is-inline-block has-tooltip-multiline has-tooltip-left"
               data-tooltip="Parce qu’il y a derrière chaque
				projet et chaque lieu des personnes
				et des histoires, nous vous invitons
				ici à en dire un peu plus sur vous et
				votre projet, le tout en quelques
				lignes : qu’est-ce qui motive votre
				projet ? Quelles sont vos attentes ?
				Quelles sont les valeurs qui vous
				portent ? Quelle est l’histoire du
				lieu ? Quelles sont les conditions de
				la transmission le cas échéant ?">Et si vous nous en disiez un peu plus sur votre projet ?* <i class="fas fa-info-circle has-text-info"></i></label>

        <text-area-counter
                name="land_offer[about_project_content]"
                :max-length=1000
                :disabled="isInputDisabled"
                v-model="formInput.aboutProject"
                :vuelidate="$v.formInput.aboutProject">
        </text-area-counter>

    </div>
    <div class="field">

        <label class="label is-inline-block">Et si vous nous en disiez un peu plus sur vous ?*</label>
        <button type="button" class="button icon has-text-info has-tooltip-multiline has-tooltip-left" data-tooltip="Parce qu’il y a derrière chaque
				projet et chaque lieu des personnes
				et des histoires, nous vous invitons
				ici à en dire un peu plus sur vous et
				votre projet, le tout en quelques
				lignes : qu’est-ce qui motive votre
				projet ? Quelles sont vos attentes ?
				Quelles sont les valeurs qui vous
				portent ? Quelle est l’histoire du
				lieu ? Quelles sont les conditions de
				la transmission le cas échéant ?">
            <i class="fas fa-info-circle"></i>
        </button>
        <text-area-counter
                name="land_offer[about_content]"
                :max-length=1000
                :disabled="isInputDisabled"
                :input-required=true
                v-model="formInput.aboutContent"
                :vuelidate="$v.formInput.aboutContent"
        >
        </text-area-counter>

    </div>
    <div class="field">
        {!! Form::label('landOffer[title]', 'Titre de votre annonce*', ['class' => 'label is-inline-block']); !!}
        <button type="button" class="button icon has-text-info has-tooltip-multiline has-tooltip-left" data-tooltip="Le titre de l’annonce est primordial !
				Il s’agit de votre carte de visite sur la
				plateforme. Un titre clair et bien
				formulé augmentera vos chances de
				contacts !">
            <i class="fas fa-info-circle"></i>
        </button>
        {!! Form::text('landOffer[title]', null,
                 ['class' => 'input',
                  ':disabled' => 'isInputDisabled',
                  'v-model.trim' => 'formInput.title',
                  'ref' => 'title',
                  'aria-describedby'=>'titleError',
                  'placeholder'=>'Saisissez votre titre'
                  ] ) !!}
        <p class="help is-danger" id="titleError" v-if="$v.formInput.title.$error">Ce champ est requis.</p>
        <p class="help is-danger" v-show="!$v.formInput.title.minLength">Le titre de votre annonce doit faire au minimum
            @{{$v.formInput.title.$params.minLength.min}} caractères .</p>
    </div>
    <div class="field">
        <span>Des photos ? Chaque photo augmente vos chances d’être recontactés !</span>
        <button type="button" class="button icon has-text-info has-tooltip-multiline has-tooltip-left"
                data-tooltip="5 photos maximum">
            <i class="fas fa-info-circle"></i>
        </button>
        <div class="file">
            <label class="file-label">
                {!! Form::file('landOffer[image1]',
                         ['class' => 'file-input',
                          ':disabled' => 'isInputDisabled']) !!}
                {!! Form::file('landOffer[image2]',
                         ['class' => 'file-input',
                          ':disabled'=>'isInputDisabled'] ) !!}
                {!! Form::file('landOffer[image3]',
                         ['class' => 'file-input',
                          ':disabled'=>'isInputDisabled'] ) !!}
                {!! Form::file('landOffer[image4]',
                         ['class' => 'file-input',
                          ':disabled' => 'isInputDisabled'] ) !!}
                {!! Form::file('landOffer[image5]',
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
            <input type="checkbox"
                   id="land_offer[chart_confirmation]"
                   name="certification_charte"
                   :disabled="isInputDisabled"
                   v-model.trim.lazy="formInput.chartConfirmation"
                   ref='chartConfirmation'
                   aria-describedby='chartConfirmationError'>

            Je certifie que mon projet correspond à la <a href="/">charte de Terre de Liens</a>
        </label>
        <p class="help is-danger" id="chartConfirmationError" v-if="$v.formInput.chartConfirmation.$error">Ce champ est
            requis.</p>
    </div>
</div>
