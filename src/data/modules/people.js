import Vue from 'vue'
import { APIRequest } from '../api'

export const module = {
  namespaced: true,
  state: {
    items: {},
    apiTarget: 'people',
		cacheTime: 5 * 60 * 1000
  },
  getters: {
    get(_state) {
      return (_id) => _id ? (_state.items[_id] ? _state.items[_id] : {}) : _state.items
    },
    get_executive(_state) {
      return Object.keys(_state.items).filter((el) => _state.items[el].executive == 1)
    },
    get_designers(_state) {
      return Object.keys(_state.items).filter((el) => _state.items[el].designer == 1).sort((a, b) => _state.items[a].username.split(' ')[1] > _state.items[b].username.split(' ')[1] ? 1 : -1)
    },
    get_artisans(_state) {
      return Object.keys(_state.items).filter((el) => _state.items[el].artisan == 1)
    },
  },
  mutations: {
		list(_state, _data) {
			let t = new Date().getTime()
			_state.cached = t
			for (let i of _data.users) {
				Vue.set(_state.items, i.id, i)
			}
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
        action: 'list',
				resource: {}
      })
    }
  }
}
