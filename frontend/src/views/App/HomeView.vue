<script>
export default {
  name: "Home",
}
</script>

<template>
  <section>
    <div class="d-flex xy-center">
      <div class="text-center">
        <h1>JobNest</h1>
        <p>A JobNest lehetővé teszi a felhasználók számára az egyszerű munka keresést, vagy annak közzétételét.</p>
        <div class="d-inline-flex">
          <input class="form-control" type="text" placeholder="Itt kereshetsz">
          <button class="btn btn-secondary">Keresés</button>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.xy-center {
  height: 100vh;
  align-items: center;
  justify-content: center;
}
</style>