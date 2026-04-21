<script>
import {getAllJobs} from "@/data/data.js";
import JobCard from "@/components/JobCard.vue";
import JobTypeNavbar from "@/components/JobTypeNavbar.vue";
import Spinner from "@/components/Spinner.vue";

export default {
  name: "JobsView",
  components: {Spinner, JobTypeNavbar, JobCard},
  data() {
    return {
      jobs: [],
      filteredJobs: [],
      loading: false,
      error: '',
      filtered: false
    }
  },
  methods: {
    async LoadAllJobs() {
      this.loading = true;
      try {
        const result = await getAllJobs();
        this.jobs = result.data.data;
        this.filteredJobs = this.jobs
      } catch (error) {
        this.error = error.message
      } finally {
        this.loading = false
      }
    },
    filterJobs(filter) {
      if (filter === 'all') {
        this.filtered = false
        this.filteredJobs = this.jobs
      } else if (filter === 'full-time') {
        this.filtered = true
        this.filteredJobs = this.jobs.filter(job => job.type === 'full-time')
      } else if (filter === 'part-time') {
        this.filtered = true
        this.filteredJobs = this.jobs.filter(job => job.type === 'part-time')
      } else if (filter === 'one-time') {
        this.filtered = true
        this.filteredJobs = this.jobs.filter(job => job.type === 'one-time')
      }
    },

  },
  mounted() {
    this.LoadAllJobs();
  }
}
</script>

<template>
  <section v-if="loading">
    <Spinner/>
  </section>
  <section v-else>
    <JobTypeNavbar @newFilter="filterJobs"/>
    <div v-if="!jobs.length" class="min-vh-100 d-flex justify-content-center align-items-center">
      <div class="border-5 border-light rounded-3">
        <h1>Még senki nem rakott fel ajánlást!</h1>
        <RouterLink class="h4 text-success" :to="{name: 'create-job'}">Legyél az első!</RouterLink>
      </div>
    </div>
    <div v-else-if="filtered && !filteredJobs.length">
      <div class="min-vh-100 d-flex justify-content-center align-items-center">
        <div class="border-5 border-light rounded-3">
          <h1>Még senki nem rakott fel ilyen típusú ajánlást!</h1>
          <RouterLink class="h4 text-primary" :to="{name: 'create-job'}">Legyél az első!</RouterLink>
        </div>
      </div>
    </div>
    <div class="container" v-if="jobs.length !== 0">
      <div class="row p-5">
        <div class="col-12 col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-5" v-for="job in filteredJobs">
          <JobCard :job="job"/>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>

</style>
