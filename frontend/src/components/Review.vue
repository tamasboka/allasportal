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
  <div class="rounded-5 p-3 border border-3 border-secondary mb-3">
    <h3>
      <RouterLink :to="{name: 'user-home', params: {userID: rating.rater.id}}" class="text-decoration-none text-white">
        <i class="bi bi-person"></i>{{ rating.rater.firstname }} {{ rating.rater.lastname }}
      </RouterLink>
    </h3>
    <div class="d-flex">
      <i v-for="i in 5" class="bi bi-star-fill" :class="{'text-warning': i <= rating.stars, 'text-secondary': i > rating.stars}"></i>
    </div>
    <div>
      <h4 class="fw-bold">{{ rating.title }}</h4>
      <p>{{ rating.message }}</p>
    </div>
  </div>
</template>

<style scoped>

</style>