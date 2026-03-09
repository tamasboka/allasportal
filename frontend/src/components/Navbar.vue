<script>

export default{
  name: "Navbar"
}
</script>

<template>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <RouterLink class="navbar-brand" :to="{name: 'home'}">Home</RouterLink>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <RouterLink class="nav-link" :to="{name: 'jobs'}">Állások</RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink class="nav-link" :to="{name: 'companies'}">Cégek</RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink class="nav-link" :to="{name: 'register'}">Regisztrálás</RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink class="nav-link" :to="{name: 'login'}">Bejelentkezés</RouterLink>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<style scoped>

</style>