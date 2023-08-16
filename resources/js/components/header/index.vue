<template>
  <div>
    <top-header></top-header>
    <bottom-header></bottom-header>
  </div>
</template>
<script>
import Top from './top.vue';
import Bottom from './bottom.vue';

export default {
  components: {
    'top-header': Top,
    'bottom-header': Bottom
  }
}
</script>