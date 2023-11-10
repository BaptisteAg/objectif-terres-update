<section class="field mb-6" ref="surface">
    {!! Form::label("{$adType}[surface]", 'Surface du foncier agricole *', ['class' => 'label']); !!}
    <b-field>
        <b-input name="{{$adType}}[surface]" v-model="formInput.surface"
        ></b-input>
        <p class="control">
                    <span style="border-bottom-right-radius: 999px; border-top-right-radius: 999px;"
                          class="button is-static">ha</span>
        </p>
    </b-field>
    <template v-if="$v.formInput.surface?.$error">
        <p class="help is-danger" v-if="!$v.formInput.surface.maxValue">
            Surface maximum : @{{$v.formInput.surface.$params.maxValue.max}} hectares.
        </p>
        <p class="help is-danger" v-if="!$v.formInput.surface.required">
            Ce champ est requis.
        </p>
        <p class="help is-danger" v-if="!$v.formInput.surface.numeric">
            Veuillez saisir un nombre.
        </p>
    </template>
</section>