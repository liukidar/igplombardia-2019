<template>
  <div class="grid">
    <div class="coloumn-width" style="width:8.3333333333%"></div>
    <slot></slot>
  </div>
</template>

<script>

import Masonry from 'masonry-layout'
import imagesLoaded from 'imagesloaded'

export default {
  props: {
    fit: {
      default: false
    }
  },
  data: function() {
    return {
      list: null
    }
  },
  methods: {
    masonry: function() {
      imagesLoaded(this.$el, () => {
        this.list = new Masonry(this.$el, {
          columnWidth: '.coloumn-width',
          itemSelector: '.col',
          stagger: 30,
          fitWidth: this.fit
        })
      })
    }
  },
  mounted: function() {
    this.masonry()
	}
}
</script>

<style scoped>

.grid {
  max-width: 100%;
  margin-left: auto;
  margin-right: auto;
  transition: height 1s;
}
.grid > * {
  float: left;
}

</style>
