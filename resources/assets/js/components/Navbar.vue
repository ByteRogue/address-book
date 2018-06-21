<template>
  <nav class="navbar fixed-top navbar-dark bg-dark justify-content-between">
    <router-link class="navbar-brand" to="/dashboard">AddressBook</router-link>
    <form class="form-inline" @submit.prevent="logout">
      <button class="btn btn-outline-danger my-2 my-sm-0" type="submit">
        <i class="fa fa-sign-out"></i> Sign Out
      </button>
    </form>
  </nav>
</template>

<script>

export default {

  methods: {
    async logout() {
      await this.$store.dispatch('auth/logout');
      this.$router.push('/login')

    }
  }
}

</script>
