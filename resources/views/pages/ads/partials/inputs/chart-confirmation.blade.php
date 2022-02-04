<div class="field">
    <label class="checkbox">
        <input type="checkbox"
               id="certification_charte"
               name="{{$inputNamePrefix}}[chart_confirmation]"
               :disabled="isInputDisabled"
               v-model="formInput.chartConfirmation"
               ref='chartConfirmation'
               aria-describedby='chartConfirmationError'>

        Je certifie que mon projet correspond à la&nbsp; <a href="{{URL::asset('docs/Charte_utilisation_d_Objectif_Terres-Validee_en_CIT_du_21_oct.pdf')}}" target="_blank"> charte Objectif Terres*</a>
    </label>
    <p class="help is-danger" id="chartConfirmationError"
       v-if="$v.formInput.chartConfirmation.$error">Vous
        devez cocher cette case.</p>
</div>
