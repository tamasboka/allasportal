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
import AdminLayout from "@/layouts/AdminLayout.vue";
import AdminHome from "@/views/Admin/AdminHome.vue";
import AdminCompaniesView from "@/views/Admin/Company/AdminCompaniesView.vue";
import AdminCompanyActions from "@/views/Admin/Company/AdminCompanyActions.vue";
import AdminJobsView from "@/views/Admin/Jobs/AdminJobsView.vue";
import AdminJobActions from "@/views/Admin/Jobs/AdminJobActions.vue";
import AdminUsersListView from "@/views/Admin/User/AdminUsersListView.vue";
import AdminUserActions from "@/views/Admin/User/AdminUserActions.vue";
import UserLayout from "@/layouts/UserLayout.vue";
import UserHomeView from "@/views/UserHomeView.vue";
import UserSettings from "@/views/User/Actions/UserSettings.vue";
import CreateJob from "@/views/User/Actions/CreateJob.vue";

const routes = [
    // APP
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
    // AUTH
    {
        path: 'auth',
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
    },
    // ADMIN
    {
        path: 'admin',
        component: AdminLayout,
        children: [
            {
                path: '',
                component: AdminHome,
                name: 'admin-home',
                meta: {
                    title: 'Admin Home'
                }
            },
            {
                path: 'companies',
                children: [
                    {
                        path: '',
                        component: AdminCompaniesView,
                        name: 'admin-companies',
                        meta: {
                            title: 'Admin - Companies'
                        }
                    },
                    {
                        path: ':companyID',
                        component: AdminCompanyActions,
                        name: 'admin-company',
                        meta: {
                            title: 'Admin - Company Actions'
                        }
                    }
                ]
            },
            {
                path: 'jobs',
                children: [
                    {
                        path: '',
                        component: AdminJobsView,
                        name: 'admin-jobs',
                        meta: {
                            title: 'Admin - Jobs'
                        }
                    },
                    {
                        path: 'jobID',
                        component: AdminJobActions,
                        name: ':admin-job',
                        meta: {
                            title: 'Admin - Job Actions'
                        }
                    }
                ]
            },
            {
                path: 'users',
                children: [
                    {
                        path: '',
                        component: AdminUsersListView,
                        name: 'admin-users',
                        meta: {
                            title: 'Admin - Users'
                        }
                    },
                    {
                        path: ':userID',
                        component: AdminUserActions,
                        name: 'admin-user',
                        meta: {
                            title: 'Admin - User Actions'
                        }
                    }
                ]
            }
        ]
    },
    // USER
    {
        path: '/user',
        component: UserLayout,
        children: [
            {
                path: ':userID',
                component: UserHomeView,
                name: 'user-home',
                meta: {
                    title: ''
                }
            },
            {
                path: 'settings',
                component: UserSettings,
                name: 'user-settings',
                meta: {
                    title: 'Settings'
                }
            },
            {
                path: 'action',
                children: [
                    {
                        path: 'create-job',
                        component: CreateJob,
                        name: 'create-job',
                        meta: {
                            title: 'Create Job'
                        }
                    },
                    {
                        path: 'edit-job',
                        component: CreateJob,
                        name: 'edit-job',
                        meta: {
                            title: 'Edit Job'
                        }
                    }
                ]
            }
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
