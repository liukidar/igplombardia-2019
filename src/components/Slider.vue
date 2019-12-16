<script>
import imagesLoaded from 'imagesloaded'
import Bull from './Bull.vue'

export default {
  render(createElement) {
    return createElement('div', { class: 'flex-filler cmp-slider' },
      [
        createElement('transition-group', {class: 'flex-filler', attrs: {name: this.transition, style: 'min-height:' + this.height + 'px;'}}, this.$slots.default
          .filter((el) => el.tag !== undefined)
          .map((el, index) => createElement('div', {class: 'flex-filler', key: index}, [el]))
          .filter((el, index) => index === this.active)
        ),
        this.indicators ? createElement('div', {class: ['indicators', {'white-text': !this.dark, 'black-text': this.dark}]}, [
          createElement('i', {class: 'material-icons left', style: 'font-size: 32px', domProps: { innerHTML: 'keyboard_arrow_left' }, on: { click: () => { this.reset(); this.prev() } }}),
          createElement('span', {}, [...Array(this.length).keys()].map((el) => { return createElement('a', {on: { click: () => { this.set(el); this.reset() } }, class: el === this.active ? 'active' : '', style: 'margin:8px;'}, [createElement('bull', {class: ['to-top', {'dark': this.dark}]})]) })),
          createElement('i', {class: 'material-icons right', style: 'font-size: 32px', domProps: { innerHTML: 'keyboard_arrow_right' }, on: { click: () => { this.reset(); this.next() } }})
        ]) : null
      ]
    )
  },
  props: {
    indicators: {
      default: true
    },
    transition: {
      default: 'fade'
    },
    dark: {
      default: false
    },
    duration: {
      default: 8000
    }
  },
  data: function() {
    return {
      interval: null,
      active: 0,
      height: undefined
    }
  },
  mounted() {
    imagesLoaded(this.$el, () => {
      this.height = this.$el.clientHeight
    })
    this.reset()
  },
  destroyed() {
    clearInterval(this.interval)
  },
  computed: {
    length() {
      return this.$slots.default.filter(el => el.tag !== undefined).length
    }
  },
  methods: {
    next: function() {
      this.active = (this.active + 1) % this.length
      this.update()
    },
    prev: function() {
      this.active = (this.active - 1 + this.length) % this.length
      this.update()
    },
    set: function(n) {
      this.active = n
      this.update()
    },
    update: function() {
      this.$nextTick(() => {
        imagesLoaded(this.$el, () => {
          if (this.$el.clientHeight > this.height) {
            this.height = this.$el.clientHeight
          }
        })
      })
    },
    reset: function() {
      clearInterval(this.interval)
      this.interval = setInterval(() => {
        this.next()
      }, this.duration)
    }
  },
  components: {
    Bull
  }
}

</script>

<style scoped>

.cmp-slider {
  transition: min-height 1s;
  position: relative;
  width: 100%;
}
.indicators {
  padding: 40px 8px 10px 8px;
  text-align: center;
  max-width: 600px;
  margin: 0 auto;
}
.inside-indicators > .indicators{
  position: absolute;
  left: 0;
  right: 0;
  bottom: 0;
  z-index: 901;
}

.bounce-leave-active {
  position: absolute;
  width: 100%;
  height: 100%;
  transition: 1.2s cubic-bezier(0.500, -0.100, 0.735, 0.045);
}
.bounce-enter-active {
  position: relative;
  transition: 1s cubic-bezier(0.530, 1.255, 0.595, 0.990);
}
.bounce-enter {
  transform: translate(100vw, 0);
}
.bounce-leave-to {
  transform: translate(-100vw, 0);
}

.slide-leave-active {
  position: absolute;
  width: 100%;
  height: 100%;
  transition: 1s 0.25s ease-in;
}
.slide-enter-active {
  position: relative;
  transition: 1s ease-out;
}
.slide-enter {
  transform: translate(100vw, 0);
}
.slide-leave-to {
  transform: translate(-100vw, 0);
}

.fade-leave-active {
  position: absolute;
  width: 100%;
  height: 100%;
  transition: opacity 1s ease-in;
}
.fade-enter-active {
  position: relative;
  transition: opacity 1s ease-out;
}
.fade-enter {
  opacity: 0;
}
.fade-leave-to {
  opacity: 0;
}

</style>
