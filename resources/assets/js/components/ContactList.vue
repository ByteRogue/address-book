<template>
<div class="card mb-3">
  <div class="card-body">
    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
      <h4 class="card-title mb-0 mt-0">Contacts</h4>
      <div class="form-inline">
        <input type="text" class="form-control mr-3" v-model="search" @keyup="filter" placeholder="Search...">
        <router-link class="btn btn-success" to="contact/create">Create Contact</router-link>
      </div>
    </div>
    <div v-if="contacts.length">
        <div  v-for="contact in contacts" :key="contact.id">
          <div class="row">
            <div class="col-md-3 col-sm-12">
              <img class="img-thumbnail contact-avatar mb-3" :src="contact.avatarPath ? contact.avatarPath : '/images/user.png'" alt="">
            </div>
            <div class="col">
              <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 mt-0">#{{contact.id}} {{contact.user.first_name}} {{contact.user.last_name}}</h5>
                <div>
                  <router-link class="btn btn-sm btn-success" :to="'/contact/'+contact.id">View</router-link>
                  <button @click="deleteContact(contact)" class="btn btn-sm btn-outline-danger">Delete</button>
                </div>
              </div>
              <strong>Agency: </strong>{{contact.agency.name}}<br>
              <strong>Email: </strong><a :href="'mailto:'+contact.user.email">{{contact.user.email}}</a><br>
              <strong>Phones: </strong>{{listPhones(contact)}}
            </div>
          </div>
          <hr>
        </div>
    </div>
    <h3 v-else class="text-center text-muted mb-5 mt-5">Contact list is empty</h3>
  </div>
</div>
</template>


<script>
import swal from 'sweetalert2'
import {mapState, mapActions} from 'vuex'

export default {

  data() {
    return {
      //contacts: [],
      //search: '',
      timeout: null
    }
  }, 
  mounted() {
    //const {data} = await axios.get('/api/contacts')
    //this.contacts = data
    this.fetchContacts()
  },
  computed: {
    ...mapState(['contacts']),
    search: {
      get () {
        return this.$store.state.contactSearch
      },
      set (value) {
        this.$store.commit('setContactSearch', value)
      }
    }
  },
  methods: {
    ...mapActions(['fetchContacts', 'deleteContact']),
    listPhones(contact) {
      return contact.phones.slice(0, 3).map((phone) => phone.number).join(', ')
    },
    /*async fetchContacts() {
      const {data} = await axios.get('/api/contacts?filter='+this.search)
      this.contacts = data
    },*/
    filter() {
      clearTimeout(this.timeout)
      this.timeout = setTimeout(() => {
        this.fetchContacts()
      }, 300)
    }
  }
}
</script>
