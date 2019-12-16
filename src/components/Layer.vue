<template>
  <div class="cmp-layer">
    <div class="cmp-main-layer flex-fill" :class="{ 'active': !layer }">
      <slot :set="set" :active="layer"></slot>
    </div>
    <div class="cmp-background">
      <div :class="[ layerColor, {'active': active} ]" :style="layerStyle"></div>
    </div>
    <div class="cmp-layers" :class="bkgColor">
      <transition name="fade">
        <div class="cmp-content" :key="layer" v-if="layer">
          <slot :set="set" :active="layer" :name="layer"></slot>
        </div>
      </transition>
    </div>
  </div>
</template>

<script>

export default {
  data: () => {
    return {
      layerStyle: {
        top: 0,
        left: 0,
        width: 0,
        height: 0,
        opacity: 1
      },
      mainStyle: {
        'z-index': 1
      },
      layer: null,
      layerColor: null,
      bkgColor: null,
      active: false
    }
  },
  mounted() {
    let occluder = this.$el.getElementsByClassName('cmp-background')[0].children[0]
    occluder.addEventListener('transitionend', (e) => {
      this.bkgColor = this.layer ? this.layerColor : 'transparent'
      if (this.layer || e.propertyName === 'opacity') {
        this.reset()
      }
    })
  },
  methods: {
    reset() {
      this.active = false
      this.layerStyle.width = this.layerStyle.height = 0
      this.layerStyle.opacity = 1
    },
    set(e, layer, color) {
      if (layer !== this.layer) {
        this.reset()
        this.$nextTick(() => {
          this.active = true
          this.layer = layer
          this.layerColor = color
          let tmp = this.$el.getBoundingClientRect()
          if (!e) {
            this.layerStyle.top = ((tmp.bottom - tmp.top) / 2) + 'px'
            this.layerStyle.left = ((tmp.right - tmp.left) / 2) + 'px'
          } else {
            this.layerStyle.top = Math.min(this.$el.clientHeight, Math.max(0, (e.clientY - tmp.top))) + 'px'
            this.layerStyle.left = Math.min(this.$el.clientWidth, Math.max(0, (e.clientX - tmp.left))) + 'px'
          }
          this.layerStyle.width = this.layerStyle.height = 2 * Math.max(this.$el.clientWidth, this.$el.clientHeight) + 'px'
          this.layerStyle.opacity = 0
        })
      }
    }
  }
}
</script>

<style scoped>
.cmp-layer {
  position: relative;
  display: flex;
  padding: 0 !important;
}

.cmp-layers {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  pointer-events: none;
}

.cmp-main-layer {
  width: 100%;
  position: relative;
  z-index: 0;
  opacity: 0;
  transition: opacity .5s ease;
}
.cmp-main-layer.active {
  z-index: 2;
  opacity: 1;
  transition: opacity .5s .1s ease;
}
.cmp-main-layer > * {
  width: 100%;
}
.cmp-layer-controller {
  pointer-events: all;
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  z-index: 4;
}

.cmp-content {
  display: flex;
  pointer-events: none;
  position: absolute;
  width: 100%;
  height: 100%;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  overflow: hidden;
}

.cmp-background {
  z-index: 1;
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  overflow: hidden;
  pointer-events: none;
}
.cmp-background > div {
  position: absolute;
  border-radius: 100%;
  transform: translate(-50%, -50%);
}
.cmp-background > div.active {
  border-radius: 0;
  transition: width .3s ease-in, height .3s ease-in, border-radius .25s .15s ease-out, opacity .6s .3s;
}

.fade-leave-active {
  z-index: 1;
  transition: opacity .5s ease;
}
.fade-enter-active {
  z-index: 2;
  transition: opacity .5s .1s ease;
}
.fade-enter {
  opacity: 0;
}
.fade-leave-to {
  opacity: 0;
}
</style>

<style>
.cmp-content > * {
  position: relative;
  pointer-events: all;
  width: 100%;
}
</style>
