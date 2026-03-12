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
  <main>
    <RouterView/>
  </main>
  <Footer/>
</template>

<style scoped>

</style>