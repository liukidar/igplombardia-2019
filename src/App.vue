<template>
  <div id="!" class="app">
    <navbar></navbar>
    <main id="body">
      <router-view/>
    </main>
    <footerbar></footerbar>
    <scroll-up-arrow></scroll-up-arrow>
  </div>
</template>

<script>
import './lib/js/materialize.min.js'

import Navbar from './sections/Navbar'
import Footerbar from './sections/Footerbar'
import ScrollUpArrow from './components/ScrollUpArrow'
import { scrollTo } from './lib/js/script'

export default {
  methods: {
    materialize() {
      let elems = document.querySelectorAll('.modal')
      M.Modal.init(elems, {})
      elems = document.querySelectorAll('.tooltipped')
      M.Tooltip.init(elems, {})
    },
    handleScroll() {
      if (!this.$route.hash) {
        this.$router.replace('#')
      }
    }
  },
  created() {
    window.addEventListener('scroll', this.handleScroll)
  },
  destroyed() {
    window.removeEventListener('scroll', this.handleScroll)
  },
  mounted() {
    this.materialize()
    scrollTo(this.$route.params.target)
  },
  updated() {
    this.materialize()
  },
  watch: {
    $route(to) {
      if (to.hash !== '#') {
        scrollTo(this.$route.params.target)
      }
    }
  },
  components: {
    // Sections
    Navbar, Footerbar,
    // Components
    ScrollUpArrow
  }
}
</script>

<style>

@import './lib/css/materialize.min.css';
@import './lib/css/style.css';
@import 'https://fonts.googleapis.com/icon?family=Material+Icons';
@import 'https://fonts.googleapis.com/css?family=Poiret+One';
@import 'https://fonts.googleapis.com/css?family=Roboto:300';
@import 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css';

html {
  font-size: 12px;
}

.app {
  display: flex;
  min-height: 100vh;
  flex-direction: column;
  max-width: 100vw;
}

</style>
