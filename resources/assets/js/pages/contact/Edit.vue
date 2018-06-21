<template>
  <div class="row justify-content-center">
    <div class="col-md-9">
      <div class="card">
        <div class="card-header">
          <router-link class="mr-3" :to="'/contact/'+$route.params.contact">
            <i class="fa fa-chevron-left"></i>
          </router-link>
          Edit Contact
        </div>
        <div class="card-body">
          <contact-form v-if="contact" ref="form" :data="contact" @submit="storeContact" :busy="busy"></contact-form>
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
      busy: false,
      contact: null
    }
  },
  async mounted() {
    const {data} = await axios.get('/api/contacts/'+this.$route.params.contact)
    this.contact = data;
  },
  methods: {
    async storeContact(data) {
      this.busy = true
      try {
        await axios.post('/api/contacts/'+this.$route.params.contact, data)
        this.$router.push('/contact/'+this.$route.params.contact)
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
