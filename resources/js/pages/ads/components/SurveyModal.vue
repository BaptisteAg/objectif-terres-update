<template>
  <div>
    <div class="buttons has-addons is-right">
      <b-button
          v-if="ad.is_draft"
          :href="isArchiveHref"
          tag="a" icon-left="check"
          rounded>Soumettre
      </b-button>
      <b-button
          :href="editHref"
          tag="a" icon-left="pencil" rounded>Modifier
      </b-button>
      <b-button @click="openModal('archive')" icon-left="archive-arrow-down" rounded>
        Archiver
      </b-button>
      <b-button @click="openModal('delete')" icon-left="delete" rounded>
        Supprimer
      </b-button>
    </div>
    <b-modal
        v-model="isModalActive"
        has-modal-card
        trap-focus
        :destroy-on-hide="false"
        aria-role="dialog"
        aria-label="Modal"
        close-button-aria-label="Close"
        aria-modal
    >
      <template #default="props">
        <div class="bg-beige custo-modal objT-border p-6 p-5-mobile">
          <h3 class="title">{{ modalTitle }}</h3>
          <div class="mt-5">
            <form @submit.prevent="submitForm" method="POST">
              <input type="hidden" name="_token" :value="csrfToken">


              <b-field
                  label="Êtes-vous satisfait de la plateforme ? *">
                <div class="feedback-options">
                  <b-radio v-model="thanksToPlatform"
                           name="thanks_to_platform"
                           native-value="Oui"
                           class="custom-radio mr-5">
                    <span class="radio-label">
                      <b-icon icon="thumb-up" size="is-small" class="mr-2"></b-icon>
                      Oui
                    </span>
                  </b-radio>
                  <b-radio v-model="thanksToPlatform"
                           name="thanks_to_platform"
                           native-value="Non"
                           class="custom-radio">
                    <span class="radio-label">
                      <b-icon icon="thumb-down" size="is-small" class="mr-2"></b-icon>
                      Non
                    </span>
                  </b-radio>
                </div>
                <p v-if="showError" class="has-text-danger mt-2">
                  <b-icon icon="alert" size="is-small"></b-icon>
                  <span class="ml-2">Veuillez sélectionner une option</span>
                </p>
              </b-field>

              <b-field
                  label="Un partage, une remarque ou autre à nous transmettre ? (facultatif)">
                <b-input v-model="remarks" name="remarks" type="textarea"></b-input>
              </b-field>

              <div class="buttons">
                <b-button rounded
                          type="is-primary"
                          native-type="submit"
                          :loading="isLoading">
                  Envoyer
                </b-button>
                <b-button rounded @click="closeModal(props.close)">Annuler</b-button>
              </div>
            </form>
          </div>
        </div>
      </template>
    </b-modal>
  </div>
</template>

<script>
export default {
  props: {
    ad: {
      type: Object,
      required: true
    },
    isArchiveHref: {
      type: String,
      required: false,
      default: ''
    },
    editHref: {
      type: String,
      required: true
    },
    archiveRoute: {
      type: String,
      required: true
    },
    deleteRoute: {
      type: String,
      required: true
    },
    csrfToken: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      isModalActive: false,
      modalTitle: '',
      reason: '',
      thanksToPlatform: '',
      remarks: '',
      formAction: '',
      showError: false,
      isLoading: false
    }
  },
  methods: {
    openModal(type) {
      this.modalTitle = type === 'archive' ? 'Archiver l\'annonce' : 'Supprimer l\'annonce';
      this.formAction = type === 'archive' ? this.archiveRoute : this.deleteRoute;
      this.isModalActive = true;
      this.showError = false;
      this.thanksToPlatform = '';
      this.remarks = '';
    },
    closeModal(close) {
      this.showError = false;
      this.thanksToPlatform = '';
      this.remarks = '';
      close();
    },
    async submitForm() {
      if (!this.thanksToPlatform) {
        this.showError = true;

        // Utilisation du toast au lieu de la notification
        this.$buefy.toast.open({
          message: 'Veuillez indiquer si vous êtes satisfait de la plateforme',
          type: 'is-danger',
          position: 'is-top',
          duration: 3000,
          queue: false,
          animation: 'fade'
        })
        return;
      }

      this.isLoading = true;

      try {
        const formData = new FormData();
        formData.append('_token', this.csrfToken);
        formData.append('thanks_to_platform', this.thanksToPlatform);
        formData.append('remarks', this.remarks);

        await fetch(this.formAction, {
          method: 'POST',
          body: formData
        });

        this.isModalActive = false;
        this.$buefy.toast.open({
          message: 'Opération effectuée avec succès',
          type: 'is-success',
          position: 'is-top',
          duration: 3000
        });

        setTimeout(() => {
          window.location.reload();
        }, 1000);

      } catch (error) {
        this.$buefy.toast.open({
          message: 'Une erreur est survenue',
          type: 'is-danger',
          position: 'is-top',
          duration: 3000
        });
      } finally {
        this.isLoading = false;
      }
    }
  },
}
</script>

<style scoped>
@media (min-width: 1024px) {
  .custo-modal {
    min-width: 1000px;
  }
}

.feedback-question {
  background-color: #f5f5f5;
  padding: 1.5rem;
  border-radius: 8px;
}

.feedback-options {
  display: flex;
  align-items: center;
}

.custom-radio {
  transition: all 0.3s ease;
}

.custom-radio:hover {
  transform: translateY(-2px);
}

.radio-label {
  display: flex;
  align-items: center;
  font-weight: 500;
}

.has-text-danger {
  font-size: 0.9rem;
  font-weight: 500;
  display: flex;
  align-items: center;
  background-color: #fff5f7;
  padding: 0.5rem;
  border-radius: 4px;
  margin-top: 0.5rem !important;
}

.feedback-question {
  background-color: #f5f5f5;
  padding: 1.5rem;
  border-radius: 8px;
  border: 1px solid #dbdbdb;
}

.feedback-question.error {
  border-color: #ff3860;
  animation: shake 0.5s ease-in-out;
}

@keyframes shake {
  0%, 100% {
    transform: translateX(0);
  }
  25% {
    transform: translateX(-5px);
  }
  75% {
    transform: translateX(5px);
  }
}
</style>

@keyframes shake {
0%, 100% { transform: translateX(0); }
25% { transform: translateX(-5px); }
75% { transform: translateX(5px); }
}
</style>
