<section class="container">
    <div class="columns">
        <div class="column"></div>
        <div class="column is-half">
            <zone-select
                    name="locationable"
                    radius-name="locationable_radius"
                    json-name="selected_zones"
                    ref="selectedZones"
                    v-model="formInput.selectedZones"
                    radius-value="{{old('land_seek[locationable_radius]', 0)}}"
                    :vuelidate="$v.formInput.selectedZones"
                    :disabled="isInputDisabled">
            </zone-select>
        </div>
        <div class="column"></div>
    </div>
</section>
