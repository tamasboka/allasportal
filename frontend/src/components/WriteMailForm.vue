<script>
import {ErrorMessage, Field, Form} from "vee-validate";
import {http} from "@/utils/http.js";

export default {
  name: "WriteMailForm",
  data() {
    return {
      failed: false
    }
  },
  emits: ['new'],
  components: {ErrorMessage, Field, Form},
  methods: {
    async sendMail(data) {
      try {
        await http.post('/api/notifications', data, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`
          }
        })
        this.$router.go()
      } catch (e) {
        this.failed = true
      }
    },
    emitNew(data) {
      this.$emit('new', data)
    }
  }
}
</script>

<template>
  <section class="border-block p-5 bg-dark">
    <p class="alert alert-danger text-dark text-center" v-if="failed">Hibás e-mail!</p>
    <Form @submit="sendMail">
      <ErrorMessage name="email" class="alert alert-danger text-dark text-center" as="p"/>
      <ErrorMessage name="title" class="alert alert-danger text-dark text-center" as="p"/>
      <ErrorMessage name="message" class="alert alert-danger text-dark text-center" as="p"/>
      <div class="input-group">
        <span class="input-group-text">Címzett e-mail címe</span>
        <Field name="email" class="form-control" rules="required|email"/>
      </div>
      <div class="input-group">
        <span class="input-group-text">Tárgy</span>
        <Field name="title" class="form-control" rules="required|min:3|max:100"/>
      </div>
      <div class="input-group">
        <span class="input-group-text">Tárgy</span>
        <Field name="message" as="textarea" class="form-control" rules="required|min:3|max:255"/>
      </div>
      <button type="submit" class="btn btn-primary btn-lg w-100">Küldés</button>
    </Form>
  </section>
</template>

<style scoped>

</style>