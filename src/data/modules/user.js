import { APIRequest } from '../api'

/* let dbo = {
  user: {
    username: 'Luca',
    mail: 'pincoluca1@gmail.com',
    access: { view: true }
  }
} */

export const module = {
  namespaced: true,
  state: {
    user: null,
		apiTarget: 'login'
  },
  getters: {
    get(_state) {
      return () => _state.user
    }
  },
  mutations: {
    load(_state, _data) {
			_state.user = _data.user
    },
    remove(_state) {
      _state.user = null
    }
  },
  actions: {
    _login(_ctx, _data) {
      return APIRequest(_ctx, {
        type: 'POST',
        action: 'load',
        body: _data
      })
    },
    _logout(_ctx) {
      return APIRequest(_ctx, {
        type: 'POST',
        action: 'remove',
        body: {}
      })
    }
  }
}
