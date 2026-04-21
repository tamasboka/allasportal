<script>
import {Form, ErrorMessage, Field} from "vee-validate";
import {http} from "@/utils/http.js";
export default {
  name: "NewJobForm",
  components: {Form, ErrorMessage, Field},
  data() {
    return {
      has_home_office: false,
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
      ],
      currency: 'HUF'
    }
  },
  methods: {
    async Create(data) {
      try {
        console.log({...data, has_home_office: this.has_home_office})
        const res = await http.post('/api/jobs', {
          ...data,
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
    <h1 class="text-center mb-4 underline-gray">Új munka</h1>
    <Form @submit="Create">
      <ErrorMessage class="alert alert-danger text-center" name="name" as="p"/>
      <ErrorMessage class="alert alert-danger text-center" name="type" as="p"/>
      <ErrorMessage class="alert alert-danger text-center" name="min_salary" as="p"/>
      <ErrorMessage class="alert alert-danger text-center" name="max_salary" as="p"/>
      <ErrorMessage class="alert alert-danger text-center" name="capacity" as="p"/>
      <ErrorMessage class="alert alert-danger text-center" name="description" as="p"/>
      <div class="input-group">
        <span class="input-group-text">Név</span>
        <Field name="name" id="name" class="form-control" rules="required|min:3|max:100"/>
      </div>
      <div class="input-group mt-3">
        <span class="input-group-text">Típus</span>
        <Field name="type" as="select" class="form-select" rules="required">
          <option value="full-time">Teljes munka</option>
          <option value="part-time">Részmunka</option>
          <option value="one-time">Egyszeri munka</option>
        </Field>
      </div>
      <div class="input-group mt-3">
        <span class="input-group-text">Minimum fizetés</span>
        <Field name="min_salary" class="form-control" type="number"
               rules="required|min:1"/>
        <Field as="select" class="input-group-text" v-model="currency" name="currency" id="currency-select">
          <option v-for="currency in currencies" :value="currency.code">{{ currency.code }} ({{
              currency.symbol
            }})
          </option>
        </Field>
      </div>
      <div class="input-group mt-3">
        <span class="input-group-text">Maximum fizetés</span>
        <Field name="max_salary" id="max_salary" type="number" class="form-control" rules="required|min:1"/>
        <Field as="select" class="input-group-text" v-model="currency" name="currency" id="currency-select">
          <option v-for="currency in currencies" :value="currency.code">{{ currency.code }} ({{
              currency.symbol
            }})
          </option>
        </Field>
      </div>
      <div class="input-group mt-3">
        <span class="input-group-text">Hely (Nem kötelező)</span>
        <Field name="location" id="location" class="form-control"/>
      </div>
      <div class="input-group mt-3">
        <span class="input-group-text">Férőhely</span>
        <Field name="capacity" id="capacity" class="form-control" type="number" rules="required|min:1"/>
        <span class="input-group-text">Fő</span>
      </div>
      <div class="input-group mt-3">
        <span class="input-group-text">Leírás</span>
        <Field name="description" id="description" as="textarea" class="form-control" rules="required|min:3|max:500"/>
      </div>
      <div class="d-flex align-items-center">
        <label for="has_home_office" class="form-label me-2">
          Van home office
        </label>
        <Field name="has_home_office" id="has_home_office" type="checkbox" v-model="has_home_office"
               class="form-check"/>
      </div>
      <div class="d-flex justify-content-center">
        <input type="submit" class="btn btn-warning mt-3" value="Mentés">
      </div>
    </Form>
  </section>
</template>

<style scoped>

</style>