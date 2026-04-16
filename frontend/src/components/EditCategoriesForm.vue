<script>
import {getAllCategories} from "@/data/data.js";
import {http} from "@/utils/http.js";

export default {
  name: "EditCategoriesForm",
  data() {
    return {
      allCategories: [],
      categoriesLoading: false,
      categoryID: 0
    }
  },
  props: {
    categories: {
      type: Array,
      required: true
    },
    job_id: {
      type: Number,
      required: true
    }
  },
  methods: {
    async getAllCategories() {
      this.categoriesLoading = true
      try {
        const res = await getAllCategories()
        this.allCategories = res.data.data
      } catch (e) {
        console.log(e.message)
      } finally {
        this.categoriesLoading = false
      }
    },
    async addCategory() {
      try {
        await http.post('/api/addcategory', {
          job_id: this.job_id,
          category_id: this.categoryID
        }, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`
          }
        })
        await this.getAllCategories()
      } catch (e) {
        console.log(e)
      }
      this.$router.go()
    }
  },
  mounted() {
    this.getAllCategories()
  }
}
</script>

<template>
  <h1 class="bg-warning text-center">Kategóriák</h1>
  <h2 v-if="!categories.length">Nincsenek hozzáadott kategóriák!</h2>
  <table class="table table-striped" v-else>
    <thead>
    <tr>
      <th>Név</th>
      <th>Törlés</th>
    </tr>
    </thead>
    <tbody>
    <tr v-for="category in categories">
      <td>{{ category.name }}</td>
      <td><button class="btn btn-danger"><i class="bi bi-trash3-fill"></i></button></td>
    </tr>
    </tbody>
  </table>
  <div class="row">
    <div class="col-12 col-lg-4 col-md-12 col-sm-12">
      <p class="me-5">Új kategória</p>
    </div>
    <div class="col-12 col-lg-4 col-md-12 col-sm-12">
      <select v-if="!categoriesLoading" v-model="categoryID" class="form-select">
        <option :value="category.id" v-for="category in allCategories">{{ category.name }}</option>
      </select>
    </div>
    <div class="col-12 col-lg-4 col-md-12 col-sm-12">
      <button class="btn btn-success" @click="addCategory">Hozzáadás</button>
    </div>
  </div>
</template>

<style scoped>

</style>