function cached(_ctx, _data, _t) {
	if (_data.type !== 'GET') {
		return false
	}
	let t = new Date().getTime() - _t
	if (_data.resource.id) {
		return _ctx.getters.get(_data.resource.id).cached > t
	} else {
		return _ctx.state.cached > t
	}
}

export function APIRequest(_ctx, _data, _dbo) {
	return new Promise((resolve, reject) => {
		let t = _ctx.state.cacheTime ? _ctx.state.cacheTime : (60 * 1000)
		if (!cached(_ctx, _data, t)) {
			_ctx.rootState.api.request(_data.type, _ctx.state.apiTarget, _data.resource, _data.body).then((r) => {
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
				data: _ctx.getters.get(_data.resource.id),
				cached: true
			})
		}
	})
}

function objectToFormData(obj) {
	let formData = new FormData();

	function appendFormData(data, root = '') {
		if (data instanceof File) {
			formData.append(root, data);
		} else if (Array.isArray(data)) {
			for (let i = 0; i < data.length; i++) {
				appendFormData(data[i], root + '[' + i + ']');
			}
		} else if (typeof data === 'object' && data) {
			for (let key in data) {
				if (data.hasOwnProperty(key)) {
					if (root === '') {
						appendFormData(data[key], key);
					} else {
						appendFormData(data[key], root + '.' + key);
					}
				}
			}
		} else {
			if (data !== null && typeof data !== 'undefined') {
				formData.append(root, data);
			}
		}
	}
	appendFormData(obj);

	return formData;
}

export function API(path, version) {
  function request(method, target, resource, body, headers) {
    return new Promise((resolve, reject) => {
      let ajaxRequest = new XMLHttpRequest()
			let payload = null
			
			let query = []
			for (let property in resource) {
				if (Array.isArray(resource[property])) {
					for (let value of resource[property]) {
						query.push(encodeURIComponent(property) + '[]=' + encodeURIComponent(value))
					}
				} else {
					query.push(encodeURIComponent(property) + '=' + encodeURIComponent(resource[property]))
				}
			}
			target += '?' + query.join('&')

			if (method == 'POST' || method == 'PUT') {
				payload = objectToFormData(body)
			}

			ajaxRequest.open(method, target)
      for (let header in headers) {
				ajaxRequest.setRequestHeader(header, headers[header])
      }
      ajaxRequest.onreadystatechange = function() {
        if (ajaxRequest.readyState === XMLHttpRequest.DONE) {
					let r = JSON.parse(ajaxRequest.responseText)

					for (let header in r.headers) {
						headers[header] = r.headers[header]
					}

          if (ajaxRequest.status === 200) {
            resolve(r)
          } else {
            reject(ajaxRequest.status)
          }
        }
			}
			
			ajaxRequest.send(payload)
    })
  }

  return {
    headers: {},
    request: function(method, target, resource, body) { return request(method, path + '/' + version + '/controller/' + target + '.php', resource, body, this.headers) }
  }
}
