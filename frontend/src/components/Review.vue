<script>
export default {
  name: "Review",
  props: {
    rating: {
      type: Object,
      required: true
    }
  },
}
</script>

<template>
  <div class="rounded-5 p-3 border border-3 border-secondary mb-3" >
    <h3>{{rating.rater.firstname}} {{rating.rater.lastname}}</h3>
    <p>{{ rating.title }}</p>
    <div class="d-flex">
      <i v-for="i in rating.stars" class="bi bi-star-fill text-warning"></i>
    </div>
    <p>{{ rating.message }}</p>
  </div>

</template>

<style scoped>

</style>