<script>

import Spinner from "@/components/Spinner.vue";
import {getAllRatings} from "@/data/data.js";
import {http} from "@/utils/http.js";

export default {
  name: "AdminRatingsView",
  components: {Spinner},
  data() {
    return {
      loading: false,
      ratings: [],
      error:''
    }
  },
  methods:{
    async GetAllRatings() {
      this.loading = true;
      try {
        const result = await getAllRatings();
        this.ratings = result.data.data;
      } catch (error) {
        this.error = error.message
      } finally {
        this.loading = false
      }
    },
    async DeleteRating(id){
      try{
        await http.delete(`/api/ratings/${id}`,{
          headers:{
            Authorization:`Bearer ${localStorage.getItem('token')}`
          }
        })
      }catch (e){
        console.log(e.message)
      }
      await this.GetAllRatings();
    }
  },
  mounted() {
    this.GetAllRatings();
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
        <th>Azonosító</th>
        <th>Feltöltő</th>
        <th>Állás neve</th>
        <th>Csillag</th>
        <th>Cím</th>
        <th>Üzenet</th>
        <th>Törlés</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="rating in ratings">
        <td>{{rating.id}}</td>
        <td><RouterLink :to="{name: 'user-home',params:{userID:rating.rater.id}}" class="text-decoration-none">{{rating.rater.firstname}} {{rating.rater.lastname}}</RouterLink></td>
        <td><RouterLink :to="{name: 'job',params:{jobID:rating.rated.id}}" class="text-decoration-none">{{rating.rated.name}}</RouterLink></td>
        <td>{{rating.stars}}</td>
        <td>{{rating.title}}</td>
        <td>{{rating.message}}</td>
        <td><button class="btn btn-danger" @click="DeleteRating(rating.id)"><i class="bi bi-trash-fill"></i></button></td>
      </tr>
      </tbody>
    </table>
  </section>
</template>

<style scoped>

</style>