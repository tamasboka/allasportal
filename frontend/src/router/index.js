import {createRouter, createWebHistory} from 'vue-router'
import AppLayout from "@/layouts/AppLayout.vue";
import HomeView from "@/views/App/HomeView.vue";
import JobsView from "@/views/App/Jobs/JobsView.vue";
import CompaniesView from "@/views/App/Companies/CompaniesView.vue";
import AuthLayout from "@/layouts/AuthLayout.vue";
import RegisterView from "@/views/Auth/RegisterView.vue";
import LoginView from "@/views/Auth/LoginView.vue";
import JobView from "@/views/App/Jobs/JobView.vue";
import CompanyView from "@/views/App/Companies/CompanyView.vue";

const routes = [
    {
        path: '/',
        component: AppLayout,
        children: [
            {
                path: '',
                component: HomeView,
                name: 'home',
                meta: {
                    title: 'Főoldal',
                }
            },
            {
                path: 'jobs',
                children: [
                    {
                        path: '',
                        component: JobsView,
                        name: 'jobs',
                        meta: {
                            title: 'Állások'
                        }
                    },
                    {
                        path: ':jobID',
                        component: JobView,
                        name: 'job',
                    }
                ]
            },
            {
                path: 'companies',
                children: [
                    {
                        path: '',
                        component: CompaniesView,
                        name: 'companies',
                        meta: {
                            title: 'Cégek'
                        }
                    },
                    {
                        path: ':companyID',
                        component: CompanyView,
                        name: 'company',
                    }
                ]
            },
        ]
    },
    {
        path: '/auth',
        component: AuthLayout,
        children: [
            {
                path: 'register',
                component: RegisterView,
                name: 'register',
                meta: {
                    title: 'Regisztráció'
                }
            },
            {
                path: 'login',
                component: LoginView,
                name: 'login',
                meta: {
                    title: 'Bejelentkezés'
                }
            },
        ]
    }
];

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes,
})
router.beforeEach((to, from, next) => {
    document.title = to.meta.title
    next()
})
export default router
