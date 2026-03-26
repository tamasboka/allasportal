<script>
import {getAllJobs} from "@/data/data.js";
import JobCard from "@/components/JobCard.vue";
import JobTypeNavbar from "@/components/JobTypeNavbar.vue";

export default {
  name: "JobsView",
  components: {JobTypeNavbar, JobCard},
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
      else if (filter === 'fulltime') this.filteredJobs = this.jobs.filter(job => job.type === 'fulltime')
      else if (filter === 'parttime') this.filteredJobs = this.jobs.filter(job => job.type === 'parttime')
      else if (filter === 'onetime') this.filteredJobs = this.jobs.filter(job => job.type === 'onetime')
    }
  },
  mounted() {
    this.LoadAllJobs();
  }
}
</script>

<template>
  <section>
    <JobTypeNavbar @newFilter="filterJobs"/>
    <div class="row">
      <div class="col-12 col-xl-2 col-lg-4 col-md-6 col-sm-6" v-for="job in filteredJobs">
          <JobCard :job="job"/>
      </div>
    </div>

  </section>
</template>

<style scoped>

</style>