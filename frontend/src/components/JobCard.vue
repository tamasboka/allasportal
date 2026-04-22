<script>

export default {
  name: "JobCard",
  props: {
    job: {
      type: Object,
      required: true
    }
  },
  computed: {
    Translate() {
      if (this.job.type === "full-time") {
        return "Teljes munka"
      } else if (this.job.type === "part-time") {
        return "Részmunka"
      } else if (this.job.type === "one-time") {
        return "Egyszeri munka"
      }
    }
  }
}
</script>

<template>
  <section class="py-2">
    <div class="card" :class="job.type">
      <div class="card-body d-flex flex-column p-4">
        <div class="mb-2">
          <h2 class="h4 fw-bold mb-1 text-dark">{{ job.name }}</h2>
          <p class="text-muted fw-bold text-uppercase">{{ Translate }}</p>
          <p class="text-muted fw-bold text-uppercase">Férőhely: {{job.workers.length}}/{{job.capacity}}</p>
        </div>
        <p v-if="job?.advertiser" class="card-text text-secondary mb-4">
          <i class="bi bi-person-fill"></i> {{ job?.advertiser.firstname }} {{ job?.advertiser.lastname }}
        </p>
        <RouterLink
            :to="{name: 'job', params: {jobID: job.id}}"
            class="btn btn-dark px-4 fw-bold">
          Részletek
        </RouterLink>
      </div>
    </div>
  </section>
</template>

<style scoped>
.card {
  transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
  background-color: #fff;
}

.card:hover {
  transform: translate(-10px, -10px);
  box-shadow: 8px 8px black;
}

.full-time {
  border-left: 10px solid var(--bs-primary) !important;
}

.part-time {
  border-left: 10px solid var(--bs-secondary) !important;
}

.one-time {
  border-left: 10px solid #ffff47 !important;
}
</style>