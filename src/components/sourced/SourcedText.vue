<template>
  <span class="sourced-text">
    <template v-if="editable">
      <span :key="0" contenteditable="true" spellcheck="false" @blur="update($event)" v-text="value"></span>
      <i class="grey-text text-darken-1 white circle-halo-white z-depth-3 material-icons">edit</i>
    </template>
    <span :key="1" v-else v-text="value ? value : '-'"></span>
  </span>
</template>

<script>

export default {
  props: ['value'],
  computed: {
    editable() {
      return true
    }
  },
  methods: {
    update(e) {
      this.$emit('update:value', e.target.innerText)
      this.$nextTick(() => {
        let event = new CustomEvent('resize')
        window.dispatchEvent(event)
      })
    }
  }
}

</script>

<style scoped>

.sourced-text {
  position: relative;
  overflow: visible;
}
.sourced-text > i {
  position: absolute;
  top: -38px;
  left: -38px;
  transform: scale(0);
  transition: transform .25s;
}
.sourced-text > span:focus + i {
  transform: scale(1);
}
.sourced-text span {
  white-space: pre-wrap;
}

</style>
