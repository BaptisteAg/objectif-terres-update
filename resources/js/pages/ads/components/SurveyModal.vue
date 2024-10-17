<template>
  <div>
    <div class="buttons has-addons is-right">
<!--      <b-button-->
<!--          v-if="isArchive"-->
<!--          :href="isArchiveHref"-->
<!--          tag="a" icon-left="check"-->
<!--          rounded>Soumettre-->
<!--      </b-button>-->

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
    <b-modal v-model="isModalActive" :destroy-on-hide="false" aria-role="dialog" aria-modal>
      <div class="card">
        <header class="card-header">
          <p class="card-header-title">
            {{ modalTitle }}
          </p>
        </header>
        <div class="card-content">
          <form :action="formAction" method="POST">
            <input type="hidden" name="_token" :value="csrfToken">

            <b-field label="Si votre annonce est retirée, c'est que :">
              <b-radio v-model="reason" name="reason" native-value="installed">
                Vous vous êtes installé.e
              </b-radio>
              <b-radio v-model="reason" name="reason" native-value="in_progress">
                Votre installation est en cours
              </b-radio>
              <b-radio v-model="reason" name="reason" native-value="abandoned">
                Vous avez abandonné votre projet d'installation
              </b-radio>
              <b-radio v-model="reason" name="reason" native-value="continue">
                Vous souhaitez poursuivre la publication de votre annonce
              </b-radio>
            </b-field>

            <b-field v-if="['installed', 'in_progress'].includes(reason)"
                     label="Si votre recherche a abouti, est-ce grâce à la plateforme Objectif Terres ?">
              <b-radio v-model="thanksToPlatform" name="thanks_to_platform" native-value="yes">Oui</b-radio>
              <b-radio v-model="thanksToPlatform" name="thanks_to_platform" native-value="no">Non</b-radio>
              <b-radio v-model="thanksToPlatform" name="thanks_to_platform" native-value="unknown">Je ne sais pas
              </b-radio>
            </b-field>

            <b-field
                label="Si vous avez des remarques à nous faire pour améliorer notre plateforme, ce champ est à votre disposition.">
              <b-input v-model="remarks" name="remarks" type="textarea"></b-input>
            </b-field>

            <div class="buttons">
              <b-button type="is-primary" native-type="submit">Envoyer</b-button>
              <b-button @click="isModalActive = false">Annuler</b-button>
            </div>
          </form>
        </div>
      </div>
    </b-modal>
  </div>
</template>

<script>
export default {
  props: {
    isArchive: {
      type: Boolean,
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
      csrfToken: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
  },
  methods: {
    openModal(type) {
      this.modalTitle = type === 'archive' ? 'Archiver l\'annonce' : 'Supprimer l\'annonce';
      this.formAction = type === 'archive' ? this.archiveRoute : this.deleteRoute;
      this.isModalActive = true;
    }
  }
}
</script>
