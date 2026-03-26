<script>
import Navbar from "@/components/Navbar.vue";
import Footer from "@/components/Footer.vue";

export default {
  name: "AppLayout",
  components: {Footer, Navbar}
}
</script>

<template>
  <Navbar/>
  <main class="min-vh-100 px-5">
    <RouterView/>
  </main>
  <Footer/>
</template>

<style scoped>

</style>