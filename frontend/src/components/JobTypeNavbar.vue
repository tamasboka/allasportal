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
        <li class="nav-item full-time">
          <button class="nav-link" @click="emitFilter('full-time')">Teljes munka</button>
        </li>
        <li class="nav-item part-time">
          <button class="nav-link" @click="emitFilter('part-time')">Részmunka</button>
        </li>
        <li class="nav-item one-time">
          <button class="nav-link" @click="emitFilter('one-time')">Egyszeri munka</button>
        </li>
      </ul>
    </div>
  </nav>
</template>

<style scoped>

</style>