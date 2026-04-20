<script>
import Navbar from "@/components/Navbar.vue";
import Footer from "@/components/Footer.vue";

export default {
  name: "UserLayout",
  components: {Footer, Navbar},
}
</script>

<template>
  <Navbar/>
  <main class="min-vh-100">
    <RouterView/>
  </main>
  <Footer/>
</template>

<style scoped>

</style>