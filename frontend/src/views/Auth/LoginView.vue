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
    <h1 class="text-center mb-4">Bejelentkezés</h1>
    <p class="alert alert-danger text-center mb-4" v-if="failed">Sikertelen bejelentkezés!</p>
    <Form @submit="Login">
      <ErrorMessage class="alert alert-danger text-center" name="email" as="p"/>
      <ErrorMessage class="alert alert-danger text-center" name="password" as="p"/>
      <Field name="email" class="mt-3 form-control" type="email" placeholder="Email" rules="required|email"/>
      <Field name="password" class="mt-3 form-control" type="password" placeholder="Jelszó" rules="required|min:8|max:25"/>
      <span class="text-center m-5">Még nincs fiókod? <RouterLink :to="{name: 'register'}" class="text-decoration-none">Regisztálj!</RouterLink></span>
      <div class="d-flex justify-content-center">
        <button class="mt-3 btn btn-warning" type="submit">Bejelentezés</button>
      </div>
    </Form>
  </section>
</template>
<style scoped>
</style>