<script>
import {http} from "@/utils/http.js";

export default {
  name: "EditWorkersForm",
  props: {
    workers: {
      type: Array,
      required: true
    },
    jobID: {
      type: Number,
      required: true
    }
  },
  methods: {
    async kickWorker(id) {
      try {
        await http.delete(`/api/jobs/${this.jobID}/user/${id}`, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`
          }
        })
      } catch (e) {
        console.log(e.message)
      }
      this.workers.splice(this.workers.findIndex(worker => worker.id === id), 1)
    }
  }
}
</script>

<template>
  <div class="mt-5">
    <h1 class="text-center mb-4 fw-bold underline-blue">Dolgozók</h1>
    <h2 v-if="!workers.length" class="text-center">Nincsenek dolgozók!</h2>
    <table class="table table-striped" v-else>
      <thead>
      <tr>
        <th>Név</th>
        <th>Kirúgás</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="worker in workers">
        <td>{{ worker.firstname }} {{ worker.lastname }}</td>
        <td><button class="btn btn-danger" @click="kickWorker(worker.id)"><i class="bi bi-door-open"></i></button></td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<style scoped>

</style>