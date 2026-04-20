<script>
import {getAllSkills} from "@/data/data.js";
import {http} from "@/utils/http.js";

export default {
  name: "EditJobSkills",
  data() {
    return {
      allSkills: [],
      skillsLoading: false,
      skillId: 0,
    }
  },
  props: {
    skills: {
      type: Array,
      required: true
    },
    job_id: {
      type: Number,
      required: true
    }
  },
  methods: {
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
    async addSkill() {
      if (this.skills.find(skill => this.skillId === skill.id)) return
      try {
        await http.post('/api/addjobskill', {
          job_id: this.job_id,
          skill_id: this.skillId
        }, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`
          }
        })
        await this.getAllSkills()
      } catch (e) {
        console.log(e)
      }
      this.skills.push({
        id: this.skillId,
        name: this.allSkills.find(skill => skill.id === this.skillId).name
      })
    },
    async removeSkill(skill_id) {
      try {
        await http.delete(`/api/jobs/${this.job_id}/skill/${skill_id}`, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`
          }
        })
      } catch (e) {
        console.log(e.message)
      }
      this.skills.splice(this.skills.findIndex(skill => skill.id === skill_id), 1)
    }
  },
  mounted() {
    this.getAllSkills()
  }
}
</script>

<template>
  <h1 class="border-bottom border-4 border-secondary text-center mb-4 fw-bold">Skillek</h1>
  <div class="input-group mb-3">
    <span class="input-group-text">Új skill</span>
    <select v-if="!skillsLoading" v-model="skillId" class="form-select">
      <option :value="skill.id" v-for="skill in allSkills">{{ skill.name }}</option>
    </select>
    <button class="btn btn-success" @click="addSkill">Hozzáadás</button>
  </div>
  <h2 v-if="!skills.length" class="text-danger fw-bold border-top border-5 border-danger border-bottom">Nincsenek hozzáadott skillek!</h2>
  <table class="table table-striped" v-else>
    <thead>
    <tr>
      <th>Név</th>
      <th>Törlés</th>
    </tr>
    </thead>
    <tbody>
    <tr v-for="skill in skills">
      <td>{{ skill.name }}</td>
      <td>
        <button class="btn btn-danger" @click="removeSkill(skill.id)"><i class="bi bi-trash3-fill"></i></button>
      </td>
    </tr>
    </tbody>
  </table>

</template>

<style scoped>

</style>