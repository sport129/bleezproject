import { myStorage } from './storage'

const mutations = {
  'SET_PUBLIC_CREDENTIALS' (state, payload) {
    const { token, lastActivity, device, clientIP, publicLogged } = payload
    state.publicCrendentials.token = token
    state.publicCrendentials.lastActivity = lastActivity
    state.publicCrendentials.device = device
    state.publicCrendentials.clientIP = clientIP
    state.publicCrendentials.publicLogged = publicLogged
  },
  'SET_CALL_DASHBOARD' (state, payload) {
    const { form, model, opened, processing } = payload
    state.call.form = form
    state.call.model = model
    state.call.opened = opened
    state.call.processing = processing
  },
  'SET_TOAST' (state, payload) {
    const { color, visible, content } = payload
    state.toast.color = color || 'black'
    state.toast.visible = visible
    state.toast.content = content
  },
  'USER_SIGN_IN' (state, payload) {
    state.auth = payload
    myStorage.persist('auth', state.auth)
  },
  'USER_SIGN_OUT' (state, payload) {
    myStorage.remove('auth')
    state.auth = {
      client: {
        name: '',
        email: '',
        status: '',
        profile: '',
        avatar: ''
      },
      credentials: {
        token: '',
        expires_in: ''
      },
      menu: [],
      logged: false
    }
  }
}

export default mutations
