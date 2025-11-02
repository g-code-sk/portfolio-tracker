<template>
    <component :is="layout">
        <router-view />
    </component>
</template>

<script setup lang="ts">
import AuthLayout from '@/layouts/AuthLayout.vue';
import DefaultLayout from '@/layouts/DefaultLayout.vue';
import { computed } from 'vue';
import { useRoute } from 'vue-router';

const route = useRoute();

const layouts: Record<string, any> = {
    auth: AuthLayout,
    default: DefaultLayout,
};

const layout = computed(() => {
    const layoutName = (route.meta.layout as string) || 'default';
    return layouts[layoutName] || DefaultLayout;
});
</script>
