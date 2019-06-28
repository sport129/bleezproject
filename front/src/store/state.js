const state = {
  auth: {
    client: {
      id: '',
      username: '',
      password: '',
      email: ''
    },
    credentials: {
      token: '',
      time_expired: ''
    },
    logged: false
  },
  toast: {
    y: 'bottom',
    x: 'right',
    mode: 'multi-line',
    timeout: 2000,
    visible: false,
    color: 'black',
    content: ''
  },
  publicCrendentials: {
    token: '',
    lastActivity: null,
    device: '',
    clientIP: '',
    publicLogged: false
  }
}

export default state
