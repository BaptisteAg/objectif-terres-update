<div class="field">
    <label class="checkbox tooltip has-tooltip-left has-tooltip-multiline" data-tooltip="Il s'agit des informations saisies lors de votre inscriptions sur le site. Vous pouvez les vérifier dans la rubrique Mon compte.">
        <input value="1"
               :disabled="isInputDisabled"
               {{old('accept_share_contact_infos') == 1 ? 'checked' : ''}}
               name="accept_share_contact_infos"
               type="checkbox">
        J'accepte de faire apparaître publiquement mes informations de contact
    </label>
</div>