<script>
import {getApplications} from "@/data/data.js";
import {http} from "@/utils/http.js";
import JobApplication from "@/components/JobApplication.vue";

export default {
  name: "IncomingApplications",
  components: {JobApplication},
  data() {
    return {
      applications: [],
      loading: false
    }
  },
  props: {
    jobID: {
      type: Number,
      required: true
    }
  },
  methods: {
    async getApplications() {
      this.loading = true
      try {
        const res = await getApplications(this.jobID)
        this.applications = res.data.data.applications
      } catch (e) {
        console.log(e.message)
      } finally {
        this.loading = false
      }
    },
    async acceptApplication(applicationID) {
      try {
        await http.post(`/api/acceptapplication/${applicationID}`, {}, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`
          }
        })
        await this.getApplications()
      } catch (e) {
        console.log(e.message)
      }
    },
    async rejectApplication(applicationID) {
      try {
        await http.post(`/api/rejectapplication/${applicationID}`, {}, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`
          }
        })
        await this.getApplications()
      } catch (e) {
        console.log(e.message)
      }
    }
  },
  mounted() {
    this.getApplications()
  }
}
</script>

<template>
  <div class="container mt-5">
    <h1 class="underline-yellow text-center mb-4 fw-bold">Jelentkezők</h1>
    <h2 v-if="!applications.length" class="text-center">Nincsenek jelentkezők!</h2>
    <div v-else class="px-5">
      <JobApplication v-for="application in applications" @accept="acceptApplication" @reject="rejectApplication" :application="application" class="my-2"/>
    </div>
  </div>
</template>

<style scoped>

</style>