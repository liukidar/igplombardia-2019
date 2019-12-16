import Vue from 'vue'
import VueI18n from 'vue-i18n'

import it from './lang/italian'

Vue.use(VueI18n)

export const i18n = new VueI18n({
  locale: 'it',//(window.navigator.userLanguage || window.navigator.language).substr(0,2),
	messages: {
		it,
		en: {}
	}
})
