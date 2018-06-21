<template>
  <div class="row justify-content-center">
    <div class="col-lg-6 col-md-12 col-sm-12">
      <contact-list></contact-list>
    </div>
    <div class="col-lg-6 col-md-12 col-sm-12">
      <agency-list></agency-list>
    </div>
  </div>
</template>

<script>
import ContactList from '../components/ContactList'
import AgencyList from '../components/AgencyList'

export default {
  components: {ContactList, AgencyList},
}

</script>
