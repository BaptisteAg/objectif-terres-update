<section class="mb-6 field" {!! $condition ?? ''  !!}>
    @if(isset($tooltip) && $tooltip)
        <b-tooltip class="w-100" ref="selectedZones" label="{{$tooltip}}">
            @endif
            <zone-select
                    src="{{ isset($withDepartments) && $withDepartments ? '/locations' : '/locations/cities' }}"
                    name="locationable"
                    label="{{$label}}"
                    json-name="selected_zones"
                    :has-tooltip="{{isset($tooltip) && $tooltip ? 'true' : 'false'}}"
                    ref="selectedZones"
                    :vuelidate="$v.formInput.selectedZones"
                    v-model="formInput.selectedZones">
            </zone-select>
            @if(isset($tooltip) && $tooltip)
        </b-tooltip>
    @endif
    <p>
        Il est nécessaire que nous ayons les informations sur votre bien à l'échelle de la commune, mais l'annonce ne
        l'affichera pas si vous souhaitez rester plus général sur l'emplacement du foncier. Seul le département
        apparaîtra.
    </p>
</section>
