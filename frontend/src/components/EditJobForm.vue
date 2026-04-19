<script>
import {ErrorMessage, Field, Form} from "vee-validate";
import EditJobSkills from "@/components/EditJobSkills.vue";
import EditCategoriesForm from "@/components/EditCategoriesForm.vue";
import {http} from "@/utils/http.js";

export default {
  name: "EditJobForm",
  components: {ErrorMessage, EditCategoriesForm, EditJobSkills, Field, Form},
  data() {
    return {
      job_type: '',
      has_home_office: false,
      currency: this.job.currency,
      successful: false,
      currencies: [
        {
          code: 'EUR',
          symbol: '€'
        },
        {
          code: 'HUF',
          symbol: 'Ft'
        },
        {
          code: 'USD',
          symbol: '$'
        },
        {
          code: 'GBP',
          symbol: '£'
        },
        {
          code: 'CHF',
          symbol: 'Fr'
        },
        {
          code: 'CAD',
          symbol: '$'
        },
        {
          code: 'AUD',
          symbol: '$'
        },
        {
          code: 'RON',
          symbol: 'lei'
        },
      ]
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
      console.log(data)
      try {
        await http.patch(`/api/jobs/${this.job.id}`, {
          ...data,
          has_home_office: this.has_home_office,
        }, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`
          }
        })
        this.successful = true
      } catch (e) {
        console.log(e)
        this.successful = false
      }
    }
  }
}
</script>

<template>
  <div class="row">
    <div class="col-12 col-lg-4 col-md-12 col-sm-12 mt-5">
      <h1 class="border-bottom border-4 border-primary text-center mb-4 fw-bold">Alap adatok</h1>
      <Form @submit="editJob" @input="successful = false">
        <p class="alert alert-success text-center" v-if="successful">Sikeres mentés!</p>
        <ErrorMessage class="alert alert-danger text-center" name="name" as="p"/>
        <ErrorMessage class="alert alert-danger text-center" name="type" as="p"/>
        <ErrorMessage class="alert alert-danger text-center" name="min_salary" as="p"/>
        <ErrorMessage class="alert alert-danger text-center" name="max_salary" as="p"/>
        <ErrorMessage class="alert alert-danger text-center" name="capacity" as="p"/>
        <ErrorMessage class="alert alert-danger text-center" name="description" as="p"/>
        <div class="input-group">
          <span class="input-group-text">Név</span>
          <Field name="name" id="name" :value="job.name" class="form-control" rules="required|min:3|max:100"/>
        </div>
        <div class="input-group mt-3">
          <span class="input-group-text">Típus</span>
          <Field name="type" as="select" class="form-select" :value="job.type" rules="required">
            <option value="full-time">Teljes munka</option>
            <option value="part-time">Részmunka</option>
            <option value="one-time">Egyszeri munka</option>
          </Field>
        </div>
        <div class="input-group mt-3">
          <span class="input-group-text">Minimum fizetés</span>
          <Field name="min_salary" class="form-control" type="number" placeholder="Minimum fizetés"
                 rules="required|min:1" :value="job.min_salary"/>
          <Field as="select" class="input-group-text" v-model="currency" name="currency" id="currency-select">
            <option v-for="currency in currencies" :value="currency.code">{{ currency.code }} ({{
                currency.symbol
              }})
            </option>
          </Field>
        </div>
        <div class="input-group mt-3">
          <span class="input-group-text">Maximum fizetés</span>
          <Field name="max_salary" id="max_salary" type="number" :value="job.max_salary" class="form-control" rules="required|min:1"/>
          <Field as="select" class="input-group-text" v-model="currency" name="currency" id="currency-select">
            <option v-for="currency in currencies" :value="currency.code">{{ currency.code }} ({{
                currency.symbol
              }})
            </option>
          </Field>
        </div>
        <div class="input-group mt-3">
          <span class="input-group-text">Hely (Nem kötelező)</span>
          <Field name="location" id="location" :value="job.location" class="form-control"/>
        </div>
        <div class="input-group mt-3">
          <span class="input-group-text">Férőhely</span>
          <Field name="capacity" id="capacity" :value="job.capacity" class="form-control" type="number" rules="required|min:1"/>
        </div>
        <div class="input-group mt-3">
          <span class="input-group-text">Leírás</span>
          <Field name="description" id="description" as="textarea" :value="job.description" class="form-control" rules="required|min:3|max:500"/>
        </div>
        <div class="d-flex align-items-center">
          <label for="has_home_office" class="form-label me-2">
            Van home office
          </label>
          <Field name="has_home_office" id="has_home_office" type="checkbox" v-model="has_home_office"
                 :value="job.has_home_office"
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