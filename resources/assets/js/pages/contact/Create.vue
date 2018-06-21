<template>
  <div class="row justify-content-center">
    <div class="col-md-9">
      <div class="card">
        <div class="card-header">
            <router-link class="mr-3" to="/dashboard">
              <i class="fa fa-chevron-left"></i>
            </router-link>
          Create Contact
        </div>
        <div class="card-body">
          <contact-form ref="form" @submit="storeContact" :busy="busy"></contact-form>
        </div>
      </div>
    </div>
  </div>
</template>


<script>

import ContactForm from '../../components/ContactForm'

export default {
  components: {ContactForm},
  data() {
    return {
      busy: false
    }
  },
  methods: {
    async storeContact(contact) {
      console.log(contact)
      this.busy = true
      try {
        const {data} = await axios.post('/api/contacts', contact)
        this.$router.push('/contact/'+data.id)
      } catch (e) {
        this.$nextTick(() => {
          this.$refs.form.validateRequestErrors(e)
        })

      }
      this.busy = false
    }
  }
}
</script>
