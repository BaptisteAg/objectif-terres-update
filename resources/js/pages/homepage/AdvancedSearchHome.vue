<template>
    <section class="global-map is-flex-direction-column is-flex is-justify-content-center is-align-items-center">

        <div class="is-flex is-flex-direction-column is-justify-content-space-around objT-border">

			<b-message v-if="error.formEmpty" type="is-danger">
				Merci de remplir le formulaire ci-dessous pour accéder aux annonces.
			</b-message>


            <form @submit.prevent="sendAdsForm()">
                <h3 class="title is-5">Consulter les annonces :</h3>

                <div class="columns is-desktop">
                    <div class="column is-one-third">
                        <single-selector
                            label="Je souhaite consulter ..."
                            :options="categoryLabels"
                            v-model="adsForm.selectedCategory">
                        </single-selector>
                    </div>

                    <div class="column is-one-third">
                        <multiple-selector
                            label="Région"
                            unit-label="région"
                            unit-label-gender="f"
                            :list-options="regions"
                            v-model="adsForm.selectedLocalisation"
                            :has-toggle-all="true"
                        >
                        </multiple-selector>
                    </div>

                    <div class="column is-one-third">
                        <multiple-selector
                            label="Production principale"
                            unit-label="production"
                            unit-label-gender="f"
                            :conditionDisabled="adsForm.selectedCategory === 'all'"
                            :listOptions="productions"
                            v-model="adsForm.selectedProductions"
                            :have-tags="true"
                        >
                        </multiple-selector>
                    </div>
                </div>

                <transition name="fade">
                    <div class="columns is-desktop is-flex-wrap-wrap" v-if="advancedSearch.active">

                        <div class="column is-one-third"
                             v-if="['landSeekAd', 'landOfferAd', 'associateOfferAd'].includes(adsForm.selectedCategory)">
                            <range-input
                                label="Surface (en hectares)"
                                v-model="adsForm.selectedSurface"
                                :error="error.surface"
                            >
                            </range-input>
                        </div>

                        <div class="column is-one-third"
                             v-if="['jobOfferAd'].includes(adsForm.selectedCategory)">
                            <multiple-selector
                                label="Type d'expérience"
                                unit-label="expérience"
                                unit-label-gender="f"
                                :listOptions="experiences"
                                v-model="adsForm.selectedExperiences"
                            >
                            </multiple-selector>
                        </div>

                        <div class="column is-one-third"
                             v-if="['jobSeekAd'].includes(adsForm.selectedCategory)">
                            <multiple-selector
                                label="Niveau de formation"
                                unit-label="formation"
                                unit-label-gender="f"
                                :listOptions="formations"
                                v-model="adsForm.selectedFormations"
                            >
                            </multiple-selector>
                        </div>

                        <div class="column is-one-third"
                             v-if="['landOfferAd', 'associateOfferAd'].includes(adsForm.selectedCategory)">
                            <single-selector
                                label="Accès à l'eau existant"
                                :options="waterAccess"
                                v-model="adsForm.selectedWaterAccess">
                            </single-selector>
                        </div>

                        <div class="column is-one-third"
                             v-if="['landSeekAd'].includes(adsForm.selectedCategory)">
                            <single-selector
                                label="Vous êtes installées ou comptez vous installer"
                                :options="installation"
                                v-model="adsForm.selectedInstallation">
                            </single-selector>
                        </div>

                        <div class="column is-one-third"
                             v-if="['landOfferAd'].includes(adsForm.selectedCategory)">
                            <multiple-selector
                                label="Type de transmission"
                                unit-label="transmission"
                                unit-label-gender="f"
                                :listOptions="transmission"
                                v-model="adsForm.selectedTransmissions"
                            >
                            </multiple-selector>
                        </div>

                        <div class="column is-one-third"
                             v-if="['landOfferAd'].includes(adsForm.selectedCategory)">
                            <range-input
                                label="Prix de vente"
                                v-model="adsForm.selectedPrice"
                                :error="error.price"
                            >
                            </range-input>
                        </div>

                        <div class="column is-one-third"
                             v-if="['landOfferAd'].includes(adsForm.selectedCategory)">
                            <range-input
                                label="Fermage annuel"
                                v-model="adsForm.selectedFermage"
                                :error="error.fermage"
                            >
                            </range-input>
                        </div>

                        <div class="column is-one-third">
                            <div class="is-flex is-flex-direction-column is-justify-content-space-between">
                                <div class="mb-3">Par mots clés</div>
                                <div class="columns">
                                    <div class="column">
                                        <b-input v-model="adsForm.selectedKeywords" placeholder="Mots clés..."
                                                 rounded></b-input>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </transition>
            </form>
        </div>

        <div class="columns is-desktop mt-5">
            <div class="column">
                <b-button @click="advancedSearchButton()" :disabled="adsForm.selectedCategory==='all'" rounded>
                    {{ advancedSearch.message }}
                </b-button>
            </div>
            <div class="column">
                <b-button rounded @click="sendAdsForm()" type="is-danger">Lancer la recherche</b-button>
            </div>
        </div>
    </section>
