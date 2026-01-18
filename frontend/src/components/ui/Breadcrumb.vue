<template>
    <!-- <nav class="flex w-full items-center rounded-lg border border-gray-200 bg-white p-1 text-sm"> -->
    <nav class="flex w-full items-center rounded-lg p-1 text-sm">
        <ol class="inline-flex list-none items-center px-3">
            <li v-for="(item, index) in items" :key="`${item.label}-${index}`" class="inline-flex items-center">
                <RouterLink v-if="isClickable(item, index)" :to="item.to!" class="text-gray-600 no-underline transition-colors duration-200 hover:text-gray-900">
                    {{ item.label }}
                </RouterLink>
                <span v-else-if="isLoadingLastItem(index)" class="cursor-default font-medium text-gray-900"> ... </span>
                <span v-else class="cursor-default font-medium text-gray-900">
                    {{ item.label }}
                </span>
                <span v-if="shouldShowSeparator(index)" class="mx-3 text-gray-400 select-none">›</span>
            </li>
        </ol>
    </nav>
</template>

<script setup lang="ts">
import type { BreadcrumbItem } from '@/lib/types/generic-types'

interface Props {
    items: BreadcrumbItem[]
    loading?: boolean
}

const props = withDefaults(defineProps<Props>(), {
    loading: false,
})

function isLastItem(index: number): boolean {
    return index === props.items.length - 1
}

function isClickable(item: BreadcrumbItem, index: number): boolean {
    return Boolean(item.to && !(props.loading && isLastItem(index)))
}

function isLoadingLastItem(index: number): boolean {
    return props.loading && isLastItem(index)
}

function shouldShowSeparator(index: number): boolean {
    return !isLastItem(index)
}
</script>
