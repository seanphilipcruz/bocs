<template>
  <div>

  </div>
</template>

<script>
export default {
  name: "Navigation",
  data: () => ({
    drawer: false,
    group: null
  }),
  watch: {
    group() {
      this.drawer = false
    }
  }
}
</script>

<style scoped>

</style>