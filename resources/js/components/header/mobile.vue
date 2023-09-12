<template>
  <nav class="is-hidden-desktop navbar is-transparent p-2 is-flex-wrap-wrap is-flex" role="navigation"
       aria-label="main navigation">
    <div class="navbar-brand">
      <div class="is-flex">
        <a class="image is-96x96"
           :href="routes.home">
          <img class="is-rounded"
               src="/images/logo/logo_TdL_cartouche_blanc-rouge_500.png"
               alt="objectif-terres-logo">
        </a>
        <div class="pl-4 is-flex is-flex-direction-column is-justify-content-center pl-">
          <h1 class="title mb-0 mt-0">Objectif Terres</h1>
          <h3 class="mt-0 subtitle">Faites pousser votre projet agricole</h3>
        </div>
      </div>

      <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarHeader">
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
      </a>
    </div>

    <div id="navbarHeader" class="navbar-menu">
      <div class="navbar-start">

        <div class="navbar-item">
          <a v-if="$user" class="title is-5" :href="routes.logout">
            <span class="icon-text is-align-items-center">
              <span class="icon is-medium">
                <i class="mdi mdi-36px mdi-account-outline"></i>
              </span>
              <span>Déconnexion</span>
            </span>
          </a>
          <a v-else class="title is-5" :href="routes.login">
            <span class="icon-text is-align-items-center">
              <span class="icon is-medium">
                <i class="mdi mdi-36px mdi-account-outline"></i>
              </span>
              <span>Se connecter</span>
            </span>
          </a>
        </div>

        <hr class="mr-4 ml-4">

        <div class="navbar-item has-dropdown is-hoverable">
          <a class="navbar-link title is-5">
            Je souhaite
          </a>

          <div class="navbar-dropdown">
            <a class="navbar-item subtitle is-5" href="/minstaller-comme-paysan">
              M'installer paysan
            </a>
            <a class="navbar-item subtitle is-5" href="/trouver-une-terre-ou-des-financements">
              Trouver une terre
            </a>
            <a class="navbar-item subtitle is-5" href="/transmettre-ma-ferme">
              Transmettre ma ferme
            </a>
            <a class="navbar-item subtitle is-5" href="/confier-mes-terres">
              Faire une donation ou un leg à Terre de Liens
            </a>
          </div>

        </div>

        <div class="navbar-item has-dropdown is-hoverable">
          <a class="navbar-link title is-5">
            Qui sommes nous
          </a>

          <div class="navbar-dropdown">
            <a class="navbar-item subtitle is-5" :href="`${routes.about_us}#le-mouvement-terre-de-liens`">
              Le mouvement Terre de Liens
            </a>
            <a class="navbar-item subtitle is-5" :href="`${routes.about_us}#a-propos-d-objectif-terres`">
              A propos d'Objectif Terres
            </a>
          </div>

        </div>


        <a class="navbar-item title is-5">
          FAQ
        </a>
      </div>

      <div class="navbar-end">
        <div class="navbar-item">
          <a class="button is-danger is-medium is-rounded is-fullwidth mt-3">
            <strong>Nous soutenir</strong>
          </a>
        </div>
      </div>
    </div>
  </nav>
</template>
<script>
export default {
  props: ['routes', 'unread_messages', 'unread_notifications']
}
</script>
<style lang="scss" scoped>
.title {
  margin: 0;
}
hr {
  background-color: #E3CFB5;
}
.subtitle {
  margin-bottom: 0;
}
#navbarHeader a.subtitle:before {
  content:"• ";
}
.navbar-brand {
  width: 100%;
}
</style>
