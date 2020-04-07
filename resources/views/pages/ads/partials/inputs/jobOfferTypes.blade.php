<div class="columns">
    @foreach($jobOfferTypes as $i => $offerType)
        <div class="column">
            <custom-checkbox
                    name="{{$name}}"
                    input-value="{{$offerType["id"]}}"
                    v-model="formInput.offerTypes"
                    :disabled="isInputDisabled"
                    ref="offerTypes">

                <i class="fa {{$offerType["icon"]}}"
                   style="font-size: 30px;"></i><br><br>
                <span style="font-size:16px">
                    {{ $offerType["name"] }}
                </span>
            </custom-checkbox>
        </div>
    @endforeach
</div>