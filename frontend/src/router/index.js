import { createRouter, createWebHistory } from 'vue-router'
import AppLayout from "@/layouts/AppLayout.vue";
import HomeView from "@/views/App/HomeView.vue";
import JobsView from "@/views/App/JobsView.vue";
import CompaniesView from "@/views/App/CompaniesView.vue";
import AuthLayout from "@/layouts/AuthLayout.vue";
import RegisterView from "@/views/Auth/RegisterView.vue";
import LoginView from "@/views/Auth/LoginView.vue";

const routes=[
    {
        path:'/',
        component: AppLayout,
        children: [
            {
                path:'',
                component: HomeView,
                name: 'home',
                meta:{
                    title: 'Főoldal',
                }
            },
            {
                path: 'jobs',
                component: JobsView,
                name: 'jobs'
            },
            {
                path: 'companies',
                component: CompaniesView,
                name: 'companies'
            },
        ]
    },
    {
        path:'/auth',
        component: AuthLayout,
        children: [
            {
                path:'register',
                component: RegisterView,
                name: 'register'
            },
            {
                path:'login',
                component: LoginView,
                name: 'login'
            },
        ]
    }
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
})

export default router
