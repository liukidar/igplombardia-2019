import Vue from 'vue'
import App from './App.vue'
import { router } from './router'
import { store } from './data/index'
import { i18n } from './locale'

Vue.config.productionTip = false

new Vue({
	router,
	store,
	i18n,
  render: h => h(App),
}).$mount('#app')
