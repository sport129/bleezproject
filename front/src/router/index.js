import Vue from 'vue'
import store from '@/store'
import Router from 'vue-router'
import AuthLogin from '@/scenes/Auth/Login/Index'
import dpoIndex from '@/scenes/Aplication/Index'

Vue.use(Router)

const router = new Router({
  routes: [
    {
      path: '/',
      name: 'Default',
      redirect: '/login'
    },
    {
      path: '/login',
      name: 'AuthLogin',
      component: AuthLogin
    },
    {
      path: '/dashboard',
      name: 'Dashboard',
      component: dpoIndex,
      meta: { requiresAuth: true, title: 'Dashboard' }
    }
  ]
})

router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth) {
    if (!store.getters.isLogged) {
      next({ name: 'AuthLogin' })
    } else {
      next()
    }
  } else if (store.getters.isLogged) {
    next({ name: 'Dashboard' })
  } else {
    next()
  }
})

export default router
