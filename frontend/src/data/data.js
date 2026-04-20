import {http} from '@/utils/http.js'

export async function getAllJobs() {
    return await http.get('/api/jobs')
}

export async function getJobById(id) {
    return await http.get('/api/jobs/' + id)
}

export async function getAllUsers() {
    return await http.get('/api/user', {
        headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`
        }
    })
}

export async function getAllCategories() {
    return await http.get('/api/categories')
}

export async function getAllSkills() {
    return await http.get('/api/skills')
}

export async function getUserById(id) {
    return await http.get('/api/user/' + id)
}

export async function getSavedJobs() {
    return await http.get('/api/savedjobs', {
        headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`
        }
    })
}

export async function getApplications(jobID) {
    return await http.get(`/api/job/${jobID}/applications`, {
        headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`
        }
    })
}

export async function getAllRatings(){
    return await http.get('/api/ratings',{
        headers:{
            Authorization: `Bearer ${localStorage.getItem('token')}`
        }
    })
}

export async function getUserData(){
    return await http.get('/api/me',{
        headers:{
            Authorization:`Bearer ${localStorage.getItem('token')}`
        }
    })
}