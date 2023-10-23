@php
    if(!isset($isUnique) || $isUnique === null) {
        $isUnique = false;
    }
@endphp
<list-select
        unit-label="production"
        unit-label-gender="f"
        :options="{{$productionGenres}}"
        name="{{$name}}"
        v-model="{{$vModel}}"
        :is-unique="{{ $isUnique ? 'true' : 'false' }}"
        :is-input-disabled="isInputDisabled">
    @if($isRequired ?? false)
        <p class="help is-danger" id="productionGenresError"
           v-if="$v.{{ $vModel }}.$error">
            Ce champ est requis.
        </p>
    @endif
</list-select>
