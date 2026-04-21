<script>
export default {
  name: "AuthLayout",
  data() {
    return {
      isReturnBtnHovered: false
    }
  }
}
</script>

<template>
  <main>
    <section class="min-vh-100 d-flex align-items-center justify-content-center">
      <div class="card text-bg-dark p-1 border-block">
        <div class="card-body">
          <RouterLink to="/" class="text-decoration-none text-light btn"
                      :class="{ 'btn-outline-light': !isReturnBtnHovered, 'btn-outline-primary': isReturnBtnHovered}"
                      @mouseover="isReturnBtnHovered = true" @mouseleave="isReturnBtnHovered = false">
            <i class="bi bi-arrow-left-circle me-2"></i>
            Vissza
          </RouterLink>
          <RouterView/>
        </div>
      </div>
    </section>
  </main>
</template>

<style scoped>

</style>