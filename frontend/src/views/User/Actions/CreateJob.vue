<script>
import {Field, Form} from "vee-validate";
import NewJobForm from "@/components/NewJobForm.vue";

export default {
  name: "CreateJob",
  components: {NewJobForm, Field, Form},
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
      <div class="card text-bg-dark p-1 border-5 border-secondary rounded-5">
        <div class="card-body">
          <RouterLink to="/" class="text-decoration-none text-light btn"
                      :class="{ 'btn-outline-light': !isReturnBtnHovered, 'btn-outline-primary': isReturnBtnHovered}"
                      @mouseover="isReturnBtnHovered = true" @mouseleave="isReturnBtnHovered = false">
            <i class="bi bi-arrow-left-circle me-2"></i>
            Vissza
          </RouterLink>
          <NewJobForm/>
        </div>
      </div>
    </section>
  </main>
</template>

<style scoped>

</style>