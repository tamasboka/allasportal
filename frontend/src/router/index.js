import {createRouter, createWebHistory} from 'vue-router'
import {http} from "@/utils/http.js";
import {getJobById, getSavedJobs, getUserById} from "@/data/data.js";


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
                        beforeEnter: async (to) => {
                            const job = await getJobById(to.params.jobID)
                            if (!job) return {name: 'not-found'}
                            to.meta.prefetched = job.data.data
                            to.meta.title = job.data.data.name
                            return true
                        }
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
                        path: ':jobID',
                        component: () => import("@/views/Admin/Jobs/AdminJobActions.vue"),
                        name: 'admin-job',
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
            },
            {
              path: 'categories',
                name: 'admin-categories',
                component:()=>import("@/views/Admin/categories/AdminCategoriesView.vue"),
                meta: {
                    title:'Admin - Categories',
                    requiresAdmin: true
                }
            },
            {
                path: 'skills',
                name: 'admin-skills',
                component:()=>import("@/views/Admin/Skills/AdminSkillsView.vue"),
                meta: {
                    title:'Admin - Skills',
                    requiresAdmin: true
                }
            },
            {
                path: 'ratings',
                name: 'admin-ratings',
                component:()=>import("@/views/Admin/ratings/AdminRatingsView.vue"),
                meta: {
                    title:'Admin - Ratings',
                    requiresAdmin: true
                }
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
                beforeEnter: async (to) => {
                    const user = await getUserById(to.params.userID)
                    console.log(user)
                    if (!user) return {name: 'not-found'}
                    to.meta.prefetched = {user}
                    to.meta.title = user.data.data.firstname + " " + user.data.data.lastname
                    return true
                },
            },
            {
                path: 'saved',
                component: () => import("@/views/User/SavedJobs.vue"),
                name: 'saved-jobs',
                meta: {
                    title: 'Saved jobs',
                    requiresAuth: true
                },
                beforeEnter: async (to) => {
                    const result = await getSavedJobs();
                    const jobs = result.data.data;
                    to.meta.prefetched = {jobs}
                    return true;
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
        ]
    },
    {
        path: '/action',
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
                path: 'edit-job/:jobID',
                component: () => import("@/views/User/Actions/EditJob.vue"),
                name: 'edit-job',
                beforeEnter: async (to) => {
                    const job = await getJobById(to.params.jobID)
                    if (!job) {
                        return {name: 'not-found'}
                    }
                    to.meta.prefetched = {job}
                    to.meta.title = "Szerkesztés | " + job.data.data.name
                    return true
                },
                meta: {
                    requiresAuth: true
                }
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
            },
            {
                path: '401',
                name: 'unauthorized',
                component: () => import('@/views/Error/Unauthorized.vue'),
                meta: {
                    title: '401 Unauthorized'
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
router.beforeEach(async (to, from, next) => {
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
    if (to.meta.requiresAuth) {
        if (isLoggedIn) {
            next()
        } else {
            next({
                name: 'login'
            })
        }
        return;
    }
    if (to.meta.requiresAdmin) {
        if (await isAdmin()) {
            next()
        } else {
            next({
                name: 'unauthorized'
            })
        }
        return;
    }
    if (to.meta.guestOnly) {
        if (!isLoggedIn) {
            next()
        } else {
            next({
                name: 'home'
            })
        }
        return;
    }
    next()
})
router.afterEach((to) => {
    document.title = to.meta.title
})
export default router
