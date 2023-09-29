<list-select :production-genres="{{$productionGenres}}"></list-select>
<div class="checkboxes-production-genre">
    <div class="columns">
        @foreach($productionGenres as $i => $productionGenre)
            <div class="column is-half">
                <custom-checkbox
                        name="{{$name}}"
                        input-value="{{$productionGenre["id"]}}"
                        :disabled="isInputDisabled"
                        v-model="{{ $vModel ?? "formInput.productionGenres" }}"
                        :exclusive-values="['1']"
                        ref="{{ $ref ?? "productionGenres" }}">

                    {{--                    <i class="fa fa-home"></i>--}}
                    <span style="font-size:16px">
                        {{ $productionGenre["name"] }}
                    </span>
                </custom-checkbox>
            </div>
            @if($i % 2)
    </div>
    <div class="columns">
        @endif
        @endforeach
    </div>
</div>
