<script>

export default {
  name: "JobCard",
  props: {
    job: {
      type: Object,
      required: true
    }
  }
}
</script>

<template>
  <section>
    <div class="card">
      <div class="card-body">
        <h1 class="card-title text-dark">{{ job.name }}</h1>
        <p class="card-text text-dark">{{ job.advertiser.firstname }} {{ job.advertiser.lastname }}</p>
        <RouterLink :to="{name: 'job', params: {jobID: job.id}}">Részletek</RouterLink>
      </div>
    </div>
  </section>
</template>

<style scoped>

</style>