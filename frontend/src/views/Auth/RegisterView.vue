<script>

export default {
  name: "RegisterView"
}
</script>

<template>
  <section class="mt-3">
    <form>
      <div class="row">
        <div class="col-12 col-lg-6">
          <input class="form-control" type="text" placeholder="Vezetéknév">
        </div>
        <div class="col-12 col-lg-6">
          <input class="form-control" type="text" placeholder="Keresztnév">
        </div>
      </div>
      <input class="mt-3 form-control" type="email" placeholder="Email">
      <input class="mt-3 form-control" type="password" placeholder="Jelszó">
      <input class="mt-3 form-control" type="password" placeholder="Jelszó megerősítése">
      <input class="mt-3 form-control" type="tel" placeholder="Telefonszám">
      <select class="mt-3 form-select">
        <option selected hidden="hidden">Neme</option>
        <option>Nő</option>
        <option>Férfi</option>
        <option>Nem adom meg</option>
      </select>
      <div class="d-flex justify-content-center">
        <button class="mt-3 btn btn-success" type="submit">Regisztrálás</button>
      </div>
    </form>
  </section>
</template>

<style scoped>

</style>