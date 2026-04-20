<script>
import {Form,Field,ErrorMessage} from "vee-validate";
import Spinner from "@/components/Spinner.vue";
import {getAllCategories} from "@/data/data.js";
import {http} from "@/utils/http.js";

export default {
  name: "AdminCategoriesView",
  components: {Spinner,Form,Field,ErrorMessage},
  data() {
    return {
      loading: false,
      categories: [],
      error:''
    }
  },
  methods:{
    async GetAllCategories() {
      this.loading = true;
      try {
        const result = await getAllCategories();
        this.categories = result.data.data;
      } catch (error) {
        this.error = error.message
      } finally {
        this.loading = false
      }
    },
    async DeleteCategory(id){
      try{
        await http.delete(`/api/categories/${id}`,{
          headers:{
            Authorization:`Bearer ${localStorage.getItem('token')}`
          }
        })
      }catch (e){
        console.log(e.message)
      }
      await this.GetAllCategories();
    },
    async CreateCategory(data){
      try{
        await http.post(`/api/categories`,data,{
          headers:{
            Authorization:`Bearer ${localStorage.getItem('token')}`
          }
        })
      }catch (e){
        console.log(e.message)
      }
      await this.GetAllCategories();
    }
  },
  mounted() {
    this.GetAllCategories();
  }
}
</script>

<template>
  <section v-if="loading" class="min-vh-100 d-flex justify-content-center align-items-center">
    <spinner/>
  </section>
  <section v-else-if="!loading">
    <Form @submit="CreateCategory">
      <div class="input-group">
        <span class="input-group-text">Név:</span>
        <Field name="name" class="form-control" rules="required"/>
        <button type="submit" class="btn btn-primary">Küldés</button>
      </div>
    </Form>
    <table class="table table-striped table-dark">
      <thead>
      <tr>
        <th>Azonosító</th>
        <th>Név</th>
        <th>Törlés</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="category in categories">
        <td>{{category.id}}</td>
        <td>{{category.name}}</td>
        <td><button class="btn btn-danger" @click="DeleteCategory(category.id)"><i class="bi bi-trash-fill"></i></button></td>
      </tr>
      </tbody>
    </table>
  </section>
</template>

<style scoped>

</style>