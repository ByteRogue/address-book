<template>

  <div class="row justify-content-center">
    <div class="col-md-9">

      <div class="card">
        <div class="card-header">
          <router-link class="mr-3" :to="'/agency/'+$route.params.agency">
            <i class="fa fa-chevron-left"></i>
          </router-link>
          Edit Agency
        </div>
        <div class="card-body">
          <agency-form v-if="agency" ref="form" :data="agency" @submit="store" :busy="busy"></agency-form>
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
      busy: false,
      agency: null
    }
  },
  async mounted() {
    const {data} = await axios.get('/api/agencies/'+this.$route.params.agency)
    console.log(data)
    this.agency = data;
  },
  methods: {
    async store(data) {
      this.busy = true
      try {
        await axios.patch('/api/agencies/'+this.$route.params.agency, data)
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
