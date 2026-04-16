<script>
export default {
  name: "EditWorkersForm",
  props: {
    workers: {
      type: Array,
      required: true
    }
  },
  methods: {
    kickWorker(id) {

    }
  }
}
</script>

<template>
  <div class="mt-5">
    <h1 class="text-success text-center">Dolgozók</h1>
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
        <td><button class="btn btn-danger"><i class="bi bi-door-open"></i></button></td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<style scoped>

</style>