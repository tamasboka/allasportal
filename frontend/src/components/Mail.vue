<script>
export default {
  name: "Mail",
  props: {
    notification: {
      type: Object,
      required: true
    }
  }
}
</script>

<template>
  <div class="bg-dark p-5 mx-5" :class="{'border-block-yellow': !notification.is_read, 'border-block': notification.is_read}">
    <div :class="{'horizontal-green': notification.type === 'accept'}">
      <div class="mx-3">
        <div class="underline-blue">
          <h1 class="h2 fw-bold text-white">{{ notification.from.firstname }} {{ notification.from.lastname }}</h1>
          <h2 class="h6 fw-bold text-secondary">{{ notification.from.email }}</h2>
        </div>
        <div>
          <h2 class="fw-bold text-white">{{ notification.title }}</h2>
          <p class="text-white mt-3">{{ notification.message }}</p>
        </div>
        <button class="btn btn-primary">Megjelölés olvasottnak</button>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>