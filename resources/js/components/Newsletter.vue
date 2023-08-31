<template>
  <form @submit="checkForm"
        action="/newsletter"
        method="post">
    <b-field :type="invalidMail ? 'is-danger' : null" :message="invalidMail ? 'Veuillez renseigner une adresse email valide' : null">
      <b-input v-model="email" type="email" name="email" rounded placeholder="Votre email" expanded></b-input>
      <p class="control">
        <b-button native-type="submit" type="is-primary" rounded>M'inscrire</b-button>
      </p>
    </b-field>
    <b-field :message="invalidCheckbox ? 'Veuillez accepter' : null">
      <b-checkbox v-model="accept" size="is-small">J'accepte de recevoir les actualités et les informations de Terre de Liens
      </b-checkbox>
    </b-field>
    <input type="hidden" name="_token" :value="csrf_token">
  </form>
</template>
<style lang="scss">
.newsletter {
  min-height: 30vh;
}

.newsletter .title {
  margin-bottom: 1rem;
}
</style>
<script>
export default {
  props: ['csrf_token'],
  data() {
    return {
      email: '',
      accept: false,
      invalidMail: false,
      invalidCheckbox: false
    }
  },
  methods : {
    checkForm: function (e) {
      this.validEmail(this.email) ? this.invalidMail = false : this.invalidMail = true;
      this.accept ? this.invalidCheckbox = false : this.invalidCheckbox = true;
      if (!this.invalidMail && this.accept) {
        return true;
      }
      e.preventDefault();
    },
    validEmail: function (email) {
      var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(email);
    }
  }
}
</script>