<template>
  <div>
    <div v-show="value === ''" class="adTypes-container">

      <h1 class="title">Formulaire de dépôt d’annonces</h1>
      <p>Objectif Terre est une plateforme ayant pour but de mettre en liens les personnes ayant des projets agricoles
        professionnels définis. Si votre annonce ne rentre pas dans cette catégorie (exemple : habitat collectif,
        volontariat, partage de jardin, chantier participatif...), veuillez vous référer à la FAQ mise à votre
        disposition pour vous rendre sur la plateforme adaptée à votre besoin.</p>
      <div :class="errors.check ? 'field-error mt-2 pt-2' : 'mt-2 pt-2'">
        <b-field :type="errors.check ? 'is-danger' : ''" :message="errors.check"
                 class="is-flex is-flex-direction-column">
          <b-checkbox v-model="isCertified" class="has-text-weight-bold is-size-6">Je certifie que mon annonce
            concerne
            un
            projet agricole professionnel sur des productions principales nourricières <a
                href="/conditions-utilisation">(charte
              Objectif Terre)</a>.
          </b-checkbox>
        </b-field>
      </div>

      <hr class="is-primary">

      <h3 class="title is-4">Je dépose cette annonce</h3>
      <div class="block">
        <b-radio v-model="otherPersonAd.value" name="false" :native-value="false">En mon nom</b-radio>
        <b-radio v-model="otherPersonAd.value" name="true" :native-value="true">Pour une autre personne</b-radio>
      </div>

      <div class="pb-4 is-flex is-flex-wrap-wrap is-justify-content-space-between" v-if="otherPersonAd.value">
        <b-field class="w-50 is-size-6" label="Email" :type="errors.email ? 'is-danger' : ''" :message="errors.email">
          <b-input placeholder="jean.dupont@gmail.com" size="is-medium" rounded type="email"
                   v-model="otherPersonAd.email" maxlength="30"></b-input>
        </b-field>
        <b-field class="w-50 is-size-6" label="Prénom" :type="errors.firstName ? 'is-danger' : ''"
                 :message="errors.firstName">
          <b-input placeholder="Jean" size="is-medium" rounded type="text" v-model="otherPersonAd.first_name"
                   maxlength="30"></b-input>
        </b-field>
        <b-field class="w-50 is-size-6" label="Nom" :type="errors.lastName ? 'is-danger' : ''"
                 :message="errors.lastName">
          <b-input placeholder="Dupont" size="is-medium" rounded type="text" v-model="otherPersonAd.last_name"
                   maxlength="30"></b-input>
        </b-field>
        <b-field class="w-50 is-size-6" label="Téléphone" :type="errors.phone ? 'is-danger' : ''"
                 :message="errors.phone">
          <b-input placeholder="06 06 06 06 06" size="is-medium" rounded type="text" v-model="otherPersonAd.phone"
                   maxlength="30"></b-input>
        </b-field>
        <input type="hidden" name="otherPersonAdEmail" :value="otherPersonAd.email">
        <input type="hidden" name="otherPersonAdFirstName" :value="otherPersonAd.first_name">
        <input type="hidden" name="otherPersonAdLastName" :value="otherPersonAd.last_name">
        <input type="hidden" name="otherPersonAdPhone" :value="otherPersonAd.phone">
      </div>

      <b-field>
        <b-checkbox name="accept_share_contact_infos" v-model="isMailOnly" class="is-size-6" value="0">
            Je ne souhaite pas être contacté par téléphone (dans ce
          cas,
          je serais contacté uniquement par email)
        </b-checkbox>
      </b-field>
      <input type="hidden" name="isMailOnly" :value="isMailOnly">

      <h3 class="title is-4">Mon projet</h3>
      <p class="pb-4 has-text-danger" v-show="errors.adType">Le type d'annonce n'est pas défini.</p>
      <div class="is-flex-wrap-wrap is-flex is-justify-content-space-between gap-5">
        <div v-for="(adType,adTypeValue) in adTypes"
             class="bg-beige is-clickable p-5 w-30 is-flex is-justify-content-center is-align-items-center has-text-centered objT-border"
             :class="{'bg-blue': currentAdType === adTypeValue}" @click="currentAdType = adTypeValue">
          {{ adType.label }}
        </div>
      </div>

      <p class="pt-6">Ajouter une phrase de : "Vous allez déposer une annonce de recherche de foncier, n'oubliez pas
        de
        consulter les annonces d'offres de foncier."</p>
      <p class="pt-5">Votre annonce sera visible uniquement par les personnes qui recherchent des porteurs de projet.
        Si
        vous souhaitez qu’elle soit visible par d’autres types de personnes, nous vous recommandons de créer une autre
        annonce pour multiplier vos chances.</p>

      <div class="is-flex is-justify-content-flex-end pt-6">
        <b-button size="is-medium" class="ml-2" rounded type="is-danger" @click="setAdType">Etape suivante</b-button>
      </div>

    </div>
    <div class="is-align-self-flex-start py-3" v-show="value !== ''">
      <a href="#" @click.prevent="changeAdType()" v-if="isSupportRequest">← Changer de type
        d'accompagnement</a>
      <a href="#" @click.prevent="changeAdType()" v-else>← Changer de type d'annonce</a>
    </div>

    <input type="hidden" :name="name" :value="value">

  </div>
</template>

<script>
export default {
  props: {
    oldValues: {
      type: Object
    },
    value: {
      type: String
    },
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
    let v = this.oldValues;


    if (!v.before_form) {
      v.before_form = {}
    }


    return {
      errors: {
        check: '',
        email: '',
        firstName: '',
        lastName: '',
        phone: '',
        adType: '',
      },
      otherPersonAd: {
        value: v.before_form.is_for_other || false,
        first_name: v.before_form.other_person_first_name || "",
        last_name: v.before_form.other_person_last_name || "",
        email: v.before_form.other_person_email || "",
        phone: v.before_form.other_person_phone || "",
      },
      isMailOnly: v.before_form.is_mail_only || false,
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
      this.errors = {
        check: '',
        email: '',
        firstName: '',
        lastName: '',
        phone: '',
        adType: '',
      };

      if (!this.isCertified) {
        this.errors.check = 'Vous devez certifier que votre annonce concerne un projet agricole professionnel.';
        window.scrollTo({top: 0, behavior: 'smooth'});
      }

      if (this.otherPersonAd.value) {
        if (!this.otherPersonAd.first_name) {
          this.errors.firstName = 'Le prénom est requis.';
        }
        if (!this.otherPersonAd.last_name) {
          this.errors.lastName = 'Le nom est requis.';
        }
        if (!this.otherPersonAd.phone) {
          this.errors.phone = 'Le téléphone est requis.';
        }

        let emailRegex = /^[\w-]+(.[\w-]+)*@([\w-]+.)+[a-zA-Z]{2,7}$/;
        if (!emailRegex.test(this.otherPersonAd.email)) {
          this.errors.email = "L'email n'est pas valide.";
        }
      }

      if (!this.currentAdType) {
        this.errors.adType = "Le type d'annonce n'est pas défini.";
      }

      if (!this.isCertified) {
        return false;
      }

      return Object.values(this.errors).every(error => !error);
    },
    created() {
      this.currentAdType = this.value;
    },
    setAdType() {
      if (this.validateFields()) {
        this.$emit('input', this.currentAdType);
      }
    },
    changeAdType() {
      this.$emit('input', '');
    }
  }
}
</script>
