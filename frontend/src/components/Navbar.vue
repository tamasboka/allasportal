<script>
import {http} from "@/utils/http.js";
export default {
  name: "Navbar",
  data() {
    return {
      user: {},
      userLoading: true
    }
  },
  computed:{
    isLoggedIn(){
      return !!localStorage.getItem('token')
    }
  },
  methods:{
    async Logout(){
      await http.post('/api/logout',{},{headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}})
      localStorage.removeItem('token')
      alert("Sikeres kijelentkezés")
      this.$router.push()
    },
    async getUserData() {
      this.userLoading = true
      if (!this.isLoggedIn) return
      const res = await http.get('/api/me', {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('token')}`
        }
      })
      this.userLoading = false
      this.user = res.data.data
    }
  },
  mounted() {
    this.getUserData()
  }
}
</script>

<template>
  <header>
    <nav class="navbar bg-black navbar-expand-lg p-3" data-bs-theme="dark">
      <div class="container">
        <RouterLink class="navbar-brand" :to="{name: 'home'}">Főoldal</RouterLink>
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
              <RouterLink class="nav-link" :to="{name: 'about'}">Rólunk</RouterLink>
            </li>
          </ul>
          <div class="d-flex gap-3">
            <div v-if="!isLoggedIn">
              <RouterLink class="btn btn-primary rounded-pill" :to="{name: 'register'}">Regisztrálás</RouterLink>
              <RouterLink class="btn btn-secondary rounded-pill" :to="{name: 'login'}">Bejelentkezés</RouterLink>
            </div>
            <div v-else-if="isLoggedIn && !userLoading">
              <RouterLink :to="{name: 'user-home', params: {userID: user.id}}" class="btn btn-primary">{{ user.firstname }} {{ user.lastname }}</RouterLink>
            </div>
            <div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-gear"></i>
              </button>
              <ul class="dropdown-menu">
                <li v-if="isLoggedIn"><RouterLink :to="{name: 'user-settings'}" class="dropdown-item">Profil szerkesztése</RouterLink></li>
                <li><button class="dropdown-item"><i class="bi bi-circle-half"></i> Téma</button></li>
                <li class="bg-danger" v-if="isLoggedIn"><button class="dropdown-item bg-danger">Kijelentkezés</button></li>
              </ul>
            </div>
            <RouterLink class="btn btn-warning" :to="{name: 'create-job'}">Új munka</RouterLink>
          </div>
        </div>
      </div>
    </nav>
  </header>
</template>

<style scoped>
.bg-danger:hover{
  background-color: var(--bs-danger) !important;
}
</style>