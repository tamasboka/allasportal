import {http} from '@/utils/http.js'
export async function getAllJobs(){
    return await http.get('/api/jobs')
}