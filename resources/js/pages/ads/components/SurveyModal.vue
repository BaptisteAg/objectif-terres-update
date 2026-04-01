<template>
  <div class="modal is-active p-8 p-0-mobile">
    <div class="modal-background" @click="handleClose"></div>
    <div class="modal-content">
      <div class="card">
        <header class="card-header">
          <p class="card-header-title">
            Archivage ou suppression d'une annonce - Enquête de succès
          </p>
        </header>
        <div class="card-content">
          <div v-if="isLoading">
            <p>Envoi en cours...</p>
          </div>
          <div v-else>
            <p class="mb-4">
              Afin d'archiver ou supprimer une annonce, veuillez répondre à la question suivante pour nous permettre d'améliorer Objectif-Terres
            </p>

            <div class="field">
              <label class="label">
                Votre annonce a-t-elle aboutie grâce à Objectif-Terres ? <span class="has-text-danger">*</span>
              </label>
              <div class="control">
                <label class="radio">
                  <input type="radio" name="survey_response" value="oui" v-model="surveyResponse">
                  Oui
                </label>
                <label class="radio ml-4">
                  <input type="radio" name="survey_response" value="non" v-model="surveyResponse">
                  Non
                </label>
              </div>
              <p v-if="showError" class="help is-danger">Veuillez répondre à cette question</p>
            </div>

            <div class="field mt-4">
              <label class="label">
                Si vous avez des remarques à nous faire pour nous améliorer (optionnel)
              </label>
              <div class="control">
                <textarea
                  class="textarea"
                  v-model="surveyComments"
                  placeholder="N'hésitez pas à nous faire part de vos remarques..."
                  rows="4"
                ></textarea>
              </div>
            </div>
          </div>
        </div>
        <footer class="card-footer">
          <div class="buttons card-footer-item">
            <button @click="handleClose" class="button form-button basic secondary" :disabled="isLoading">
              <span>Annuler</span>
            </button>
            <button @click="handleSubmit" class="button form-button basic is-danger" :disabled="isLoading">
              <span v-if="action === 'archive'">Archiver mon annonce</span>
              <span v-else>Supprimer mon annonce</span>
            </button>
          </div>
          <button id="close-modal" class="modal-close is-large" aria-label="close"
                  @click="handleClose"></button>
        </footer>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  props: {
    ad: {
      type: Object,
      required: true
    },
    action: {
      type: String,
      required: true,
      validator: value => ['archive', 'delete'].includes(value)
    }
  },
  data() {
    return {
      surveyResponse: null,
      surveyComments: '',
      isLoading: false,
      showError: false
    }
  },
  methods: {
    handleClose() {
      if (!this.isLoading) {
        this.$emit('close')
      }
    },
    handleSubmit() {
      // Validate that a response is selected
      if (!this.surveyResponse) {
        this.showError = true
        return
      }

      this.showError = false
      this.isLoading = true

      // Submit survey data
      axios
        .post(`/annonces/survey/${this.ad.id}/${this.action}`, {
          survey_success_via_platform: this.surveyResponse,
          survey_comments: this.surveyComments
        })
        .then(response => {
          // Redirect or reload after successful submission
          if (response.data.redirect) {
            window.location.href = response.data.redirect
          } else {
            window.location.reload()
          }
        })
        .catch(error => {
          console.error('Survey submission error:', error)
          alert('Une erreur est survenue. Veuillez réessayer.')
          this.isLoading = false
        })
    }
  }
}
</script>

<style scoped>
.mb-4 {
  margin-bottom: 1rem;
}
.mt-4 {
  margin-top: 1rem;
}
.ml-4 {
  margin-left: 1rem;
}
</style>
