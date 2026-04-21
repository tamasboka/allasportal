<script>
export default {
  name: "NotificationNavbar",
  emits: ['filter'],
  methods: {
    emitFilter(filter) {
      this.$emit('filter', filter)
    }
  }
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
          <button class="nav-link" @click="emitFilter('unread')">Olvasatlan</button>
        </li>
        <li class="nav-item part-time">
          <button class="nav-link" @click="emitFilter('read')">Olvasott</button>
        </li>
        <li class="nav-item one-time">
          <button class="nav-link" @click="emitFilter('sent')">Elküldött</button>
        </li>
        <li class="nav-item one-time">
          <button class="nav-link" @click="emitFilter('write')">Küldés</button>
        </li>
      </ul>
    </div>
  </nav>
</template>

<style scoped>

</style>