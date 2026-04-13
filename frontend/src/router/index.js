import {createRouter, createWebHistory} from 'vue-router'
import {http} from "@/utils/http.js";


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
            {
                path: 'about',
                component: () => import('@/views/App/AboutUsView.vue'),
                name: 'about',
                meta: {
                    title: 'Rólunk'
                }
            }
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
                    title: 'Regisztráció',
                    guestOnly: true
                }
            },
            {
                path: 'login',
                component: () => import("@/views/Auth/LoginView.vue"),
                name: 'login',
                meta: {
                    title: 'Bejelentkezés',
                    guestOnly: true
                }
            },
        ]
    },
    // ADMIN
    // Kell auth
    {
        path: '/admin',
        component: () => import("@/layouts/AdminLayout.vue"),
        redirect: {
            name: 'admin-home'
        },
        children: [
            {
                path: '',
                component: () => import("@/views/Admin/AdminHome.vue"),
                name: 'admin-home',
                meta: {
                    title: 'Admin Home',
                    requiresAdmin: true
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
                            requiresAdmin: true
                        }
                    },
                    {
                        path: ':companyID',
                        component: () => import("@/views/Admin/Company/AdminCompanyActions.vue"),
                        name: 'admin-company',
                        meta: {
                            title: 'Admin - Company Actions',
                            requiresAdmin: true
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
                            requiresAdmin: true
                        }
                    },
                    {
                        path: 'jobID',
                        component: () => import("@/views/Admin/Jobs/AdminJobActions.vue"),
                        name: ':admin-job',
                        meta: {
                            title: 'Admin - Job Actions',
                            requiresAdmin: true
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
                            requiresAdmin: true
                        }
                    },
                    {
                        path: ':userID',
                        component: () => import("@/views/Admin/User/AdminUserActions.vue"),
                        name: 'admin-user',
                        meta: {
                            title: 'Admin - User Actions',
                            requiresAdmin: true
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
                component: () => import("@/views/User/UserView.vue"),
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
    },
    {
        path: '/error',
        component: () => import('@/layouts/ErrorLayout.vue'),
        children: [
            {
                path: '/404',
                name: 'not-found',
                component: () => import('@/views/Error/NotFound.vue'),
                meta: {
                    title: '404 Not Found'
                }
            }
        ]
    },
    {
        path: '/:pathMatch(.*)*',
        redirect: {
            name: 'not-found'
        }
    }
];

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes,
})
const isLoggedIn = !!localStorage.getItem('token')
const isAdmin = async () => {
    if (!isLoggedIn) {
        return false;
    }
    const result = await http.get('/api/role', {
        headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}
    })
    return result.data.role === 'admin';
}
router.beforeEach(async (to, from, next) => {
    if (to.meta.requiresAuth) {
        if (isLoggedIn) {
            next()
        } else {
            next({
                name: 'not-found'
            })
        }
        return;
    }
    if (to.meta.requiresAdmin) {
        if (await isAdmin()) {
            next()
        } else {
            next({
                name: 'not-found'
            })
        }
        return;
    }
    if (to.meta.guestOnly) {
        if (!isLoggedIn) {
            next()
        } else {
            next({
                name: 'not-found'
            })
        }
        return;
    }
    document.title = to.meta.title
    next()
})
export default router
