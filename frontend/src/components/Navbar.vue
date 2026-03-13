<script>

export default {
  name: "Navbar"
}
</script>

<template>
  <header>
    <nav class="navbar bg-black navbar-expand-lg p-3" data-bs-theme="dark">
      <div class="container">
        <RouterLink class="navbar-brand" :to="{name: 'home'}">Home</RouterLink>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav me-auto">
            <li class="nav-item">
              <RouterLink class="nav-link" :to="{name: 'jobs'}">Állások</RouterLink>
            </li>
            <li class="nav-item">
              <RouterLink class="nav-link" :to="{name: 'companies'}">Cégek</RouterLink>
            </li>
            <li class="nav-item">
              <RouterLink class="nav-link" :to="{name: 'about'}">Rólunk</RouterLink>
            </li>
          </ul>
          <div class="d-flex gap-3">
            <RouterLink class="btn btn-primary rounded-pill" :to="{name: 'register'}">Regisztrálás</RouterLink>
            <RouterLink class="btn btn-secondary rounded-pill" :to="{name: 'login'}">Bejelentkezés</RouterLink>
            <button class="btn" :class="{ 'btn-light':  true}"><i class="bi bi-brightness-high"></i></button>
          </div>
        </div>
      </div>
    </nav>
  </header>
</template>

<style scoped>

</style>