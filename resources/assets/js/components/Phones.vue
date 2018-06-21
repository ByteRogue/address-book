<template>
  <div>
    <div class="form-group">
      <label>Phones</label>
      <div class="input-group" :class="{'is-invalid' : errors.has('phone')}">
        <input type="text" class="form-control" :class="{'is-invalid' : errors.has('phone')}" name="phone" v-model="phone" v-validate="'required|phoneNumber'" placeholder="Enter phone">
        <div class="input-group-append">
          <button class="btn btn-success" @click="addPhone" :disabled="errors.has('phone')" type="button">Add</button>
        </div>
      </div>

      <span class="invalid-feedback" role="alert">
        <strong>Invalid Phone number</strong>
      </span>

    </div>
    <ul class="list-group mb-3">
      <li v-for="(phone, i) in phones" :key="uniqueId()" class="list-group-item d-flex justify-content-between align-items-center">
        {{phone}}
        <i class="fa fa-remove text-danger" @click="$emit('remove', i)"></i>
      </li>
    </ul>
  </div>
</template>

<script>

export default {
  props: ['phones'],
  data() {
    return {
      phone: null
    }
  },
  methods: {
    uniqueId() {
      return _.uniqueId('phone_')
    },
    addPhone() {
      this.$validator.validate().then(result => {
        if (result) {
          this.$emit('add', this.phone)
          this.phone = null
          this.$validator.reset()
        }


      })
    }
  }
}
</script>
