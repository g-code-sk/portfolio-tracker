import { createRouter, createWebHistory } from '@ionic/vue-router';
import { RouteRecordRaw } from 'vue-router';

const routes: Array<RouteRecordRaw> = [
    // Auth Layout Routes (no header/sidebar)
    {
        path: '/',
        component: () => import('@/layouts/AuthLayout.vue'),
        children: [
            {
                path: '',
                component: () => import('@/views/Home.vue'),
            },
            {
                path: 'login',
                component: () => import('@/views/Auth/Login.vue'),
            },
            {
                path: 'register',
                component: () => import('@/views/Auth/Register.vue'),
            },
        ],
    },
    // Default Layout Routes (with header/sidebar)
    {
        path: '/app',
        component: () => import('@/layouts/DefaultLayout.vue'),
        children: [
            {
                path: 'dashboard',
                component: () => import('@/views/Dashboard.vue'),
            },
            {
                path: 'folder/:id',
                component: () => import('@/views/FolderPage.vue'),
            },
            {
                path: 'portfolios',
                component: () => import('@/views/Portfolios/Index.vue'),
            },
        ],
    },
];

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes,
});

export default router;
