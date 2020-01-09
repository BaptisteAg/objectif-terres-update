<div id="land_offer_form">
    <div class="field">
        {!! Form::label('is_beneficiary', 'Je poste l\'annonce', ['class' => 'label']); !!}
        <div class="select">
            {!! Form::select('is_beneficiary', ['true' => 'En mon nom','false' => 'Pour le compte d\'une autre personne'], null, ['placeholder' => 'Veuillez séléctionner...','required', ':disabled'=>'land_offer_ads.is_input_disabled']); !!}
        </div>
    </div>
    <div class="columns">
        <div class="column is-half">
            <div class="field">
                {!! Form::label('zipCode', 'Code postal', ['class' => 'label']); !!}
                <div class="control">
                    {!! Form::number('zipCode', null, ['min'=>1, 'class' => 'input', 'required', ':disabled'=>'land_offer_ads.is_input_disabled'] ) !!}
                </div>
            </div>
        </div>
        <div class="column"></div>
    </div>
    <div class="field">
        {!! Form::checkbox('accept_use_zip_code', 'true', false, [':disabled'=>'land_offer_ads.is_input_disabled']) !!}
        J'accepte que le code postal soit utilisé pour localiser l'annonce(recommandé)
    </div>
    <div class="field">
        {!! Form::label('surface_range', 'Surface du foncier agricole(en ha)', ['class' => 'label']); !!}
        {!! Form::checkbox('surface_range', '0-5', false, [':disabled'=>'land_offer_ads.is_input_disabled']) !!}
        0-5
        {!! Form::checkbox('surface_range', '5-10', false, [':disabled'=>'land_offer_ads.is_input_disabled']) !!}
        5-10
        {!! Form::checkbox('surface_range', '10-20', false, [':disabled'=>'land_offer_ads.is_input_disabled']) !!}
        10-20
        {!! Form::checkbox('surface_range', '20-50', false, [':disabled'=>'land_offer_ads.is_input_disabled']) !!}
        20-50
        {!! Form::checkbox('surface_range', '50-100', false, [':disabled'=>'land_offer_ads.is_input_disabled']) !!}
        50-100
        {!! Form::checkbox('surface_range', '>100', false, [':disabled'=>'land_offer_ads.is_input_disabled']) !!}
        >100
    </div>
    <div class="field">
        {!! Form::label('lands_offer_type', 'Type de cession du foncier', ['class' => 'label']); !!}
        {!! Form::checkbox('lands_offer_type', 'location', false, [':disabled'=>'land_offer_ads.is_input_disabled']) !!}
        Location
        {!! Form::checkbox('lands_offer_type', 'selling', false, [':disabled'=>'land_offer_ads.is_input_disabled']) !!}
        Vente
        {!! Form::checkbox('lands_offer_type', 'agricultural_test', false, [':disabled'=>'land_offer_ads.is_input_disabled']) !!}
        Test agricole
    </div>
    <p class="has-text-centered is-size-4">Bâti agricole</p>
    <div class="columns">
        <div class="column is-one-third">
            <div class="field">
                {!! Form::label('building_number', 'Nombre', ['class' => 'label']); !!}
                {!! Form::number('building_number', null, ['min'=>0, 'class' => 'input', ':disabled'=>'land_offer_ads.is_input_disabled'] ) !!}
            </div>
        </div>
        <div class="column ">
            <div class="field">
                {!! Form::label('building_surface', 'Surface (en m²)', ['class' => 'label']); !!}
                {!! Form::number('building_surface', null, ['min'=>0, 'class' => 'input', ':disabled'=>'land_offer_ads.is_input_disabled'] ) !!}
            </div>
        </div>
        <div class="column ">
            <div class="field">
                {!! Form::label('building_offer_type', 'Type de cession', ['class' => 'label']); !!}
                {!! Form::checkbox('building_offer_type', 'location', false, [':disabled'=>'land_offer_ads.is_input_disabled']) !!}
                Location
                {!! Form::checkbox('building_offer_type', 'selling', false, [':disabled'=>'land_offer_ads.is_input_disabled']) !!}
                Vente
            </div>
        </div>
    </div>
    <p class="has-text-centered is-size-4">Habitation</p>
    <div class="columns">
        <div class="column is-one-third">
            <div class="field">
                {!! Form::label('house_number', 'Nombre de pièces', ['class' => 'label']); !!}
                {!! Form::number('house_number', null, ['min'=>0, 'class' => 'input', ':disabled'=>'land_offer_ads.is_input_disabled'] ) !!}
            </div>
        </div>
        <div class="column ">
            <div class="field">
                {!! Form::label('house_surface', 'Surface (en m²)', ['class' => 'label']); !!}
                {!! Form::number('house_surface', null, ['min'=>0, 'class' => 'input', ':disabled'=>'land_offer_ads.is_input_disabled'] ) !!}
            </div>
        </div>
        <div class="column ">
            <div class="field">
                {!! Form::label('house_offer_type', 'Type de cession', ['class' => 'label']); !!}
                {!! Form::checkbox('house_offer_type', 'location', false, [':disabled'=>'land_offer_ads.is_input_disabled']) !!}
                Location
                {!! Form::checkbox('house_offer_type', 'selling', false, [':disabled'=>'land_offer_ads.is_input_disabled']) !!}
                Vente
            </div>
        </div>
    </div>
    <p class="has-text-centered is-size-4">Appel à candidature</p>
    <div class="field">
        {!! Form::checkbox('is_call_for_application_community', 'true', false, [':disabled'=>'land_offer_ads.is_input_disabled']) !!}
        Il s'agit d’un appel à candidatures dans le cadre d'un projet soutenu par une collectivité
    </div>
    <div class="field">
        {!! Form::checkbox('is_call_for_application_terre_de_liens', 'true', false, [':disabled'=>'land_offer_ads.is_input_disabled']) !!}
        Il s’agit d’un appel à candidatures pour une ferme Terre de Liens
    </div>
    <div class="field">
        {!! Form::checkbox('is_call_for_application_test_area', 'true', false, [':disabled'=>'land_offer_ads.is_input_disabled']) !!}
        Il s’agit d’un appel à candidatures dans le cadre d'un Espace test
    </div>
    <div class="field">
        {!! Form::label('is_activity_transfert', 'Transmission d\'activité (ferme toujours en fonctionnement)', ['class' => 'label']) !!}
        {!! Form::radio('is_activity_transfert', true, null, [':disabled'=>'land_offer_ads.is_input_disabled', 'v-model'=>'land_offer_ads.is_activity_transfer']) !!}
        Oui
        {!! Form::radio('is_activity_transfert', false, null, [':disabled'=>'land_offer_ads.is_input_disabled', 'v-model'=>'land_offer_ads.is_activity_transfer']) !!}
        Non
    </div>
    <div class="columns">
        <div class="column is-half" v-show="land_offer_ads.is_activity_transfer === ''">
            {!! Form::label('land_availability', 'A partir de quand votre terre est-elle disponible ?', ['class' => 'label']); !!}
            {!! Form::date('land_availability', \Carbon\Carbon::now(), [ ':disabled'=>'land_offer_ads.is_input_disabled'] ) !!}
        </div>
        <div class="column" v-show="land_offer_ads.is_activity_transfer === '1'">
            {!! Form::label('land_transfert_deadline', 'Avant quelle date souhaitez-vous transmettre votre ferme ?', ['class' => 'label']); !!}
            {!! Form::date('land_transfert_deadline', \Carbon\Carbon::now(), [ ':disabled'=>'land_offer_ads.is_input_disabled'] ) !!}
        </div>
    </div>
    <div class="field" v-show="land_offer_ads.is_activity_transfer === '1'">
        {!! Form::label('production_type', 'Système de production en place', ['class' => 'label']); !!}
        {!! Form::checkbox('production_type', 'production_type_1', false, [':disabled'=>'land_offer_ads.is_input_disabled']) !!}
        Production 1
        {!! Form::checkbox('production_type', 'production_type_2', false, [':disabled'=>'land_offer_ads.is_input_disabled']) !!}
        Production 2
        {!! Form::checkbox('production_type', 'other', false, ['v-model'=>'land_offer_ads.is_production_type_other',':disabled'=>'land_offer_ads.is_input_disabled' ]) !!}
        Autre
    </div>
    <div class="field" v-show="land_offer_ads.is_production_type_other">
        {!! Form::label('other_production_type', 'Veuillez préciser', ['class' => 'label']); !!}
        {!! Form::text('other_production_type', null, ['class' => 'input', ':disabled'=>'land_offer_ads.is_input_disabled'] ) !!}
    </div>
    <div class="field" v-show="land_offer_ads.is_activity_transfer === ''">
        {!! Form::label('production_type_wanted', 'Production envisageables', ['class' => 'label']); !!}
        {!! Form::checkbox('production_type_wanted', 'production_type_1', false, [':disabled'=>'land_offer_ads.is_input_disabled']) !!}
        Production 1
        {!! Form::checkbox('production_type_wanted', 'production_type_2', false, [':disabled'=>'land_offer_ads.is_input_disabled']) !!}
        Production 2
        {!! Form::checkbox('production_type_wanted', 'other', false, ['v-model'=>'land_offer_ads.is_production_type_wanted_other',':disabled'=>'land_offer_ads.is_input_disabled' ]) !!}
        Autre
        {!! Form::checkbox('production_type_wanted', 'unknown', false, [':disabled'=>'land_offer_ads.is_input_disabled' ]) !!}
        Je ne sais pas
    </div>
    <div class="field" v-show="land_offer_ads.is_production_type_wanted_other">
        {!! Form::label('other_production_type_wanted', 'Veuillez préciser', ['class' => 'label']); !!}
        {!! Form::text('other_production_type_wanted', null, ['class' => 'input', ':disabled'=>'land_offer_ads.is_input_disabled'] ) !!}
    </div>
    <div class="columns">
        <div class="column is-two-thirds">
            <div class="field">
                {!! Form::label('water_access', 'Accès à l\'eau (forage, réserve d\'eau, canal d’irrigation, borne)', ['class' => 'label']); !!}
                <div class="select">
                    {!! Form::select('water_access', ['yes' => 'Oui','no' => 'Non', 'unknown'=>'Je ne sais pas'],['placeholder' => 'Veuillez séléctionner...','required', ':disabled'=>'land_offer_ads.is_input_disabled']); !!}
                </div>
            </div>
        </div>
        <div class="column">
            <div class="field">
                {!! Form::label('altitude', 'Altitude (en m)', ['class' => 'label']); !!}
                <div class="control">
                    {!! Form::number('altitude', null, ['min'=>0, 'class' => 'input', ':disabled'=>'land_offer_ads.is_input_disabled', 'required'] ) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="field">
        {!! Form::label('bio_certification', 'Certification bio des terres', ['class' => 'label']); !!}
        {!! Form::checkbox('bio_certification', 'ab', false, [':disabled'=>'land_offer_ads.is_input_disabled']) !!}
        AB
        {!! Form::checkbox('bio_certification', 'demeter', false, [':disabled'=>'land_offer_ads.is_input_disabled']) !!}
        Demeter
        {!! Form::checkbox('bio_certification', 'nature_et_progres', false, [':disabled'=>'land_offer_ads.is_input_disabled']) !!}
        Nature & Progrès
        {!! Form::checkbox('bio_certification', 'conversion', false, [':disabled'=>'land_offer_ads.is_input_disabled']) !!}
        En conversion
        {!! Form::checkbox('bio_certification', 'none', false, [':disabled'=>'land_offer_ads.is_input_disabled']) !!}
        Aucune
    </div>
    <p class="has-text-centered is-size-4">Prix de vente ou loyer mensuel (en €)</p>
    <div class="columns">
        <div class="column is-one-third">
            <div class="field">
                {!! Form::label('land_price', 'Foncier', ['class' => 'label']); !!}
                {!! Form::number('land_price', null, ['min'=>0, 'class' => 'input', ':disabled'=>'land_offer_ads.is_input_disabled', 'required'] ) !!}
            </div>
        </div>
        <div class="column ">
            <div class="field">
                {!! Form::label('house_price', 'Habitation', ['class' => 'label']); !!}
                {!! Form::number('house_price', null, ['min'=>0, 'class' => 'input', ':disabled'=>'land_offer_ads.is_input_disabled'] ) !!}
            </div>
        </div>
        <div class="column ">
            <div class="field">
                {!! Form::label('building_price', 'Bâti', ['class' => 'label']); !!}
                {!! Form::number('building_price', null, ['min'=>0, 'class' => 'input', ':disabled'=>'land_offer_ads.is_input_disabled'] ) !!}
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
        {!! Form::label('about_project', 'Et si vous nous en disiez un peu plus sur votre projet ?', ['class' => 'label']); !!}
        {!! Form::textarea('about_project', null, ['class' => 'textarea','required', ':disabled'=>'land_offer_ads.is_input_disabled', 'maxlength'=>1000, 'placeholder'=>'Limite de 1000 caractères'] ) !!}
    </div>
    <div class="field">
        {!! Form::label('about_content', 'Et si vous nous en disiez un peu plus sur vous ?', ['class' => 'label']); !!}
        {!! Form::textarea('about_content', null, ['class' => 'textarea','required', ':disabled'=>'land_offer_ads.is_input_disabled', 'maxlength'=>1000, 'placeholder'=>'Limite de 1000 caractères'] ) !!}
    </div>
    <div class="field">
        {!! Form::label('title', 'Titre de votre annonce', ['class' => 'label']); !!}
        {!! Form::text('title', null, ['class' => 'input', 'required', ':disabled'=>'land_offer_ads.is_input_disabled'] ) !!}
    </div>
    <div class="field">
        <span>Des photos ? Chaque photo augmente vos chances d’être recontactés !</span>
        <div class="file">
            <label class="file-label">
                {!! Form::file('image1', ['class' => 'file-input', ':disabled'=>'land_offer_ads.is_input_disabled'] ) !!}
                {!! Form::file('image2', ['class' => 'file-input', ':disabled'=>'land_offer_ads.is_input_disabled'] ) !!}
                {!! Form::file('image3', ['class' => 'file-input', ':disabled'=>'land_offer_ads.is_input_disabled'] ) !!}
                {!! Form::file('image4', ['class' => 'file-input', ':disabled'=>'land_offer_ads.is_input_disabled'] ) !!}
                {!! Form::file('image5', ['class' => 'file-input', ':disabled'=>'land_offer_ads.is_input_disabled'] ) !!}
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
    <div class="field is-grouped">
        <div class="control">
            {!! Form::submit('Envoyer',['class'=>'button is-link', ':disabled'=>'land_offer_ads.is_input_disabled']) !!}
        </div>
        <div class="control">
            <button class="button is-link is-light">Annuler</button>
        </div>
    </div>
</div>