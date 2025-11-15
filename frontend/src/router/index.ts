import { createRouter, createWebHistory } from '@ionic/vue-router'
import { RouteRecordRaw } from 'vue-router'

const routes: Array<RouteRecordRaw> = [
    {
        path: '',
        component: () => import('@/views/Home.vue'),
    },
    {
        path: '/login',
        component: () => import('@/views/Auth/Login.vue'),
    },
    {
        path: '/register',
        component: () => import('@/views/Auth/Register.vue'),
    },
    {
        path: '/dashboard',
        component: () => import('@/views/Dashboard.vue'),
    },
    {
        path: '/portfolios',
        component: () => import('@/views/Portfolios/Index.vue'),
    },
]

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes,
})

export default router
