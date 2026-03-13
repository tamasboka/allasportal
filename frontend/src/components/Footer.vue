<script>

export default {
  name: "Footer"
}
</script>

<template>
<footer class="p-5">
  <div class="row">
    <div class="col-12 col-lg-6 col-md-6 col-sm-6 text-center">
      <h1 class="h4">Készítők</h1>
      <div class="inline-flex m-3">
        <img src="https://avatars.githubusercontent.com/u/114821563?v=4" alt="tamasboka profile picture" class="mx-2">
        <a href="https://github.com/tamasboka">tamasboka</a>
      </div>
      <div class="inline-flex">
        <img src="https://avatars.githubusercontent.com/u/171667151?v=4" alt="BBence1 profile picture" class="mx-2">
        <a href="https://github.com/BBence1">BBence1</a>
      </div>
    </div>
    <div class="col-12 col-lg-6 col-md-6 col-sm-6 text-center">
      <h1 class="h4">GitHub Repository</h1>
      <a href="https://github.com/tamasboka/allasportal" target="_blank" class="btn btn-secondary"><i class="bi bi-github me-2"></i>allasportal</a>
    </div>
  </div>
</footer>
</template>

<style scoped>
img {
  width: 5%;
  height: 5%;
  border-radius: 50%;
}
a {
  text-decoration: none;
  color: white
}
</style>