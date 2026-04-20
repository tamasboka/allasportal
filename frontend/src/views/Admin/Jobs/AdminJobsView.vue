<script>
import {getAllJobs} from "@/data/data.js";
import {http} from "@/utils/http.js";
import Spinner from "@/components/Spinner.vue";

export default {
  name: "JobsView",
  components: {Spinner},
  data() {
    return {
      loading: false,
      jobs: [],
      error:''
    }
  },
  methods: {
    async GetAllJobs() {
      this.loading = true;
      try {
        const result = await getAllJobs();
        this.jobs = result.data.data;
      } catch (error) {
        this.error = error.message
      } finally {
        this.loading = false
      }
    },
    async DeleteJob(id) {
      try {
        await http.delete(`/api/jobs/${id}`, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`
          }
        });
      }catch (e){
        console.log(e.message)
      }
      await this.GetAllJobs();
    }
  },
  mounted() {
    this.GetAllJobs();
  }
}
</script>

<template>
  <section v-if="loading" class="min-vh-100 d-flex justify-content-center align-items-center">
    <spinner/>
  </section>
  <section v-else-if="!loading" class="d-flex justify-content-center">
    <table class="table table-striped table-dark">
      <thead>
      <tr>
        <th>Név</th>
        <th>Típus</th>
        <th>Feltöltő</th>
        <th>Részletek</th>
        <th>Törlés</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="job in jobs">
        <td>{{ job.name }}</td>
        <td>{{ job.job_type }}</td>
        <td>{{ job.advertiser.firstname }} {{ job.advertiser.lastname }}</td>
        <td>
          <RouterLink :to="{name:'admin-job',params:{jobID: job.id}}"><i class="bi bi-info-circle-fill"></i>
          </RouterLink>
        </td>
        <td><button class="btn btn-danger" @click="DeleteJob(job.id)"><i class="bi bi-trash3-fill"></i></button></td>
      </tr>
      </tbody>
    </table>
  </section>
</template>

<style scoped>

</style>