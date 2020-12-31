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
                    radius-value="{{$old['locationable_radius'] ?? 0}}"
                    :vuelidate="$v.formInput.selectedZones"
                    :disabled="isInputDisabled">
            </zone-select>
        </div>
        <div class="column"></div>
    </div>
    @if(!empty($isSupportRequest))
        @if(isset($old["id"]))
            @include('pages.ads.partials.inputs.support-request-territory')
        @endif
    @endif


</section>
