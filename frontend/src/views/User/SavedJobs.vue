<script>
import JobCard from "@/components/JobCard.vue";

export default {
  name: "SavedJobs",
  components: {JobCard},
  data() {
    return {
      jobs: this.$route.meta.prefetched.jobs
    }
  }
}
</script>

<template>
<section class="min-vh-100 d-flex justify-content-center py-5">
  <div class="row">
    <div class="col-12">
      <RouterLink :to="{name: 'home'}" class="btn btn-outline-primary mb-5">Vissza</RouterLink>
      <h1 class="border-bottom border-danger" v-if="!jobs.length">Nincsenek mentett állásaid!</h1>
      <JobCard v-for="job in jobs" :job="job" class="mb-5" v-else/>
    </div>
  </div>
</section>
</template>

<style scoped>

</style>