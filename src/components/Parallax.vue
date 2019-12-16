<template>
  <div class="parallax-container" :style="{height:height}">
    <div class="parallax"><img :src="img"></div>
  </div>
</template>

<script>
export default {
  props: ['height', 'img'],
  mounted: function() {
    M.Parallax.init(this.$el.children[0], {responsiveThreshold: 601})
  }
}
</script>

<style scoped>

.parallax-container {
  box-shadow: 0 0 11px rgba(0, 0, 0, 0.18) inset, 0 0 15px rgba(0, 0, 0, 0.15) inset;
}

</style>
