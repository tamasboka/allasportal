<script>
import {Form, Field, ErrorMessage} from "vee-validate";

export default {
  name: "ReviewForm",
  components: {ErrorMessage, Field, Form},
  emits: ['sent'],
  methods: {
    async sendReview(data) {
      this.$emit('sent', data)
    }
  }
}
</script>

<template>
  <Form @submit="sendReview">
    <ErrorMessage name="rating" class="alert alert-danger text-center text-white" as="p"/>
    <ErrorMessage name="title" class="alert alert-danger text-center text-white" as="p"/>
    <ErrorMessage name="message" class="alert alert-danger text-center text-white" as="p"/>
    <div class="input-group">
      <span class="input-group-text">Csillag</span>
      <Field name="rating" type="number" class="form-control" rules="required|between:1,5"/>
    </div>
    <div class="input-group">
      <span class="input-group-text">Cím</span>
      <Field name="title" class="form-control" rules="required|min:1|max:50"/>
    </div>
    <div class="input-group">
      <span class="input-group-text">Tartalom</span>
      <Field name="message" as="textarea" class="form-control" rules="required|min:1|max:255"/>
    </div>
    <button type="submit" class="btn btn-success mt-3 btn-lg w-50">Küldés</button>
  </Form>
</template>

<style scoped>

</style>