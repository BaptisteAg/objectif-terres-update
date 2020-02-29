<div class="field">
    <label class="checkbox">
        <input value="1"
               :disabled="isInputDisabled"
               {{old('accept_share_contact_infos') == 1 ? 'checked' : ''}}
               name="accept_share_contact_infos"
               type="checkbox">
        J'accepte de faire apparaître publiquement mes informations de contact
    </label>
</div>
