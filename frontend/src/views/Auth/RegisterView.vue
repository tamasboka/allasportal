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
    <div class="underline mb-4">
      <h1 class="text-center fw-bold">Regisztráció</h1>
    </div>
    <p class="alert alert-danger text-center mb-4" v-if="failed">Sikertelen regisztráció!</p>
    <Form @submit="Register">
      <ErrorMessage class="alert alert-danger text-center" name="firstname" as="p"/>
      <ErrorMessage class="alert alert-danger text-center" name="lastname" as="p"/>
      <ErrorMessage class="alert alert-danger text-center" name="email" as="p"/>
      <ErrorMessage class="alert alert-danger text-center" name="password" as="p"/>
      <div class="row">
        <div class="col-12 col-lg-6">
          <div class="input-group">
            <span class="input-group-text">Keresztnév<span class="text-danger fw-bold">*</span></span>
            <Field name="firstname" class="form-control" type="text" placeholder="pl.: Bálint"
                   rules="required|min:2|max:25"/>
          </div>
        </div>
        <div class="col-12 col-lg-6">
          <div class="input-group">
            <span class="input-group-text">Vezetéknév<span class="text-danger fw-bold">*</span></span>
            <Field name="lastname" class="form-control" type="text" placeholder="pl.: Minta"
                   rules="required|min:2|max:25"/>
          </div>
        </div>
      </div>
      <div class="input-group mt-3">
        <span class="input-group-text">E-mail<span class="text-danger fw-bold">*</span></span>
        <Field name="email" class="form-control" type="email" placeholder="pl.: mintabalint@example.com"
               rules="required|email"/>
      </div>
      <div class="input-group mt-3">
        <span class="input-group-text">Jelszó<span class="text-danger fw-bold">*</span></span>
        <Field name="password" class="form-control" placeholder="••••••••" type="password" rules="required|min:8"/>
      </div>
      <div class="input-group mt-3">
        <span class="input-group-text">Telefonszám</span>
        <Field name="phone" class="form-control" type="tel" placeholder="12345678" rules="min:8|max:15"/>
      </div>
      <div class="input-group mt-3">
        <span class="input-group-text">Nem<span class="text-danger fw-bold">*</span></span>
        <Field name="gender" as="select" class="form-select" rules="required">
          <option value="female">Nő</option>
          <option value="male">Férfi</option>
          <option value="not-given">Nem adom meg</option>
        </Field>
      </div>
      <div class="d-flex justify-content-center">
        <button class="mt-3 btn btn-warning" type="submit">Regisztrálás</button>
      </div>
    </Form>
  </section>
</template>

<style scoped>

</style>