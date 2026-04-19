<script>
import {Form, Field, ErrorMessage} from "vee-validate";
import {http} from "@/utils/http.js";

export default {
  name: "JobApplicationForm",
  data() {
    return {
      text: ''
    }
  },
  components: {Field, Form, ErrorMessage},
  emits: ['success'],
  props: {
    jobID: {
      type: Number,
      required: true
    },
    userID: {
      type: Number,
      required: true
    }
  },
  methods: {
    async Send(data) {
      try {
        await http.post('/api/applications', {
          user_id: this.userID,
          job_id: this.jobID,
          ...data
        }, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`
          }
        })
        this.$emit('success')
      } catch (e) {
        console.log(e.message)
      }
    }
  }
}
</script>

<template>
  <section>
    <Form @submit="Send" class="my-2">
      <Field as="textarea" name="message" class="form-control" v-model="text" rules="required|min:100|max:500"/>
      <p class="text-center">{{ text.length }}/100</p>
      <input type="submit" class="btn btn-primary my-2" value="Küldés">
    </Form>
  </section>
</template>

<style scoped>
textarea {
  height: 200px
}
</style>