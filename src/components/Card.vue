<template>
  <div class="card-wrap">
    <div class="card no-margin no-padding">
      <div class="card-image">
        <material-box :class="ratio" :img="img">
          <span class="card-title title" v-if="this.$slots['title']">
            <slot name="title"></slot>
          </span>
        </material-box>
      </div>
      <div class="card-content" v-if="this.$slots['description']">
        <div class="flow-text" style="margin:0"><slot name="description"></slot></div>
      </div>
      <div class="card-action" v-if="this.$slots['action']">
        <slot name="action"></slot>
      </div>
    </div>
  </div>
</template>

<script>
import MaterialBox from './MaterialBox'

export default {
  props: {
    img: {
      default: undefined
    },
    ratio: {
      default: 'r1-1'
    }
  },
  components: {
    MaterialBox
  }
}
</script>

<style scoped>

.card-wrap {
	padding: 2rem;
}

.card-flat > .card {
  box-shadow: none;
  text-align: center;
}

.card-flat .card-title {
  bottom: auto;
  right: 0;
  top: 100%;
  padding: 12px;
  color: inherit !important;
}
.card-flat .card-content {
  padding-top: 48px;
}
.card-flat .card-action {
  text-align: left;
  border: none;
}

.card-title {
  padding-bottom: 18px !important;
}

</style>
