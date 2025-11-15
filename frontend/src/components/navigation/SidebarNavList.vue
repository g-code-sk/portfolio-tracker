<template>
    <ul class="space-y-1 p-0">
        <li v-for="item in items" :key="item.label">
            <router-link v-if="item.to" :to="item.to" :class="linkClasses">
                <IonIcon :icon="item.icon" :class="iconClasses" />
                {{ item.label }}
            </router-link>
            <a v-else :href="item.href || '#'" :class="linkClasses">
                <IonIcon :icon="item.icon" :class="iconClasses" />
                {{ item.label }}
            </a>
        </li>
    </ul>
</template>

<script setup lang="ts">
import { SidebarNavItem } from '@/lib/types/generic-types'
import { IonIcon } from '@ionic/vue'

defineProps<{
    items: SidebarNavItem[]
}>()

const linkClasses =
    'flex no-underline items-center rounded-lg pl-10 py-2.5 text-sm font-medium text-gray-700 transition-all duration-150 hover:bg-blue-50 hover:text-blue-700'
const iconClasses = 'mr-3 h-5 w-5'
</script>

<style scoped lang="scss">
li {
    list-style: none;
}
</style>
