<template>
  <div class="cmp-chips">
    <div class="chips"></div>
  </div>
</template>

<script>
export default {
  props: ['value', 'placeholder', 'secondaryPlaceholder'],
  data: function() {
    return {
      chips: null,
      guard: null
    }
  },
  mounted() {
    this.update()
  },
  watch: {
    value: function() {
      if (Array.isArray(this.value) && this.guard != this.value) {
        this.update()
      }
    }
  },
  methods: {
    update() {
      this.chips = M.Chips.init(this.$el.querySelectorAll('.chips'), {
        data: this.value.map(el => ({ tag: el })),
        onChipAdd: () => {
          this.guard = this.chips.chipsData.map(el => el.tag)
          this.$emit('update:value', this.guard)
        },
        onChipDelete: () => {
          this.guard = this.chips.chipsData.map(el => el.tag)
          this.$emit('update:value', this.guard)
        },
        placeholder: this.placeholder,
        secondaryPlaceholder: this.secondaryPlaceholder
      })[0]
    }
  }
}
</script>

<style>

</style>