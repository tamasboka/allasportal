<script>
import {Field, Form} from "vee-validate";
import EditJobSkills from "@/components/EditJobSkills.vue";
import EditCategoriesForm from "@/components/EditCategoriesForm.vue";
import {http} from "@/utils/http.js";

export default {
  name: "EditJobForm",
  components: {EditCategoriesForm, EditJobSkills, Field, Form},
  data() {
    return {
      job_type: '',
      has_home_office: false
    }
  },
  props: {
    job: {
      type: Object,
      required: true
    }
  },
  methods: {
    async editJob(data) {
      try {
        await http.patch(`/api/jobs/${this.job.id}`, {...data, has_home_office: this.has_home_office, type: this.job_type}, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`
          }
        })
        this.$router.go()
      } catch (e) {
        console.log(e)
      }
    }
  }
}
</script>

<template>
  <div class="row">
    <div class="col-12 col-lg-4 col-md-12 col-sm-12 mt-5">
      <h1 class="border-bottom border-4 border-primary text-center mb-4 fw-bold">Alap adatok</h1>
      <Form @submit="editJob">
        <div class="d-flex align-items-center">
          <label for="name" class="form-label me-2">
            Név
          </label>
          <Field name="name" id="name" :value="job.name" class="form-control"/>
        </div>
        <div class="d-flex align-items-center">
          <label for="type" class="form-label me-2">
            Típus
          </label>
          <select v-model="job_type" id="type" name="type" class="mt-3 form-select">
            <option value="full-time">Teljes munka</option>
            <option value="part-time">Részmunka</option>
            <option value="one-time">Egyszeri munka</option>
          </select>
        </div>
        <div class="d-flex align-items-center">
          <label for="min_salary" class="form-label me-2">
            Minimun fizetés
          </label>
          <Field name="min_salary" id="min_salary" type="number" :value="job.min_salary" class="form-control"/>
        </div>
        <div class="d-flex align-items-center">
          <label for="max_salary" class="form-label me-2">
            Maximum fizetés
          </label>
          <Field name="max_salary" id="max_salary" type="number" :value="job.max_salary" class="form-control"/>
        </div>
        <div class="d-flex align-items-center">
          <label for="location" class="form-label me-2">
            Hely (Nem kötelező)
          </label>
          <Field name="location" id="location" :value="job.location" class="form-control"/>
        </div>
        <div class="d-flex align-items-center">
          <label for="capacity" class="form-label me-2">
            Férőhely
          </label>
          <Field name="capacity" id="capacity" :value="job.capacity" class="form-control"/>
        </div>
        <div class="d-flex align-items-center mt-3">
          <label for="description" class="form-label me-2">
            Leírás
          </label>
          <Field name="description" id="description" as="textarea" :value="job.description" class="form-control"/>
        </div>
        <div class="d-flex align-items-center">
          <label for="has_home_office" class="form-label me-2">
            Van home office
          </label>
          <input name="has_home_office" id="has_home_office" type="checkbox" v-model="has_home_office" :value="job.has_home_office"
                 class="form-check"/>
        </div>
        <div class="d-flex justify-content-center">
          <input type="submit" class="btn btn-warning mt-3" value="Mentés">
        </div>
      </Form>
    </div>
    <div class="col-12 col-lg-4 col-md-12 col-sm-12 mt-5">
      <EditJobSkills :job_id="job.id" :skills="job.skills"/>
    </div>
    <div class="col-12 col-lg-4 col-md-12 col-sm-12 mt-5">
      <EditCategoriesForm :job_id="job.id" :categories="job.categories"/>
    </div>
  </div>
</template>

<style scoped>

</style>