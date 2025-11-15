<template>
    <div class="grid gap-4">
        <div v-for="placeholder in placeholders" :key="placeholder" class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex animate-pulse items-center justify-between">
                <div class="space-y-3">
                    <div class="h-4 w-36 rounded bg-gray-200"></div>
                    <div class="h-3 w-48 rounded bg-gray-100"></div>
                </div>
                <div class="space-y-3 text-right">
                    <div class="ml-auto h-5 w-28 rounded bg-gray-200"></div>
                    <div class="ml-auto h-4 w-20 rounded bg-gray-100"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'

const props = withDefaults(
    defineProps<{
        cards?: number
    }>(),
    {
        cards: 3,
    },
)

const placeholders = computed(() => Array.from({ length: props.cards }, (_, index) => index))
</script>
