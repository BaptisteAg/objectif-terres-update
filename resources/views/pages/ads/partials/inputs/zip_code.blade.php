<div class="field">
    {!! Form::label('locationable', ($label ?? 'Code postal du bien').'*', ['class' => 'label']); !!}
    <div class="control">
        <autocomplete
                id="land_offer_zone-autocomplete"
                placeholder="Saisissez les premiers chiffres"
                ref='selectedZones'
                :disabled="isInputDisabled"
                src="/locations/{{$uri}}"
                v-model="formInput.selectedZones"
                aria-describedby='zipCodeError'>
        </autocomplete>
        <input type="hidden" :disabled="isInputDisabled" :name="'locationable['+zone.value.type+'][]'" :value="zone.value.id"
               v-for="(zone,i) in formInput.selectedZones">
        <input type="hidden" :disabled="isInputDisabled" name="selected_zones"
               :value="JSON.stringify(formInput.selectedZones)">
        <div>
            <span class="tag autocomplete-input-tag  is-info"
                  v-for="(zone,i) in formInput.selectedZones"
                  @click="_ => formInput.selectedZones.splice(i,1)">
                Code postal sélectionné :
                <b>@{{ zone.label }}</b>
                <i class="fa fa-trash" style="cursor:pointer"></i>
            </span>
        </div>
    </div>
    <p class="help is-danger" v-if="$v.formInput.selectedZones?.$error">
        Ce champ est requis. Vous devez sélectionner un code postal dans la liste.
    </p>
</div>
