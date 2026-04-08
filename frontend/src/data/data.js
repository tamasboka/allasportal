import {http} from '@/utils/http.js'
export async function getAllJobs(){
    return await http.get('/api/jobs')
}

export async function getJobById(id){
    return await  http.get('/api/jobs/'+id)
}