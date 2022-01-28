@if(!empty($isSupportRequest))
    <div class="field">
        <label class="label" for='support_request_text'>
            Résumé*<br>
            <span style="font-weight:normal">
                Précisez brièvement ce que vous attendez de Terre de Liens,
                en quoi nous pourrions vous aider.
            </span>
        </label>

        <div class="control">
            <text-area-counter
                    name="support_request_text"
                    ref="supportRequestText"
                    :disabled="isInputDisabled"
                    :max-length="400"
                    v-model="formInput.supportRequestText"
                    :vuelidate="$v.formInput.supportRequestText">
            </text-area-counter>
        </div>
    </div>
@endif


