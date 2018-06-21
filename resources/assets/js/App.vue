<template>
  <div class="container-fluid">
    <navbar v-if="authenticated"></navbar>
    <main class="py-4">
      <transition name="fade" mode="out-in">
        <router-view></router-view>
      </transition>
    </main>
  </div>
</template>

<script>
import Navbar from './components/Navbar'

export default {
  components: {Navbar},
  computed: {
    authenticated() {
      return this.$store.getters['auth/check']
    }
  }
}
</script>
