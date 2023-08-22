<template>
  <section class="global-map is-flex-direction-column is-flex is-justify-content-center is-align-items-center">

    <div class="is-flex is-flex-direction-column is-justify-content-space-around objT-border">

      <h3 class="title is-5">Consulter les annonces :</h3>

      <div class="columns is-desktop">
        <div class="column">
          <div class="is-flex is-flex-direction-column is-justify-content-space-between">
            <div class="mb-3">Je cherche</div>
            <b-dropdown v-model="adsForm.category" expanded aria-role="list">
              <template #trigger="{ active }">
                <b-button
                    :label="categoryLabels[adsForm.category] || 'Sélectionnez une catégorie'"
                    :icon-right="active ? 'menu-up' : 'menu-down'"/>
              </template>
              <b-dropdown-item aria-role="listitem" value="land">Une terre</b-dropdown-item>
              <b-dropdown-item aria-role="listitem" value="work">Un emploi</b-dropdown-item>
            </b-dropdown>

          </div>
        </div>

        <div class="column have-border">
          <div class="is-flex is-flex-direction-column is-justify-content-space-between">
            <div class="mb-3">Localisation</div>

            <b-dropdown expanded scrollable v-model="adsForm.localisation" aria-role="list" class="mb-3" multiple>
              <template #trigger="{ active }">
                <b-button
                    :label="getSelectedRegionsLabel()"
                    :icon-right="active ? 'menu-up' : 'menu-down'"/>
              </template>

              <b-dropdown-item
                  aria-role="listitem"
                  @click="toggleAllRegions"
                  :value="-1">
                Toutes les régions
              </b-dropdown-item>

              <b-dropdown-item separator></b-dropdown-item>

              <b-dropdown-item
                  v-for="(region, index) in regions"
                  :key="index"
                  aria-role="listitem"
                  :value="region.id">
                {{ region.name }}
              </b-dropdown-item>
            </b-dropdown>
          </div>
        </div>


        <div class="column have-border">
          <div class="is-flex is-flex-direction-column is-justify-content-space-between">
            <div class="mb-3">Production principale</div>

            <b-dropdown expanded v-model="adsForm.selectedProductions" aria-role="list" class="mb-3" multiple>
              <template #trigger="{ active }">
                <b-button
                    :label="getSelectedProductionsLabel()"
                    :icon-right="active ? 'menu-up' : 'menu-down'"/>
              </template>

              <b-dropdown-item aria-role="listitem" value="viticulture">Viticulture</b-dropdown-item>
              <b-dropdown-item aria-role="listitem" value="maraichage">Maraîchage</b-dropdown-item>
            </b-dropdown>

            <b-taglist>
              <b-tag
                  v-for="option in adsForm.selectedProductions"
                  :key="option"
                  rounded
                  closable
                  @close="removeSelectedProductions(option)"
              >
                {{ categoryLabels[option] }}
              </b-tag>
            </b-taglist>
          </div>
        </div>

      </div>
      <transition name="fade">
        <div class="columns is-desktop" v-if="advancedSearch.active">
          <div class="column">
            <div class="is-flex is-flex-direction-column is-justify-content-space-between">
              <div class="mb-3">Surface (en hectares)</div>
              <div class="columns">
                <div class="column">
                  <b-input v-model="adsForm.surfaceMin" placeholder="25" rounded></b-input>
                </div>
                <div class="column">
                  <b-input v-model="adsForm.surfaceMax" placeholder="40" rounded></b-input>
                </div>
              </div>
            </div>
          </div>
          <div class="column have-border">
            <div class="is-flex is-flex-direction-column is-justify-content-space-between">
              <div class="mb-3">Prix</div>
              <div class="columns">
                <div class="column">
                  <b-input v-model="adsForm.priceMin" placeholder="250000" rounded></b-input>
                </div>
                <div class="column">
                  <b-input v-model="adsForm.priceMax" placeholder="400000" rounded></b-input>
                </div>
              </div>
            </div>
          </div>
          <div class="column have-border">
            <div class="is-flex is-flex-direction-column is-justify-content-space-between">
              <div class="mb-3">Par mots clés</div>
              <div class="columns">
                <div class="column">
                  <b-input v-model="adsForm.keywords" placeholder="Mots clés..." rounded></b-input>
                </div>
              </div>
            </div>
          </div>
        </div>
      </transition>

    </div>

    <div class="columns is-desktop mt-5">
      <div class="column">
        <b-button @click="advancedSearchButton()" rounded>{{ advancedSearch.message }}</b-button>
      </div>
      <div class="column">
        <b-button rounded @click="sendAdsForm()" type="is-danger">Lancer la recherche</b-button>
      </div>
    </div>
  </section>
</template>
<script>
export default {
  props: ['regions'],
  data() {
    return {
      categoryLabels: {
        'land': 'Une terre',
        'work': 'Un emploi',
        'viticulture': 'Viticulture',
        'maraichage': 'Maraîchage',
      },
      advancedSearch: {
        "active": false,
        "message": "Recherche avancée"
      },
      adsForm: {
        category: "",
        localisation: [],
        selectedProductions: [],
        surfaceMin: null,
        surfaceMax: null,
        priceMin: null,
        priceMax: null,
        keywords: null,
      },
    }
  },
  methods: {
    removeSelectedProductions(option) {
      this.adsForm.selectedProductions = this.adsForm.selectedProductions.filter(o => o !== option);
    },
    advancedSearchButton() {
      this.advancedSearch.active = !this.advancedSearch.active
      this.advancedSearch.message = this.advancedSearch.active ? "Recherche simple" : "Recherche avancée"
    },
    sendAdsForm() {
      const params = new URLSearchParams();
      params.append('offer_type', 'OfferAd');
      params.append('ad_category', this.adsForm.category);
      this.adsForm.localisation.forEach(id => params.append('regions_location_researches_ids[]', id));
      params.append('surfaces_research_min', this.adsForm.surfaceMin);
      params.append('surfaces_research', this.adsForm.surfaceMax);
      params.append('price_min', this.adsForm.priceMin);
      params.append('price_max', this.adsForm.priceMax);
      params.append('keywords', this.adsForm.keywords);

      window.location.href = `https://beta.objectif-terres.org/recherche?${params.toString()}`;
    },
    getSelectedProductionsLabel() {
      if (!this.adsForm.selectedProductions.length) {
        return 'Sélectionnez une catégorie';
      }

      return this.adsForm.selectedProductions
          .map(option => this.categoryLabels[option])
          .join(', ');
    },
    toggleAllRegions() {
      if (this.adsForm.localisation.length === this.regions.length + 1) {
        this.adsForm.localisation = [];
      } else {
        this.adsForm.localisation = [...this.regions.map(region => region.id)];
      }
    },
    getSelectedRegionsLabel() {
      if (!this.adsForm.localisation.length) {
        return 'Sélectionnez une région';
      } else if (this.adsForm.localisation.length === this.regions.length) {
        return 'Toutes les régions';
      } else {
        return this.adsForm.localisation
            .map(id => this.regions.find(region => region.id === id).name)
            .join(', ');
      }
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
  }

  .column.have-border {
    border-left: 2px solid $border-color;
  }

  span.tag {
    background-color: $tag-background-color;
  }

  .dropdown button {
    width: 100%;
    justify-content: space-between;
    border-radius: 999px;
  }

  .dropdown div button span {
    width: 300px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    text-align: left;
  }
}
</style>