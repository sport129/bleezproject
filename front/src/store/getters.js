const getters = {
  publicCrendentials: state => state.publicCrendentials,
  auth: state => state.auth,
  menu: state => state.auth.menu,
  isLogged: (state) => {
    return state.auth.logged
  },
  callDashboard: state => state.call,
  toast: state => state.toast
}

export default getters
