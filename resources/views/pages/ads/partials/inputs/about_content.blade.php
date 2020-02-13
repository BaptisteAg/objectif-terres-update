<div class="field">
    <label class="label is-inline-block has-tooltip-multiline has-tooltip-right"
           data-tooltip="Qui êtes-vous en quelques mots ?"
           for="about_content">
        Et si vous nous en disiez un peu plus sur vous ?*
        <i class="fas fa-info-circle has-text-info"></i>
    </label>

    <text-area-counter
            name="about_content"
            :max-length="1000"
            :disabled="isInputDisabled"
            ref="aboutContent"
            v-model="formInput.aboutContent"
            :vuelidate="$v.formInput.aboutContent">
    </text-area-counter>
</div>