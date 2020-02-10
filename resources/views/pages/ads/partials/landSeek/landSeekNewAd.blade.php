<div id="land_seek_form">
    <form-wizard
        title=""
        subtitle=""
        next-button-text="Suivant"
        back-button-text="Précédent"
        finish-button-text="Publier"
        step-size="xs"
        @on-complete="$emit('form-complete')"
        color="#3498db"
        ref="formWizard">

        <tab-content title="Zone" icon="ti-location-arrow">
            <zone-select
                name="land_seek[locationable]"
                radius-name="land_seek[locationable_radius]"
                json-name="land_seek[selected_zones]"
                ref="selectedZones"
                v-model="formInput.selectedZones"
                :vuelidate="$v.formInput.selectedZones"
                :disabled="isInputDisabled">
            </zone-select>
        </tab-content>

        <tab-content title="Production" icon="ti-settings">
            <div class="field">
                {!! Form::label('land_seek[installation_type_id]', 'Type d\'installation*', ['class' => 'label']); !!}
                <div class="select">
                    {!! Form::select('land_seek[installation_type_id]',
                         $installationTypes->pluck('name', 'id'),
                         null,
                         ['placeholder' => 'Choisir un type d\'installation...',
                         "v-model.trim"=>"formInput.installationTypeId",
                         ':disabled' => 'isInputDisabled',
                         'ref' => 'installationTypeId',
                         'aria-describedby'=>'installationTypeIdError']); !!}
                </div>

                <p class="help is-danger" id="installationTypeIdError" v-if="$v.formInput.installationTypeId.$error">Ce
                    champ
                    est requis.</p>
            </div>

            <div class="field">
                {!! Form::label('land_seek[is_bio]', 'Je souhaite m\'installer en bio', ['class' => 'label']) !!}
                {!! Form::radio('land_seek[is_bio]', '1',old('land_seek[is_bio]') === '1', [':disabled' => 'isInputDisabled']) !!}
                oui
                {!! Form::radio('land_seek[is_bio]', '0', old('land_seek[is_bio]') === '0', [':disabled' => 'isInputDisabled']) !!}
                non
            </div>
            <div class="field">
                {!! Form::label('land_seek[surface_range][]', 'Surface recherchée(en ha)', ['class' => 'label']); !!}
                @foreach ($surfaceRanges->pluck('surface', 'id') as $id => $surface)
                    {!! Form::checkbox(
                        'land_seek[surface_range][]',
                        $id,
                        null,
                        [
                            ':disabled' => 'isInputDisabled'
                        ]
                    ) !!}
                    {{$surface}}
                @endforeach
            </div>
            <div class="field">
                {!! Form::label('land_seek[production_genre][]', 'Production(s) envisagée(s)*', ['class' => 'label']); !!}

                @foreach ($productionGenres->pluck('name', 'id') as $id => $productionGenre)
                    {!! Form::checkbox('land_seek[production_genre][]',
                        $id,
                        null,
                        [
                            ':disabled' => 'isInputDisabled',
                            'v-model'=>'formInput.productionGenre',
                            'ref' => 'productionGenre',
                            'aria-describedby'=>'productionGenreError'
                        ])
                    !!}
                    {{$productionGenre}}
                @endforeach
                {!! Form::checkbox('land_seek[production_genre][]',
                'other',
                null,
                [':disabled' => 'isInputDisabled',
                'v-model.trim.lazy'=>'formInput.productionGenre',
                'ref' => 'productionGenre',
                'aria-describedby'=>'productionGenreError']) !!}
                Autre
                <p class="help is-danger" id="productionGenreError" v-if="$v.formInput.productionGenre.$error">Ce champ
                    est
                    requis.</p>
            </div>

            <div class="field" v-show="isProductionGenreOther">
                {!! Form::label('land_seek[production_type_add]', 'Veuillez préciser', ['class' => 'label']); !!}
                {!! Form::text('land_seek[production_type_add]',
                     null,
                     [
                        'class' => 'input',
                        ':disabled' => 'isInputDisabled',
                        'v-model' => 'formInput.productionTypeAdd'
                     ]
                 ) !!}
            </div>
        </tab-content>

        <tab-content title="Foncier" icon="ti-home">
            <div class="field">
                {!! Form::label('land_seek_has_farms_or_buildings', 'Habitation(s) et bâti(s)', ['class' => 'label']); !!}
                {!! Form::checkbox('land_seek[has_farm_buildings]', '1', old('land_seek[has_farm_buildings]'), [':disabled' => 'isInputDisabled']) !!}
                Avec une maison d'habitation existante
                {!! Form::checkbox('land_seek[has_houses]', '1', old('land_seek[has_houses]'), [':disabled' => 'isInputDisabled']) !!}
                Avec des bâtis agricoles existants
            </div>
            <div class="field">
                {!! Form::label('land_seek[offer_genre_id]', 'Accès au foncier souhaité', ['class' => 'label']); !!}
                <div class="select">
                    {!! Form::select('land_seek[offer_genre_id]',
                             $offerGenresLandSeek->pluck('name', 'id'),
                             null,
                              ['placeholder' => 'Veuillez choisir...',
                               ':disabled' => 'isInputDisabled',
                               'v-model'=> 'formInput.offerGenre']);!!}
                </div>
            </div>
            <div class="field" v-show="formInput.offerGenre === '2'">
                {!! Form::label('land_seek[price_range][]', 'Prix (en €)', ['class' => 'label']); !!}
                @foreach ($priceRanges->pluck('price', "id") as $priceId => $price)
                    {!! Form::checkbox('land_seek[price_range][]', $priceId, in_array($priceId, old('land_seek[price_range]', [])), [':disabled' => 'isInputDisabled']) !!}
                    {{$price}}
                @endforeach
            </div>
            <div class="columns">
                <div class="column is-half">
                    <div class="field" v-show="formInput.offerGenre === '1'">
                        {!! Form::label('land_seek[rent_min]', 'Loyer minimum (en €)', ['class' => 'label']); !!}
                        {!! Form::text('land_seek[rent_min]',
                                 null,
                                  ['min'=>0,
                                  'class' => 'input',
                                   'v-model.trim'=> 'formInput.minRent',
                                   ':disabled' => 'isInputDisabled'] ) !!}
                        <p class="help is-danger" v-if="!$v.formInput.minRent.numeric">Veuillez saisir des chiffres.</p>
                    </div>
                </div>
                <div class="column">
                    <div class="field" v-show="formInput.offerGenre === '1'">
                        {!! Form::label('land_seek[rent_max]', 'Loyer maximum (en €)', ['class' => 'label']); !!}
                        {!! Form::text('land_seek[rent_max]',
                                  null,
                                  ['min'=>1,
                                  'class' => 'input',
                                  'v-model.trim' => 'formInput.maxRent',
                                  ':disabled' => 'isInputDisabled'] ) !!}
                        <p class="help is-danger" v-if="!$v.formInput.maxRent.numeric">Veuillez saisir des chiffres.</p>
                    </div>
                </div>
            </div>
        </tab-content>

        <tab-content title="Documents" icon="ti-folder">
            <div class="field">
                <span>Une photo de vous ? Une synthèse de votre projet ? Les photos sont importantes pour donner envie de consulter votre annonce.</span>

                <vue-dropzone
                    ref="documents"
                    id="dropzone"
                    :options="{
                        url: '/documents/upload',
                        thumbnailWidth: 150,
                        maxFiles: 5,
                        maxFilesize: 1,
                        addRemoveLinks: true,
                        uploadMultiple: true,
                        acceptedFiles: 'image/*, application/pdf, text/*, application/msword, application/vnd.ms-excel, application/zip'
                    }"
                    :duplicate-check="true"
                    :use-custom-slot="true"
                    @vdropzone-sending-multiple="onBeforeDocumentsUpload"
                    @vdropzone-success-multiple="onSuccessDocumentsUpload">

                    <div class="dropzone-custom-content">
                        <div class="subtitle">Cliquez ici pour déposer des fichiers</div>
                        <h3 class="dropzone-custom-title">Vous pouvez également glisser-déposer</h3>
                    </div>
                </vue-dropzone>
                <input type="hidden" name="land_seek[documents][]" :value="id" v-for="id in formInput.documents">
            </div>
        </tab-content>

        <tab-content title="Description" icon="ti-menu-alt">
            <div class="field">
                <label class="label is-inline-block has-tooltip-multiline has-tooltip-right"
                       data-tooltip="Pour certains cédants, l’expérience est
				un plus. N’hésitez pas à détailler ici de
				précédentes expériences
				professionnelles dans le domaine
				agricole, de stages ou de bénévolat sur
				des fermes ou encore si vous êtes
				titulaires de diplômes agricoles.">
                    Expérience dans le domaine agricole
                    <i class="fas fa-info-circle has-text-info"></i>
                </label>

                <text-area-counter
                    name="land_seek[experience_farming]"
                    :max-length=1000
                    :disabled="isInputDisabled"
                    ref="experienceFarming"
                    v-model="formInput.experienceFarming"
                    :vuelidate="$v.formInput.experienceFarming">
                </text-area-counter>
            </div>
            <div class="field">
                <label class="label is-inline-block has-tooltip-multiline has-tooltip-right"
                       data-tooltip="Quel est le projet que vous portez ?
                            Qu’est-ce qui motive votre projet ?
                            Quelles sont les valeurs que vous
                            défendez ? etc."
                       for="land_seek[about_project_content]">
                    Et si vous nous en disiez un peu plus sur votre projet ?*
                    <i class="fas fa-info-circle has-text-info"></i>
                </label>

                <text-area-counter
                    name="land_seek[about_project_content]"
                    :max-length="1000"
                    :disabled="isInputDisabled"
                    ref="aboutProject"
                    v-model="formInput.aboutProject"
                    :vuelidate="$v.formInput.aboutProject">
                </text-area-counter>
            </div>
            <div class="field">
                <label class="label is-inline-block has-tooltip-multiline has-tooltip-right"
                       data-tooltip="Qui êtes-vous en quelques mots ?"
                       for="land_seek[about_content]">
                    Et si vous nous en disiez un peu plus sur vous ?*
                    <i class="fas fa-info-circle has-text-info"></i>
                </label>

                <text-area-counter
                    name="land_seek[about_content]"
                    :max-length="1000"
                    :disabled="isInputDisabled"
                    ref="aboutContent"
                    v-model="formInput.aboutContent"
                    :vuelidate="$v.formInput.aboutContent">
                </text-area-counter>
            </div>
        </tab-content>

        <tab-content title="Titre" icon="ti-share">
            <div class="field">
                <label class="label is-inline-block has-tooltip-multiline has-tooltip-right"
                       for="land_seek[title]"
                       data-tooltip="Le titre de l’annonce est primordial ! Il
                                    s’agit de votre carte de visite sur la
                                    plateforme. Un titre clair et bien
                                    formulé augmentera vos chances de
                                    contacts.">
                    Titre de votre annonce*
                    <i class="fas fa-info-circle has-text-info"></i>
                </label>

                {!! Form::text('land_seek[title]',
                         null,
                         ['class' => 'input',
                          'placeholder'=> 'Saisissez votre titre...',
                          ':disabled' => 'isInputDisabled',
                          'v-model.trim' => 'formInput.title',
                          'ref' => 'title',
                          'aria-describedby'=>'titleError']) !!}
                <p class="help is-danger" id="titleError" v-if="$v.formInput.title.$error">Ce champ est requis.</p>
                <p class="help is-danger" v-show="!$v.formInput.title.minLength">Le titre de votre annonce doit faire au
                    minimum
                    @{{$v.formInput.title.$params.minLength.min}} caractères .</p>
            </div>
            <div class="field">
                <label class="checkbox">
                    <input type="checkbox"
                           id="certification_charte"
                           name="land_seek[chart_confirmation]"
                           :disabled="isInputDisabled"
                           v-model="formInput.chartConfirmation"
                           ref='chartConfirmation'
                           aria-describedby='chartConfirmationError'>

                    Je certifie que mon projet correspond à la <a href="/">charte de Terre de Liens</a>
                </label>
                <p class="help is-danger" id="chartConfirmationError" v-if="$v.formInput.chartConfirmation.$error">Vous
                    devez cocher cette case.</p>
            </div>

            <article class="message is-warning" v-if="$v.$error">
                <div class="message-header">
                    <p>Veuillez revoir votre formulaire</p>
                </div>
                <div class="message-body">
                    Des erreurs empêchent la publication de votre annonce. Avez-vous tout vérifié ?
                </div>
            </article>
        </tab-content>

        <template slot="custom-buttons-right">
            <button class="button is-light">Sauvegarder</button>
        </template>

    </form-wizard>
</div>

