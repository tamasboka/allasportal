<script>
import {getJobById} from "@/data/data.js";
import Spinner from "@/components/Spinner.vue";
import {http} from "@/utils/http.js";

export default {
  name: "JobView",
  components: {Spinner},
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
    async SaveJob(){
      try {
        await http.post('/api/savejob',{
          job_id:this.job.id,
        },{
          headers:{
            Authorization:`Bearer ${localStorage.getItem('token')}`
          }
        })
      }catch (e){
        console.log(e.message)
      }
    },

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
    <div v-if="!loading" class="row">
      <div class="col-12 col-lg-8 col-md-6 col-sm-12">
          <h1>{{job.name}}</h1>
        <RouterLink v-if="job.advertiser" class="text-decoration-none text-black badge bg-white" :to="{name: 'user-home', params: {userID: job.advertiser.id}}">{{ job.advertiser.firstname }} {{ job.advertiser.lastname }}</RouterLink>
        <p>{{Translate}}</p>
        <p class="badge bg-success">Fizetés: {{job.min_salary}}Ft - {{job.max_salary}}Ft</p>
        <p>{{job.description}}</p>
        <div class="d-flex">
          <button class="btn btn-primary me-2">Jelentkezés</button>
          <button class="btn btn-secondary ms-2" @click="SaveJob">Mentés</button>
        </div>
      </div>
      <aside class="col-12 col-lg-4 col-md-6 col-sm-12">
        <h1>Vélemények: </h1>
      </aside>
    </div>
    <spinner v-else/>
  </section>
</template>

<style scoped>

</style>