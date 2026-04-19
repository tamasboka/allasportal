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
      if (this.categories.find(cat => this.categoryID === cat.id)) return
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
      this.categories.push({
        id: this.categoryID,
        name: this.allCategories.find(cat => cat.id === this.categoryID).name
      })
    },
    async removeCategory(cat_id) {
      try {
        await http.delete(`/api/jobs/${this.job_id}/category/${cat_id}`, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`
          }
        })
      } catch (e) {
        console.log(e.message)
      }
      this.categories.splice(this.categories.findIndex(cat => cat.id === cat_id), 1)
    }
  },
  mounted() {
    this.getAllCategories()
  }
}
</script>

<template>
  <h1 class="border-bottom border-4 border-warning text-center fw-bold mb-4">Kategóriák</h1>
  <div class="input-group mb-3">
    <span class="input-group-text">Új kategória</span>
    <select v-if="!categoriesLoading" v-model="categoryID" class="form-select">
      <option :value="category.id" v-for="category in allCategories">{{ category.name }}</option>
    </select>
    <button class="btn btn-success" @click="addCategory">Hozzáadás</button>
  </div>
  <h2 v-if="!categories.length" class="text-danger fw-bold border-top border-5 border-danger border-bottom">Nincsenek
    hozzáadott kategóriák!</h2>
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
      <td>
        <button class="btn btn-danger" @click="removeCategory(category.id)"><i class="bi bi-trash3-fill"></i></button>
      </td>
    </tr>
    </tbody>
  </table>

</template>

<style scoped>

</style>