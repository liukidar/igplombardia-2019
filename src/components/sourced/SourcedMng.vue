<template>
  <div class="sourced-mng">
    <i @click="save" class="close-btn material-icons grey-text white waves-effect square-halo-white z-depth-2 highlight-oh light">save</i>
    <i v-if="editable" class="close-btn material-icons grey-text white waves-effect square-halo-white z-depth-2 highlight-oh light" @click="close">close</i>
    <i v-else class="close-btn material-icons grey-text white waves-effect square-halo-white z-depth-2 highlight-oh light" @click="open">edit</i>
  </div>
</template>

<script>

export const module = {
  namespaced: true,
  state: {
    active: false
  },
  mutations: {
    status(state, payload) {
      state.active = payload
    }
  },
  actions: {
    open(context) {
      context.commit('status', true)
    },
    close(context) {
      context.commit('status', false)
    }
  }
}

export default {
  props: {
    onsave: {
      default: function() {}
    }
  },
  computed: {
    editable() {
      return true
    }
  },
  methods: {
    save() {
      this.onsave()
    },
    open() {
      this.$store.dispatch('sourcedmng/open')
    },
    close() {
      this.$store.dispatch('sourcedmng/close')
    }
  }
}

</script>

<style scoped>

.sourced-mng {
  position: fixed;
  left: 8px;
  bottom: 8px;
}

</style>
