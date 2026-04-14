<script>
import {Form,Field,ErrorMessage} from "vee-validate";
import {http} from "@/utils/http.js";

export default {
  name: "RegisterView",
  components: {Form,Field,ErrorMessage},
  methods:{
    async Register(data){
      try{
        await http.post('/api/register',data)
      }catch (e){
        console.log(e.message)
      }
      this.$router.push({
        name: 'login'
      })
    }
  }
}
</script>

<template>
  <section class="mt-3">
    <h1 class="text-center mb-4">Regisztráció</h1>
    <Form @submit="Register">
      <div class="row">
        <div class="col-12 col-lg-6">
          <Field name="firstname" class="form-control" type="text" placeholder="Vezetéknév"/>
        </div>
        <div class="col-12 col-lg-6">
          <Field name="lastname" class="form-control" type="text" placeholder="Keresztnév"/>
        </div>
      </div>
      <Field name="email" class="mt-3 form-control" type="email" placeholder="Email"/>
      <Field name="password" class="mt-3 form-control" type="password" placeholder="Jelszó"/>
      <Field name="phone" class="mt-3 form-control" type="tel" placeholder="Telefonszám"/>
      <Field name="gender" as="select" class="mt-3 form-select">
        <option selected hidden="hidden">Neme</option>
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