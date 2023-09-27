<template>
  <div class="is-flex is-flex-direction-column is-align-items-center" v-if="displaySelection">
    <div class="column is-four-fifths">

      <!--Infos-->
      <h1 class="title">Formulaire de dépôt d’annonces</h1>
      <p>
        Objectif Terre est une plateforme ayant pour but de mettre en liens les personnes ayant des projets agricoles
        professionnels définis. Si votre annonce ne rentre pas dans cette catégorie (exemple : habitat collectif,
        volontariat, partage de jardin, chantier participatif...), veuillez vous référer à la FAQ mise à votre
        disposition pour vous rendre sur la plateforme adaptée à votre besoin.
      </p>
      <b-field class="pt-4">
        <b-checkbox v-model="isCertified" class="has-text-weight-bold is-size-6">Je certifie que mon annonce concerne un
          projet agricole
          professionnel
          sur des productions
          principales nourricières <a href="/conditions-utilisation">(charte Objectif Terre)</a>.
        </b-checkbox>
      </b-field>

      <hr class="is-primary">

      <!--IsPersonnalAd-->
      <h3 class="title is-4">Je dépose cette annonce</h3>
      <div class="block">
        <b-radio v-model="otherPersonAd.value"
                 name="false"
                 v-bind:native-value="false">
          En mon nom
        </b-radio>
        <b-radio v-model="otherPersonAd.value"
                 name="true"
                 v-bind:native-value="true">
          Pour une autre personne
        </b-radio>
      </div>

      <div class="pb-4 is-flex is-flex-wrap-wrap is-justify-content-space-between" v-if="otherPersonAd.value">
        <b-field class="w-50 is-size-6" label="Email"
                 :type="emailError ? 'is-danger' : ''"
                 :message="emailError">
          <b-input placeholder="jean.dupont@gmail.com" size="is-medium" rounded type="email"
                   v-model="otherPersonAd.email"
                   maxlength="30">
          </b-input>
        </b-field>
        <b-field class="w-50 is-size-6" label="Prénom"
                 :type="firstNameError ? 'is-danger' : ''"
                 :message="firstNameError">
          <b-input placeholder="Jean" size="is-medium" rounded type="text"
                   v-model="otherPersonAd.first_name"
                   maxlength="30">
          </b-input>
        </b-field>
        <b-field class="w-50 is-size-6" label="Nom"
                 :type="lastNameError ? 'is-danger' : ''"
                 :message="lastNameError">
          <b-input placeholder="Dupont" size="is-medium" rounded type="text"
                   v-model="otherPersonAd.last_name"
                   maxlength="30">
          </b-input>
        </b-field>
        <b-field class="w-50 is-size-6" label="Téléphone"
                 :type="phoneError ? 'is-danger' : ''"
                 :message="phoneError">
          <b-input placeholder="06 06 06 06 06" size="is-medium" rounded type="text"
                   v-model="otherPersonAd.phone"
                   maxlength="30">
          </b-input>
        </b-field>
      </div>

      <!--MailOnly-->
      <b-field>
        <b-checkbox class="is-size-6">Je ne souhaite pas être contacté par téléphone (dans ce cas, je serais contacté
          uniquement par email)
        </b-checkbox>
      </b-field>

      <!--ProjetType-->
      <h3 class="title is-4">Mon projet</h3>
      <div class="is-flex-wrap-wrap is-flex is-justify-content-space-between gap-5">
        <div v-for="(adType,adTypeValue) in adTypes"
             class="bg-beige p-5 w-30 is-flex is-justify-content-center is-align-items-center has-text-centered objT-border"
             :class="{'bg-blue': currentAdType === adTypeValue}"
             @click="currentAdType = adTypeValue">
          {{ adType.label }}
        </div>
      </div>

      <!--Informations-->
      <p class="pt-6">Ajouter une phrase de : "Vous allez déposer une annonce de recherche de foncier, n'oubliez pas de
        consulter les
        annonces d'offres de foncier."</p>

      <p class="pt-5">Votre annonce sera visible uniquement par les personnes qui recherchent des porteurs de projet. Si
        vous
        souhaitez qu’elle soit visible par d’autres types de personnes, nous vous recommandons de créer une autre
        annonce pour multiplier vos chances.</p>

      <!--NavButtons-->
      <div class="is-flex is-justify-content-space-between pt-6">
        <b-button disabled size="is-medium" rounded type="is-warning">Enregistrer l’annonce en tant que
          brouillon
        </b-button>
        <div>
          <b-button disabled size="is-medium" rounded>Etape précédente</b-button>
          <b-button size="is-medium" class="ml-2" rounded type="is-danger" @click="setAdType"
                    :disabled="!currentAdType">Etape suivante
          </b-button>
        </div>
      </div>

      <input type="hidden" :name="name" :value="currentAdType">
    </div>
  </div>
</template>

<style lang="scss">
@import "../../sass/variables";

</style>

<script>
export default {
  props: {
    name: {
      type: String,
      required: true
    },
    isSupportRequest: {
      type: Boolean,
      required: true
    },
  },
  data() {
    return {
      emailError: '',
      firstNameError: '',
      lastNameError: '',
      phoneError: '',
      adTypeError: '',
      displaySelection: !this.value,
      otherPersonAd: {
        value: false,
        first_name: "",
        last_name: "",
        email: "",
        phone: ""
      },
      isCertified: false,
      currentAdType: null
    }
  },
  computed: {
    adTypes() {
      let extraAdTypes = this.isSupportRequest ? {} : {
        job_seek: {
          label: "Je cherche une opportunité professionnelle",
        },
        job_offer: {
          label: "Je propose une opportunité professionnelle",
        },
        job_associate: {
          label: "Associé pour projet d'installation",
        }
      };

      return {
        land_seek: {
          label: "Je cherche du foncier agricole",
        },
        land_offer: {
          label: "Je propose du foncier agricole",
        },
        land_partner: {
          label: "Associé sur une ferme ",
        },
        ...extraAdTypes
      }
    },
  },
  methods: {
    validateFields() {
      this.emailError = '';
      this.firstNameError = '';
      this.lastNameError = '';
      this.phoneError = '';
      this.adTypeError = '';

      if (this.otherPersonAd.value) {
        if (!this.otherPersonAd.first_name) {
          this.firstNameError = 'Le prénom est requis.';
        }
        if (!this.otherPersonAd.last_name) {
          this.lastNameError = 'Le nom est requis.';
        }
        if (!this.otherPersonAd.phone) {
          this.phoneError = 'Le téléphone est requis.';
        }

        let emailRegex = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/;
        if (!emailRegex.test(this.otherPersonAd.email)) {
          this.emailError = 'L\'email n\'est pas valide.';
        }
      }

      if (!this.currentAdType) {
        this.adTypeError = 'Le type d\'annonce n\'est pas défini.';
      }

      if (!this.isCertified) {
        return false;
      }

      return !this.emailError && !this.firstNameError && !this.lastNameError && !this.phoneError && !this.adTypeError;
    },
    setAdType() {
      if (this.validateFields()) {
        this.$emit('input', this.currentAdType);
        this.displaySelection = false;
      }
    }
  }
}
</script>
