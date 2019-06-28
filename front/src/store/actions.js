const actions = {
  userSignIn ({ commit }, payload) {
    commit('USER_SIGN_IN', payload)
  },
  userSignOut ({ commit }) {
    commit('USER_SIGN_OUT')
  },
  setCallDashboard ({ commit }, payload) {
    commit('SET_CALL_DASHBOARD', payload)
  },
  setToast ({ commit }, payload) {
    commit('SET_TOAST', payload)
  },
  publicCrendentials ({ commit }, payload) {
    commit('SET_PUBLIC_CREDENTIALS', payload)
  }
}

export default actions
