<template>
  <div>
    <nav class="container navbar is-hidden-touch is-transparent py-2">
      <div class="navbar-menu">
        <div class="navbar-start">

          <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link has-text-weight-bold">
              Je souhaite
            </a>
            <div class="navbar-dropdown is-boxed">
              <a class="navbar-item" href="/minstaller-comme-paysan">
                M'installer paysan
              </a>
              <a class="navbar-item" href="/trouver-une-terre-ou-des-financements">
                Trouver une terre
              </a>
              <a class="navbar-item" href="/transmettre-ma-ferme">
                Transmettre ma ferme
              </a>
              <a class="navbar-item" href="/confier-mes-terres">
                Faire une donation ou un leg à Terre de Liens
              </a>
            </div>
          </div>

          <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link has-text-weight-bold" :href="routes.about_us">
              Qui sommes nous ?
            </a>
            <div class="navbar-dropdown is-boxed">
              <a class="navbar-item" :href="`${routes.about_us}#le-mouvement-terre-de-liens`">
                Le mouvement Terre de Liens
              </a>
              <a class="navbar-item" :href="`${routes.about_us}#a-propos-d-objectif-terres`">
                A propos d'Objectif Terres
              </a>
            </div>
          </div>

          <a class="navbar-item has-text-weight-bold" href="/faq">
            FAQ
          </a>

        </div>

        <div class="navbar-end">
          <div class="navbar-item buttons">
            <b-button tag="a" :href="routes.all_ads" rounded icon-left="magnify">
              Consulter les annonces
            </b-button>
            <b-button tag="a" :href="routes.create_ads" rounded type="is-info" icon-left="plus">
              Déposer une annonce
            </b-button>
            <b-button tag="a" href="/accompagnement/demarrer" rounded type="is-warning" icon-left="handshake-outline">
              Être accompagné
            </b-button>
          </div>
        </div>
      </div>
    </nav>
  </div>
</template>
<script>
export default {
  props: ['routes']
}
</script>