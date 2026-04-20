<script>
import {Form,Field,ErrorMessage} from "vee-validate";
import Spinner from "@/components/Spinner.vue";
import {getAllSkills} from "@/data/data.js";
import {http} from "@/utils/http.js";

export default {
  name: "AdminSkillsView",
  components: {Spinner,Form,Field,ErrorMessage},
  data() {
    return {
      loading: false,
      skills: [],
      error:''
    }
  },
  methods:{
    async GetAllSkills() {
      this.loading = true;
      try {
        const result = await getAllSkills();
        this.skills = result.data.data;
      } catch (error) {
        this.error = error.message
      } finally {
        this.loading = false
      }
    },
    async DeleteSkill(id){
      try{
        await http.delete(`/api/skills/${id}`,{
          headers:{
            Authorization:`Bearer ${localStorage.getItem('token')}`
          }
        })
      }catch (e){
        console.log(e.message)
      }
      await this.GetAllSkills();
    },
    async CreateSkill(data){
      try{
        await http.post(`/api/skills`,data,{
          headers:{
            Authorization:`Bearer ${localStorage.getItem('token')}`
          }
        })
      }catch (e){
        console.log(e.message)
      }
      await this.GetAllSkills();
    }
  },
  mounted() {
    this.GetAllSkills();
  }
}
</script>

<template>
  <section v-if="loading" class="min-vh-100 d-flex justify-content-center align-items-center">
    <spinner/>
  </section>
  <section v-else-if="!loading" class="p-5 mb-0">
    <Form @submit="CreateSkill" class="mb-5">
      <div class="input-group">
        <span class="input-group-text">Új készség neve</span>
        <Field name="name" class="form-control" rules="required"/>
        <button type="submit" class="btn btn-primary">Létrehozás</button>
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
      <tr v-for="skill in skills">
        <td>{{skill.id}}</td>
        <td>{{skill.name}}</td>
        <td><button class="btn btn-danger" @click="DeleteSkill(skill.id)"><i class="bi bi-trash-fill"></i></button></td>
      </tr>
      </tbody>
    </table>
  </section>
</template>

<style scoped>

</style>