<template>
    <button
        :disabled="disabled || loading"
        :class="buttonClasses"
        class="inline-flex items-center justify-center rounded-lg font-medium transition-all duration-200 focus:ring-2 focus:ring-offset-2 focus:outline-none"
    >
        <!-- Loading Spinner -->
        <svg v-if="loading" :class="spinnerSizeClasses" class="animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path
                class="opacity-75"
                fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
            ></path>
        </svg>

        <!-- Button Content -->
        <span v-if="!loading">
            <slot></slot>
        </span>
    </button>
</template>

<script setup lang="ts">
import { computed } from 'vue';

interface Props {
    color?: 'primary' | 'secondary' | 'success' | 'danger' | 'warning' | 'info';
    size?: 'sm' | 'md' | 'lg' | 'xl';
    disabled?: boolean;
    loading?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    color: 'primary',
    size: 'md',
    disabled: false,
    loading: false,
});

const colorClasses = computed(() => {
    if (props.disabled || props.loading) {
        return 'bg-gray-300 text-gray-500 cursor-not-allowed';
    }

    const colors = {
        primary: 'bg-blue-600 hover:bg-blue-700 text-white focus:ring-blue-500',
        secondary: 'bg-gray-600 hover:bg-gray-700 text-white focus:ring-gray-500',
        success: 'bg-green-600 hover:bg-green-700 text-white focus:ring-green-500',
        danger: 'bg-red-600 hover:bg-red-700 text-white focus:ring-red-500',
        warning: 'bg-yellow-500 hover:bg-yellow-600 text-white focus:ring-yellow-500',
        info: 'bg-cyan-600 hover:bg-cyan-700 text-white focus:ring-cyan-500',
    };

    return colors[props.color];
});

const sizeClasses = computed(() => {
    const sizes = {
        sm: 'px-3 py-1.5 text-sm',
        md: 'px-4 py-2 text-base',
        lg: 'px-6 py-3 text-lg',
        xl: 'px-8 py-4 text-xl',
    };

    return sizes[props.size];
});

const spinnerSizeClasses = computed(() => {
    const sizes = {
        sm: 'h-4 w-4',
        md: 'h-5 w-5',
        lg: 'h-6 w-6',
        xl: 'h-7 w-7',
    };

    return sizes[props.size];
});

const buttonClasses = computed(() => {
    return `${colorClasses.value} ${sizeClasses.value}`;
});
</script>
