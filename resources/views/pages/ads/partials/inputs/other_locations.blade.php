<section class="mb-6" {!! $condition ?? ''  !!}>
    @if(isset($tooltip) && $tooltip)
    <b-tooltip class="w-100 field" ref="selectedZones" label="{{$tooltip}}">
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
</section>
