<script>
import AdminNavbar from "@/components/AdminNavbar.vue";

export default {
  name: "AdminLayout",
  components: {AdminNavbar}
}
</script>

<template>
<section>
<AdminNavbar/>
  <main class="min-vh-100">
    <RouterView/>
  </main>
</section>
</template>

<style scoped>

</style>