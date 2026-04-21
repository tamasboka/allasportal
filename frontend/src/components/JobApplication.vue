<script>
export default {
  name: "JobApplication",
  props: {
    application: {
      type: Object,
      required: true
    }
  },
  methods: {
    accept(id) {
      this.$emit('accept', id)
    },
    reject(id) {
      this.$emit('reject', id)
    }
  }
}
</script>

<template>
  <div class="card w-100 border-block">
    <div class="card-body p-4">
      <div class="d-flex underline-gray">
        <h2 class="h4">{{ application.sender.firstname }} {{ application.sender.lastname }}</h2>
        <div class="ms-auto">
          <button class="btn btn-success me-1" @click="accept(application.id)">Elfogadás</button>
          <button class="btn btn-danger ms-1" @click="reject(application.id)">Elutasítás</button>
        </div>
      </div>
      <div class="mt-3">
        <p class="text-black">{{ application.message }}</p>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>