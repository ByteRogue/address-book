<template>
  <form @submit.prevent="submit">
    <div class="row">
      <div class="col-md">

        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" class="form-control" :class="{'is-invalid': errors.has('email')}" id="email" name="email" v-validate="'required|email'" v-model="contact.email" placeholder="Enter email">
          <span class="invalid-feedback" role="alert">
            <strong>{{errors.first('email')}}</strong>
          </span>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" class="form-control" :class="{'is-invalid': errors.has('password')}" id="password" name="password" v-validate="'required'" v-model="contact.password" placeholder="Password">
          <span class="invalid-feedback" role="alert">
            <strong>{{errors.first('password')}}</strong>
          </span>
        </div>
        <div class="form-group">
          <label for="first_name">First Name</label>
          <input type="text" class="form-control" :class="{'is-invalid': errors.has('first_name')}" id="first_name" name="first_name" v-validate="'required'" v-model="contact.first_name" placeholder="Enter first name">
          <span class="invalid-feedback" role="alert">
            <strong>{{errors.first('first_name')}}</strong>
          </span>
        </div>
        <div class="form-group">
          <label for="last_name">Last Name</label>
          <input type="text" class="form-control" :class="{'is-invalid': errors.has('last_name')}" id="last_name" name="last_name" v-validate="'required'" v-model="contact.last_name" placeholder="Enter last name">
          <span class="invalid-feedback" role="alert">
            <strong>{{errors.first('last_name')}}</strong>
          </span>
        </div>
        <div class="form-group">
          <label for="web">Web</label>
          <input type="text" class="form-control" :class="{'is-invalid': errors.has('web')}" id="web" name="web" v-validate="'url'" v-model="contact.web" placeholder="Enter web">
          <span class="invalid-feedback" role="alert">
            <strong>{{errors.first('web')}}</strong>
          </span>
        </div>
      </div>
      <div class="col-md">
       <div class="row">
        <div class="col">
          <div class="form-group">
            <label for="agency">Agency</label>
            <select class="form-control" :class="{'is-invalid' : errors.has('agency_id')}" v-validate="'required'" id="agency" name="agency_id"  v-model="contact.agency_id">
              <option :value="null">Please Select</option>
              <option v-for="agency in agencies" :key="agency.id" :value="agency.id">{{agency.name}}</option>
            </select>
            <span class="invalid-feedback" role="alert">
              <strong>{{errors.first('agency_id')}}</strong>
            </span>
          </div>
          <multi-select label="Professions" v-model="contact.professions" :options="professions"></multi-select>
        </div>
        <div class="col">
          <div class="clearfix">
            <avatar class="pull-right" :initialSrc="avatarPath" @loaded="file=$event"></avatar>
          </div>
        </div>
       </div>
        <phones :phones="contact.phones" @add="addPhone" @remove="removePhone"></phones>   
      </div>
    </div>
    <submit-button :loading="busy">Save</submit-button>
  </form>
</template>

<script>

import Phones from './Phones'
import Avatar from './Avatar'
import MultiSelect from './MultiSelect'

export default {
  components: {Phones, Avatar, MultiSelect},
  props: ['busy' , 'data'],
  data() {
    return {
      file: null,
      contact : {
        first_name : this.data ? this.data.user.first_name : null,
        last_name : this.data ? this.data.user.last_name : null,
        password: null,
        web : this.data ? this.data.web : null,
        email : this.data ? this.data.user.email : null,
        agency_id : this.data ? this.data.agency_id : null,
        phones: this.data ? this.data.phones.map((item) => item.number) : [],
        professions: this.data ? this.data.professions.map((item) => item.id) : [],
      },
      avatarPath: this.data ? this.data.avatarPath : null,
      agencies: [],
      professions: []
    }
  },

  mounted() {
    axios.get('/api/professions').then(({data}) => {
      this.professions = data.map(({id, name}) => {
        return {value: id, text: name}
      })
    })

    axios.get('/api/agencies').then(({data}) => {
      this.agencies = data
    })

  },
  methods: {
    removePhone(i) {
      this.contact.phones.splice(i, 1)
    },
    addPhone(phone) {
      this.contact.phones.push(phone)
    },
    validateRequestErrors(e) {
      let errors = []
      for (let key in e.response.data.errors) {
        errors.push({field : key, msg : e.response.data.errors[key][0]})
      }
      this.errors.add(errors)
    },
    submit() {

      this.$validator.validate().then(result => {
        if (result) {
          let data = new FormData();
          if (this.file)
            data.append('avatar', this.file)
          data.append('contact', JSON.stringify(this.contact))
          this.$emit('submit', data)
        }
      })
    }
  }
}
</script>
