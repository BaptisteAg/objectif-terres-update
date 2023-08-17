<template>
  <div>
    <mobile-header :home-url="homeUrl"></mobile-header>
    <top-header :home-url="homeUrl"></top-header>
    <bottom-header></bottom-header>
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
  props: ['homeUrl']
}
</script>
<style>
top-header, BottomHeader {
  width: 100%;
}
</style>