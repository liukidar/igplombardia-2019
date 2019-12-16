let dbo = {
  user: {
    username: 'Luca',
    mail: 'pincoluca1@gmail.com',
    access: { view: true }
  }
}

export const module = {
  namespaced: true,
  state: {
    apiTarget: 'temp',
    request: (_ctx, _data, _dbo) => {
      return new Promise((resolve, reject) => {
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
      })
    },
    user: null
  },
  getters: {
    get(_state) {
      return _state.user
    }
  },
  mutations: {
    load(_state, _data) {
      _state.user = _data
    },
    delete(_state) {
      _state.user = null
    }
  },
  actions: {
    load(_ctx, _data) {
      return _ctx.state.request(_ctx, {
        data: _data,
        type: 'POST',
        action: 'load'
      }, dbo.user)
    },
    delete(_ctx, _data) {
      return _ctx.state.request(_ctx, {
        data: _data,
        type: 'DELETE',
        action: 'delete'
      })
    }
  }
}
