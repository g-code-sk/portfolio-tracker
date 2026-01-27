<template>
    <svg :class="sizeClass" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
    </svg>
</template>

<script setup lang="ts">
import { computed } from 'vue'

interface Props {
    size?: number
}

const props = withDefaults(defineProps<Props>(), {
    size: 4,
})

const sizeClass = computed(() => `h-${props.size} w-${props.size}`)
</script>
