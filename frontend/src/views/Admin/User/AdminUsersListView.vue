<script>
import {getAllUsers} from "@/data/data.js";
import {http} from "@/utils/http.js";
import Spinner from "@/components/Spinner.vue";

export default {
  name: "AdminUsersListView",
  components: {Spinner},
  data() {
    return {
      loading: false,
      users: [],
    }
  },
  methods: {
    async GetAllUsers() {
      this.loading = true;
      try {
        const result = await getAllUsers();
        this.users = result.data.data;
      } catch (error) {
        this.error = error.message
      } finally {
        this.loading = false
      }
    },
    async DeleteUser(id) {
      try {
        await http.delete(`/api/user/${id}`, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`
          }
        });
      }catch (e){
        console.log(e.message)
      }
      await this.GetAllUsers();
    }
  },
  mounted() {
    this.GetAllUsers();
  }
}
</script>

<template>
  <section v-if="loading" class="min-vh-100 d-flex justify-content-center align-items-center">
    <spinner/>
  </section>
  <section v-else-if="!loading" class="d-flex justify-content-center">
    <table class="table table-striped table-dark">
      <thead>
      <tr>
        <th>Név</th>
        <th>Email</th>
        <th>Részletek</th>
        <th>Törlés</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="user in users">
        <td>{{user.firstname}} {{user.lastname}}</td>
        <td>{{user.email}}</td>
        <td>
          <RouterLink :to="{name:'admin-user',params:{userID: user.id}}"><i class="bi bi-info-circle-fill"></i>
          </RouterLink>
        </td>
        <td><button class="btn btn-danger" @click="DeleteUser(user.id)"><i class="bi bi-trash3-fill"></i></button></td>
      </tr>
      </tbody>
    </table>
  </section>
</template>

<style scoped>

</style>