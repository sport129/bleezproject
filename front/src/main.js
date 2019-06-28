// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import Echo from 'laravel-echo'
import Pusher from 'pusher-js'
import store from './store'
import router from './router'
import Vuetify from 'vuetify'
import axios from 'axios'

import 'vuetify/dist/vuetify.min.css'

Vue.use(Vuetify)

Vue.config.productionTip = false

require('@/config')
require('@/services')
require('@/bootstrap')
require('@/components')

Pusher.logToConsole = false
window.Pusher = Pusher
window.Echo = new Echo({
  broadcaster: 'pusher',
  key: '5e69969fec2396356747',
  cluster: 'us2',
  encrypted: true
})

Vue.prototype.$echo = window.Echo
Vue.prototype.$axios = axios

/* eslint-disable no-new */
new Vue({
  el: '#app',
  store,
  router,
  components: { App },
  template: '<App/>'
})
