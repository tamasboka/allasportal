<script>
import NewJobForm from "@/components/NewJobForm.vue";
import {Field, Form} from "vee-validate";
import EditJobForm from "@/components/EditJobForm.vue";
import EditWorkersForm from "@/components/EditWorkersForm.vue";
import {http} from "@/utils/http.js";
import Unauthorized from "@/views/Error/Unauthorized.vue";
import ErrorLayout from "@/layouts/ErrorLayout.vue";
import IncomingApplications from "@/components/IncomingApplications.vue";

export default {
  name: "EditJob",
  components: {IncomingApplications, ErrorLayout, Unauthorized, EditWorkersForm, EditJobForm, NewJobForm, Field, Form},
  data() {
    return {
      isReturnBtnHovered: false,
      job: this.$route.meta.prefetched.job.data.data,
      userLoading: false,
      user: {}
    }
  },
  computed: {
    isOwner() {
      if (!this.user || !this.job || !this.job.advertiser) return false;
      return this.user.id === this.job.advertiser.id;
    }
  },
  methods: {
    async getUserData() {
      this.userLoading = true
      if (!localStorage.getItem('token')) return
      const res = await http.get('/api/me', {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('token')}`
        }
      })
      this.userLoading = false
      this.user = res.data.data
    }
  },
  mounted() {
    this.getUserData()
  }
}
</script>

<template>
  <main>
    <section class="min-vh-100 d-flex align-items-center justify-content-center" v-if="userLoading">
      <h1 class="bg-danger">Authenticating</h1>
    </section>
    <section class="min-vh-100 d-flex align-items-center justify-content-center py-5" v-if="isOwner">
      <div class="card text-bg-dark border-block rounded-5 shadow-lg my-5">
        <div class="card-body">
          <RouterLink :to="{name: 'job', params: {jobID: job.id}}" class="text-decoration-none text-light btn"
                      :class="{ 'btn-outline-light': !isReturnBtnHovered, 'btn-outline-primary': isReturnBtnHovered}"
                      @mouseover="isReturnBtnHovered = true" @mouseleave="isReturnBtnHovered = false">
            <i class="bi bi-arrow-left-circle me-2"></i>
            Vissza
          </RouterLink>
          <EditJobForm :job="job" class="mt-3"/>
          <div class="underline-gray mt-5"></div>
          <div class="container mt-5">
            <div class="row">
              <div class="col-12 col-lg-6 col-md-12 col-sm-12">
                <EditWorkersForm :jobID="job.id" :workers="job.workers"/>
              </div>
              <div class="col-12 col-lg-6 col-md-12 col-sm-12">
                <IncomingApplications :jobID="job.id"/>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section v-if="!isOwner" class="min-vh-100 d-flex justify-content-center align-items-center">
      <Unauthorized/>
    </section>
  </main>
</template>

<style scoped>
.card {
  width: 85%
}
</style>