<script>

import Navbar from "@/components/Navbar.vue";

export default {
  name: "AppLayout",
  components: {Navbar}
}
</script>

<template>
  <Navbar/>
  <RouterView/>
</template>

<style scoped>

</style>