<script>
import {getAllJobs} from "@/data/data.js";
import JobCard from "@/components/JobCard.vue";

export default {
  name: "Allasok",
  components: {JobCard},
  data() {
    return {
      jobs: [],
      loading: false,
      error: ''
    }
  },
  methods: {
    async LoadAllJobs() {
      this.loading = true;
      try {
        const result = await getAllJobs();
        this.jobs = result.data;
      } catch (error) {
        this.error = error.message
      } finally {
        this.loading = false
      }
    }
  },
  mounted() {
    this.LoadAllJobs();
  }
}
</script>

<template>
  <section>
    <div class="row">
      <div class="col-12 col-xl-2 col-lg-4 col-md-6 col-sm-6" v-for="job in jobs">
          <JobCard :job="job"/>
      </div>
    </div>

  </section>
</template>

<style scoped>

</style>