export const module = {
  namespaced: true,
  state: {
    title: 'IGPLombardia',
    home: {
      id: 'home',
      href: '',
      icon: 'home',
      color: 'main-color',
			sections: ['description', /*'news'*/],
			visible: true
    },
    pages: {
      information: {
        id: 'information',
        href: '/information',
        icon: 'info',
        color: 'main-color',
        sections: [/*'igp',*/ 'executive'/*,'partner'*/],
				visible: true
      },
      /*
      passivhaus: {
        id: 'passivhaus',
        href: '/passivhaus',
        icon: 'battery_charging_full',
        color: 'green',
        sections: ['description', 'designers', 'projects']
      },
      */
      registration: {
        id: 'registration',
        href: '/registration',
        icon: 'supervisor_account',
        color: '',
        sections: ['private', 'registration'],
				visible: true
      },
      /*
      blog: {
        id: 'blog',
        href: '/blog',
        icon: 'chat_bubble_outline',
        color: 'blue',
        sections: ['events', 'projects'],
				visible: true
      },*/
      admin: {
				id: 'admin',
				href: '/admin',
				sections: ['accounts', 'articles']
      }
    }
  },
  getters: {
    title(state) {
      return state.title
    },
    pages(state) {
      return state.pages
    },
    pageFromRoute(state) {
      return (route) => {
        var path = route.path.substr(1, route.path.indexOf('/', 1) - 1)
        if (path !== '') {
          return state.pages[path]
        } else {
          return state.home
        }
      }
    }
  },
  mutations: {
  }
}
