import Vue from 'vue'
import App from './App.vue'
import { router } from './router'
import { store } from './data/index'
import { i18n } from './locale'

Vue.config.productionTip = false

Vue.directive('hold', {
	bind: function (el, binding, vNode) {
			if (typeof binding.value !== 'function') {
					const compName = vNode.context.name
					let warn = `[hold:] provided expression '${binding.expression}' is not a function, but has to be`
					if (compName) { warn += `Found in component '${compName}' ` }
					// eslint-disable-next-line
					console.warn(warn)
			}

			let pressTimer = null

			let start = (e) => {
					if (e.type === 'click' && e.button !== 0) {
							return;
					}
					if (pressTimer === null) {
							pressTimer = setTimeout(() => {
									handler()
							}, 1000)
					}
			}

			let cancel = () => {
					if (pressTimer !== null) {
							clearTimeout(pressTimer)
							pressTimer = null
					}
			}
			const handler = (e) => {
					binding.value(e)
			}

			el.addEventListener("mousedown", start)
			el.addEventListener("touchstart", start)
			el.addEventListener("click", cancel)
			el.addEventListener("mouseout", cancel)
			el.addEventListener("touchend", cancel)
			el.addEventListener("touchcancel", cancel)
	}
})

new Vue({
	router,
	store,
	i18n,
  render: h => h(App),
}).$mount('#app')
