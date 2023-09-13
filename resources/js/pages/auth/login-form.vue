<template>
  <section class="mh-40 container is-flex is-flex-direction-column is-justify-content-center">
    <div class="columns">
      <div class="column is-half mx-auto">
        <form method="post" :action="login_route" @submit.prevent="onSubmit">
          <div class="is-flex is-flex-direction-column gap-2">
            <h1 class="title is-3">Identifiez-vous</h1>
            <b-field>
              <b-input size="is-medium"
                       rounded
                       placeholder="Votre adresse email..."
                       v-model="email"
                       type="email"
                       icon="email"
                       icon-right="close-circle"
                       icon-right-clickable
                       @icon-right-click="clearIconClick"
                       @change="onEmailChange"
                       name="email">
              </b-input>
            </b-field>
            <b-field v-if="hasPassedCheckpoint">
              <b-input rounded
                       icon="lock"
                       size="is-medium"
                       type="password"
                       placeholder="Votre mot de passe..."
                       password-reveal
                       name="password">
              </b-input>
            </b-field>
            <div class="buttons is-justify-content-space-between">
              <b-button tag="a" :href="routes.password_request" type="is-text" rounded>Mot de passe oublié ?</b-button>
              <b-button native-type="submit" type="is-primary" size="is-medium" rounded :loading="isLoading"
                        :disabled="isLoading">
                <span v-if="isLoading">Chargement</span>
                <span v-else-if="hasPassedCheckpoint">Valider</span>
                <span v-else>Suivant</span>
              </b-button>
            </div>
            <b-button tag="a" :href="routes.register" rounded type="is-light" size="is-medium" expanded>Créer un compte</b-button>
          </div>
          <input type="hidden" name="_token" :value="csrf_token">
        </form>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  props: {
    oldValues: {
      type: Object,
      default: () => ({}),
    },
    csrf_token: {
      type: String,
      default: '',
    },
    routes: {
      type: Array,
      default: () => [],
    },
  },
  data() {
    return {
      email: this.oldValues.email || '',
      hasPassedCheckpoint: !!this.oldValues.email,
      isLoading: false,
    };
  },
  methods: {
    clearIconClick() {
      this.email = '';
    },
    onValidate(event) {
      event.preventDefault();

      if (!this.email) {
        alert("Veuillez saisir votre adresse email");
        return;
      }

      if (this.hasPassedCheckpoint) {
        event.target.submit();
        return;
      }

      let formData = new FormData;
      formData.append('_token', this.csrf_token);
      formData.append('email', this.email);

      this.isLoading = true;
      fetch('/connexion/checkpoint', {
        method: 'POST',
        body: formData,
        headers: {
          'Accept': 'application/json',
        },
      })
          .then(response => response.json())
          .then(result => {
            if (result.error) {
              if (result.status === 419) {
                alert("La page a expiré et va être rafraîchie. Merci de réessayer.") && location.reload();
              } else {
                this.loginErrorHandler(result.error);
              }
            } else if (result.redirect && result.redirect !== '') {
              location.href = result.redirect;
            } else {
              this.hasPassedCheckpoint = true;
              this.isLoading = false;
            }
          })
          .catch(error => this.loginErrorHandler(error));
    },
    onEmailChange() {
      this.hasPassedCheckpoint = false;
    },
    loginErrorHandler(error) {
      console.log("checkpoint error :", error);
      alert("Une erreur imprévue a eu lieu.");
      this.isLoading = false;
    },
    onSubmit(event) {
      this.onValidate(event);
    },
  },
};
</script>
