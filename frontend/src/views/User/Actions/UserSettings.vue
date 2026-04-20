<script>
import {Field, Form} from "vee-validate";
import {http} from "@/utils/http.js";
import {getAllSkills} from "@/data/data.js";

export default {
  name: "UserSettings",
  components: {Field, Form},
  data() {
    return {
      user: this.$route.meta.prefetched,
      allSkills: [],
      loading: false,
      skillID: 0
    }
  },
  methods:{
    async UpdateUser(data){
      try{
        await http.patch(`/api/user/${this.user.id}`,data,{
          headers:{
            Authorization:`Bearer ${localStorage.getItem('token')}`
          }
        })
        this.$router.go();
      }catch (e){
        console.log(e.message)
      }
    },
    async addSkill() {
      if (this.user.skills.find(skill => this.skillID === skill.id)) return
      try {
        await http.post('/api/adduserskill', {
          skill_id: this.skillID
        }, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`
          }
        })
        await this.getAllSkills()
      } catch (e) {
        console.log(e)
      }
      this.user.skills.push({
        id: this.skillID,
        name: this.allSkills.find(skill => skill.id === this.skillID).name
      })
    },
    async removeSkill(skill_id) {
      try {
        await http.delete(`/api/user/${this.user.id}/skill/${skill_id}`, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`
          }
        })
      } catch (e) {
        console.log(e.message)
      }
      this.user.skills.splice(this.user.skills.findIndex(skill => skill.id === skill_id), 1)
    },
    async getAllSkills() {
      this.skillsLoading = true
      try {
        const res = await getAllSkills()
        this.allSkills = res.data.data
      } catch (e) {
        console.log(e.message)
      } finally {
        this.skillsLoading = false
      }
    },
  },
  mounted() {
    this.getAllSkills()
  }
}
</script>

<template>
  <section>
    <div class="container">
      <div class="row">
        <div class="col-12 col-lg-6 col-md-12 col-sm-12 d-flex min-vh-100 align-items-center">
          <div class="border border-5 border-secondary rounded-5 p-3">
            <Form @submit="UpdateUser">
              <div class="border-5 border-bottom mb-4">
                <h1 class="text-center fw-bold">Fiók adatok</h1>
              </div>
              <div class="input-group">
                <span class="input-group-text">Keresztnév</span>
                <Field name="firstname" class="form-control me-3" :value="user.firstname"/>
                <span class="input-group-text">Vezetéknév</span>
                <Field name="lastname" class="form-control" :value="user.lastname"/>
              </div>
              <div class="input-group mt-2">
                <span class="input-group-text">Telefonszám</span>
                <Field name="phone" class="form-control" :value="user.phone"/>
              </div>
              <div class="input-group mt-2">
                <span class="input-group-text">E-mail</span>
                <Field name="email" class="form-control" :value="user.email"/>
              </div>
              <div class="input-group mt-2">
                <span class="input-group-text">Új jelszó</span>
                <Field name="password" class="form-control"/>
              </div>
              <div class="input-group mt-2">
                <span class="input-group-text">Profil leírás</span>
                <Field name="bio" as="textarea" class="form-control"/>
              </div>
              <div class="d-flex justify-content-center">
                <button class="btn btn-primary mt-2">Mentés</button>
              </div>
            </Form>
          </div>
        </div>
        <aside class="col-12 col-lg-6 col-md-12 col-sm-12 text-center p-5">
          <div class="border border-5 border-secondary rounded-5 p-3">
            <div class="border-5 border-bottom mb-4">
              <h1 class="text-center fw-bold">Készségeid</h1>
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text">Új skill</span>
              <select v-if="!loading" v-model="skillID" class="form-select">
                <option :value="skill.id" v-for="skill in allSkills">{{ skill.name }}</option>
              </select>
              <button class="btn btn-success" @click="addSkill">Hozzáadás</button>
            </div>
            <h2 v-if="!user.skills.length" class="text-danger fw-bold border-top border-5 border-danger border-bottom">Nincsenek hozzáadott skillek!</h2>
            <table class="table table-striped" v-else>
              <thead>
              <tr>
                <th>Név</th>
                <th>Törlés</th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="skill in user.skills">
                <td>{{ skill.name }}</td>
                <td>
                  <button class="btn btn-danger" @click="removeSkill(skill.id)"><i class="bi bi-trash3-fill"></i></button>
                </td>
              </tr>
              </tbody>
            </table>
          </div>
        </aside>
      </div>
    </div>
  </section>
</template>

<style scoped>

</style>