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
    </div>

    <div class="navbar-menu">
      <div class="navbar-end">

        <div class="navbar-item" v-if="$user && $user.role>=1">
          <b-dropdown :triggers="['hover']" aria-role="list">
            <template #trigger>
              <b-button
                  label="Administration"
                  type="is-text"
                  icon-right="menu-down"/>
            </template>


            <b-dropdown-item has-link
                             v-if="routes.administration.role_4"
                             aria-role="listitem"
            >
              <a :href="routes.administration.role_4">Administration</a>
            </b-dropdown-item>

            <b-dropdown-item has-link
                             v-if="routes.administration.role_3"
                             aria-role="listitem"
            >
              <a :href="routes.administration.role_3">Tableau de bord</a>
            </b-dropdown-item>

            <b-dropdown-item has-link
                             v-if="$user.role >= 3"
                             aria-role="listitem"
            >
              <a target="_blank" :href="routes.administration.role_2">Gestion des accompagnements</a>
            </b-dropdown-item>

            <b-dropdown-item has-link
                             v-else-if="$user.role >= 2"
                             aria-role="listitem"
            >
              <a target="_blank" :href="routes.administration.role_2">Espace primo-accueillant</a>
            </b-dropdown-item>

            <b-dropdown-item has-link
                             v-if="$user.role >= 3"
                             aria-role="listitem"
            >
              <a :href="routes.administration.role_1">Gestion des annonces</a>
            </b-dropdown-item>
            <b-dropdown-item has-link
                             v-else
                             aria-role="listitem"
            >
              <a :href="routes.administration.role_1">Espace modérateur</a>
            </b-dropdown-item>
          </b-dropdown>
        </div>

        <div class="navbar-item">
          <a href="https://soutenir.terredeliens.org/objectifterre/~mon-don"
             class="button is-danger is-rounded">
            <span>Nous soutenir</span>
          </a>
        </div>

        <div class="navbar-item number-sticker-wrap" v-if="$user">
          <a class="icon-text" :href="routes.notifications">
              <span class="icon is-medium">
                <i class="mdi mdi-24px mdi-bell-ring-outline"></i>
              </span>
          </a>
          <span v-if="unread_notifications" class="number-sticker">{{ unread_notifications }}</span>
        </div>
        <div class="navbar-item number-sticker-wrap" v-if="$user">
          <a class="icon-text" :href="routes.messages">
              <span class="icon is-medium">
                <i class="mdi mdi-24px mdi-email-outline"></i>
              </span>
          </a>
          <span v-if="unread_messages" class="number-sticker">{{ unread_messages }}</span>
        </div>
        <div class="navbar-item" v-if="$user">
          <a class="icon-text" :href="routes.account">
              <span class="icon is-medium">
                <i class="mdi mdi-24px mdi-account-outline"></i>
              </span>
          </a>
        </div>
        <div class="navbar-item" v-if="$user">
          <a class="has-text-weight-semibold navbar-item" :href="routes.logout">
            Déconnexion
          </a>
        </div>
        <div class="navbar-item" v-else>
          <a class="has-text-weight-semibold navbar-item" :href="routes.login">
            Se connecter
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
