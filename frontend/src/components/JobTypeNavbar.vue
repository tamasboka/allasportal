<script>
export default {
  name: "JobTypeNavbar",
  methods: {
    emitFilter(filter) {
      this.$emit('newFilter', filter)
    }
  },
  emits: ['newFilter']
}
</script>

<template>
  <nav class="navbar bg-black navbar-expand-lg" data-bs-theme="dark">
    <div class="container d-flex justify-content-center">
      <ul class="navbar-nav">
        <li class="nav-item">
          <button class="nav-link" @click="emitFilter('all')">Összes</button>
        </li>
        <li class="nav-item">
          <button class="nav-link" @click="emitFilter('fulltime')">Full Time</button>
        </li>
        <li class="nav-item">
          <button class="nav-link" @click="emitFilter('parttime')">Part Time</button>
        </li>
        <li class="nav-item">
          <button class="nav-link" @click="emitFilter('onetime')">One Time</button>
        </li>
      </ul>
    </div>
  </nav>
</template>

<style scoped>

</style>