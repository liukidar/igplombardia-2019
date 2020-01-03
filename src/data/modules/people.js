import Vue from 'vue'
import { APIRequest } from '../api'

let dbo = {
	people: [
		{ id: 0, username: 'Luca' },
		{ id: 1, username: 'Eva' }
	]
}

export const module = {
  namespaced: true,
  state: {
    items: {},
    apiTarget: 'temp',
		cacheTime: 5 * 60 * 1000
  },
  getters: {
    get(_state) {
      return (_id) => _id ? (_state.items[_id] ? _state.items[_id] : {}) : _state.items
    }
  },
  mutations: {
		list(state, _data) {
			let t = new Date().getTime()
			state.cached = t
			state.items = _data
		},
    create(_state, _data) {
			let t = new Date().getTime()
			for (let i of _data) {
				i.cached = t
				Vue.set(_state.items, i.id, i)
			}
    },
    edit(_state, _data) {
      Vue.set(_state.items, _data.id, _data)
    },
    remove(_state, _data) {
      Vue.delete(_state.items, _data.id)
    }
  },
  actions: {
    _list(_ctx) {
      return APIRequest(_ctx, {
        type: 'GET',
        action: 'list'
      }, dbo.people)
    }
  }
}
