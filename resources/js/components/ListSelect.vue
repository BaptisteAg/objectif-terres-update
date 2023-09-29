<template>
  <div class="columns">
    <div class="column">
      <b-dropdown size="is-medium" v-model="selectedProductionGenres" expanded aria-role="list" class="mb-3" multiple>
        <template #trigger="{ active }">
          <b-button
              :label="label"
              :icon-right="active ? 'menu-up' : 'menu-down'"/>
        </template>

        <b-dropdown-item v-for="(productionGenre, index) in productionGenres"
                         :key="index"
                         :value="productionGenre.name"
                         aria-role="listitem">
          {{ productionGenre.name }}
        </b-dropdown-item>
      </b-dropdown>
    </div>
    <div class="column">
      <b-taglist>
        <b-tag
            v-for="(selectedProductionGenre,index) in selectedProductionGenres"
            :key="index"
            rounded
            size="is-medium"
            type="is-primary"
            closable
            @close="removeSelectedProductions(selectedProductionGenre)"
        >
          {{ selectedProductionGenre }}
        </b-tag>
      </b-taglist>
    </div>

  </div>
</template>
<script>
export default {
  props: ['productionGenres'],
  data() {
    return {
      selectedProductionGenres: [],
    }
  },
  methods: {
    removeSelectedProductions(option) {
      this.selectedProductionGenres = this.selectedProductionGenres.filter(o => o !== option);
    },
  },
  computed: {
    label() {
      if (this.selectedProductionGenres.length === 0) {
        return 'Sélectionner un genre de production'
      } else if (this.selectedProductionGenres.length === 1) {
        return this.selectedProductionGenres[0]
      } else {
        return this.selectedProductionGenres.length + ' genres de production sélectionnés'
      }
    }
  },
}
</script>
