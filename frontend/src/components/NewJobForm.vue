<script>
import {Form, ErrorMessage, Field} from "vee-validate";

export default {
  name: "NewJobForm",
  components:{Form, ErrorMessage, Field},
  methods:{
    Create(){

    }
  }
}
</script>

<template>
  <section class="mt-3">
    <h1 class="text-center mb-4">Új munka</h1>
    <Form @submit="Create">
      <Field name="name" class="mt-3 form-control" type="text" placeholder="Munka neve"/>
      <Field name="job_type" as="select" class="mt-3 form-select">
        <option selected hidden="hidden">Típus</option>
        <option value="full-time">Teljes munka</option>
        <option value="part-time">Részmunka</option>
        <option value="one-time">Egyszeri munka</option>
      </Field>
      <div class="d-flex justify-content-center">
        <button class="mt-3 btn btn-success" type="submit">Feltöltés</button>
      </div>
    </Form>
  </section>
</template>

<style scoped>

</style>