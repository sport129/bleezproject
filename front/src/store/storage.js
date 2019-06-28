import { config } from '@/config'

const STORAGE_NAME = config.app.storageName
const persistedStorage = JSON.parse(localStorage.getItem(STORAGE_NAME)) || {}

const myStorage = {
  persist (key, payload) {
    persistedStorage[key] = payload
    localStorage.setItem(STORAGE_NAME, JSON.stringify(persistedStorage))
  },
  remove (key) {
    persistedStorage[key] = undefined
    localStorage.setItem(STORAGE_NAME, JSON.stringify(persistedStorage))
  },
  fetch (key) {
    return persistedStorage[key]
  }
}

export { myStorage }
