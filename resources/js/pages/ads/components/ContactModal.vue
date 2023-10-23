<template>
  <div>
    <b-button @click="showContactModal = true" rounded type="is-danger">
      Répondre à l'annonce
    </b-button>
    <b-modal
        v-model="showContactModal"
        has-modal-card
        trap-focus
        :destroy-on-hide="false"
        aria-role="dialog"
        aria-label="Pre contact modal"
        close-button-aria-label="Close"
        aria-modal>
      <template #default="props">
        <div class="bg-beige objT-border p-6 p-5-mobile">
          <slot></slot>
        </div>
      </template>
    </b-modal>
  </div>
</template>

<script>
export default {
  data() {
    return {
      showContactModal: false,
    }
  },
}
</script>
