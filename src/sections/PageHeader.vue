<template>
  <div class="cmp-page-header white-text text-important">
    <div class="container">
      <tr-slide-in class="ch-tr1 roboto-important">
        <h2 :key="0" data-index="0" data-from="-16rem, 0">{{openTitleChar}}</h2>
        <h1 :key="1" data-index="1" data-from="0, -8rem" class="no-margin">
          <slot name="title"></slot>
        </h1>
        <h4 :key="2" data-index="2" data-from="0, 16rem" class="grey-text text-lighten-1">
          <slot name="subtitle"></slot>
        </h4>
        <h2 :key="3" data-index="3" data-from="16rem, 0">{{closeTitleChar}}</h2>
      </tr-slide-in>
    </div>
    <tr-slide-in stagger="1000" :settings="{from : '-100vw, 0'}" class="ch-tr1 container">
      <div :key="0" data-index="1" class="flow-text" style="margin: 2rem 0 2rem 0;">
        <small>
          <slot name="description"></slot>
        </small>
      </div>
      <router-link :to="to" :key="1" data-index="1" data-from="0, 50vh" v-if="learnMoreBtn" class="learn-more waves-effect waves-light highlight-oh">
        LEARN MORE
      </router-link>
    </tr-slide-in>
  </div>
</template>

<script>
import TrSlideIn from '../components/TrSlideIn'

export default {
  props: {
    'open-title-char': {
      default: '<'
    },
    'close-title-char': {
      default: '>'
    },
    learnMoreBtn: {
      default: true
    },
    to: {
      default: '!'
    }
  },
  components: {
    TrSlideIn
  }
}
</script>

<style scoped>

.roboto-important {
  font-family: "Roboto";
  font-variant: small-caps;
}

.cmp-page-header {
	background: rgba(0,0,0,0.6);
	pointer-events: none;
	overflow: hidden;
}

.learn-more {
  border: 1px solid #aaa;
  padding: 1rem;
  pointer-events: auto;
  margin: 1rem 0 4rem 0;
}

</style>
