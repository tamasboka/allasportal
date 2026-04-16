<script>
import NewJobForm from "@/components/NewJobForm.vue";
import {Field, Form} from "vee-validate";
import EditJobForm from "@/components/EditJobForm.vue";
import EditWorkersForm from "@/components/EditWorkersForm.vue";

export default {
  name: "EditJob",
  components: {EditWorkersForm, EditJobForm, NewJobForm, Field, Form},
  data() {
    return {
      isReturnBtnHovered: false,
      job: this.$route.meta.prefetched.job.data.data,
    }
  }
}
</script>

<template>
  <main>
    <section class="min-vh-100 d-flex align-items-center justify-content-center">
      <div class="card text-bg-dark">
        <div class="card-body">
          <RouterLink to="/" class="text-decoration-none text-light btn"
                      :class="{ 'btn-outline-light': !isReturnBtnHovered, 'btn-outline-primary': isReturnBtnHovered}"
                      @mouseover="isReturnBtnHovered = true" @mouseleave="isReturnBtnHovered = false">
            <i class="bi bi-arrow-left-circle me-2"></i>
            Vissza
          </RouterLink>
          <EditJobForm :job="job" class="mt-3"/>
          <EditWorkersForm :workers="job.workers"/>
        </div>
      </div>
    </section>
  </main>
</template>

<style scoped>
.card {
  width: 75%
}
</style>