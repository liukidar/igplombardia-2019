function cached(_ctx, _data, _t) {
	if (_data.type !== 'GET') {
		return false
	}
	let t = new Date().getTime() - _t
	if (_data.id) {
		return _ctx.getters.get(_data.id).cached > t
	} else {
		return _ctx.state.cached > t
	}
}

export function APIRequest(_ctx, _data, _dbo) {
	return new Promise((resolve, reject) => {
		let t = _ctx.state.cacheTime ? _ctx.state.cacheTime : (60 * 1000)
		if (!cached(_ctx, _data.data, t)) {
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
		else {
			resolve({
				status: true,
				data: _ctx.getters.get(_data.data.id),
				cached: true
			})
		}
	})
}

function isIterable(obj) {
  if (obj == null) {
    return false
  }
  return Array.isArray(obj) || typeof obj === 'object'
}

export function API(path, version) {
  function request(method, target, data, headers) {
    return new Promise((resolve, reject) => {
      let ajaxRequest = new XMLHttpRequest()
      let payload = ''

      if (method === 'GET' || method === 'DELETE') {
        if (isIterable(data)) {
          for (let value in data) {
            if (data[value] !== undefined) {
              payload += '/' + encodeURIComponent(data[value])
            }
          }
        } else {
          payload = '/' + encodeURIComponent(data)
        }
        ajaxRequest.open(method, target + payload)
      } else {
        ajaxRequest.open(method, target)
        ajaxRequest.setRequestHeader('Content-Type', 'application/json')
        payload = JSON.stringify(data)
      }

      for (let header in headers.data) {
        ajaxRequest.setRequestHeader(header, headers.data[header])
      }
      ajaxRequest.setRequestHeader('Cache-Control', 'no-cache')
      ajaxRequest.onreadystatechange = function() {
        if (ajaxRequest.readyState === XMLHttpRequest.DONE) {
					for (let header in data.headers) {
						headers.set(header, data.headers[header])
					}

          if (ajaxRequest.status === 200) {
            let r = JSON.parse(ajaxRequest.responseText)
            
            resolve(r)
          } else {
            reject(ajaxRequest.status)
          }
        }
      }

      if (method === 'GET' || method === 'DELETE') {
        ajaxRequest.send()
      } else {
        ajaxRequest.send(payload)
      }
    })
  }

  return {
    headers: {
      data: {},
      set: function(name, data) { this.data[name] = data }
    },
    request: function(method, target, data) { return request(method, path + '/' + version + '/controller/' + target + '.php', data, this.headers) }
  }
}
