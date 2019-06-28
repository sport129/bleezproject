import axios from 'axios'

const config = {
  api: {
    url: 'http://127.0.0.1:8080/api',
    key: '-',
    secret: '-',
    token: btoa(`-:`)
  },
  app: {
    url: 'http://127.0.0.1:8081',
    storageName: '@BLEEZPROJECT'
  },
  pusher: {
    key: '5e69969fec2396356747'
  }
}

export { axios, config }
