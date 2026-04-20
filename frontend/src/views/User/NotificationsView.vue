<script>
import Mail from "@/components/Mail.vue";

export default {
  name: "NotificationsView",
  components: {Mail},
  data() {
    return {
      notifications: this.$route.meta.prefetched.notifications
    }
  }
}
</script>

<template>
  <section v-if="!notifications.length" class="min-vh-100 d-flex justify-content-center align-items-center">
    <div class="d-block">
      <h1 class="fw-bold">Még nem jöttek leveleid!</h1>
      <h2 class="text-center h4 border-top border-5 text-light">Nézz be később!</h2>
    </div>
  </section>
  <section v-else class="p-5">
    <Mail v-for="notification in notifications" :notification="notification" class="m-5"/>
  </section>
</template>

<style scoped>

</style>