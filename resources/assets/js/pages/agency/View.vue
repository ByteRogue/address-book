<template>
  <div class="row justify-content-center">
    <div class="col-md-9">
      <div v-if="agency" class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <div>
            <router-link class="mr-3" to="/dashboard">
              <i class="fa fa-chevron-left"></i>
            </router-link>
            {{agency.name}}
          </div>
          <router-link class="btn btn-success" :to="{name: 'agency.edit', params: {agency : agency.id}}">Edit</router-link>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col">
              <h5>Basic Info</h5>
              <dl class="row">
                <dt class="col-sm-3">Email</dt>
                <dd class="col-sm-9">{{agency.email}}</dd>
                <dt class="col-sm-3">Country</dt>
                <dd class="col-sm-9">{{agency.city.country.name}}</dd>
                <dt class="col-sm-3">City</dt>
                <dd class="col-sm-9">{{agency.city.name}}</dd>
                <dt class="col-sm-3">Address</dt>
                <dd class="col-sm-9">{{agency.address}}</dd>
                <dt class="col-sm-3">Web</dt>
                <dd class="col-sm-9">{{agency.web}}</dd>
              </dl>
            </div>
            <div class="col">
              <h5>Phones</h5>
              <ul class="list-group">
                <li v-for="phone in agency.phones" class="list-group-item">{{phone.number}}</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  data() {
    return {
      busy: false,
      agency: null
    }
  },
  async mounted() {
    const {data} = await axios.get('/api/agencies/'+this.$route.params.agency)
    this.agency = data;
  },
}

</script>
