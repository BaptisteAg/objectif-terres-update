<template>
  <div class="columns">
    <div class="column">
      <b-dropdown size="is-medium" v-model="selectedProductionGenres" expanded aria-role="list" class="mb-3" multiple>
        <template #trigger="{ active }">
          <b-button
              :label="label"
              :icon-right="active ? 'menu-up' : 'menu-down'"/>
        </template>

        <b-dropdown-item :disabled="isInputDisabled" v-for="(productionGenre, index) in productionGenres"
                         :key="index"
                         :value="productionGenre"
                         aria-role="listitem">
          {{ productionGenre.name }}
        </b-dropdown-item>
      </b-dropdown>
      <slot></slot>
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
          {{ selectedProductionGenre.name }}
        </b-tag>
      </b-taglist>
    </div>
    <input v-for="selectedProductionGenre in selectedProductionGenres" type="hidden" :name="name"
           :value="selectedProductionGenre.id">
  </div>
</template>
<script>
export default {
  props: {
    name: String,
    productionGenres: {
      type: Array,
      required: true
    },
  },
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
        return this.selectedProductionGenres[0].name
      } else {
        return this.selectedProductionGenres.length + ' genres de production sélectionnés'
      }
    },
    checked: {
      get() {
        return Array.isArray(this.value) ? this.value.map(v => v.toString()) : this.value.toString()
      },
      set(newValue) {
        if (Array.isArray(newValue)) {
          this.$emit('input', newValue);
        } else {
          this.$emit('input', this.inputValue)
        }
      }
    }
  },
}
</script>
