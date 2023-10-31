<b-tooltip
        label="Il s'agit des informations saisies lors de votre inscriptions sur le site. Vous pouvez les vérifier dans la rubrique Mon compte.">
{{--    <b-checkbox value="1" name="accept_share_contact_infos" :v-model="true">J'accepte de faire apparaître publiquement mes informations de contact</b-checkbox>--}}
    <input value="1"
           {{($old['accept_share_contact_infos'] ?? null) == 1 ? 'checked' : ''}}
           name="accept_share_contact_infos"
           type="checkbox">
    J'accepte de faire apparaître publiquement mes informations de contact
</b-tooltip>
