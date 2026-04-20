<script>

import JobCard from "@/components/JobCard.vue";

export default {
  name: "UserProfileCard",
  components: {JobCard},
  props: {
    user: {
      type: Object,
      required: true
    }
  }
}
</script>

<template>
  <section>
    <div class="border border-5 border-secondary rounded-5 p-3">
      <h1 class="border-bottom border-5 border-secondary">{{ user.firstname }} {{ user.lastname }}</h1>
      <div class="border-bottom border-5 border-secondary">
        <p class="text-white text-center"><i class="bi bi-telephone"></i> +{{ user.phone }}</p>
        <p class="text-white text-center"><i class="bi bi-envelope"></i> {{ user.email }}</p>
      </div>
      <div>
        <p v-if="!user.bio">Nincs leírás</p>
        <p v-else>{{ user.bio }}</p>
      </div>
    </div>
  </section>
</template>

<style scoped>

</style>