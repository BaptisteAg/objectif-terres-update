@php
    $isUnique = isset($isUnique) ? $isUnique : false;
    $isRequired = isset($isRequired) ? $isRequired : false;
@endphp
{!! Form::label($name, (string)$label . ($isRequired ? ' *' : ''), ['class' => 'label']); !!}
<list-select
        unit-label="production"
        unit-label-gender="f"
        :options="{{$productionGenres}}"
        name="{{$name}}"
        v-model="{{$vModel}}"
        :is-unique="{{ $isUnique ? 'true' : 'false' }}">
    @if($isRequired ?? false)
        <p class="help is-danger" id="productionGenresError"
           v-if="$v.{{ $vModel }}?.$error">
            Ce champ est requis.
        </p>
    @endif
</list-select>
