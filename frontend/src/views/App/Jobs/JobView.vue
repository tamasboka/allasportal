<script>
import {getJobById} from "@/data/data.js";
import Spinner from "@/components/Spinner.vue";
import {http} from "@/utils/http.js";

export default {
  name: "JobView",
  components: {Spinner},
  data() {
    return {
      job: this.$route.meta.prefetched,
      user: {},
      userLoading: false
    }
  },
  computed: {
    Translate() {
      if (this.job.type === "full-time") {
        return "Teljes munka"
      } else if (this.job.type === "part-time") {
        return "Részmunka"
      } else if (this.job.type === "one-time") {
        return "Egyszeri munka"
      }
    },
    isOwner() {
      if (!this.user || !this.job || !this.job.advertiser) return false;
      return this.user.id === this.job.advertiser.id;
    },
  },
  methods: {
    async SaveJob() {
      try {
        await http.post('/api/savejob', {
          job_id: this.job.id,
        }, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`
          }
        })
      } catch (e) {
        console.log(e.message)
      }
    },
    async getUserData() {
      this.userLoading = true
      if (!localStorage.getItem('token')) {
        this.userLoading = false
        return
      }
      const res = await http.get('/api/me', {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('token')}`
        }
      })
      this.userLoading = false
      this.user = res.data.data
    },
  },
  mounted() {
    this.getUserData()
  }
}
</script>

<template>
  <section class="container py-5">
    <div v-if="!userLoading" class="row g-4">
      <div class="col-12 col-lg-8 col-md-12 col-sm-12">
        <div class="card bg-dark text-white border-secondary p-4 shadow">
          <div class="d-flex justify-content-between align-items-start mb-3">
            <div>
              <h1 class="display-5 fw-bold mb-1">{{ job.name }}</h1>
              <RouterLink v-if="job.advertiser"
                          class="text-info text-decoration-none fw-semibold"
                          :to="{name: 'user-home', params: {userID: job.advertiser.id}}">
                <i class="bi bi-person"></i> {{ job.advertiser.firstname }} {{ job.advertiser.lastname }}
              </RouterLink>
            </div>
            <span class="badge bg-primary fs-6">{{ Translate }}</span>
          </div>
          <div class="mb-4">
            <span class="h4 text-success fw-bold">{{ job.min_salary }} - {{ job.max_salary }} Ft</span>
          </div>
          <hr class="border-secondary">
          <div class="mb-4">
            <h5 class="text-secondary text-uppercase small fw-bold">Kategóriák</h5>
            <div class="d-flex flex-wrap gap-2">
              <span v-for="cat in job.categories" :key="cat.id" class="badge rounded-pill bg-warning text-dark px-3">
                {{ cat.name }}
              </span>
            </div>
          </div>
          <div class="mb-4">
            <h5 class="text-secondary text-uppercase small fw-bold">Szükséges készségek</h5>
            <div class="d-flex flex-wrap gap-2">
              <span v-for="skill in job.skills" :key="skill.id"
                    class="badge rounded-pill border border-warning text-warning px-3">
                {{ skill.name }}
              </span>
            </div>
          </div>
          <div class="mb-5">
            <h5 class="text-secondary text-uppercase small fw-bold">Leírás</h5>
            <p class="lh-lg">{{ job.description }}</p>
          </div>
          <div class="d-grid d-md-flex gap-3 mt-auto">
            <button class="btn btn-primary btn-lg px-5 fw-bold">Jelentkezés</button>
            <button class="btn btn-outline-secondary btn-lg px-5" @click="SaveJob">
              <i class="bi bi-bookmark"></i> Mentés
            </button>
            <RouterLink :to="{name: 'edit-job', params: {jobID: job.id}}" v-if="isOwner" class="btn btn-outline-warning btn-lg px-5 fw-bold">Szerkesztés</RouterLink>
          </div>
        </div>
      </div>
      <aside class="col-12 col-lg-4 col-md-12 col-sm-12">
        <div class="card bg-dark text-white border-secondary p-4 shadow h-100">
          <div class="d-flex border-bottom border-secondary">
            <h3 class="h5">Vélemények</h3>
            <button class="btn btn-primary ms-auto" :disabled="isOwner">Vélemény írása</button>
          </div>

          <div class="text-center py-5">
            <h1 class="italic" v-if="!job.ratings.length">Még nincsenek vélemények!</h1>
          </div>
        </div>
      </aside>
    </div>
    <div v-else class="d-flex justify-content-center py-5">
      <spinner/>
    </div>
  </section>
</template>

<style scoped>

</style>