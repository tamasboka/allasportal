import axios from 'axios';

export const http = axios.create({
    baseURL: '127.0.0.1:8000',
    headers: {
        "Content-Type":"application/json"
    }
});