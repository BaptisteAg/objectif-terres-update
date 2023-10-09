<list-select
        :production-genres="{{$productionGenres}}"
        name="{{$name}}">
    <p class="help is-danger" id="productionGenresError"
       v-if="$v.formInput.productionGenres.$error">
        Ce champ est requis.
    </p>
</list-select>
