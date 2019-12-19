<template>
  <div class="sourced-style">
    <slot :value="value"></slot>
    <template v-if="accessFlag.indexOf('-A-') !== -1">
      <transition name="style-pannel">
        <div v-if="open" class="style-pannel bkg-main-color z-depth-3">
          <div class="white z-depth-2">
            <div class="horizontal-flex" style="justify-content: space-between;">
              <div v-for="(el, key, index) in prototype" :key="index" style="padding: 0 2rem;">
                <p class="flow-text">{{key}}</p>
                <p v-for="(value, name, index) in el" :key="index">
                  <label>
                    <input @change="setStyle" v-model="classes[key]" type="radio" :name="key" :value="value">
                    <span>{{name}}</span>
                  </label>
                </p>
              </div>
            </div>
            </div>
            <div class="row">
              <button @click="toggle()" class="right btn btn-hm waves-effect waves-light text-important"><i class="material-icons">close</i></button>
            </div>
        </div>
      </transition>
      <i @click="toggle()" class="material-icons circle-halo white gret-text text-darken-1 z-depth-3 highlight-oh light">brush</i>
    </template>
  </div>
</template>

<script>

import { mapState } from 'vuex'

export default {
  props: {
    value: {
      default: null
    },
    prototype: {
      default: null
    },
    onclose: {
      default: null
    }
  },
  data: function() {
    return {
      open: false,
      classes: {}
    }
  },
  computed: {
    ...mapState(['accessFlag'])
  },
  methods: {
    toggle() {
      this.open = !this.open
      if (!this.open && this.onclose) {
        this.onclose()
      }
    },
    setStyle() {
      this.value.style = ''
      for (let c in this.prototype) {
        this.value.style += (this.classes[c] ? this.classes[c] : this.prototype[c].default) + ' '
      }
      this.$nextTick(() => {
        let event = new CustomEvent('resize')
        window.dispatchEvent(event)
      })
    }
  }
}
</script>

<style scoped>

.sourced-style {
  position: relative;
}
.sourced-style > i {
  z-index: 1;
  position: absolute;
  bottom: 24px;
  left: 24px;
  transform: scale(0);
  transition: .25s;
}
.sourced-style:hover > i {
  transform: scale(1);
}

.style-pannel {
  position: absolute;
  left: 4rem;
  top: -2rem;
  border-radius: 32px;
  overflow: hidden;
  z-index: 4;
  opacity: 0.1;
  transition: .75s;
}
.style-pannel:hover {
  opacity: 1;
}
.style-pannel > div {
  padding: 1rem 2rem;
}
.style-pannel > div:first-child {
  border-radius: 32px;
  padding: 2rem 4rem;
}
.style-pannel-enter, .style-pannel-leave-to {
  transform: scale(0);
  top: 100%;
  right: 100%;
  opacity: 0;
}

</style>
