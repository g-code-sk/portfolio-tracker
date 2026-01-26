<template>
    <svg :class="sizeClass" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
        <path
            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"
        />
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
