<script>
import {Form, Field, ErrorMessage} from "vee-validate";
import {http} from "@/utils/http.js";

export default {
  name: "LoginView",
  data() {
    return {
      failed: false
    }
  },
  components: {Form, Field, ErrorMessage},
  methods: {
    async Login(data) {
      try {
        const result = await http.post('/api/login', data)
        if (result.data.token) {
          localStorage.setItem('token', result.data.token)
          this.$router.push({
            name: 'home'
          })
        } else {
          this.failed = true
        }
      } catch (e) {
        this.failed = true
      }
    }
  }
}
</script>

<template>
  <section class="mt-3">
    <div class="border-5 border-bottom mb-4">
      <h1 class="text-center fw-bold">Bejelentkezés</h1>
    </div>
    <p class="alert alert-danger text-center mb-4" v-if="failed">Sikertelen bejelentkezés!</p>
    <Form @submit="Login">
      <ErrorMessage class="alert alert-danger text-center" name="email" as="p"/>
      <ErrorMessage class="alert alert-danger text-center" name="password" as="p"/>
      <div class="input-group mt-3">
        <span class="input-group-text">E-mail<span class="text-danger fw-bold">*</span></span>
        <Field name="email" class="form-control" type="email" placeholder="pl.: mintabalint@example.com"
               rules="required|email"/>
      </div>
      <div class="input-group mt-3">
        <span class="input-group-text">Jelszó<span class="text-danger fw-bold">*</span></span>
        <Field name="password" class="form-control" placeholder="••••••••" type="password" rules="required|min:8"/>
      </div>
      <span class="text-center m-5">Még nincs fiókod? <RouterLink :to="{name: 'register'}" class="text-decoration-none">Regisztálj!</RouterLink></span>
      <div class="d-flex justify-content-center">
        <button class="mt-3 btn btn-warning" type="submit">Bejelentezés</button>
      </div>
    </Form>
  </section>
</template>
<style scoped>
</style>