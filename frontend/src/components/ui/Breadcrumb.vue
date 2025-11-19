<template>
    <!-- <nav class="flex w-full items-center rounded-lg border border-gray-200 bg-white p-1 text-sm"> -->
    <nav class="flex w-full items-center rounded-lg p-1 text-sm">
        <ol class="inline-flex list-none items-center px-3">
            <li v-for="(item, index) in items" :key="item.label" class="inline-flex items-center">
                <RouterLink v-if="item.to" :to="item.to" class="text-gray-600 no-underline transition-colors duration-200 hover:text-gray-900">
                    {{ item.label }}
                </RouterLink>
                <span v-else class="cursor-default font-medium text-gray-900">
                    {{ item.label }}
                </span>
                <span v-if="index < items.length - 1" class="mx-3 text-gray-400 select-none">›</span>
            </li>
        </ol>
    </nav>
</template>

<script setup lang="ts">
import type { BreadcrumbItem } from '@/lib/types/generic-types'

interface Props {
    items: BreadcrumbItem[]
}

defineProps<Props>()
</script>
