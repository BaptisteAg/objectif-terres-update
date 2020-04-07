<section class="container">
    <div class="columns is-desktop">
        <div class="column"></div>
        <div class="column is-half-desktop is-8-mobile">
            <zone-select
                    name="locationable"
                    label="{{$label ?? "Zones de recherche"}}"
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
