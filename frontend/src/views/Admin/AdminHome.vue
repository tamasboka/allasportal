<script>import {http} from "@/utils/http.js";

export default {
  name: "AdminHome",
  data(){
    return{
      user:{},
      loading:false
    }
  },
  methods:{
    async getUser(){
      this.loading=true;
      try{
        const result=await http.get('/api/me',{
          headers:{
            Authorization: `Bearer ${localStorage.getItem('token')}`
          }
        })
        console.log(result)
        this.user=result.data.data;
      }catch (e){
        console.log(e.message)
      }finally {
        this.loading=false;
      }
    },
  },
  mounted() {
    this.getUser();
  }
}
</script>

<template>
<section v-if="!loading" class="min-vh-100 d-flex justify-content-center align-items-center">
  <div>
    <h1>Üdvözlünk {{user.firstname}} {{user.lastname}}!</h1>
    <p class="text-center">Ez az admin felület.</p>
  </div>

</section>
</template>

<style scoped>

</style>