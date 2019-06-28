import { axios, config } from '@/config'

const serviceAuth = {
  async signIn (payload) {
    return this.dispatchRequest('post', `${config.api.url}/login`, payload)
  },
  async getProducts () {
    return this.dispatchRequest('get', `${config.api.url}/getProducts`)
  },
  async signOut (payload) {
    return this.dispatchRequest('post', `${config.api.url}/logout`, payload)
  },
  async dispatchRequest (method, url, payload = {}, headers = {}) {
    try {
      const response = await axios[method](url, payload)
      return response
    } catch (error) {
      return error.response
    }
  }
}

export default serviceAuth
