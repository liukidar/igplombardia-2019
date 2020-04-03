import Vue from 'vue'
import Vuex from 'vuex'
import { API } from './api.js'
import { module as app } from './modules/app'
import { module as user } from './modules/user'
import { module as people } from './modules/people'
import { module as posts } from './modules/posts'
import { module as cms} from './modules/cms'

Vue.use(Vuex)

export const store = new Vuex.Store({
  state: {
    api: API('https://igplombardia.it/api', 'v0')
  },
  modules: {
		app,
    user,
    people,
    posts,
		cms
  }
})