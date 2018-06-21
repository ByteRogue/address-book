<template>
  <div class="mb-2 avatar">
    <div class="border-top border-left border-right">
      <img :src="src" width="198" height="200" alt="...">
    </div>
    <label class="btn border-0 rounded-0 btn-primary form-control">
      Browse <input type="file" accept="image/*" hidden @change="onChange">
    </label>
  </div>
</template>

<script>
export default {
  props: ['initialSrc'],
  data() {
    return {
      src: this.initialSrc ? this.initialSrc : '/images/user.png'
    }
  },
  methods: {
    onChange(e) {
      if (! e.target.files.length)
        return
      let file = e.target.files[0]
      let reader = new FileReader()
      reader.readAsDataURL(file);

      reader.onload = e => {
        this.src = e.target.result
        this.$emit('loaded', file)
      }

    },
  }
}
</script>
