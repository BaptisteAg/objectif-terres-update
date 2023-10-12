<div id="land_offer_form" class="form-container">
    <form-wizard
            title=""
            subtitle=""
            step-size="xs"
            @on-complete="$emit('form-complete')"
            @on-change="nextStep"
            color="#A74B2B"
            ref="formWizard">

        <tab-content title="Terres proposées">
            <section class="field mb-6">
                <zone-select
                        name="locationable"
                        label="Code Postal, Commune"
                        json-name="selected_zones"
                        ref="selectedZones"
                        v-model="formInput.selectedZones"
                        :disabled="isInputDisabled">
                </zone-select>
            </section>
        </tab-content>

        @include('pages.ads.partials.form-wizard-footer', ["moveToRef"=>"land_offer"])
    </form-wizard>
</div>
