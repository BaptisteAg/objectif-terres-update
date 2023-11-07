<b-checkbox
        name="{{$inputNamePrefix}}[chart_confirmation]"
        v-model="formInput.chartConfirmation"
        aria-describedby='chartConfirmationError'>Je certifie que mon projet correspond à la <a
            href="{{URL::asset('docs/Charte_utilisation_d_Objectif_Terres-Validee_en_CIT_du_21_oct.pdf')}}"
            target="_blank">charte Objectif Terres *</a>
</b-checkbox>

<p class="help is-danger" id="chartConfirmationError"
   v-if="$v.formInput.chartConfirmation?.$error">Vous
    devez cocher cette case.</p>
