<div class="field">
    <label class="label is-inline-block has-tooltip-multiline has-tooltip-left"
           data-tooltip="Pour donner envie à un cédant ou propriétaire de vous proposer du foncier, décrivez votre projet, son histoire, ses valeurs, votre date d'installation envisagée, etc."
           for="about_project_content">
        Et si vous nous en disiez un peu plus sur votre projet ?*
        <i class="fas fa-info-circle has-text-info"></i>
    </label>

    <text-area-counter
            name="about_project_content"
            :max-length="1000"
            :disabled="isInputDisabled"
            ref="aboutProject"
            v-model="formInput.aboutProject"
            :vuelidate="$v.formInput.aboutProject">
    </text-area-counter>
</div>
