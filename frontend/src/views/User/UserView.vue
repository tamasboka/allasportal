<script>
import JobCard from "@/components/JobCard.vue";
import UserProfileCard from "@/components/UserProfileCard.vue";

export default {
  name: "UserView",
  components: {UserProfileCard, JobCard},
  data(){
    return{
      user:this.$route.meta.prefetched.user.data.data
    }
  }
}
</script>

<template>
  <section class="min-vh-100">
    <div class="container">
      <div class="row">
        <div class="col-12 col-lg-4 col-md-12 col-sm-12 text-center d-flex align-items-center min-vh-100">
          <UserProfileCard :user="user"/>
        </div>
        <div class="col-12 col-lg-8 col-md-12 col-sm-12">
          <JobCard :job="job" v-for="job in user.published_jobs"/>
          <div v-if="!user.published_jobs.length" class="d-flex min-vh-100 align-items-center">
            <p class="alert alert-danger text-center w-100">Még nincs feltöltött munkája</p>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>

</style>