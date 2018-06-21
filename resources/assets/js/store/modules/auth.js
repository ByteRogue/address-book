const state = {
  user : null,
  token : localStorage.getItem('token')
}

const getters = {
  user : state => state.user,
  role: state => state.user.role,
  contactId : state => state.user.contact.id,
  token : state => state.token,
  check : state => state.user !== null
}

const mutations = {
  saveToken(state, {token}) {
    state.token = token
    localStorage.setItem("token", token)
  },
  fetchUserSuccess(state, {user}) {
    state.user = user
  },
  fetchUserFailure(state) {
    state.token = null
    state.user = null
    localStorage.removeItem("token")
  },
  updateUser(state, {user}) {
    state.user = user
  },
  logout(state) {
    state.user = null
    state.token = null
    localStorage.removeItem("token")
  }
}

const actions = {

  saveToken({commit}, payload) {
    commit('saveToken', payload)
  },

  async fetchUser({commit}) {
    try {
      const {data} = await axios.get('/api/auth/me')
      commit('fetchUserSuccess', {user : data})
    } catch (e) {
      commit('fetchUserFailure')
    }
  },

  updateUser({commit}, payload) {
    commit('updateUser', payload)
  },
  
  async logout({commit}) {
    try {
      await axios.post('/api/auth/logout')
    } catch (e) {}
    commit('logout')
  }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}
