<list-select
        :production-genres="{{$productionGenres}}"
        name="{{$name}}"
        v-model="{{$vModel}}">
    @if($isRequired ?? false)
        <p class="help is-danger" id="productionGenresError"
           v-if="$v.{{ $vModel }}.$error">
            Ce champ est requis.
        </p>
    @endif
</list-select>
