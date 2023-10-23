<template>
  <div class="container">

    <div class="searchTags objT-border is-flex py-4 px-5 my-3 columns is-justify-content-space-between is-hidden-touch">
      <div class="is-flex is-align-items-center gap-2 column mw-30 flex-fit-content">
        <strong class="flex-fit-content">Je cherche</strong>
        <p class="three-dots">{{ categoryLabels[params.get('ad_category')] || 'Tout' }}</p>
      </div>

      <div class="is-flex is-align-items-center gap-2 column mw-37 flex-fit-content">
        <strong class="flex-fit-content">Localisation(s)</strong>
        <p class="three-dots">{{ regions_searched.join(', ') || 'Non définie' }}</p>
      </div>

      <div class="is-flex is-align-items-center gap-2 column mw-37 flex-fit-content">
        <strong class="flex-fit-content">Production principale</strong>
        <p class="three-dots">{{ productions_searched.join(', ') || 'Non définie' }}</p>
      </div>
    </div>
  </div>
</template>

<style>
.searchTags {
  background-color: #F8F3EE;
}
</style>

<script>
import {searchAdTypes} from "../definitions/searchAdTypes";

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
      categoryLabels: searchAdTypes,
    }
  },
}
</script>
