<template>
  <button class="btn btn-primary" type="submit" :disabled="loading || !enabled">
    <i v-if="loading" class="fa fa-spinner fa-pulse"></i>
    <slot></slot>
  </button>
</template>

<script>

export default {
  props : {
    loading : {
      type : Boolean,
      default : false,
    },
    enabled: {
      type: Boolean,
      default: true
    }
  }
}

</script>

