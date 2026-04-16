<script>
import {Form, ErrorMessage, Field} from "vee-validate";
import {http} from "@/utils/http.js";
export default {
  name: "NewJobForm",
  components: {Form, ErrorMessage, Field},
  data() {
    return {
      job_type: '',
      has_home_office: false
    }
  },
  methods: {
    async Create(data) {
      try {
        console.log({...data, type: this.job_type, has_home_office: this.has_home_office})
        const res = await http.post('/api/jobs', {
          ...data,
          type: this.job_type,
          has_home_office: this.has_home_office
        }, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`
          }
        })
        console.log(res)
        console.log(res.data.data.id)
        this.$router.push({name: 'edit-job', params: {
            jobID: res.data.data.id
          }})
      } catch (e) {
        console.log(e.message)
      }
    },
    async getCategories() {
      this.categoriesLoading = true;
      try {
        const result = await getAllCategories();
        console.log(result)
        this.categories = result.data.data;
      } catch (e) {
        console.log(e.message)
      } finally {
        this.categoriesLoading = false;
      }
    },
    async getSkills() {
      this.skillsLoading = true;
      try {
        const result = await getAllSkills();
        this.skills = result.data.data;
      } catch (e) {
        console.log(e.message)
      } finally {
        this.skillsLoading = false;
      }
    }
  },
  mounted() {
    this.getCategories();
    this.getSkills();
  }
}
</script>

<template>
  <section class="mt-3">
    <h1 class="text-center mb-4">Új munka</h1>
    <Form @submit="Create">
      <Field name="name" class="mt-3 form-control" type="text" placeholder="Munka neve"/>
      <select v-model="job_type" name="type" class="mt-3 form-select">
        <option selected hidden="hidden">Típus</option>
        <option value="full-time">Teljes munka</option>
        <option value="part-time">Részmunka</option>
        <option value="one-time">Egyszeri munka</option>
      </select>
      <Field name="min_salary" class="form-control mt-3" type="number" placeholder="Minimum fizetés"/>
      <Field name="max_salary" class="form-control mt-3" type="number" placeholder="Maximum fizetés"/>
      <Field name="location" class="form-control mt-3" type="text" placeholder="Hely (nem kötelező)"/>
      <Field name="capacity" class="mt-3 form-control" type="number" placeholder="Férőhely"/>
      <Field as="textarea" name="description" class="mt-3 form-control" placeholder="Leírás"/>

      <div class="d-flex">
        <label class="mt-3 me-2" for="has_home_office">Lehet dolgozni home office-ban</label>
        <input v-model="has_home_office" class="mt-3 form-check" name="has_home_office" id="has_home_office" type="checkbox"/>
      </div>
      <div class="d-flex justify-content-center">
        <button class="mt-3 btn btn-warning" type="submit">Feltöltés</button>
      </div>
    </Form>
  </section>
</template>

<style scoped>

</style>