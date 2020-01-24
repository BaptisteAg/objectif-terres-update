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
                            ref='selectedZones'
                            :disabled="isInputDisabled"
                            src="/json/locationables"
                            :data-renderer="renderZoneItemData"
                            v-model="formInput.selectedZones"
                            :multiple="true">
                    </autocomplete>
                    <div v-show="$v.formInput.selectedZones.$error">
                        <p class="help is-danger" v-show="!$v.formInput.selectedZones.hasZone">
                            Vous devez sélectionner au minimum une zone géographique.
                        </p>
                    </div>
                </div>

                <h4 v-if="formInput.selectedZones.length">Vous avez sélectionné :</h4>
                <h4 v-else>Vous n'avez encore sélectionné aucune zone.</h4>

                <div class="selected-zone" v-for="(zone,i) in formInput.selectedZones">
                    <span @click="_ => formInput.selectedZones.splice(i, 1)">
                        <i class="fa fa-trash-alt" style="cursor:pointer;"></i>
                    </span>
                    <b>{{getLabels().ZONE_TYPES[zone.value.type]}}</b> : {{zone.value.originalLabel}}
                    <input type="hidden" :name="'land_seek[locationable]['+zone.value.type+'][]'" :value="zone.value.id">
                </div>
            </div>
        </div>
        <input type="hidden" name="land_seek[selected_zones]" :value="JSON.stringify(formInput.selectedZones)">
        <div class="card-footer">
            <div class="card-footer-item">
                <div class="column">
                    <p class="label">Dans un rayon de </p>
                    <vue-slider
                            name="land_seek[locationable_radius]"
                            :data="['0km','5km','10km','20km','50km']"
                    ></vue-slider>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss">
    .selected-zones {

    }
</style>

<script>
    import Autocomplete from "./Autocomplete";

    export default {
        components: [
            Autocomplete
        ],
        props: {
            value: {
                type:
            }
        },
        data() {
            return {
                id: 'zone-select'+Math.random().toString(36).substr(2, 9)
            }
        }
    }
</script>
