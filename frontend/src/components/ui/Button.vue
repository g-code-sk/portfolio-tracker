<template>
    <button
        :disabled="disabled || loading"
        :class="buttonClasses"
        class="relative flex items-center justify-center rounded-lg font-medium transition-all duration-200 focus:ring-2 focus:ring-offset-2 focus:outline-none"
    >
        <!-- Loading Spinner (absolutely positioned) -->
        <SpinnerIcon v-if="loading" :size="spinnerSize" class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2" />

        <!-- Button Content (invisible when loading but maintains space) -->
        <div class="flex items-center gap-2" :class="{ 'opacity-0': loading }">
            <slot></slot>
        </div>
    </button>
</template>

<script setup lang="ts">
import { computed } from 'vue'

import SpinnerIcon from '@/components/ui/icons/SpinnerIcon.vue'

interface Props {
    color?: 'primary' | 'secondary' | 'success' | 'danger' | 'warning' | 'info'
    size?: 'sm' | 'md' | 'lg' | 'xl'
    disabled?: boolean
    loading?: boolean
}

const props = withDefaults(defineProps<Props>(), {
    color: 'primary',
    size: 'md',
    disabled: false,
    loading: false,
})

const colorClasses = computed(() => {
    if (props.disabled || props.loading) {
        return 'bg-gray-300 text-gray-500 cursor-not-allowed'
    }

    const colors = {
        primary: 'bg-blue-600 hover:bg-blue-700 text-white focus:ring-blue-500',
        secondary: 'bg-gray-600 hover:bg-gray-700 text-white focus:ring-gray-500',
        success: 'bg-green-600 hover:bg-green-700 text-white focus:ring-green-500',
        danger: 'bg-red-600 hover:bg-red-700 text-white focus:ring-red-500',
        warning: 'bg-yellow-500 hover:bg-yellow-600 text-white focus:ring-yellow-500',
        info: 'bg-cyan-600 hover:bg-cyan-700 text-white focus:ring-cyan-500',
    }

    return colors[props.color]
})

const sizeClasses = computed(() => {
    const sizes = {
        sm: 'px-3 py-1.5 text-sm',
        md: 'px-4 py-2 text-base',
        lg: 'px-6 py-3 text-lg',
        xl: 'px-8 py-4 text-xl',
    }

    return sizes[props.size]
})

const spinnerSize = computed(() => {
    const sizes = {
        sm: 4,
        md: 5,
        lg: 6,
        xl: 7,
    }

    return sizes[props.size]
})

const buttonClasses = computed(() => {
    return `${colorClasses.value} ${sizeClasses.value}`
})
</script>
