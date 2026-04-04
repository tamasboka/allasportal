<script>

export default {
  name: "JobCard",
  props: {
    job: {
      type: Object,
      required: true
    }
  },
}
</script>

<template>
  <section>
    <div class="card" :class="job.type">
      <div class="card-body">
        <h1 class="card-title text-dark">{{ job.name }}</h1>
        <p class="card-text text-dark">({{job.type}})</p>
        <p class="card-text text-dark">{{ job.advertiser.firstname }} {{ job.advertiser.lastname }}</p>
        <RouterLink :to="{name: 'job', params: {jobID: job.id}}" class="btn btn-outline-dark">Részletek</RouterLink>
      </div>
    </div>
  </section>
</template>

<style scoped>
.full-time{
    border: 10px solid var(--bs-primary);
}
.part-time{
    border: 10px solid var(--bs-secondary);
}
.one-time{
  border: 10px solid #ffff47;
}
</style>