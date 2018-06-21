<template>
  <div class="row justify-content-center">
    <div class="col-md-9">
      <div class="card">
        <div class="card-header">
          <router-link class="mr-3" to="/dashboard">
            <i class="fa fa-chevron-left"></i>
          </router-link>
          Create Agency
        </div>
        <div class="card-body">
          <agency-form ref="form" @submit="store" :busy="busy"></agency-form>
        </div>
      </div>
    </div>
  </div>
</template>


<script>

import AgencyForm from '../../components/AgencyForm'

export default {
  components: {AgencyForm},
  data() {
    return {
      busy: false
    }
  },
  methods: {
    async store(data) {
      this.busy = true
      try {
        await axios.post('/api/agencies', data)
        this.$router.push('/dashboard')
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
