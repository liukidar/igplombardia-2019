import Vue from 'vue'
import { APIRequest } from '../api'

export const module = {
  namespaced: true,
  state: {
		items: {},
		target: null,
		edit: false,
		apiTarget: 'cms',
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
		list(state, _data) {
			let t = new Date().getTime()
			state.cached = t
			for (let i of _data.files) {
				Vue.set(state.items, i.id, i)
			}
		},
		create(state, _data) {
			let t = new Date().getTime()
			for (let i of _data.files) {
				i.cached = t
				Vue.set(state.items, i.id, i)
			}
		},
		remove(state, _data) {
			for (let i of _data.files) {
				Vue.delete(state.items, i)
			}
		}
	},
	actions: {
		_target(_ctx, _data) {
			_ctx.commit('target', _data)
		},
		_edit(_ctx, _data) {
			_ctx.commit('edit', _data)
		},
		_list(_ctx) {
			return APIRequest(_ctx, {
				type: 'GET',
				action: 'list',
				resource: {}
			})
		},
		_create(_ctx, { resource, body }) {
			return APIRequest(_ctx, {
				type: 'POST',
				action: 'create',
				resource,
				body
			})
		},
		_remove(_ctx, { resource }) {
			return APIRequest(_ctx, {
				type: 'DELETE',
				action: 'remove',
				resource
			})
		}
	}
}
