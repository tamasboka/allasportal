<script>
export default {
  name: "Review",
  props: {
    rating: {
      type: Object,
      required: true
    }
  }
}
</script>

<template>
<p>{{ rating.title }}</p>
<p>{{ rating.rating }}</p>
<p>{{ rating.message }}</p>
</template>

<style scoped>

</style>