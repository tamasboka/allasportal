<script>
import {Form,Field,ErrorMessage} from "vee-validate";
import {http} from "@/utils/http.js";

export default {
  name: "LoginView",
  components: {Form,Field,ErrorMessage},
  methods:{
    async Login(data){
      try{
        const result = await http.post('/api/login',data)
        localStorage.setItem('token',result.data.data.token)
      }catch (e){
        console.log(e.message)
      }
      this.$router.push({
        name: 'home'
      })
    }
  }
}
</script>

<template>
  <section class="mt-3">
    <h1 class="text-center mb-4">Bejelentkezés</h1>
    <Form @submit="Login">
      <Field name="email" class="mt-3 form-control" type="email" placeholder="Email"/>
      <Field name="password" class="mt-3 form-control" type="password" placeholder="Jelszó"/>
      <div class="d-flex justify-content-center">
        <button class="mt-3 btn btn-warning" type="submit">Bejelentezés</button>
      </div>
    </Form>
  </section>
</template>
<style scoped>
</style>