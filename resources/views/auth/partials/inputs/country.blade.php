<div class="field">
    <label class="label">Pays*</label>
    <autocomplete
            name="countrySelect"
            id="countrySelect"
            autocomplete="off"
            class="@error('country_id') is-danger @enderror"
            placeholder="Saisissez les premiers caractères"
            ref='countrySelect'
            src="/locations/countries"
            v-model="countrySelect">
        <input autocomplete="off" type="hidden" name="country_id" :value="zone.value.id"
               v-for="(zone,i) in countrySelect">
        <div class="tag autocomplete-input-tag is-info"
             v-for="(zone,i) in countrySelect"
             @click="_ => countrySelect.splice(i,1)">
            @{{ zone.label }}
            &nbsp;&nbsp
            <i class="fa fa-trash" style="cursor:pointer"></i>
        </div>
    </autocomplete>
    @error('country_id')
    <article class="message is-danger" role="alert">
        <div class="message-body">
            {{ $message }}
        </div>
    </article>
    @enderror
</div>