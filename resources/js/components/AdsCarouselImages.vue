<template>
  <b-carousel>
    <b-carousel-item v-for="(image, i) in images" :key="i">
      <b-image class="image is-3by2" :src="'https://objectif-terres.org/' + image.path"></b-image>
    </b-carousel-item>
  </b-carousel>
</template>

<script>
export default {
  props: ['images']
}
</script>
<style lang="scss">
.carousel-items {
  border-radius: 12px;
}
</style>
