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
      error: ''
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
      if (filter === 'all') this.filteredJobs = this.jobs
      else if (filter === 'full-time') this.filteredJobs = this.jobs.filter(job => job.type === 'full-time')
      else if (filter === 'part-time') this.filteredJobs = this.jobs.filter(job => job.type === 'part-time')
      else if (filter === 'one-time') this.filteredJobs = this.jobs.filter(job => job.type === 'one-time')
    }
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
    <div class="row p-5 m-1">
      <div class="col-12 col-xl-2 col-lg-4 col-md-6 col-sm-6" v-for="job in filteredJobs">
          <JobCard :job="job"/>
      </div>
    </div>

  </section>
</template>

<style scoped>

</style>