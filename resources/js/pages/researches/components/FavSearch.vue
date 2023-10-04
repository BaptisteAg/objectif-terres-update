<template>
  <div>
    <b-button @click="isFavSearchModalOpen = true" rounded icon-left="heart-outline">Sauvegarder
    </b-button>
    <b-modal
        v-model="isFavSearchModalOpen"
        has-modal-card
        trap-focus
        :destroy-on-hide="false"
        aria-role="dialog"
        aria-label="Like"
        close-button-aria-label="Close"
        aria-modal>
      <template #default="props">
        <div class="bg-beige objT-border p-6 p-5-mobile">
          <h3 class="title">Sauvgarde d'une recherche</h3>
          <p>Donner un titre à votre recherche :</p>
          <div class="mt-5">
              <slot></slot>
          </div>
        </div>
      </template>
    </b-modal>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isFavSearchModalOpen: false
    }
  },
}
</script>
