<template>
  <nav class="container is-hidden-touch navbar is-transparent py-2 is-flex-wrap-wrap is-flex" role="navigation"
       aria-label="main navigation">
    <div class="navbar-brand">
      <div class="is-flex">
        <a class="image is-128x128"
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
      <div class="navbar-end">
        <div class="navbar-item">
          <a href="https://soutenir.terredeliens.org/objectifterre/~mon-don" class="button is-danger is-small is-rounded">
            <span>Nous soutenir</span>
          </a>
        </div>
        <div class="navbar-item">
          <a class="icon-text">
              <span class="icon is-medium">
                <i class="mdi mdi-24px mdi-bell-ring-outline"></i>
              </span>
          </a>
        </div>
        <div class="navbar-item">
          <a class="icon-text">
              <span class="icon is-medium">
                <i class="mdi mdi-24px mdi-email-outline"></i>
              </span>
          </a>
        </div>
        <div class="navbar-item">
          <a class="icon-text is-flex is-align-items-center" href="/connexion">
              <span class="icon is-medium">
                <i class="mdi mdi-24px mdi-account-outline"></i>
              </span>
            <strong>Connexion/Inscription</strong>
          </a>
        </div>

      </div>
    </div>
  </nav>
</template>
<script>
export default {
  props: ['routes']
}
</script>
<style>
i.mdi.mdi-36px.mdi-account-outline{
  transform: translateY(3px);
}
</style>
