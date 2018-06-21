<template>
  <div class="row justify-content-center">
    <div class="col-xl-5 col-lg-5 col-md-12">
      <div class="card">

        <div class="card-body bg-dark text-white">
          <h4 class="card-title text-center">Login</h4>
          <form @submit.prevent="login" @keydown="error=null">

            <div class="form-group row">
              <label for="email" class="col-sm-4 col-form-label text-md-right">Email</label>

              <div class="col-md-6">
                <input id="email" type="email" class="form-control" :class="hasError" v-model="email" name="email" required autofocus>

                <span class="invalid-feedback" role="alert">
                  <strong>{{error}}</strong>
                </span>
              </div>
            </div>

            <div class="form-group row">
              <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

              <div class="col-md-6">
                <input id="password" type="password" class="form-control" v-model="password" name="password" required>
              </div>
            </div>


            <div class="form-group row mb-0">
              <div class="col-md-8 offset-md-4">
                <submit-button class="btn-outline-primary" :loading="busy">Login</submit-button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>


<script>

export default {
  data() {
    return {
      email: '',
      password: '',
      busy: false,
      error: null
    }
  },
  computed: {
    hasError() {
      return this.error ? 'is-invalid' : ''
    }
  },
  methods: {

    async login() {
      this.busy = true
      try {
        const {data} = await axios.post('/api/auth/login', {
          email: this.email,
          password: this.password
        })
        this.$store.dispatch('auth/saveToken', data)
        await this.$store.dispatch('auth/fetchUser')
        if (this.$store.getters['auth/user'].role == 'admin')
          this.$router.push('/dashboard')
        else
          this.$router.push('/contact/'+this.$store.getters['auth/user'].contact.id)
      } catch (e) {
        this.handleException(e)
      }
      this.busy = false
    },
    handleException(e) {
      console.log(e)
      const {status, data} = e.response
      this.error = data.error
    },
  }
}
</script>
