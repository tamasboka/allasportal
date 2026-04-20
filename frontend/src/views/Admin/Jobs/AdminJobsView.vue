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
  <section v-else-if="!loading" class="p-5 mb-0">
    <table class="table table-striped table-dark">
      <thead>
      <tr>
        <th>Név</th>
        <th>Típus</th>
        <th>Feltöltő</th>
        <th>Min. fizetés</th>
        <th>Max fizetés</th>
        <th>Pénznem</th>
        <th>Részletek</th>
        <th>Törlés</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="job in jobs">
        <td>{{ job.name }}</td>
        <td>{{ job.type }}</td>
        <td><RouterLink :to="{name: 'user-home', params: {userID: job.advertiser.id}}" class="text-decoration-none">{{ job.advertiser.firstname }} {{ job.advertiser.lastname }}</RouterLink></td>
        <td>{{ job.min_salary }}</td>
        <td>{{ job.max_salary }}</td>
        <td>{{ job.currency }}</td>
        <td>
          <RouterLink :to="{name:'job',params:{jobID: job.id}}"><i class="bi bi-info-circle-fill"></i>
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