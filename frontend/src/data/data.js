import {http} from '@/utils/http.js'
export async function getAllJobs(){
    return await http.get('/api/jobs')
}

export async function getJobById(id){
    return await  http.get('/api/jobs/'+id)
}

export async function getAllUsers(){
    return await http.get('/api/user',{
        headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`
        }
    })
}

export async function getAllCategories(){
    return await http.get('/api/categories')
}

export async function getAllSkills(){
    return await http.get('/api/skills')
}