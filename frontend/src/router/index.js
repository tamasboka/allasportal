import {createRouter, createWebHistory} from 'vue-router'

const routes = [
    // APP
    // Nem kell auth
    {
        path: '/',
        component: () => import("@/layouts/AppLayout.vue"),
        children: [
            {
                path: '',
                component: () => import("@/views/App/HomeView.vue"),
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
                        component: () => import("@/views/App/Jobs/JobsView.vue"),
                        name: 'jobs',
                        meta: {
                            title: 'Állások'
                        }
                    },
                    {
                        path: ':jobID',
                        component: () => import("@/views/App/Jobs/JobView.vue"),
                        name: 'job',
                    }
                ]
            },
            {
                path: 'companies',
                children: [
                    {
                        path: '',
                        component: () => import("@/views/App/Companies/CompaniesView.vue"),
                        name: 'companies',
                        meta: {
                            title: 'Cégek'
                        }
                    },
                    {
                        path: ':companyID',
                        component: () => import("@/views/App/Companies/CompanyView.vue"),
                        name: 'company',
                    }
                ]
            },

        ]
    },
    // AUTH
    // Nem kell auth
    {
        path: '/auth',
        component: () => import("@/layouts/AuthLayout.vue"),
        children: [
            {
                path: 'register',
                component: () => import("@/views/Auth/RegisterView.vue"),
                name: 'register',
                meta: {
                    title: 'Regisztráció'
                }
            },
            {
                path: 'login',
                component: () => import("@/views/Auth/LoginView.vue"),
                name: 'login',
                meta: {
                    title: 'Bejelentkezés'
                }
            },
        ]
    },
    // ADMIN
    // Kell auth
    {
        path: '/admin',
        component: () => import("@/layouts/AdminLayout.vue"),
        children: [
            {
                path: '',
                component: () => import("@/views/Admin/AdminHome.vue"),
                name: 'admin-home',
                meta: {
                    title: 'Admin Home',
                    requiresAuth: true
                }
            },
            {
                path: 'companies',
                children: [
                    {
                        path: '',
                        component: () => import("@/views/Admin/Company/AdminCompaniesView.vue"),
                        name: 'admin-companies',
                        meta: {
                            title: 'Admin - Companies',
                            requiresAuth: true
                        }
                    },
                    {
                        path: ':companyID',
                        component: () => import("@/views/Admin/Company/AdminCompanyActions.vue"),
                        name: 'admin-company',
                        meta: {
                            title: 'Admin - Company Actions',
                            requiresAuth: true
                        }
                    }
                ]
            },
            {
                path: 'jobs',
                children: [
                    {
                        path: '',
                        component: () => import("@/views/Admin/Jobs/AdminJobsView.vue"),
                        name: 'admin-jobs',
                        meta: {
                            title: 'Admin - Jobs',
                            requiresAuth: true
                        }
                    },
                    {
                        path: 'jobID',
                        component: () => import("@/views/Admin/Jobs/AdminJobActions.vue"),
                        name: ':admin-job',
                        meta: {
                            title: 'Admin - Job Actions',
                            requiresAuth: true
                        }
                    }
                ]
            },
            {
                path: 'users',
                children: [
                    {
                        path: '',
                        component: () => import("@/views/Admin/User/AdminUsersListView.vue"),
                        name: 'admin-users',
                        meta: {
                            title: 'Admin - Users',
                            requiresAuth: true
                        }
                    },
                    {
                        path: ':userID',
                        component: () => import("@/views/Admin/User/AdminUserActions.vue"),
                        name: 'admin-user',
                        meta: {
                            title: 'Admin - User Actions',
                            requiresAuth: true
                        }
                    }
                ]
            }
        ]
    },
    // USER
    // Van olyan rész ahova kell auth
    {
        path: '/user',
        component: () => import("@/layouts/UserLayout.vue"),
        children: [
            {
                path: ':userID',
                component: () => import("@/views/UserHomeView.vue"),
                name: 'user-home',
                meta: {
                    title: ''
                }
            },
            {
                path: 'settings',
                component: () => import("@/views/User/Actions/UserSettings.vue"),
                name: 'user-settings',
                meta: {
                    title: 'Settings',
                    requiresAuth: true
                }
            },
            {
                path: 'action',
                children: [
                    {
                        path: 'create-job',
                        component: () => import("@/views/User/Actions/CreateJob.vue"),
                        name: 'create-job',
                        meta: {
                            title: 'Create Job',
                            requiresAuth: true
                        }
                    },
                    {
                        path: 'edit-job',
                        component: () => import("@/views/User/Actions/CreateJob.vue"),
                        name: 'edit-job',
                        meta: {
                            title: 'Edit Job',
                            requiresAuth: true
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
