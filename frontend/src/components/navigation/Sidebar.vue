<template>
    <aside class="fixed top-[72px] left-0 z-40 h-[calc(100vh-72px)] w-64 overflow-y-auto border-r border-gray-200 bg-gray-50">
        <nav class="p-4">
            <div class="mb-6">
                <SidebarSectionHeading>Main Menu</SidebarSectionHeading>
                <SidebarNavList :items="mainMenuItems" />
            </div>

            <div class="mb-6">
                <SidebarSectionHeading>Tools</SidebarSectionHeading>
                <SidebarNavList :items="toolsItems" />
            </div>
        </nav>
    </aside>
</template>

<script setup lang="ts">
import SidebarNavList from '@/components/navigation/SidebarNavList.vue'
import SidebarSectionHeading from '@/components/navigation/SidebarSectionHeading.vue'
import { SidebarNavItem } from '@/lib/types/generic-types'
import { barChartOutline, briefcaseOutline, cashOutline, documentTextOutline, homeOutline, settingsOutline } from 'ionicons/icons'

const mainMenuItems: SidebarNavItem[] = [
    {
        label: 'Dashboard',
        icon: homeOutline,
        to: '/dashboard',
    },
    {
        label: 'Portfolios',
        icon: briefcaseOutline,
        to: '/portfolios',
    },
    {
        label: 'Analytics',
        icon: barChartOutline,
        href: '#',
    },
    {
        label: 'Transactions',
        icon: cashOutline,
        href: '#',
    },
]

const toolsItems: SidebarNavItem[] = [
    {
        label: 'Reports',
        icon: documentTextOutline,
        href: '#',
    },
    {
        label: 'Settings',
        icon: settingsOutline,
        href: '#',
    },
]
</script>
