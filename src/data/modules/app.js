export const module = {
  namespaced: true,
  state: {
    title: 'IGPLombardia',
    home: {
      id: 'home',
      href: '',
      icon: 'home',
      color: 'main-color',
      sections: ['description', /*'news'*/]
    },
    pages: {
      information: {
        id: 'information',
        href: '/information',
        icon: 'info',
        color: 'main-color',
        sections: ['igp', 'executive', 'partner']
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
        sections: ['private', 'society']
      },
      blog: {
        id: 'blog',
        href: '/blog',
        icon: 'chat_bubble_outline',
        color: 'blue',
        sections: ['events', 'projects']
      }
      /*
      admin: {
      },
      article: {
      }
      */
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
