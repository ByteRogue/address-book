import auth from './modules/auth'
import Vuex from 'vuex'
import Vue from 'vue'
import swal from 'sweetalert2'

Vue.use(Vuex)

export default new Vuex.Store({
  state : {
    contacts: [],
    contactSearch: '',
  },
  mutations: {
    setContacts(state, {data}) {
      state.contacts = data
    },
    setContactSearch(state, value) {
      state.contactSearch = value
    }
  },
  actions: {
    async fetchContacts({state, commit}) {
      const {data} = await axios.get('/api/contacts?filter='+state.contactSearch)
      commit('setContacts', {data} )
    },
    async deleteContact({state, commit}, contact) {
      swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.value) {
          commit('setContacts', {data: state.contacts.filter((item) => item.id != contact.id)})
          axios.delete('/api/contacts/'+contact.id)
        }
      })
    }
  },
  modules : {
    auth
  }   
})                                                                                                                                                                                                  
