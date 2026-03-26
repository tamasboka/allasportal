<script>
import {getAllJobs} from "@/data/data.js";

export default {
  name: "Searchbar",
  data() {
    return {
      jobs: [],
      filteredJobs: [],
      query: ''
    }
  },
  methods: {
    async LoadAllJobs() {
      this.loading = true;
      try {
        const result = await getAllJobs();
        console.log(result)
        this.jobs = result.data.data;
      } catch (error) {
        this.error = error.message
      } finally {
        this.loading = false
      }
    },
    filterJobs() {
      if (this.query) this.filteredJobs = this.jobs.filter(job => job.name.toLowerCase().includes(this.query.toLowerCase())).slice(0, 4)
      else this.filteredJobs = []
    }
  },
  mounted() {
    this.LoadAllJobs();
  }
}
</script>

<template>
  <input type="text" v-model="query" class="form-control" placeholder="Keress állást..." @input="filterJobs">
  <ul class="list-group" v-if="filteredJobs">
    <li class="list-group-item" v-for="job in filteredJobs">
      <RouterLink :to="{name: 'job', params: {jobID: job.id}}" class="text-decoration-none">{{ job.name }}</RouterLink>
    </li>
  </ul>
</template>

<style scoped>

</style>