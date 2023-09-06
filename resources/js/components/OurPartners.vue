<template>
  <b-carousel-list :data="items" :arrow-hover="false" v-bind="al" as-indicator>
    <template #item="list">
      <figure class="image is-128x128">
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
        },
        {
          image: '/images/logo-partenaires/LOGO_RESEAU_CIVAM_FOND_TRANSPARENT.PNG',
        },
        {
          image: '/images/logo-partenaires/logo_inpact_Plan%20de%20travail%201.png',
        },
        {
          image: '/images/logo-partenaires/logo%20IA%20fond%20transparent.png',
        },
        {
          image: '/images/logo-partenaires/logo-fnab-new.png',
        },
        {
          image: '/images/logo-partenaires/Logo%20Reneta%20-%20RVB.png',
        },
        {
          image: '/images/logo/logo_TdL_cartouche_blanc-rouge_500.png',
        },
      ]
    }
  },
  methods: {}
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
