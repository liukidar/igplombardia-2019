<template>
  <div class="materialboxed">
    <div :style="{ 'background-image': 'url(' + img + ')' }"><slot></slot></div>
  </div>
</template>

<script>

import imagesLoaded from 'imagesloaded'

export default {
  props: {
    img: {
      default: 'https://materializecss.com/images/sample-1.jpg'
    }
  },
  mounted() {
    imagesLoaded(this.$el, () => {
      M.Materialbox.init(this.$el, {})
    })
  }
}
</script>

<style scoped>
.materialboxed {
  position: relative;
}
.materialboxed > div {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: no-repeat center center;
  background-size: cover;
}
.materialboxed.reveal > div {
  background-size: auto;
}
</style>
