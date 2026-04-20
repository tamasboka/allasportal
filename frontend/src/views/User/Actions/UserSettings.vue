<script>
import {Field, Form} from "vee-validate";
import {http} from "@/utils/http.js";

export default {
  name: "UserSettings",
  components: {Field, Form},
  data() {
    return {
      user: this.$route.meta.prefetched
    }
  },
  methods:{
    async UpdateUser(data){
      console.log(data)
      try{
        await http.patch(`/api/user/${this.user.id}`,data,{
          headers:{
            Authorization:`Bearer ${localStorage.getItem('token')}`
          }
        })
      }catch (e){
        console.log(e.message)
      }
    }
  }
}
</script>

<template>
  <section>
    <div class="container">
      <div class="row">
        <div class="col-12 col-lg-6 col-md-12 col-sm-12">
          <div class="border border-5 border-secondary rounded-5 p-3">
            <Form @submit="UpdateUser">
              <div class="input-group">
                <span class="input-group-text">Új keresztnév: </span>
                <Field name="firstname" class="form-control me-3" :value="user.firstname"/>
                <span class="input-group-text">Új vezetéknév: </span>
                <Field name="lastname" class="form-control" :value="user.lastname"/>
              </div>
              <div class="input-group mt-2">
                <span class="input-group-text">Új telefonszám: </span>
                <Field name="phone" class="form-control" :value="user.phone"/>
              </div>
              <div class="input-group mt-2">
                <span class="input-group-text">Új email: </span>
                <Field name="email" class="form-control" :value="user.email"/>
              </div>
              <div class="input-group mt-2">
                <span class="input-group-text">Új jelszó: </span>
                <Field name="password" class="form-control"/>
              </div>
              <div class="d-flex justify-content-center">
                <button class="btn btn-primary mt-2">Mentés</button>
              </div>
            </Form>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>

</style>