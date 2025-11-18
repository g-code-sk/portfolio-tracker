<template>
    <div class="rounded-xl border border-dashed border-gray-200 bg-white p-8 text-center">
        <p class="text-lg font-semibold text-gray-900">{{ title }}</p>
        <p v-if="description" class="mt-2 text-sm text-gray-500">{{ description }}</p>
    </div>
</template>

<script setup lang="ts">
interface Props {
    title: string
    description?: string
}

defineProps<Props>()
</script>

<style scoped></style>
