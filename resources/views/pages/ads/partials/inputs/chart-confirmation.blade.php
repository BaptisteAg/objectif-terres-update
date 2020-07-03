<div class="field">
    <label class="checkbox">
        <input type="checkbox"
               id="certification_charte"
               name="{{$inputNamePrefix}}[chart_confirmation]"
               :disabled="isInputDisabled"
               v-model="formInput.chartConfirmation"
               ref='chartConfirmation'
               aria-describedby='chartConfirmationError'>

        Je certifie que mon projet correspond à la <a href="/" target="_blank">charte de Terre de Liens</a>
    </label>
    <p class="help is-danger" id="chartConfirmationError"
       v-if="$v.formInput.chartConfirmation.$error">Vous
        devez cocher cette case.</p>
</div>
