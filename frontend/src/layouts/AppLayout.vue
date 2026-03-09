<script>
import Navbar from "@/components/Navbar.vue";

export default {
  name: "AppLayout",
  components: {Navbar}
}
</script>

<template>
  <Navbar/>
  <main>
    <RouterView/>
  </main>

</template>

<style scoped>

</style>