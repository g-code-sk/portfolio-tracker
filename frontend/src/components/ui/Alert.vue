<template>
    <div :class="alertClasses" role="alert">
        <div class="flex items-start">
            <component :is="alertIcon" class="shrink-0 mt-[2px] me-3" />
            <div class="text-sm font-medium">
                <slot />
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'

import CheckCircleIcon from '@/components/ui/icons/CheckCircleIcon.vue'
import InfoCircleIcon from '@/components/ui/icons/InfoCircleIcon.vue'
import WarningCircleIcon from '@/components/ui/icons/WarningCircleIcon.vue'

const props = withDefaults(
    defineProps<{
        type?: 'info' | 'warning' | 'error' | 'success'
        bordered?: boolean
    }>(),
    {
        type: 'info',
        bordered: false,
    },
)

const alertClasses = computed(() => {
    const baseClasses = 'p-4 rounded-lg'

    const typeClasses = {
        info: props.bordered ? 'text-blue-800 border border-blue-300 bg-blue-50' : 'text-blue-800 bg-blue-50',
        warning: props.bordered ? 'text-yellow-800 border border-yellow-300 bg-yellow-100' : 'text-yellow-800 bg-yellow-100',
        error: props.bordered ? 'text-red-800 border border-red-300 bg-red-50' : 'text-red-800 bg-red-50',
        success: props.bordered ? 'text-green-800 border border-green-300 bg-green-50' : 'text-green-800 bg-green-50',
    }

    return [baseClasses, typeClasses[props.type]]
})

const alertIcon = computed(() => {
    const icons = {
        info: InfoCircleIcon,
        warning: WarningCircleIcon,
        error: WarningCircleIcon,
        success: CheckCircleIcon,
    }

    return icons[props.type]
})
</script>
