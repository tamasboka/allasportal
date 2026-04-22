<script>
import Spinner from "@/components/Spinner.vue";
import {http} from "@/utils/http.js";
import JobApplicationForm from "@/components/JobApplicationForm.vue";
import ReviewForm from "@/components/ReviewForm.vue";
import Review from "@/components/Review.vue";

export default {
  name: "JobView",
  components: {Review, ReviewForm, JobApplicationForm, Spinner},
  data() {
    return {
      job: this.$route.meta.prefetched,
      user: {},
      userLoading: false,
      isWritingApplication: false,
      isApplicationSuccessful: false,
      isWritingReview: false,
      isReviewSuccessful: false
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
    isLoggedIn() {
      return !!localStorage.getItem('token')
    },
    isOwner() {
      if (!this.user || !this.job || !this.job.advertiser) return false;
      return this.user.id === this.job.advertiser.id;
    },
    isJobSaved() {
      if (!this.isLoggedIn || !this.user?.saved_jobs) return false;
      return this.user.saved_jobs.some(j => j.id === this.job.id);
    },
  },
  methods: {
    async toggleSave() {
      if (!this.isLoggedIn) {
        return this.$router.push({name: 'login'});
      }

      const token = localStorage.getItem('token');
      const config = {headers: {Authorization: `Bearer ${token}`}};

      try {
        if (!this.isJobSaved) {
          await http.post('/api/savejob', {job_id: this.job.id}, config);
          this.user.saved_jobs.push({id: this.job.id});
        } else {
          await http.delete(`/api/unsavejob/${this.job.id}`, config);
          this.user.saved_jobs = this.user.saved_jobs.filter(j => j.id !== this.job.id);
        }
      } catch (e) {
        console.error("Hiba a mentés során:", e.message);
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
    async sendReview(data) {
      console.log(
          {
            job_id: this.job.id,
            ...data
          }
      )
      try {
        await http.post('/api/ratings', {
          job_id: this.job.id,
          ...data
        }, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`
          }
        })
        this.isWritingReview = false
        this.job.ratings.push({
          rater: this.user,
          ...data
        })
      } catch (e) {
        this.isReviewSuccessful = false
      }
    },
    handleSuccess() {
      this.isWritingApplication = false
      this.isApplicationSuccessful = true
    },
    toggleWritingApplication() {
      if (!localStorage.getItem('token')) {
        this.$router.push({name: 'login'})
      }
      this.isWritingApplication = !this.isWritingApplication
      this.isApplicationSuccessful = false
    },
    toggleWritingReview() {
      if (!localStorage.getItem('token')) {
        this.$router.push({name: 'login'})
      }
      this.isWritingReview = !this.isWritingReview
      this.isReviewSuccessful = false
    }
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
        <div class="card bg-dark text-white p-4 border-block"
             :class="{'border-secondary': job.type === 'part-time', 'border-primary': job.type === 'full-time', 'border-warning': job.type === 'one-time'}">
          <div class="d-flex justify-content-between align-items-start mb-3">
            <div>
              <h1 class="display-5 fw-bold mb-1">{{ job.name }}</h1>
              <RouterLink v-if="job.advertiser"
                          class="text-info text-decoration-none fw-semibold"
                          :to="{name: 'user-home', params: {userID: job.advertiser.id}}">
                <i class="bi bi-person"></i> {{ job.advertiser.firstname }} {{ job.advertiser.lastname }}
              </RouterLink>
            </div>
            <span class="badge fs-6"
                  :class="{'bg-secondary': job.type === 'part-time', 'bg-primary': job.type === 'full-time', 'bg-warning': job.type === 'one-time'}">{{
                Translate
              }}</span>
          </div>
          <div class="mb-4">
            <span class="h4 text-success fw-bold">{{ job.min_salary }} - {{ job.max_salary }} {{ job.currency }}</span>
            <p class="text-secondary h4 fw-bold">Férőhely: {{ job.workers.length }}/{{ job.capacity }}</p>
          </div>
          <div class="underline-gray mb-3"></div>
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
          <div>
            <div v-if="!isOwner" class="gap-3 d-grid d-md-flex mt-auto">
              <button class="btn btn-primary btn-lg px-5 fw-bold"
                      :disabled="job.capacity===job.workers.length || !isLoggedIn" @click="toggleWritingApplication">
                Jelentkezés
              </button>
              <button class="btn btn-lg px-5" :class="isJobSaved ? 'btn-success' : 'btn-secondary'" @click="toggleSave" :disabled="!isLoggedIn">
                <i class="bi" :class="isJobSaved ? 'bi-bookmark-fill' : 'bi bi-bookmark'"></i>
                {{ isJobSaved ? 'Mentve' : 'Mentés' }}
              </button>
            </div>
            <RouterLink :to="{name: 'edit-job', params: {jobID: job.id}}" v-if="isOwner"
                        class="btn btn-outline-warning btn-lg px-5 fw-bold">Szerkesztés
            </RouterLink>
          </div>
          <div v-if="isWritingApplication" class="mt-3">
            <JobApplicationForm @success="handleSuccess" :userID="user.id" :jobID="job.id"/>
          </div>
          <div v-if="isApplicationSuccessful">
            <p class="alert bg-success text-white text-center mt-3">Sikeres jelentkezés!</p>
          </div>
        </div>
      </div>
      <aside class="col-12 col-lg-4 col-md-12 col-sm-12">
        <div class="card bg-dark text-white p-4 h-100 border-block">
          <div class="d-flex">
            <h3 class="h5">Vélemények</h3>
            <button class="btn btn-primary ms-auto btn-sm" v-if="!isOwner" @click="toggleWritingReview">Vélemény írása
            </button>
          </div>
          <div class="underline-gray mt-4"></div>
          <div class="text-center py-3">
            <ReviewForm v-if="isWritingReview" @sent="sendReview"/>
            <h1 class="italic" v-if="!job.ratings.length && !isWritingReview">Még nincsenek vélemények!</h1>
          </div>
          <Review v-for="rating in job.ratings" :rating="rating"/>
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