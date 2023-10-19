<template>
  <div>
    <b-button class="rounded-button-mobile" @click="showDocumentsModal = true" rounded icon-left="download">
      <span class="is-hidden-touch">Documents</span>
    </b-button>
    <b-modal
        v-model="showDocumentsModal"
        has-modal-card
        trap-focus
        :destroy-on-hide="false"
        aria-role="dialog"
        aria-label="Pre moderation modal"
        close-button-aria-label="Close"
        aria-modal>
      <template #default="props">
        <div class="bg-beige objT-border p-6 p-5-mobile">
          <h3 class="title">Documents joints au projet : </h3>
          <p>Choisissez le fichier à consulter</p>
          <div class="buttons mt-5">
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
      showDocumentsModal: false,
    }
  },
}
</script>
