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
            <form :action="formAction" method="POST">
              <input type="hidden" name="_token" :value="csrfToken">

              <!--              <div class="mb-4">-->
              <!--                <p class="has-text-weight-bold mb-2">Si votre annonce est retirée, c'est que :</p>-->
              <!--                <b-field>-->
              <!--                  <b-radio v-model="reason" name="reason" native-value="Vous vous êtes installé.e">-->
              <!--                    Vous vous êtes installé.e-->
              <!--                  </b-radio>-->
              <!--                </b-field>-->
              <!--                <b-field>-->
              <!--                  <b-radio v-model="reason" name="reason" native-value="Votre installation est en cours">-->
              <!--                    Votre installation est en cours-->
              <!--                  </b-radio>-->
              <!--                </b-field>-->
              <!--                <b-field>-->
              <!--                  <b-radio v-model="reason" name="reason" native-value="Vous avez abandonné votre projet d'installation">-->
              <!--                    Vous avez abandonné votre projet d'installation-->
              <!--                  </b-radio>-->
              <!--                </b-field>-->
              <!--<b-field>
                <b-radio v-model="reason" name="reason" native-value="Vous souhaitez poursuivre la publication de votre annonce">
                  Vous souhaitez poursuivre la publication de votre annonce
                </b-radio>
              </b-field>-->
              <!--              </div>-->
              <b-field label="Si votre recherche a abouti, est-ce grâce à la plateforme Objectif Terres ?">
                <!--              <b-field v-if="['Vous vous êtes installé.e', 'Votre installation est en cours'].includes(reason)"-->
                <!--                       label="Si votre recherche a abouti, est-ce grâce à la plateforme Objectif Terres ?">-->
                <b-radio v-model="thanksToPlatform" name="thanks_to_platform" native-value="Oui">Oui</b-radio>
                <b-radio v-model="thanksToPlatform" name="thanks_to_platform" native-value="Non">Non</b-radio>
              </b-field>

              <b-field
                  label="Vos suggestions pour améliorer notre plateforme (facultatif)">
                <b-input v-model="remarks" name="remarks" type="textarea"></b-input>
              </b-field>

              <div class="buttons">
                <b-button rounded type="is-primary" native-type="submit">Envoyer</b-button>
                <b-button rounded @click="props.close">Annuler</b-button>
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
    }
  },
  methods: {
    openModal(type) {
      this.modalTitle = type === 'archive' ? 'Archiver l\'annonce' : 'Supprimer l\'annonce';
      this.formAction = type === 'archive' ? this.archiveRoute : this.deleteRoute;
      this.isModalActive = true;
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
</style>
