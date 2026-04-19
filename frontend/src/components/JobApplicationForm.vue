<script>
import {Form,Field,ErrorMessage} from "vee-validate";
import {http} from "@/utils/http.js";

export default {
  name: "JobApplicationForm",
  components: {Field, Form, ErrorMessage},
  props:{
    jobID:{
      type:Number,
      required:true
    },
    userID:{
      type:Number,
      required:true
    }
  },
  methods:{
    async Send(data){
      try{
        await http.post('/api/applications',{
          user_id:this.userID,
          job_id: this.jobID,
          ...data
        })
      }catch (e){
        console.log(e.message)
      }
    }
  }
}
</script>

<template>
<section>
<Form @submit="Send" class="my-2">
<Field as="textarea" name="message" class="form-control"/>
  <input type="submit" class="btn btn-primary my-2" value="Küldés">
</Form>
</section>
</template>

<style scoped>

</style>