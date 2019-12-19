<template>
  <div class="sourced-img">
    <slot :value="value"></slot>
    <template v-if="editable">
      <i v-if="!selected" class="material-icons circle-halo white grey-text text-darken-1 z-depth-3 highlight-oh light" @click="openFileManager">add_photo_alternate</i>
      <i v-else class="material-icons circle-halo white grey-text text-darken-1 z-depth-3 highlight-oh light" @click="closeFileManager">done</i>
    </template>
  </div>
</template>

<script>

export default {
  props: {
    value: {
      default: function() { return '' }
    }
  },
  computed: {
    selected() {
      return this.$store.state.filemanager.active === this
    },
    editable() {
      return this.$store.state.sourcedmng.active
    }
  },
  methods: {
    openFileManager: function() {
      this.$store.dispatch('filemanager/open', this)
    },
    closeFileManager: function() {
      this.$store.dispatch('filemanager/close')
    },
    select: function() {
      if (this.$store.state.filemanager.selected) {
        if (typeof this.value === 'object') {
          this.value.img = this.$store.state.filemanager.selected.src
        } else {
          this.$emit('update:value', this.$store.state.filemanager.selected.src)
        }
      }
    }
  }
}

</script>

<style scoped>

.sourced-img {
  position: relative;
}
.sourced-img > i {
  z-index: 1;
  position: absolute;
  top: 24px;
  left: 24px;
  transform: scale(0);
  transition: .25s;
}
.sourced-img:hover > i {
  transform: scale(1);
}

</style>
