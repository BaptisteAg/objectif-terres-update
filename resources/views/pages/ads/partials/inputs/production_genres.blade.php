@php
    $isUnique = isset($isUnique) ? ($isUnique ? 'true' : 'false') : 'false';
@endphp
<list-select
        :production-genres="{{$productionGenres}}"
        name="{{$name}}"
        v-model="{{$vModel}}"
        :is-unique="{{ $isUnique }}"
        is-input-disable="isInputDisabled">
    @if($isRequired ?? false)
        <p class="help is-danger" id="productionGenresError"
           v-if="$v.{{ $vModel }}.$error">
            Ce champ est requis.
        </p>
    @endif
</list-select>
