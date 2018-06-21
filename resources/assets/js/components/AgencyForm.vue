<template>
  <form @submit.prevent="submit">
    <div class="row">
      <div class="col-md">

        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" class="form-control" :class="{'is-invalid': errors.has('email')}" id="email" name="email" v-validate="'required|email'" v-model="agency.email" placeholder="Enter email">
          <span class="invalid-feedback" role="alert">
            <strong>{{errors.first('email')}}</strong>
          </span>
        </div>
        <div class="form-group">
          <label for="first_name">Name</label>
          <input type="text" class="form-control" :class="{'is-invalid': errors.has('name')}" id="name" name="name" v-validate="'required'" v-model="agency.name" placeholder="Enter name">
          <span class="invalid-feedback" role="alert">
            <strong>{{errors.first('name')}}</strong>
          </span>
        </div>
        <div class="form-group">
          <label for="last_name">Address</label>
          <textarea class="form-control" :class="{'is-invalid': errors.has('address')}" id="address" name="address" v-validate="'required'" v-model="agency.address" placeholder="Enter address"></textarea>
          <span class="invalid-feedback" role="alert">
            <strong>{{errors.first('address')}}</strong>
          </span>
        </div>
        <div class="form-group">
          <label for="web">Web</label>
          <input type="text" class="form-control" :class="{'is-invalid': errors.has('web')}" id="web" name="web" v-validate="'url'" v-model="agency.web" placeholder="Enter web">
          <span class="invalid-feedback" role="alert">
            <strong>{{errors.first('web')}}</strong>
          </span>
        </div>
      </div>
      <div class="col-md">
        <div class="form-group">
          <label for="country">Country</label>
          <select type="text" class="form-control" :class="{'is-invalid': errors.has('country')}" @change="clearCity" id="country" name="country" v-validate="'required'" v-model="country_id">
            <option :value="null">Please Select</option>
            <option :value="country.id" :key="country.id" v-for="country in countries">{{country.name}}</option>
          </select>
          <span class="invalid-feedback" role="alert">
            <strong>{{errors.first('country')}}</strong>
          </span>
        </div>
        <div class="form-group">
          <label for="country">City</label>
          <select type="text" class="form-control" :class="{'is-invalid': errors.has('city')}" id="city" name="city" v-validate="'required'" v-model="agency.city_id">
            <option :value="null">Please Select</option>
            <option :value="city.id" :key="city.id" v-for="city in cities">{{city.name}}</option>
          </select>
          <span class="invalid-feedback" role="alert">
            <strong>{{errors.first('city')}}</strong>
          </span>
        </div>
        <phones :phones="agency.phones" @add="addPhone" @remove="removePhone"></phones>   
      </div>
    </div>
    <submit-button :loading="busy">Save</submit-button>
  </form>
</template>

<script>
import Phones from './Phones'
import {mapActions} from 'vuex'

export default {
  components : {Phones},
  props: ['busy' , 'data'],
  data() {
    return {
      agency : {
        name : this.data ? this.data.name : null,
        web : this.data ? this.data.web : null,
        email : this.data ? this.data.email : null,
        city_id : this.data ? this.data.city_id : null,
        address : this.data ? this.data.address : null,
        phones : this.data ? this.data.phones.map((phone) => phone.number) : []
      },
      country_id : this.data ? this.data.city.country_id : null,
      countries : []
    }
  },

  computed: {
    cities() {

      let country = this.countries.find((country) => country.id == this.country_id)
      if (country)
        return country.cities
      return []
    }
  },
  mounted() {
    axios.get('/api/countries').then(({data}) => {
      this.countries = data
    })

  },
  methods: {
    validateRequestErrors(e) {
      let errors = []
      for (let key in e.response.data.errors) {
        errors.push({field : key, msg : e.response.data.errors[key][0]})
      }
      this.errors.add(errors)
    },

    clearCity() {
      this.agency.city_id = null
      this.$nextTick().then(() => {
        this.errors.clear()
      })
    },
    submit() {
      this.$validator.validate().then(result => {
        if (result) {
          this.$emit('submit', this.agency)
        }
      })
    },
    removePhone(i) {
      this.agency.phones.splice(i, 1)
    },
    addPhone(phone) {
      this.agency.phones.push(phone)
    },
  }
}
</script>
