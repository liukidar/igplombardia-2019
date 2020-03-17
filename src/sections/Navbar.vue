<template>
  <header class="cmp-navbar">
		<nav class="nav-extended">
      <div class="nav-wrapper"></div>
      <div class="nav-content hide-on-med-and-down"><ul class="tabs"></ul></div>
    </nav>
    <nav class="white nav-extended navbar-fixed">
      <div class="nav-wrapper">
        <language-selector class="right hide-on-med-and-down"></language-selector>
        <div class="container">
          <router-link class="hide-on-large-only" to="/!" style="padding: 6px 0;">
						<img :src="require('@/assets/imgs/igp-wide.jpg')" style="height:44px;">
						<!--<i class="material-icons color-main hide-on-large-only">home</i>-->
					</router-link>
					<router-link :to="`${activePage.href}/!`" class="hide-on-med-and-down brand-logo color-main" style="padding: 6px 0;">
						<img :src="require('@/assets/imgs/igp-wide.jpg')" style="height:52px;">
					</router-link>
          <ul class="btn-sidebar hide-on-large-only">
            <li><a data-target="slide-out" class="sidenav-trigger"><i class="material-icons grey-text text-lighten-1">menu</i></a></li>
          </ul>
          <ul class="right hide-on-med-and-down">
            <li>
              <router-link to="/!" class="transparent left grey-text highlight-oh light">HOME</router-link>
              <span class="pipe grey-text text-lighten-1"></span>
            </li>
            <li v-for="link in pages" :key="link.id">
              <template v-if="link.visible == true">
                <router-link :to="link.href + '/!'" class="transparent left grey-text highlight-oh light uppercase">{{$t(`pages.${link.id}.title`)}}</router-link>
                <span class="pipe grey-text text-lighten-1"></span>
              </template>
            </li>
          </ul>
        </div>
      </div>
      <div class="nav-content white hide-on-med-and-down">
        <div class="right">
          <ul class="tabs right">
            <li class="grey-text highlight-oh light tab" @click="openLoginModal">LOGIN</li>
          </ul>
        </div>
        <div class="container">
          <ul class="tabs">
            <li v-for="link in activePage.sections" :key="link" class="tab">
              <router-link :to="link" class="waves-effect waves-dark navbar-link color-main bkg-white-color bkg-white">{{$t(`pages.${activePage.id}.sections.${link}.title`)}}</router-link>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <login></login>
		<sidebar></sidebar>
  </header>
</template>

<script>
import LanguageSelector from '../components/LanguageSelector'
import Login from '../modals/Login'
import Sidebar from './Sidebar'

import { mapGetters } from 'vuex'

export default {
  methods: {
    openLoginModal() {
      M.Modal.getInstance(document.getElementById('login-modal')).open()
		},
		openCMS() {
			M.Modal.getInstance(document.getElementById('cms-modal')).open()
		}
  },
  computed: {
		...mapGetters('app', ['title', 'pages', 'pageFromRoute']),
		activePage() {
			return this.pageFromRoute(this.$route)
		}
  },
  components: {
		Sidebar,
		LanguageSelector,
		Login
  }
}
</script>

<style scoped>

nav {
  box-shadow: none;
  border-bottom: 1px solid #e0e0e0;
}
nav.navbar-fixed {
	position: fixed;
	top: 0;
}

.nav-wrapper {
	padding-right: 20px;
}

.nav-content {
  border-top: 1px solid #e0e0e0;
	padding-right: 20px;
}

.nav-content > .right {
	position: absolute;
	top: 0;
	right: 20px;
}

.btn-sidebar {
	position: absolute;
	right: 0;
	top: 0;
}

.tabs .tab a {
	transition: background-color 0.5s;
}
.tabs .tab a:hover {
  background-color: #eceff1 !important;
}

</style>
