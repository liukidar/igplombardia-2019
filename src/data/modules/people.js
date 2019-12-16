import Vue from 'vue'

let dbo = {
  people: {
    0: { id: 0, username: 'Luca' },
    1: { id: 1, username: 'Eva' }
  }
}

let cacheTime = 5 * 60 * 1000 // 5 minutes

export const module = {
  namespaced: true,
  state: {
    apiTarget: 'temp',
    request(_ctx, _data, _dbo) {
      return new Promise((resolve, reject) => {
        if (!_ctx.getters.cached(_data)) {
          _ctx.rootState.api.request(_data.type, _ctx.state.apiTarget, _data.data).then((r) => {
            if (r.status) {
              if (_dbo) {
                r.data = _dbo
              }
              _ctx.commit(_data.action, r.data)

              return resolve(r)
            } else {
              return reject(r)
            }
          }).catch((e) => reject(e))
        }
      })
    },
    items: {},
    cached: null
  },
  getters: {
    cached(_state) {
      return (_data) => {
        if (_data.type !== 'GET') {
          return false
        }
        let t = new Date().getTime() - cacheTime
        if (_data.id) {
          return _state.items[_data.id].cached > t
        } else {
          return _state.cached > t
        }
      }
    },
    list(_state) {
      return _state.items
    },
    get(_state) {
      return (_id) => _state.items[_id] ? _state.items[_id] : {}
    }
  },
  mutations: {
    list(_state, _data) {
      _state.items = _data
      _state.cached = new Date().getTime()
    },
    load(_state, _data) {
      _data.cached = new Date().getTime()
      _state.items[_data.id] = _data
    },
    create(_state, _data) {
      Vue.set(_state.items, _data.id, _data)
    },
    delete(_state, _data) {
      Vue.delete(_state.items, _data.id)
    },
    edit(_state, _data) {
      Vue.set(_state.items, _data.id, _data)
    }
  },
  actions: {
    list(_ctx) {
      return _ctx.state.request(_ctx, {
        type: 'GET',
        action: 'list'
      }, dbo.people)
    }
  }
}
