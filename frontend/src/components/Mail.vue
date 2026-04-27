<script>
import {http} from "@/utils/http.js";

export default {
  name: "Mail",
  props: {
    notification: {
      type: Object,
      required: true
    },
    isOwner: {
      type: Boolean,
      required: true
    }
  },
  emits: ['success'],
  methods: {
    async read() {
      try {
        await http.patch(`/api/notifications/${this.notification.id}`, {
          is_read: 1
        }, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`
          }
        })
        this.$emit('success')
      } catch (e) {
        console.log(e.message)
      }
    }
  }
}
</script>

<template>
  <div class="bg-dark p-5 mx-5"
       :class="{'border-block-yellow': !notification.is_read && !isOwner, 'border-block': notification.is_read || isOwner,}">
    <div
        :class="{'horizontal-green': notification.type === 'accept', 'horizontal-red': notification.type === 'reject', 'horizontal-blue': notification.type === 'general', 'horizintal-gray': notification.type === 'system'}">
      <div class="mx-3">
        <div class="underline-blue">
          <h1 class="h2 fw-bold text-white">{{ notification.from.firstname }} {{ notification.from.lastname }}<span
              v-if="isOwner"><i class="bi bi-arrow-right mx-2"></i>{{
              notification.to.firstname
            }} {{ notification.to.lastname }}</span></h1>

          <h2 class="h6 fw-bold text-secondary">{{ notification.from.email }}<span v-if="isOwner"><i
              class="bi bi-arrow-right mx-2"></i>{{ notification.to.email }}</span></h2>
        </div>
        <div>
          <h2 class="fw-bold text-white my-3">{{ notification.title }}</h2>
          <p class="text-white mt-3">{{ notification.message }}</p>
        </div>
        <button class="btn btn-primary" v-if="!notification.is_read && !isOwner" @click="read">Megjelölés olvasottnak
        </button>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>