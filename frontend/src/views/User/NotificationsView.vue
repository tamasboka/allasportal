<script>
import Mail from "@/components/Mail.vue";
import NotificationNavbar from "@/components/NotificationNavbar.vue";
import {Form} from "vee-validate";
import WriteMailForm from "@/components/WriteMailForm.vue";

export default {
  name: "NotificationsView",
  components: {WriteMailForm, Form, NotificationNavbar, Mail},
  data() {
    return {
      notifications: this.$route.meta.prefetched.notifications,
      filteredNotifications: [...this.$route.meta.prefetched.notifications, ...this.$route.meta.prefetched.sent],
      sent: this.$route.meta.prefetched.sent,
      filtered: false,
      isWriting: false,
      userID: this.$route.meta.prefetched.userID
    }
  },
  methods: {
    filterMails(filter) {
      if (filter === 'all') {
        this.filteredNotifications = [
            ...this.notifications,
            ...this.sent
        ]
        this.filtered = false
        this.isWriting = false
      } else if (filter === 'read') {
        this.filteredNotifications = this.notifications.filter(notif => notif.is_read)
        this.filtered = true
        this.isWriting = false
      } else if (filter === 'unread') {
        this.filteredNotifications = this.notifications.filter(notif => !notif.is_read)
        this.filtered = true
        this.isWriting = false
      } else if (filter === 'sent'){
        this.filteredNotifications = this.sent
        this.filtered = true
        this.isWriting = false
      } else {
        this.filteredNotifications = []
        this.isWriting = true
        this.filtered = false
      }
    },
    handleRead(id) {
      this.filteredNotifications.find(notif => notif.id === id).is_read = 1
    },
  }
}
</script>

<template>
  <NotificationNavbar @filter="filterMails"/>
  <section v-if="!filteredNotifications.length" class="min-vh-100 d-flex justify-content-center align-items-center">
    <div class="d-block">
      <div v-if="isWriting">
        <WriteMailForm/>
      </div>
      <div v-else-if="!filtered && !notifications.length">
        <h1 class="fw-bold">Még nem jöttek leveleid!</h1>
        <h2 class="text-center h4 border-top border-5 text-light">Nézz be később!</h2>
      </div>
      <div v-else-if="filtered && !filteredNotifications.length" class="text-center">
        <h1 class="fw-bold">Nem található olyan levél, ami megegyezik a szűrőkkel!</h1>
        <h2 class="text-center h4 border-top border-5 text-light">Nézz be később!</h2>
      </div>
    </div>
  </section>
  <section v-else class="p-5">
    <Mail v-for="notification in filteredNotifications" :notification="notification" class="m-5" :isOwner="notification.from.id === userID" @success="handleRead(notification.id)"/>
  </section>
</template>

<style scoped>

</style>