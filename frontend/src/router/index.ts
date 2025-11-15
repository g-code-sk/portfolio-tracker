import { useAuth } from '@/composables/useAuth'
import { createRouter, createWebHistory } from '@ionic/vue-router'
import { RouteRecordRaw } from 'vue-router'

declare module 'vue-router' {
    interface RouteMeta {
        requiresAuth?: boolean
    }
}

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
        meta: { requiresAuth: true },
    },
    {
        path: '/portfolios',
        component: () => import('@/views/Portfolios/Index.vue'),
        meta: { requiresAuth: true },
    },
]

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes,
})

router.beforeEach(async (to) => {
    const { isAuthenticated, isInitialized, initAuth } = useAuth()

    if (!isInitialized.value) {
        await initAuth()
    }

    if (to.meta.requiresAuth && !isAuthenticated.value) {
        return {
            path: '/login',
            query: { redirect: to.fullPath },
        }
    }

    if ((to.path === '/login' || to.path === '/register') && isAuthenticated.value) {
        return { path: '/dashboard' }
    }

    return true
})

export default router
