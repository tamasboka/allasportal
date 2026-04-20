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
    <div class="border border-5 border-secondary rounded-5 p-5">
      <h1 class="border-bottom border-5 border-secondary">{{ user.firstname }} {{ user.lastname }}</h1>
      <div class="border-bottom border-5 border-secondary my-4">
        <h2 class="text-center fw-bold h4 text-white">Elérhetőségek</h2>
        <p class="text-white text-center" v-if="user?.phone"><i class="bi bi-telephone mx-2"></i>{{ user.phone }}</p>
        <p class="text-white text-center"><i class="bi bi-envelope mx-2"></i>{{ user.email }}</p>
      </div>
      <div class="my-4">
        <h2 class="text-center fw-bold h4 text-white">{{ user.firstname }}-ról/ről</h2>
        <p v-if="!user.bio">Nincs leírás</p>
        <p v-else>{{ user.bio }}</p>
      </div>
      <div class="border-top border-secondary border-5 my-4"></div>
      <h2 class="text-center fw-bold h4 text-white">Készségek</h2>
      <p class="alert alert-warning text-center">Még nincsenek megadva készségek!</p>
      <div class="d-flex flex-wrap gap-2">
              <span v-for="skill in user.skills" :key="skill.id" class="badge rounded-pill bg-warning text-dark px-3">
                {{ skill.name }}
              </span>
      </div>
    </div>
  </section>
</template>

<style scoped>

</style>