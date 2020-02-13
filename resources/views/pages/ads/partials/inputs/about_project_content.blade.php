<div class="field">
    <label class="label is-inline-block has-tooltip-multiline has-tooltip-right"
           data-tooltip="Quel est le projet que vous portez ?
                            Qu’est-ce qui motive votre projet ?
                            Quelles sont les valeurs que vous
                            défendez ? etc."
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