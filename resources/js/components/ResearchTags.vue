<template>
  <div class="container">

    <div class="searchTags objT-border is-flex py-4 px-5 my-3 columns is-justify-content-space-between">
      <div class="is-flex is-align-items-center gap-2 column w-30 flex-fit-content">
        <strong class="flex-fit-content">Je cherche</strong>
        <p class="three-dots">{{ categoryLabels[params.get('ad_category')] || 'Tout' }}</p>
      </div>

      <div class="is-flex is-align-items-center gap-2 column w-37 flex-fit-content">
        <strong class="flex-fit-content">Localisation(s)</strong>
        <p class="three-dots">{{ regions_searched.join(', ') || 'Non définie' }}</p>
      </div>

      <div class="is-flex is-align-items-center gap-2 column w-37 flex-fit-content">
        <strong class="flex-fit-content">Production principale</strong>
        <p class="three-dots">{{ productions_searched.join(', ') || 'Non définie' }}</p>
      </div>
    </div>

      <div class="is-fullwidth py-3 is-flex is-justify-content-flex-end gap-2">
          <b-button rounded tag="a" href="/" type="is-danger">Modifier ma recherche</b-button>
          <b-button rounded icon-left="heart-outline" tag="a" href="/">Sauvegarder</b-button>
      </div>
  </div>
</template>

<style>
.searchTags {
  background-color: #F8F3EE;
}
</style>

<script>
export default {
  props: {
    regions_searched: {
      type: Array
    },
    productions_searched: {
      type: Array
    }
  },
  data() {
    return {
      params: new URLSearchParams(window.location.search),
      categoryLabels: {
        land: 'Une terre',
        job: 'Un emploi',
      },
    }
  },
}
</script>
