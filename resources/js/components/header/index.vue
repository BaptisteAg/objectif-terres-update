<template>
  <div>
    <mobile-header :routes="{ home: routes.home, about_us: routes.about_us, create_ads: routes.create_ads, all_ads: routes.all_ads }"></mobile-header>
    <top-header :routes="{ home: routes.home }"></top-header>
    <bottom-header :routes="{ about_us: routes.about_us, create_ads: routes.create_ads, all_ads: routes.all_ads }"></bottom-header>
  </div>
</template>
<script>
import MobileHeader from './mobile.vue';
import TopHeader from './top.vue';
import BottomHeader from './bottom.vue';

export default {
  components: {
    'mobile-header': MobileHeader,
    'top-header': TopHeader,
    'bottom-header': BottomHeader
  },
  props: ['routes']
}
</script>
<style lang="scss">
header, header nav.navbar {
  background-color: #F8F3EE;
}
</style>