<div class="field">
    <label class="label">Commune et Code postal*</label>
    <autocomplete
            name="citySelect"
            id="citySelect"
            autocomplete="off"
            class="@error('city_id') is-danger @enderror"
            placeholder="Saisissez les premiers caractères"
            ref='citySelect'
            src="/locations/cities"
            v-model="citySelect">
        <input autocomplete="off" type="hidden" name="city_id" :value="zone.value.id"
               v-for="(zone,i) in citySelect">
        <div class="tag autocomplete-input-tag is-info"
             v-for="(zone,i) in citySelect"
             @click="_ => citySelect.splice(i,1)">
            @{{ zone.label }}
            &nbsp;&nbsp
            <i class="fa fa-trash" style="cursor:pointer"></i>
        </div>
        <input type="hidden" name="country_id" value="75">
    </autocomplete>
    @error('city_id')
    <article class="message is-danger" role="alert">
        <div class="message-body">
            {{ $message }}
        </div>
    </article>
    @enderror
</div>