import { axios, config } from '@/config'

const serviceAuth = {
  async signIn (payload) {
    return this.dispatchRequest('post', `${config.api.url}/login`, payload)
  },
  async getProducts () {
    return this.dispatchRequest('get', `${config.api.url}/getProducts`)
  },
  async getProduct (payload) {
    return this.dispatchRequest('post', `${config.api.url}/consultProduct`, payload)
  },
  async attProduct (payload) {
    return this.dispatchRequest('post', `${config.api.url}/updateProduct`, payload)
  },
  async deletProduct (payload) {
    return this.dispatchRequest('post', `${config.api.url}/delProduct`, payload)
  },
  async novoProduto (payload) {
    return this.dispatchRequest('post', `${config.api.url}/registerProduct`, payload)
  },
  async signOut (payload) {
    return this.dispatchRequest('post', `${config.api.url}/logout`, payload)
  },
  async upimagem (payload) {
    return this.dispatchRequest('post', `${config.api.url}/uploadImage`, payload)
  },
  async getImages (payload) {
    return this.dispatchRequest('post', `${config.api.url}/getImages`, payload)
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