</template>
<script>
import {searchAdTypes} from "../../definitions/searchAdTypes";
import SingleSelector from "./composants/SingleSelectorInput.vue";
import MultipleSelector from "./composants/MultipleSelectorInput.vue";
import RangeInput from "./composants/RangeInput.vue";

export default {
    components: {RangeInput, MultipleSelector, SingleSelector},
    props: {
        regions: {
            type: Array,
            default: () => []
        },
        productions: {
            type: Array,
            default: () => []
        },
        experiences: {
            type: Array,
            default: () => []
        },
        formations: {
            type: Array,
            default: () => []
        },
        waterAccess: {
            type: Array,
            default: () => [
                {id: '1', name: 'Oui'},
                {id: '0', name: 'Non'},
                {id: '-1', name: 'Ne sait pas'},
            ]
        },
        installation: {
            type: Array,
            default: () => []
        },
        transmission: {
            type: Array,
            default: () => [
                {id: '1', name: 'Vente'},
                {id: '2', name: 'Location'},
                {id: '3', name: 'Test Agricole'},
            ]
        },
    },
    data() {
        const savedState = JSON.parse(sessionStorage.getItem('homeSearchState') || '{}');

        return {
            categoryLabels: Object.entries(searchAdTypes).map(([key, value]) => ({id: key, name: value})),
            advancedSearch: {
                "active": savedState.advancedSearchActive || false,
                "message": savedState.advancedSearchActive ? "Recherche simple" : "Recherche avancée"
            },
            adsForm: savedState.adsForm || {
                selectedCategory: "all",
                selectedLocalisation: [],
                selectedProductions: [],
                selectedExperiences: [],
                selectedFormations: [],
                selectedWaterAccess: '',
                selectedInstallation: '',
                selectedTransmissions: [],
                selectedSurface: {
                    min: "",
                    max: "",
                },
                selectedPrice: {
                    min: "",
                    max: "",
                },
                selectedFermage: {
                    min: "",
                    max: "",
                },
                selectedKeywords: "",
            },
            error: {
                formEmpty: false,
                surface: false,
                price: false,
                fermage: false,
            }
        }
    },
    watch: {
        adsForm: {
            handler(adsForm) {
                this.saveState({
                    advancedSearchActive: this.advancedSearch.active,
                    adsForm
                });
            },
            deep: true
        },
        'advancedSearch.active': function (advancedSearchActive) {
            this.saveState({
                advancedSearchActive,
                adsForm: this.adsForm
            });
        }
    },
    methods: {
        saveState(state) {
            sessionStorage.setItem('homeSearchState', JSON.stringify(state));
        },
        advancedSearchButton() {
            this.advancedSearch.active = !this.advancedSearch.active
            this.advancedSearch.message = this.advancedSearch.active ? "Recherche simple" : "Recherche avancée"
        },
        sendAdsForm() {
            this.error = {
				formEmpty: false,
                surface: false,
                price: false,
                fermage: false,
            }
            let error = false;

			if (this.adsForm.selectedCategory === 'all') {
				this.error.formEmpty = true;
				error = true;
			}

            if (parseInt(this.adsForm.selectedSurface.min) > parseInt(this.adsForm.selectedSurface.max)) {
                this.error.surface = true;
                error = true;
            }
            if (parseInt(this.adsForm.selectedPrice.min) > parseInt(this.adsForm.selectedPrice.max)) {
                this.error.price = true;
                error = true;
            }
            if (parseInt(this.adsForm.selectedFermage.min) > parseInt(this.adsForm.selectedFermage.max)) {
                this.error.fermage = true;
                error = true;
            }

            if (error) return;

            const params = new URLSearchParams();
            params.append('ad_category', this.adsForm.selectedCategory);

            if (this.adsForm.selectedLocalisation.length > 0) {
                this.adsForm.selectedLocalisation.forEach(id => params.append('regions_location_researches_ids[]', id));
            }

            if (this.adsForm.selectedProductions.length > 0) {
                this.adsForm.selectedProductions.forEach(id => params.append('production_genres[]', id));
            }

            if(this.advancedSearch.active) {
                if (['jobOfferAd'].includes(this.adsForm.selectedCategory)) {
                    this.adsForm.selectedExperiences.forEach(id => params.append('experiences[]', id));
                }

                if (['jobSeekAd'].includes(this.adsForm.selectedCategory)) {
                    this.adsForm.selectedFormations.forEach(id => params.append('formations[]', id));
                }

                if (['landOfferAd'].includes(this.adsForm.selectedCategory)) {
                    this.adsForm.selectedTransmissions.forEach(id => params.append('offer_genres[]', id));
                }

                if (['landSeekAd', 'landOfferAd', 'associateOfferAd'].includes(this.adsForm.selectedCategory)) {
                    this.adsForm.selectedSurface.min && params.append('surfaces_research_min', this.adsForm.selectedSurface.min);
                    this.adsForm.selectedSurface.max && params.append('surfaces_research_max', this.adsForm.selectedSurface.max);
                }

                if (['landOfferAd'].includes(this.adsForm.selectedCategory)) {
                    this.adsForm.selectedPrice.min && params.append('price_min', this.adsForm.selectedPrice.min);
                    this.adsForm.selectedPrice.max && params.append('price_max', this.adsForm.selectedPrice.max);
                    this.adsForm.selectedFermage.min && params.append('fermage_min', this.adsForm.selectedFermage.min);
                    this.adsForm.selectedFermage.max && params.append('fermage_max', this.adsForm.selectedFermage.max);
                }

                if(['landOfferAd', 'associateOfferAd'].includes(this.adsForm.selectedCategory)) {
                    this.adsForm.selectedWaterAccess && params.append('water_access', this.adsForm.selectedWaterAccess);
                }

                if(['landSeekAd'].includes(this.adsForm.selectedCategory)) {
                    this.adsForm.selectedInstallation && params.append('installation', this.adsForm.selectedInstallation);
                }

                this.adsForm.selectedKeywords && params.append('keywords', this.adsForm.selectedKeywords);
            }

            window.location.href = `/recherche?${params.toString()}`;
        },
    },
}
</script>
<style lang="scss">
$map-background: url("/images/illustrations/map.png");
$overlay-color: rgba(0, 0, 0, .6);
$border-color: #E3CFB5;
$background-color: #F8F3EE;
$tag-background-color: #E3CFB5;
$tablet: 769px;

.global-map .dropdown-item {
    white-space: normal;
}

.global-map {
    width: 100vw;
    min-height: 70vh;
    margin: 0;
    border-radius: 5px;
    z-index: 1;
    background-image: $map-background;
    background-position: center;
    background-repeat: no-repeat;
    position: relative;
    padding: 2em 0;

    //> div {
    //	> .columns {
    //		> .column:not(:last-child) {
    //				border-right: 2px solid $border-color;
    //		}
    //	}
    //}

    &:after {
        content: ' ';
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        background: $overlay-color;
        z-index: -1;
    }

    > div:first-child {
        width: 70vw;
        position: inherit;
        background-color: $background-color;
        padding: 2em;
        max-width: 90vw;
    }

    .column.have-border {
        border-left: 2px solid $border-color;
    }

    span.tag {
        background-color: $tag-background-color;
    }

    .dropdown div button span {
        width: 300px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        text-align: left;
    }

    .column.is-full {
        padding-top: 0;
    }
}

@media (max-width: $tablet) {
    .global-map {
        min-height: 80vh;
        padding: 0;
        background-position: top;
        background-size: cover;

        > div:first-child {
            width: 90vw;
            padding: 1em;
        }

    }
}
</style>
