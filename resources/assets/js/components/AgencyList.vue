<template>
<div class="card mb-3">
  <div class="card-body">
    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
      <h4 class="card-title mb-0 mt-0">Agencies</h4>
      <div class="form-inline">
        <input type="text" class="form-control mr-3" v-model="search" @keyup="filter" placeholder="Search...">
        <router-link class="btn btn-success" to="agency/create">Create Agency</router-link>
      </div>
    </div>
    <div v-if="agencies.length">

        <div v-for="agency in agencies" :key="agency.id">
          <div>
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h5 class="mb-0 mt-0">#{{agency.id}} {{agency.name}}</h5>
              <div>
                <router-link class="btn btn-sm btn-success" :to="'/agency/'+agency.id">View</router-link>
                <button @click="deleteAgency(agency)" class="btn btn-sm btn-outline-danger">Delete</button>
              </div>
            </div>
            <strong>Address:</strong> {{agency.address}}<br>
            <strong>Email:</strong> <a :href="'mailto:'+agency.email">{{agency.email}}</a><br>
            <strong>Phones:</strong> {{listPhones(agency)}}<br>
            <strong>Web:</strong> {{agency.web}}
            <hr>
          </div>
        </div>
    </div>  
    <h3 v-else class="text-center text-muted mb-5 mt-5">Agency list is empty</h3>
  </div>
</div>
</template>


<script>
import swal from 'sweetalert2'
import {mapActions} from 'vuex'

export default {

  data() {
    return {
      agencies: [],
      search: null,
      timeout: null
    }
  }, 
  async mounted() {
    const {data} = await axios.get('/api/agencies')
    this.agencies = data
  },
  methods: {
    ...mapActions(['fetchContacts']),
    listPhones(agency) {
      return agency.phones.slice(0, 3).map((phone) => phone.number).join(', ')
    },
    async fetch() {
      const {data} = await axios.get('/api/agencies?filter='+this.search)
      this.agencies = data
    },
    filter() {
      clearTimeout(this.timeout)
      this.timeout = setTimeout(() => {
        this.fetch()
      }, 300)
    },
    deleteAgency(agency) {
      const deleteIt = async(result) => {
        if (result.value) {
          this.agencies = this.agencies.filter((item) => item != agency)
          await axios.delete('/api/agencies/'+agency.id)
          this.fetchContacts()
        }
      }
      swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then(deleteIt)
    }
  }
}
</script>
