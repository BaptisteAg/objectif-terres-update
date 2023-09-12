<template>
  <b-carousel-list :data="items" :arrow-hover="false" v-bind="al" as-indicator>
    <template #item="list">
      <figure class="image is-128x128 is-clickable" @click="openDialog(list.title, list.text)" @touchend="openDialog(list.title, list.text)">
        <img :src="list.image">
      </figure>
    </template>
  </b-carousel-list>
</template>

<script>
export default {
  data() {
    return {
      al: {
        itemsToShow: 1,
        breakpoints: {
          768: {
            itemsToShow: 4
          },
        }
      },
      items: [
        {
          image: '/images/logo-partenaires/FADEAR-cmjn-01-01.png',
          title: 'Les ADEAR',
          text: 'Ce sont les associations de développement de l’emploi agricole et rural. Présentes dans une soixantaine de départements, elles ont mis en place un dispositif d’accompagnement des porteurs de projet qui souhaitent s’installer en agriculture ou transmettre. Elles soutiennent les valeurs de l’agriculture paysanne et accompagnent une grande diversité de projets. Plus d\'informations'
        },
        {
          image: '/images/logo-partenaires/LOGO_RESEAU_CIVAM_FOND_TRANSPARENT.PNG',
          title: 'Les CIVAM',
          text: 'Ce sont les Centres d’Initiatives pour Valoriser l’Agriculture et le Milieu rural. Ils ont pour mission de rassembler agriculteurs et ruraux d’un même territoire pour développer de nouvelles initiatives, se former, échanger, expérimenter et innover. Plus de 140 groupes existent sur l’ensemble du territoire. Plus d\'informations en cliquant sur ce lien'
        },
        {
          image: '/images/logo-partenaires/logo_inpact_Plan%20de%20travail%201.png',
          title: 'InPACT',
          text: 'Initiatives pour une Agriculture citoyenne et territoriale est un regroupement de 10 réseaux associatifs agricoles partageant une même vision de l’agriculture. Avec des champs d’action et des approches de l’accompagnement variés, le réseau InPACT dont est membre Terre de Liens est un acteur central de l’accompagnement à l’installation et à la transmission. Des déclinaisons régionales ou plus locales d’InPACT associent parfois une diversité plus grande encore d’acteurs qui font des pas de côté en agriculture (GAB, association d’éducation populaire, couveuse d’activité, ...). Plus d\'informations en cliquant sur ce lien'
        },
        {
          image: '/images/logo-partenaires/logo%20IA%20fond%20transparent.png',
          title: 'Les AFOCG',
          text: 'Ce sont les Associations de Formation collective à la gestion. Elles ont pour mission de rendre leur adhérents autonome dans leur comptabilité et dans leur gestion, et de les accompagner dans les différentes étapes de développement de leur entreprise (création, évolution, etc.).'
        },
        {
          image: '/images/logo-partenaires/logo-fnab-new.png',
          title: 'Les GAB',
          text: 'Les groupements d’agriculture biologique sont présents au niveau départemental. Ils accueillent et accompagnent les porteurs de projet en agriculture biologique ou en conversion à la bio, organisent des formations et des temps d’échanges entre agriculteurs et consommateurs Plus d\'informations'
        },
        {
          image: '/images/logo-partenaires/Logo%20Reneta%20-%20RVB.png',
          title: 'Le RENETA',
          text: 'C’est le réseau national des espaces test agricoles, dispositifs permettant à des porteurs de projet de tester la viabilité et la vivabilité de leur projet agricole Plus d\'informations'
        },
        {
          image: '/images/logo/logo_TdL_cartouche_blanc-rouge_500.png',
          title: 'Terre de Liens',
          text: 'Le réseau associatif Terre de Liens peut vous accueillir, vous orienter et vous accompagner sur le volet foncier de votre projet.'
        },
      ]
    }
  },
  methods: {
    openDialog(title, text) {
      this.$buefy.dialog.alert({
        title: title,
        message: text,
        confirmText: 'Fermer'
      })
    }
  }
}
</script>
<style lang="scss">
@import "../../sass/_variables.scss";

.carousel-slide, .carousel-slide figure {
  display: flex;
  justify-content: center;
  align-items: center;
}

.carousel-slide figure.image {
  background-color: white;
  border-radius: 20px;
  height: 220px;
  width: 220px;
}

.carousel-slide img {
  width: 70%;
}

.carousel-list.has-shadow {
  box-shadow: none;
}

@media (max-width: $tablet) {
  .carousel-list {
    width: 100vw;
  }
}
</style>
