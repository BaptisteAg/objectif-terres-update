<div id="land_offer_form" class="form-container pt-6">
    <form-wizard
            title=""
            subtitle=""
            step-size="xs"
            @on-complete="$emit('form-complete')"
            @on-change="nextStep"
            color="#A74B2B"
            ref="formWizard">

        <tab-content title="Terres proposées">

            <section class="mb-6 field">
                <label class="label">Départements *</label>
                <autocomplete
                        name="department_id"
                        label="Département*"
                        id="department_id"
                        autocomplete="off"
                        ref="selectedDepartment"
                        src="/locations/departments"
                        v-model="formInput.selectedDepartment"
                        :vuelidate="$v.formInput.selectedDepartment"
                >
                    <template v-for="(zone, i) in formInput.selectedDepartment">
                        <input
                                key="zone.id"
                                autocomplete="off"
                                type="hidden"
                                name="department_id"
                                :value="zone.value.id"
                        >
                        <div
                                key="zone.label"
                                class="tag autocomplete-input-tag is-info"
                                @click="_ => formInput.selectedDepartment.splice(i, 1)"
                        >
                            @{{ zone.label }}
                            <i class="fa fa-trash" style="cursor:pointer; margin-left: 0.5em;"></i>
                        </div>
                    </template>
                </autocomplete>
            </section>

            <section class="field mb-6">
                <b-tooltip class="w-100"
                           label="Si votre bien se situe sur plusieurs communes, merci de nous les indiquées">
                    <zone-select
                            name="locationable"
                            label="Code Postal, Commune"
                            json-name="selected_zones"
                            ref="selectedZones"
                            v-model="formInput.selectedZones">
                    </zone-select>
                </b-tooltip>
            </section>

            <section class="field mb-6">
                <b-tooltip class="w-100"
                           label="Il est nécessaire que nous ayons les informations sur votre bien, à l'échelle de la commune mais l'annonce ne l'affichera pas si vous souhaitez rester plus général sur l'emplacement du foncier. Seul le département apparaitra.">
                    {!! Form::label('land_offer[accept_use_zip_code]', 'Confidentialité', [
                                    'class' => 'label',
                                ]); !!}
                    <b-checkbox name="land_offer[accept_use_zip_code]" class="is-size-6">
                        Je ne souhaite pas que la localisation soit publique.
                    </b-checkbox>
                </b-tooltip>
            </section>

            <section class="field mb-6" ref="altitude">
                <b-tooltip class="w-100"
                           label="Il est nécessaire que nous ayons les informations sur votre bien, à l'échelle de la commune mais l'annonce ne l'affichera pas si vous souhaitez rester plus général sur l'emplacement du foncier. Seul le département apparaitra.">
                    {!! Form::label('land_offer[surface]', 'Surface du foncier agricole*', [
                                    'class' => 'label',
                                ]); !!}
                    <b-field>
                        <b-input name="land_offer[surface]" v-model="formInput.surface" placeholder="1ha = 10 000m²"
                        ></b-input>
                        <p class="control">
                        <span style="border-bottom-right-radius: 999px; border-top-right-radius: 999px;"
                              class="button is-static">ha</span>
                        </p>
                    </b-field>
                    <template v-if="$v.formInput.surface.$error">
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
                </b-tooltip>
            </section>

            <section class="field mb-6" ref="surface">
                <b-tooltip class="w-100"
                           label="Important pour savoir si votre terrain convient à certains projets agricoles">

                    {!! Form::label('land_offer[altitude]', 'Altitude*', [
                                    'class' => 'label',
                                ]); !!}
                    <b-field>
                        <b-input name="land_offer[altitude]" v-model="formInput.altitude" placeholder="1ha = 10 000m²"
                        ></b-input>
                        <p class="control">
                        <span style="border-bottom-right-radius: 999px; border-top-right-radius: 999px;"
                              class="button is-static">m</span>
                        </p>
                    </b-field>
                    <template v-if="$v.formInput.altitude.$error">
                        <p class="help is-danger" v-if="$v.formInput.altitude.required">
                            Ce champ est requis.
                        </p>
                        <p class="help is-danger" v-if="!$v.formInput.altitude.numeric">
                            Veuillez saisir un nombre.
                        </p>
                    </template>
                </b-tooltip>
            </section>

            <section class="mb-6 field" ref="sauDescription">
                <b-tooltip class="w-100"
                           label="Décrivez la répartition de la Surface Agricole Utile (SAU) : terres arables (qui peuvent être labourées ou cultivées),
                                   surfaces toujours en herbe (prairies naturelles),
                                   cultures pérennes (vignes, vergers)">
                    {!! Form::label('land_offer[altitude]', 'Description du foncier agricole*', [
                                        'class' => 'label',
                                    ]); !!}
                    <text-area-counter
                            name="land_offer[sau_description]"
                            :max-length="1000"
                            :disabled="isInputDisabled"
                            ref="sauDescription"
                            v-model="formInput.sauDescription"
                            :vuelidate="$v.formInput.sauDescription">
                    </text-area-counter>
                </b-tooltip>
            </section>

        </tab-content>
        <tab-content title="Potentiel agricole">

        </tab-content>

        @include('pages.ads.partials.new-form-wizard-footer', ["moveToRef"=>"land_offer"])
    </form-wizard>
</div>
