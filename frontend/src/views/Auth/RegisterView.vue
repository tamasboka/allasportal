<script>
import {Form, Field, ErrorMessage} from "vee-validate";
import {http} from "@/utils/http.js";

export default {
  name: "RegisterView",
  data() {
    return {
      failed: false
    }
  },
  components: {Form, Field, ErrorMessage},
  methods: {
    async Register(data) {
      try {
        await http.post('/api/register', data)
        this.$router.push({
          name: 'login'
        })
      } catch (e) {
        console.log(e.message)
        this.failed = true
      }
    }
  }
}
</script>

<template>
  <section class="mt-3">
    <h1 class="text-center mb-4">Regisztráció</h1>
    <p class="alert alert-danger text-center mb-4" v-if="failed">Sikertelen regisztráció!</p>
    <Form @submit="Register">
      <ErrorMessage class="alert alert-danger text-center" name="firstname" as="p"/>
      <ErrorMessage class="alert alert-danger text-center" name="lastname" as="p"/>
      <ErrorMessage class="alert alert-danger text-center" name="email" as="p"/>
      <ErrorMessage class="alert alert-danger text-center" name="password" as="p"/>
      <div class="row">
        <div class="col-12 col-lg-6">
          <Field name="firstname" class="form-control" type="text" placeholder="Vezetéknév" rules="required|min:2|max:25"/>
        </div>
        <div class="col-12 col-lg-6">
          <Field name="lastname" class="form-control" type="text" placeholder="Keresztnév" rules="required|min:2|max:25"/>
        </div>
      </div>
      <Field name="email" class="mt-3 form-control" type="email" placeholder="Email" rules="required|email"/>
      <Field name="password" class="mt-3 form-control" type="password" placeholder="Jelszó" rules="required|min:8"/>
      <Field name="phone" class="mt-3 form-control" type="tel" placeholder="Telefonszám" rules="min:8|max:15"/>
      <Field name="gender" as="select" class="mt-3 form-select">
        <option value="female">Nő</option>
        <option value="male">Férfi</option>
        <option value="not-given">Nem adom meg</option>
      </Field>
      <div class="d-flex justify-content-center">
        <button class="mt-3 btn btn-warning" type="submit">Regisztrálás</button>
      </div>
    </Form>
  </section>
</template>

<style scoped>

</style>