<template>
    <div class="selected-zones card">
        <header class="card-header">
            <p class="card-header-title">
                {{label}}
            </p>
        </header>
        <div class="card-content">
            <div class="content">
                <div class="field">
                    <label class="label" :for="id">
                        Code postal, commune, département ou région*
                    </label>
                    <autocomplete
                            :id="id"
                            :placeholder="value.length ? 'Saisissez une autre localisation' : 'Saisissez au moins 2 caractères pour faire apparaître la liste'"
                            :disabled="disabled"
                            src="/locations"
                            :data-renderer="helper.renderZoneItemData"
                            v-model="value"
                            :multiple="true">
                    </autocomplete>
                    <div v-show="vuelidate.$error">
                        <p class="help is-danger">
                            Vous devez sélectionner au minimum une zone géographique.
                        </p>
                    </div>
                </div>

                <h4 v-if="value.length">Votre sélection :</h4>
                <div v-else>
                    Pour sélectionner une localisation cliquez dessus dans la liste. <br>
                    Vous pouvez ajouter plusieurs localisations l'une après l'autre.<br>
                    Pour trouver une commune utilisez de préférence le code postal sinon respectez bien les accents et les tirets pour qu'elle apparaisse dans la liste.
                </div>

                <div class="selected-zone" v-for="(zone,i) in value">
                    <span @click="_ => value.splice(i, 1)" data-tooltip="Retirer cette localisation">
                        <i class="fa fa-trash-alt" style="cursor:pointer;"></i>
                    </span>
                    <b>{{helper.getLabel(zone.value.type)}}</b> : {{zone.value.originalLabel || zone.label}}
                    <input type="hidden" :disabled="disabled" :name="name+'['+zone.value.type+'][]'" :value="zone.value.id" v-if="zone.value.id">
                    <template v-if="zone.value.ids">
                        <input type="hidden" :disabled="disabled" :name="name+'['+helper.getInputNameRangeMapping(zone.value.type)+'][]'" :value="id" v-for="id in zone.value.ids">
                    </template>
                </div>
            </div>
        </div>
        <input type="hidden" :disabled="disabled" :name="jsonName" :value="JSON.stringify(value)">
        <div class="card-footer">
            <div class="card-footer-item">
                <div class="column tooltip has-tooltip-left has-tooltip-multiline" data-tooltip="Sélectionnez une commune pour activer ce champ">
                    <p class="label">Dans un rayon de </p>
                    <vue-slider
                            :disabled="!hasCities"
                            :name="radiusName"
                            :value="radiusValue"
                            :data="{
                                '0': '0km',
                                '5': '5km',
                                '10': '10km',
                                '20': '20km',
                                '50': '50km',
                                '80': '80km',
                                '100': '100km'
                            }"
                    ></vue-slider>
<!--                    <div style="margin-top: 40px;">-->
<!--                        Ce rayon s'appliquera à chaque commune et code postal de votre sélection-->
<!--                    </div>-->
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss">
    .selected-zones.card {
        margin-bottom: 20px;

        .card-footer-item {
            margin-bottom: 20px;
        }

    }
</style>

<script>
    import Autocomplete from "./Autocomplete";
    import VueSlider from "./VueSlider";
    import { LocationHelper } from "../helpers";

    export default {
        components: {
            Autocomplete,
            VueSlider,
        },
        props: {
            value: {
                type: Array,
                required: true
            },
            vuelidate: {
                type: Object,
                required: true
            },
            name: {
                type: String,
                required: true
            },
            label: {
                type: String,
                required: true
            },
            jsonName: {
                type: String,
                required: true
            },
            radiusName: {
                type: String,
                required: true
            },
            radiusValue: {
                type: String,
                default: ''
            },
            disabled: {
                type: Boolean,
                required: true
            }
        },
        data() {
            return {
                id: 'zone-select'+Math.random().toString(36).substr(2, 9)
            }
        },
        computed: {
            hasCities() {
                return !!this.value.find(zone => zone.value.type.match(/cities|zipcode/));
            },
            helper() {
                return LocationHelper;
            }
        },
        watch: {
            value(locations) {
                let uniqueLocations = [];
                let indexesToRemove = [];

                locations.forEach((location,i) => {
                    if(uniqueLocations.includes(location.label)) {
                        indexesToRemove.push(i);
                    }
                    uniqueLocations.push(location.label);
                });

                indexesToRemove.forEach(indexToRemove => {
                    this.value.splice(indexToRemove, 1);
                })
            }
        },
        methods: {
        }
    }
</script>
