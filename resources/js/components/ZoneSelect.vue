<template>
    <div class="selected-zones card">
        <header class="card-header">
            <p class="card-header-title">
                Zones de recherche
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
                            class="input"
                            placeholder="Ajoutez une zone en saisissant les premières lettres"
                            :disabled="disabled"
                            src="/json/locationables"
                            :data-renderer="renderZoneItemData"
                            v-model="value"
                            :multiple="true">
                    </autocomplete>
                    <div v-show="vuelidate.$error">
                        <p class="help is-danger">
                            Vous devez sélectionner au minimum une zone géographique.
                        </p>
                    </div>
                </div>

                <h4 v-if="value.length">Vous avez sélectionné :</h4>
                <h4 v-else>Vous n'avez encore sélectionné aucune zone.</h4>

                <div class="selected-zone" v-for="(zone,i) in value">
                    <span @click="_ => value.splice(i, 1)">
                        <i class="fa fa-trash-alt" style="cursor:pointer;"></i>
                    </span>
                    <b>{{getLabels().ZONE_TYPES[zone.value.type]}}</b> : {{zone.value.originalLabel}}
                    <input type="hidden" :name="name+'['+zone.value.type+'][]'" :value="zone.value.id">
                </div>
            </div>
        </div>
        <input type="hidden" :name="jsonName" :value="JSON.stringify(value)">
        <div class="card-footer">
            <div class="card-footer-item">
                <div class="column">
                    <p class="label">Dans un rayon de </p>
                    <vue-slider
                            :name="radiusName"
                            :data="['0km','5km','10km','20km','50km']"
                    ></vue-slider>
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

    const LABELS = {
        ZONE_TYPES: {
            cities: 'Code postal',
            departments: 'Département',
            regions: 'Région'
        }
    };

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
            jsonName: {
                type: String,
                required: true
            },
            radiusName: {
                type: String,
                required: true
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
        methods: {
            renderZoneItemData(item) {
                return {
                    label: this.getFormattedLabel(item),
                    value: {
                        ...item.value,
                        originalLabel: item.label
                    },
                }
            },
            getFormattedLabel(item) {
                if(!item.value) {
                    return item
                }
                else {
                    return '<b>' + LABELS.ZONE_TYPES[item.value.type] + '</b>: ' + item.label;
                }
            },
            getLabels() {
                return LABELS;
            }
        }
    }
</script>
