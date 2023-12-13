<template>
	<section class="global-map is-flex-direction-column is-flex is-justify-content-center is-align-items-center">

		<div class="is-flex is-flex-direction-column is-justify-content-space-around objT-border">

			<h3 class="title is-5">Consulter les annonces :</h3>

			<div class="columns is-desktop">
				<div class="column is-one-third">
					<div class="is-flex is-flex-direction-column is-justify-content-space-between">
						<div class="mb-3">Je souhaite consulter ...</div>
						<b-dropdown v-model="adsForm.category" expanded aria-role="list">
							<template #trigger="{ active }">
								<b-button
									:label="categoryLabels[adsForm.category] || 'Sélectionnez une catégorie'"
									:icon-right="active ? 'menu-up' : 'menu-down'"/>
							</template>
							<b-dropdown-item aria-role="listitem" :value="category"
											 v-for="(label, category) of categoryLabels"
											 :key="category">
								{{ label }}
							</b-dropdown-item>
						</b-dropdown>

					</div>
				</div>

				<div class="column have-border is-one-third">
					<multiple-selector
						label="Région"
						unit-label="région"
						unit-label-gender="f"
						:list-options="regions"
						v-model="adsForm.localisation"
						:has-toggle-all="true"
					>
					</multiple-selector>
				</div>


				<div class="column have-border is-one-third">
					<multiple-selector
						label="Production principale"
						unit-label="production"
						unit-label-gender="f"
						:conditionDisabled="adsForm.category === 'all'"
						:listOptions="productions"
						v-model="adsForm.selectedProductions"
						:have-tags="true"

					>
					</multiple-selector>
				</div>
			</div>

			<transition name="fade">
				<div class="columns is-desktop" v-if="advancedSearch.active">
					<div class="column is-one-third"
						 v-if="['landSeekAd', 'landOfferAd', 'associateOfferAd'].includes(adsForm.category)">
						<div class="is-flex is-flex-direction-column is-justify-content-space-between">
							<div class="mb-3">Surface (en hectares)</div>
							<div class="columns">
								<div class="column">
									<b-input
										:disabled="!['landOfferAd', 'landSeekAd', 'all'].includes(adsForm.category)"
										v-model="adsForm.surfaceMin" placeholder="Minimum" rounded></b-input>
								</div>
								<div class="column">
									<b-input
										:disabled="!['landOfferAd', 'landSeekAd', 'all'].includes(adsForm.category)"
										v-model="adsForm.surfaceMax" placeholder="Maximum" rounded></b-input>
								</div>
							</div>
						</div>
					</div>
					<div class="column is-one-third">
						<!--						TODO:continuer-->
					</div>
				</div>
			</transition>
		</div>

		<div class="columns is-desktop mt-5">
			<div class="column">
				<b-button @click="advancedSearchButton()" :disabled="adsForm.category==='all'" rounded>
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
import MultipleSelector from "./composants/MultipleSelector.vue";

export default {
	components: {MultipleSelector},
	props: ['regions', 'productions'],
	data() {
		return {
			categoryLabels: searchAdTypes,
			advancedSearch: {
				"active": false,
				"message": "Recherche avancée"
			},
			adsForm: {
				category: "all",
				localisation: [],
				selectedProductions: [],
				surfaceMin: "",
				surfaceMax: "",
				priceMin: "",
				priceMax: "",
				keywords: "",
			},
		}
	},
	methods: {
		advancedSearchButton() {
			this.advancedSearch.active = !this.advancedSearch.active
			this.advancedSearch.message = this.advancedSearch.active ? "Recherche simple" : "Recherche avancée"
		},
		sendAdsForm() {
			const params = new URLSearchParams();
			params.append('ad_category', this.adsForm.category);

			if (this.adsForm.localisation.length > 0) {
				this.adsForm.localisation.forEach(id => params.append('regions_location_researches_ids[]', id));
				console.log(this.adsForm.localisation)
			}

			if (this.adsForm.selectedProductions.length > 0) {
				this.adsForm.selectedProductions.forEach(id => params.append('production_genres[]', id));
				console.log(this.adsForm.selectedProductions)
			}

			params.append('surfaces_research_min', this.adsForm.surfaceMin);
			params.append('surfaces_research', this.adsForm.surfaceMax);
			params.append('price_min', this.adsForm.priceMin);
			params.append('price_max', this.adsForm.priceMax);
			params.append('keywords', this.adsForm.keywords);

			console.log(params.toString())
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
		min-width: 70vw;
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

		.column.have-border {
			border-left: none;
		}
	}
}
</style>
