<script>

export default {
  name: "AdminNavbar"
}
</script>

<template>
  <header>
    <nav class="navbar bg-black navbar-expand-lg p-3" data-bs-theme="dark">
      <div class="container">
        <RouterLink class="navbar-brand" :to="{name: 'admin-home'}">Admin főoldal</RouterLink>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav me-auto">
            <li class="nav-item">
              <RouterLink class="nav-link" :to="{name: 'admin-jobs'}">Állások</RouterLink>
            </li>
            <li class="nav-item">
              <RouterLink class="nav-link" :to="{name: 'admin-users'}">Felhasználók</RouterLink>
            </li>
            <li class="nav-item">
              <RouterLink class="nav-link" :to="{name: 'admin-ratings'}">Értékelések</RouterLink>
            </li>
            <li class="nav-item">
              <RouterLink class="nav-link" :to="{name: 'admin-categories'}">Kategóriák</RouterLink>
            </li>
            <li class="nav-item">
              <RouterLink class="nav-link" :to="{name: 'admin-skills'}">Képességek</RouterLink>
            </li>
          </ul>
        </div>
        <RouterLink class="btn btn-outline-primary" :to="{name: 'home'}">Vissza</RouterLink>
      </div>
    </nav>
  </header>
</template>

<style scoped>

</style>