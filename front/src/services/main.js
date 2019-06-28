import { axios, config } from '@/config'

const serviceAuthors = {
  // Apenas exemplos
  async getExemple () {
    return this.dispatchRequest('post', `${config.api.url}/Exemple`)
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

export default serviceAuthors
