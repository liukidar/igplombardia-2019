import Vue from 'vue'
import { APIRequest } from '../api'

export const module = {
  namespaced: true,
  state: {
		items: {},
		target: null,
		edit: false,
		apiTarget: 'temp',
		cached: null,
		cacheTime: 5 * 60 * 1000
  },
  getters: {
    get(_state) {
      return (_id) => _id ? (_state.items[_id] ? _state.items[_id] : {}) : _state.items
		},
		target(_state) {
			return _state.target
		}
  },
  mutations: {
		target(state, _data) {
			state.active = _data.value
		},
		edit(state, _data) {
			state.edit = _data.value
		},
		create(state, _data) {
			let t = new Date().getTime()
			for (let i of _data.items) {
				i.cached = t
				Vue.set(state.items, i.id, i)
			}
		},
		delete(state, _data) {
			for (let i of _data.items) {
				Vue.delete(state.items, i.id)
			}
		}
	},
	actions: {
		target(_ctx, _data) {
			_ctx.commit('target', _data)
		},
		edit(_ctx, _data) {
			_ctx.commit('edit', _data)
		},
		list(_ctx) {
			return APIRequest(_ctx, {
				type: 'GET',
				action: 'create'
			})
		},
		create(_ctx, _data) {
			return APIRequest(_ctx, {
				type: 'POST',
				action: 'create',
				data: _data
			})
		},
		delete(_ctx, _data) {
			return APIRequest(_ctx, {
				type: 'DELETE',
				action: 'delete',
				data: _data
			})
		}
	}
}
