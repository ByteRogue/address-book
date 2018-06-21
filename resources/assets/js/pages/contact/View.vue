<template>
  <div class="row justify-content-center">
    <div class="col-md-9">
      <div v-if="contact" class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <div>
            <router-link v-if="isAdmin()" class="mr-3" to="/dashboard">
              <i class="fa fa-chevron-left"></i>
            </router-link>
            {{contact.user.first_name}} {{contact.user.last_name}}
          </div>
          <router-link class="btn btn-success" :to="{name: 'contact.edit', params: {contact : contact.id}}">Edit</router-link>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col">
              <h5>Basic Info</h5>
              <div class="row">
                <div class="col-lg-5 col-md-12">
                  <img class="img-thumbnail contact-avatar mb-3" :src="contact.avatarPath ? contact.avatarPath : '/images/user.png'" alt="">
                </div>
              </div>
              <dl class="row">
                <dt class="col-sm-3">Email</dt>
                <dd class="col-sm-9">{{contact.user.email}}</dd>
                <dt class="col-sm-3">Agency</dt>
                <dd class="col-sm-9">{{contact.agency.name}}</dd>
                <dt class="col-sm-3">Web</dt>
                <dd class="col-sm-9">{{contact.web}}</dd>
              </dl>
            </div>
            <div class="col">
              <h5>Professions</h5>
              <ul class="list-group mb-3">
                <li v-for="profession in contact.professions" class="list-group-item">{{profession.name}}</li>
              </ul>
              <h5>Phones</h5>
              <ul class="list-group">
                <li v-for="phone in contact.phones" class="list-group-item">{{phone.number}}</li>
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
      contact: null
    }
  },
  async mounted() {
    const {data} = await axios.get('/api/contacts/'+this.$route.params.contact)
    this.contact = data;
  },
}

</script>
