import Vue from 'vue'
import { APIRequest } from '../api'

export const module = {
  namespaced: true,
  state: {
    items: {},
    apiTarget: 'post',
		cacheTime: 5 * 60 * 1000
  },
  getters: {
    get(_state) {
      return (_id) => _id ? (_state.items[_id] ? _state.items[_id] : {}) : _state.items
    }
  },
  mutations: {
		list(_state, _data) {
			let t = new Date().getTime()
			_state.cached = t
			for (let i of _data.items) {
				Vue.set(_state.items, i.id, i)
      }
		},
    create(_state, _data) {
			let t = new Date().getTime()
			for (let i of _data.items) {
				i.cached = t
				Vue.set(_state.items, i.id, i)
			}
    },
    edit(_state, _data) {
      Vue.set(_state.items, _data.item.id, _data.item)
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
    },
    _create(_ctx, _data) {
      return APIRequest(_ctx, {
        type: 'POST',
        action: 'create',
        resource: {},
        body: _data
      })
    },
    _edit(_ctx, _data) {
      return APIRequest(_ctx, {
        type: 'POST',
        action: 'edit',
        resource: {},
        body: _data
      })
    },
    _remove(_ctx, _data) {
      return APIRequest(_ctx, {
        type: 'POST',
        action: 'remove',
        resource: {},
        body: _data
      })
    }
  }
}
