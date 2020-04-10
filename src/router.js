import Vue from 'vue'
import Router from 'vue-router'
import { store } from './data/index'

import Home from './pages/Home'
//import Passivhaus from '@/pages/Passivhaus'
import Information from '@/pages/Information'
import Registration from '@/pages/Registration'
import Admin from '@/pages/Admin'
import Blog from '@/pages/Blog'

Vue.use(Router)

export const router = new Router({
	routes: [
		{
      path: '/:target?',
      name: 'Home',
      component: Home
		},
		/*{
			path: '/passivhaus/:target?',
      name: 'Passivhaus',
      component: Passivhaus
		},*/
		{
			path: '/information/:target?',
      name: 'Information',
      component: Information
		},
		{
			path: '/registration/:target?',
      name: 'Registration',
      component: Registration
		},
		{
			path: '/admin/:target?',
			name: 'Admin',
      component: Admin,
      beforeEnter: (to, from, next) => {
        let u = store.getters['user/get']()
        if (!u || !u.access['v']) {
          next(from)
        } else {
          next()
        }
      }
		},
		{
			path: '/blog/:target?',
			name: 'Blog',
			component: Blog
		}
	]
})
