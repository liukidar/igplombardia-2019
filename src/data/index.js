import Vue from 'vue'
import Vuex from 'vuex'
import { API } from './api.js'
import { module as app } from './modules/app'
import { module as user } from './modules/user'
import { module as people } from './modules/people'

Vue.use(Vuex)

export const store = new Vuex.Store({
  state: {
    api: API('http://libricope.altervista.org/api', 'v0')
  },
  modules: {
		app,
    user,
    people
  }
})