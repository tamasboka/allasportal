<script>
import Searchbar from "@/components/Searchbar.vue";

export default {
  name: "Home",
  components: {Searchbar},
}
</script>

<template>
  <section>
    <div class="d-flex justify-content-center py-5 align-items-center min-vh-100">
      <div class="text-center">
        <h1>JobNest</h1>
        <p>A JobNest lehetővé teszi a felhasználók számára az egyszerű munka keresést, vagy annak közzétételét.</p>
        <Searchbar/>
      </div>
    </div>
  </section>
</template>

<style scoped>

</style>