<template>
  <div>
    <div class="form-group">
      <label for="id">{{label}}</label>
      <select class="form-control" @change="addOption" :id="id">
        <option value="">{{placeholder}}</option>
        <option v-for="(option, i) in options" v-if="optionNotSelected(option)" :key="option.value" :value="option.value">{{option.text}}</option>
      </select>
    </div>
    <div>
      <a href="" @click.prevent="unSelect(option)" v-for="option in choosenItems" class="badge badge-pill badge-info mr-1">{{option.text}} <i class="fa fa-remove"></i></a> 
    </div>
  </div>
</template>

<script>
export default {
  props: ['label', 'options', 'value'],
  data() {
    return {
    }
  },
  computed: {
    placeholder() {
      if (this.value.length) {
        return 'Add another...'
      }
      return 'Please Select'
    },
    id() {
      return _.uniqueId('select_')
    },
    choosenItems() {
      return this.options.filter((item) => this.value.includes(item.value))
    },
  },
  methods: {
    addOption(event) {
      let value = event.target.value
      let item = this.options.find((item) => item.value == value)
      let selected = _.clone(this.value)
      selected.push(item.value)

      this.$emit('input', selected)
      event.target.value = ''
    },
    unSelect(option) {
      let selected = this.value.filter((item) => item != option.value)
      this.$emit('input', selected)
    },
    optionNotSelected(option) {
      return !this.value.includes(option.value)
    }
  }
}
</script>
