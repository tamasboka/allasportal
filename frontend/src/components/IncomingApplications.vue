<script>
import {getApplications} from "@/data/data.js";
import {http} from "@/utils/http.js";

export default {
  name: "IncomingApplications",
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
    <h1 class="text-success text-center mb-4 fw-bold">Jelentkezők</h1>
    <h2 v-if="!applications.length" class="text-center">Nincsenek jelentkezők!</h2>
    <div v-else class="px-5">
      <div v-for="application in applications" class="card w-100 border-5 border-secondary rounded-5">
        <div class="card-body p-4">
          <div class="d-flex border-bottom border-5 border-secondary">
            <h2 class="h4">{{ application.sender.firstname }} {{ application.sender.lastname }}</h2>
            <div class="ms-auto">
              <button class="btn btn-success me-1" @click="acceptApplication(application.id)">Elfogadás</button>
              <button class="btn btn-danger ms-1" @click="rejectApplication(application.id)">Elutasítás</button>
            </div>
          </div>
          <div class="mt-3">
            <p class="text-black">{{ application.message }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>