<script>
export default {
  name: "AboutUsView",
}
</script>

<template>
  <section class="p-5 container">
    <h1 class="text-center">Rólunk</h1>

    <!-- Ezeknek lehet kene kulon komponens -->

    <div class="border-block p-2">
      <div class="underline-blue">
        <h2 class="text-white text-center fw-bold">Miben segít ez az oldal?</h2>
      </div>
      <p class="text-center">Az oldalunk lehetővé teszi a felhasználó számára, hogy könnyedén találjon, vagy közzé
        tegyen új állásokat.</p>
    </div>
    <div class="border-block p-2 mt-5">
      <div class="underline-blue">
        <h2 class="text-white text-center fw-bold">Fejlesztők</h2>
      </div>
      <div class="row">
        <div class="col-12 col-lg-6 col-md-6 col-sm-12">
          <div class="inline-flex m-3 text-center">
            <img src="https://avatars.githubusercontent.com/u/114821563?v=4" alt="tamasboka profile picture"
                 class="mx-2">
            <a href="https://github.com/tamasboka">Bóka Tamás</a>
          </div>
        </div>
        <div class="col-12 col-lg-6 col-md-6 col-sm-12">
          <div class="inline-flex m-3 text-center">
            <img src="https://avatars.githubusercontent.com/u/171667151?v=4" alt="BBence1 profile picture" class="mx-2">
            <a href="https://github.com/BBence1">Beretzky Bence</a>
          </div>
        </div>
      </div>
    </div>
    <div class="border-block p-2 mt-5">
      <div class="underline-blue">
        <h2 class="text-white text-center fw-bold">Tech stack</h2>
      </div>
      <div class="row">
        <div class="col-12 col-lg-4 col-md-6 col-sm-12">
          <div class="inline-flex m-3 text-center">
            <img src="https://icon.icepanel.io/Technology/svg/Vue.js.svg" alt="Vue.js icon">
            <a href="https://vuejs.org/">Vue.js</a>
          </div>
        </div>
        <div class="col-12 col-lg-4 col-md-6 col-sm-12">
          <div class="inline-flex m-3 text-center">
            <img src="https://upload.wikimedia.org/wikipedia/commons/9/9a/Laravel.svg" alt="Laravel icon">
            <a href="https://laravel.com/">Laravel</a>
          </div>
        </div>
        <div class="col-12 col-lg-4 col-md-6 col-sm-12">
          <div class="inline-flex m-3 text-center">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/0a/MySQL_textlogo.svg/960px-MySQL_textlogo.svg.png" alt="Mysql icon">
            <a href="https://www.mysql.com/">Mysql</a>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
img {
  width: 10%;
  height: 10%;
  border-radius: 50%;
}

a {
  text-decoration: none;
  color: white
}
</style>