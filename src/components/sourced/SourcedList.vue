<template>
  <div class="sourced-list">
    <template v-if="editable">
      <div class="row">
        <div class="sourced-list-element" v-for="(el, index) in values" :key="index">
          <slot :value="el" :index="index"></slot>
          <div class="sourced-list-element-edit">
            <i @click="remove(index)" class="grey-text text-darken-1 white circle-halo-white z-depth-3 material-icons highlight-oh light">delete</i>
            <i @click="moveDown(index)" class="grey-text text-darken-1 white circle-halo-white z-depth-3 material-icons highlight-oh light">keyboard_arrow_down</i>
          </div>
        </div>
      </div>
      <div class="row">
        <div v-for="(prototype, index) in prototypes" :key="index" class="chip z-depth-3 waves-effect" @click="create(prototype)">
          <i class="material-icons left inline">add</i>{{prototype.type}}
        </div>
      </div>
    </template>
    <div v-else class="row">
      <div class="sourced-list-element" v-for="(el, index) in values" :key="index">
        <slot :value="el" :index="index"></slot>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  props: {
    prototypes: {
      default: function() { return [] }
    },
    values: {
      default: function() { return [] }
    }
  },
  computed: {
    editable() {
      return true
    }
  },
  methods: {
    moveDown(n) {
      if (n < this.values.length - 1) {
        let tmp = this.values[n]
        this.$set(this.values, n, this.values[n + 1])
        this.$set(this.values, n + 1, tmp)
      }
    },
    remove(n) {
      this.values.splice(n, 1)
      this.$nextTick(() => {
        let event = new CustomEvent('resize')
        window.dispatchEvent(event)
      })
    },
    create(el) {
      this.values.push(JSON.parse(JSON.stringify(el)))
      this.$nextTick(() => {
        let event = new CustomEvent('resize')
        window.dispatchEvent(event)
      })
    }
  }
}
</script>

<style scoped>

.sourced-list-element {
  position: relative;
}

.sourced-list.inline .sourced-list-element {
  display: inline-block;
}

.sourced-list-element-edit {
  position: absolute;
  z-index: 1;
  top: 0;
  right: 32px;
}

.sourced-list.float .sourced-list-element-edit {
  float: left;
  position: relative;
  width: 0px;
}

.sourced-list-element-edit > i {
  position: absolute;
  transform: scale(0);
  transition: .25s;
}

.sourced-list-element:hover > .sourced-list-element-edit > i {
  transform: scale(1);
}
</style>
