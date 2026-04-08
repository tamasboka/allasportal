<script>
import {getJobById} from "@/data/data.js";

export default {
  name: "JobView",
  data() {
    return {
      job: {},
      loading: false
    }
  },
  computed:{
    Translate(){
      if (this.job.type === "full-time"){
        return "Teljes munka"
      }
      else if(this.job.type === "part-time"){
        return "Részmunka"
      }
      else if(this.job.type === "one-time"){
        return "Egyszeri munka"
      }
    }
  },
  methods: {
    async getJob(id) {
      this.loading = true
      try {
        const result = await getJobById(id)
        this.job = result.data.data
      } catch (e) {
        this.$router.push({
          name: 'not-found'
        })
      } finally {
        this.loading = false
      }
    }
  },
  mounted() {
    this.getJob(this.$route.params.jobID)
  }
}
</script>

<template>
  <section class="p-5">
    <div class="row">
      <div class="col-12 col-lg-8">
        <div class="d-flex">
          <h1>{{job.name}}</h1>
          <RouterLink :to="{name:'user-home', params: {userID: job.id}}"/>
        </div>
        <p>{{Translate}}</p>
        <p class="badge bg-success">Fizetés: {{job.min_salary}}Ft - {{job.max_salary}}Ft</p>
        <p>{{job.description}}</p>
        <div class="d-flex">
          <button class="btn btn-primary me-2">Jelentkezés</button>
          <button class="btn btn-secondary ms-2">Mentés</button>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>

</style>