<section class="mb-6 field" ref="bioCertifications">
    {!! Form::label($adType.'[bio_certifications][]', 'Certification des terres *', ['class' => 'label']); !!}
    <multi-select
            :options="{{json_encode($bioCertifications)}}"
            group-values="children"
            name="{{ $adType }}[bio_certifications][]"
            v-model="formInput.bioCertifications"
            :clear-other-values="{{json_encode($bioCertifications->filter(function ($v) {
                                        return in_array($v->name, ['Aucune', 'En conversion', 'Je ne sais pas']);
                                    })->values())}}"
            :show-icons="true"
            placeholder="Sélectionnez une ou plusieurs certifications"
            ref="bioCertifications">
    </multi-select>
    <p class="help is-danger" v-if="$v.formInput.bioCertifications?.$error">
        Ce champ est requis.
    </p>
</section>
