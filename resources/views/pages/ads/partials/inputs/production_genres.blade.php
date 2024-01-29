@php
    $isUnique = isset($isUnique) ? $isUnique : false;
    $isRequired = isset($isRequired) ? $isRequired : false;
    $unitLabel = isset($unitLabel) ? $unitLabel : 'production';
    $unitLabelGender = isset($unitLabelGender) ? $unitLabelGender : 'f';
@endphp
{!! Form::label($name, (string)$label . ($isRequired ? ' *' : ''), ['class' => 'label']); !!}
@if(!$isUnique)
    <p>Vous pouvez renseigner plusieurs valeurs</p>
@endif
<list-select
        unit-label="{{$unitLabel}}"
        unit-label-gender="{{$unitLabelGender}}"
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
