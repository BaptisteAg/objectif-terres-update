<template>
  <section class="global-map is-flex is-justify-content-center is-align-items-center">

    <div class="is-flex is-flex-direction-column is-justify-content-space-around">

      <h3>Consulter les annonces :</h3>
      <div class="is-flex is-justify-content-space-between">

        <div class="columns is-desktop">
          <div class="column">
            <div class="is-flex is-flex-direction-column is-justify-content-space-between">
              <div>Je cherche</div>
              <dropdown :options="['Option 1', 'Option 2', 'Option 3']" @select="handleSelect"></dropdown>
            </div>
          </div>
          <div class="column">
            <div class="is-flex is-flex-direction-column is-justify-content-space-between">
              <div>Je cherche</div>
              <dropdown :options="['Option 1', 'Option 2', 'Option 3']" @select="handleSelect"></dropdown>
            </div>
          </div>
          <div class="column">
            <div class="is-flex is-flex-direction-column is-justify-content-space-between">
              <div>Production principale</div>
              <dropdown :options="['Option 1', 'Option 2', 'Option 3']" @select="handleSelect"></dropdown>
            </div>
          </div>
        </div>

      </div>
    </div>

  </section>
</template>
<style>
.global-map > div {
  width: 70vw;
  z-index: 10;
  min-height: 50%;
  position: inherit;
  background-color: #F8F3EE;
  padding: 2em;
}
</style>
<script>
import Dropdown from '../bulma/Dropdown.vue'

export default {
  components: {
    Dropdown
  },
  methods: {
    handleSelect(option) {
      console.log('Option sélectionnée :', option);
    }
  }
}
</script>