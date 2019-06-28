import vue from 'vue'
import serviceAuth from './auth'
import serviceAuthors from './main'

vue.prototype.$serviceAuth = serviceAuth
vue.prototype.$serviceAuthors = serviceAuthors
